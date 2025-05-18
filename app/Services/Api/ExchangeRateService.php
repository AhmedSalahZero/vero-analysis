<?php 
namespace App\Services\Api;

use Exception;
use ripcord;

class ExchangeRateService
{
	
	protected string $url ;
	protected String $db;
	protected string $username;
	protected string $password ; 
	protected \Ripcord_Client $models;
	protected ?int $uid;
	protected int $company_id;
	public function __construct($url , $db , $userName , $password,$companyId)
	{
		$this->url = $url;
		$this->db = $db;
		$this->username =$userName;
		$this->password = $password;
		$this->company_id = $companyId ;
		
		require_once(public_path('apis/ripcord.php'));
		$common = ripcord::client("$this->url/xmlrpc/2/common");
		$uid = null ;
		try{
			$uid = $common->authenticate($this->db, $this->username, $this->password, array());
		}
		catch(\Exception $e){
			$uid = null;
		}
		if(is_array($uid)){
			$uid = null ;
		}
		$models = ripcord::client("$this->url/xmlrpc/2/object");
		$this->models = $models;
		
		$this->uid = $uid;
	}
	public function execute($model, $method, $args)
    {

        return $this->models->execute_kw($this->db, $this->uid, $this->password, $model, $method, $args);
    }

    /**
     * Get the company's base currency
     * @return array Base currency details (id, name)
     */
    public function getBaseCurrency()
    {
        try {
            $company = $this->execute('res.company', 'search_read', [
                [['id', '!=', 0]], // Fetch the main company
                ['currency_id'],
                // ['limit' => 1]
            ]);
            if (empty($company)) {
                throw new Exception('No company found');
            }
			
            return $this->execute('res.currency', 'read', [
                [$company[0]['currency_id'][0]],
                ['name', 'symbol']
            ])[0];
        } catch (Exception $e) {
            throw new Exception('Failed to fetch base currency: ' . $e->getMessage());
        }
    }

    /**
     * Get currency ID by currency code (e.g., USD, EUR)
     * @param string $currencyCode
     * @return int Currency ID
     */
    public function getCurrencyId($currencyCode)
    {
        try {
            $currencies = $this->execute('res.currency', 'search_read', [
                [
					['name', '=', strtoupper($currencyCode)], ['active', '=', true]],
                ['id']
            ]);
            if (empty($currencies)) {
                throw new Exception("Currency {$currencyCode} not found or inactive");
            }
            return $currencies[0]['id'];
        } catch (Exception $e) {
		
            throw new Exception('Failed to fetch currency ID: ' . $e->getMessage());
        }
    }

    /**
     * Fetch foreign exchange rates for a currency
     * @param string $currencyCode Currency code (e.g., USD, EUR)
     * @param string|null $date Specific date (YYYY-MM-DD) for the rate
     * @param string|null $startDate Start date for range (YYYY-MM-DD)
     * @param string|null $endDate End date for range (YYYY-MM-DD)
     * @return array Exchange rates with base currency info
     */
    public function getExchangeRates($currencyCode, $date = null, $startDate = null, $endDate = null)
    {
        try {
            // Step 1: Get currency ID
            $currencyId = $this->getCurrencyId($currencyCode);

            // Step 2: Get base currency
            $baseCurrency = $this->getBaseCurrency();

            // Step 3: Build domain for exchange rates
            $domain = [['currency_id', '=', $currencyId]];
            // if ($date) {
            //     $domain[] = ['name', '=', $date];
            // } elseif ($startDate && $endDate) {
            //     $domain[] = ['name', '>=', $startDate];
            //     $domain[] = ['name', '<=', $endDate];
            // } else {
            //     // Default to most recent rate
            //     $domain[] = ['name', '<=', date('Y-m-d')];
            // }

            // Step 4: Fetch exchange rates
            $rates = $this->execute('res.currency.rate', 'search_read', [
				$domain,
                ['name', 'rate', 'currency_id', 'company_id'],
                // ['order' => 'name DESC', 'limit' => $date ? 1 : 100] // Get most recent rate for single date
            ]);
            if (empty($rates) && $date) {
                throw new Exception("No exchange rate found for {$currencyCode} on {$date}");
            }

            // Step 5: Map rates to include direct rate (1 foreign unit = X base units)
            $result = [
                'currency' => $currencyCode,
                'base_currency' => $baseCurrency['name'],
                'rates' => array_map(function ($rate) {
                    return [
                        'date' => $rate['name'],
                        'rate' => $rate['rate'], // Inverse rate (1 foreign unit = rate base units)
                        'direct_rate' => $rate['rate'] ? 1 / $rate['rate'] : 0, // Direct rate (1 base unit = X foreign units)
                        'company_id' => $rate['company_id'] ? $rate['company_id'][0] : null
                    ];
                }, $rates)
            ];

            return $result;
        } catch (Exception $e) {
            throw new Exception('Failed to fetch exchange rates: ' . $e->getMessage());
        }
    }
	 
}
?>
