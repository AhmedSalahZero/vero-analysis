<?php
namespace App\Services\Caching;

use App\Models\Company;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CustomerDashboardCashing
{
    private Company $company ;
    private string $year ;
    private string $newCustomerCashingName ;
    private string $repeatingCustomerCashingName ;
    private string $activeCustomerCashingName ;
    private string $stopReactivatedCustomerCashingName ;
    private string $deadReactivatedCustomerCashingName ;
    private string $stopRepeatingCustomerCashingName ;
    private string $stopCustomerCashingName ;
    private string $deadCustomerCashingName ;
    private array $typesOfCaching ;  
    
    public function __construct(Company $company , string $year)
    {
        $this->company = $company ;
        $this->year = $year ; 
        $this->newCustomerCashingName  = getNewCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->repeatingCustomerCashingName =getRepeatingCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->activeCustomerCashingName =getActiveCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->stopReactivatedCustomerCashingName =getStopReactivatedCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->deadReactivatedCustomerCashingName =getDeadReactivatedCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->stopRepeatingCustomerCashingName =getStopRepeatingCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->stopCustomerCashingName = getStopCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->deadCustomerCashingName =getDeadCustomersCacheNameForCompanyInYear($company , $year) ;
        $this->totalCustomerCashingName = getTotalCustomersCacheNameForCompanyInYear($this->company , $this->year) ;   
        $this->typesOfCaching = getAllColumnsTypesForCaching($this->company->id);
    }

    public function cacheNewCustomers()
     
    {
        
          if(! Cache::has($this->newCustomerCashingName)){
              
              $newCustomers = DB::select(DB::raw("
                select  customer_name , min(Year) as first_appearnce , min(Year) -1 as previous_appearance , count(*) as no_customers,
                 sum(case when Year = ". $this->year  ." then net_sales_value else 0 end ) total_sales  from sales_gathering 
                 force index (min__index)
                  where company_id = ". $this->company->id ." group by customer_name having  min(Year) = ". $this->year   ." order by total_sales desc
                "
                  )); 
              Cache::forever($this->newCustomerCashingName, $newCustomers);
              }
              else
              {
                  $newCustomers = Cache::get($this->newCustomerCashingName);
            }

            return $newCustomers ;
            
    }

    public function cacheNewCustomersForTypes()
     
    {
        $newCustomersForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {   
            $cacheKeyName = getNewCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
                 if(! Cache::has($cacheKeyName)){
                $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
              $newCustomers = DB::select(DB::raw("
                select  customer_name , ". $typeToCache  ." , count(*) as no_customers,
                 sum(case when Year = ". $this->year  ." then net_sales_value else 0 end ) total_sales  from sales_gathering  ". $forceIndex . " 
                 
                  where company_id = ". $this->company->id ." group by customer_name , ". $typeToCache  ." having  min(Year) = ". $this->year   ." order by total_sales desc"
                  )); 
                  Cache::forever($cacheKeyName, $newCustomers);
              }
              else
              {
                  $newCustomers = Cache::get($cacheKeyName);
              }
                        
                        if(\array_key_exists($typeToCache , $newCustomersForTypes))
                        {
                            array_push($newCustomersForTypes[$typeToCache] , $newCustomers) ;
                        }
                        else{
                             $newCustomersForTypes[$typeToCache] =$newCustomers ;
                        }
        }
           
            return $newCustomersForTypes ;
            
    }

    public function cacheRepeatingCustomers()
    {
         if(! Cache::has($this->repeatingCustomerCashingName)){
             
       
            $RepeatingCustomers = DB::select(
            DB::raw(
       

        "
        select  customer_name , min(Year) as date ,count(*) as no_customers, sum(case when Year = ". $this->year . " then net_sales_value else 0 end ) total_sales  from sales_gathering
         force index (min__index) 
        
        where company_id = ". $this->company->id ." group by customer_name having  min(Year) = ". ($this->year-1) ." and 
        max(case when Year = ". $this->year ." then 1 else 0 end ) = 1 order by total_sales desc
        "
            )
        );


        Cache::forever($this->repeatingCustomerCashingName, $RepeatingCustomers);

        }
        else{
                  $RepeatingCustomers = Cache::get(getRepeatingCustomersCacheNameForCompanyInYear($this->company , $this->year));
        }

        

        return $RepeatingCustomers ; 
    }



       public function cacheRepeatingCustomersForType()
    {
        $newRepeatingForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
             $cacheKeyName = getRepeatingCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
         if(! Cache::has($cacheKeyName)){

              $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
             
       
            $RepeatingCustomers = DB::select(
            DB::raw(
       

        "
        select  customer_name , ". $typeToCache ." ,count(*) as no_customers, sum(case when Year = ". $this->year . " then net_sales_value else 0 end ) total_sales  from sales_gathering
          " . $forceIndex . "
        
        where company_id = ". $this->company->id ." group by customer_name , ". $typeToCache ." having  min(Year) = ". ($this->year-1) ." and 
        max(case when Year = ". $this->year ." then 1 else 0 end ) = 1 order by total_sales desc
        "
            )
        );


        Cache::forever($cacheKeyName, $RepeatingCustomers);

        }
        else{
                  $RepeatingCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $newRepeatingForTypes))
                        {
                            array_push($newRepeatingForTypes[$typeToCache] , $RepeatingCustomers) ;
                        }
                        else{
                             $newCustomersForTypes[$typeToCache] =$RepeatingCustomers ;
                        }


        
        }
        

        return $newRepeatingForTypes ; 
    }

    public function cacheActiveCustomers()
    {
         if(! Cache::has($this->activeCustomerCashingName)){
        $activeCustomers = DB::select(
            DB::raw(
                "
                select (customer_name) ,count(*) as no_customers, sum(case when Year = ". $this->year ." then net_sales_value else 0 end ) total_sales
                from sales_gathering 
                force index (min__index)
                where company_id = " . $this->company->id . " 
                GROUP by customer_name
                having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1 
                and max(case when  Year = " . ($this->year - 1) ." then 1 else 0 end ) = 1 
                and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 1
                ORDER BY total_sales DESC
                "
                            )
                        );


        Cache::forever($this->activeCustomerCashingName, $activeCustomers);

        }
        else{
                  $activeCustomers = Cache::get($this->activeCustomerCashingName);
        }
        
        return $activeCustomers ; 
    }


    
     public function cacheActiveCustomersForType()
    {
        $newActiveForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
             $cacheKeyName = getActiveCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
         if(! Cache::has($cacheKeyName)){
             $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
       
            $ActiveCustomers = DB::select(
            DB::raw(
                "
                select (customer_name) , ".$typeToCache." ,count(*) as no_customers, sum(case when Year = ". $this->year ." then net_sales_value else 0 end ) total_sales
                from sales_gathering ". $forceIndex ."
                
                where company_id = " . $this->company->id . " 
                GROUP by customer_name , " . $typeToCache ."
                having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1 
                and max(case when  Year = " . ($this->year - 1) ." then 1 else 0 end ) = 1 
                and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 1
                ORDER BY total_sales DESC
                "
                            )
        );


        Cache::forever($cacheKeyName, $ActiveCustomers);

        }
        else{
                  $ActiveCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $newActiveForTypes))
                        {
                            array_push($newActiveForTypes[$typeToCache] , $ActiveCustomers) ;
                        }
                        else{
                             $newCustomersForTypes[$typeToCache] =$ActiveCustomers ;
                        }


        
        }
        

        return $newActiveForTypes ; 
    }
    

   


    public function cacheStopReactivatedCustomers()
    {
        if(! Cache::has($this->stopReactivatedCustomerCashingName)){
            $stopReactive = DB::select(
                DB::raw(
                    "
                    select (customer_name) ,count(*) as no_customers, sum(case when Year = ". $this->year ." then net_sales_value else 0 end ) total_sales from sales_gathering 
                     force index (min__index)
                    where company_id = ". $this->company->id ."
                    GROUP by customer_name
                    having max(case when Year = ". ($this->year) ." then 1 else 0 end ) = 1
                    and max(case when Year = ". ($this->year - 1) ." then 1 else 0 end ) = 0
                    and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 1
                    order by total_sales desc 
                    "
            )
        );

        Cache::forever($this->stopReactivatedCustomerCashingName, $stopReactive);

        }
        else{
                  $stopReactive = Cache::get($this->stopReactivatedCustomerCashingName);
        }
        return $stopReactive ; 
    }

     public function cacheStopReactivatedCustomersForType()
    {
        $newStopReactivatedForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
            $cacheKeyName = getStopReactivatedCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
            
            if(! Cache::has($cacheKeyName)){
                         $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
                $StopReactivatedCustomers = DB::select(
            DB::raw(
                    "
                    select (customer_name) , ". $typeToCache  ." ,count(*) as no_customers, sum(case when Year = ". $this->year ." then net_sales_value else 0 end ) total_sales from sales_gathering 
                     ". $forceIndex ."
                    where company_id = ". $this->company->id ."
                    GROUP by customer_name , ". $typeToCache ."
                    having max(case when Year = ". ($this->year) ." then 1 else 0 end ) = 1
                    and max(case when Year = ". ($this->year - 1) ." then 1 else 0 end ) = 0
                    and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 1
                    order by total_sales desc 
                    "
            )
        );


        Cache::forever($cacheKeyName, $StopReactivatedCustomers);

        }
        else{
                  $StopReactivatedCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $newStopReactivatedForTypes))
                        {
                            array_push($newStopReactivatedForTypes[$typeToCache] , $StopReactivatedCustomers) ;
                        }
                        else{
                             $newStopReactivatedForTypes[$typeToCache] =$StopReactivatedCustomers ;
                        }


        
        }
        

        return $newStopReactivatedForTypes ; 
    }

    public function cacheDeadReactivatedCustomers()
    {
         if(! Cache::has($this->deadReactivatedCustomerCashingName)){
          $deadReactivatedCustomers = DB::select(
          
            DB::raw(
          
                "
                    select (customer_name) ,count(*) as no_customers, sum(case when year = ".  $this->year   ." then net_sales_value else 0 end ) total_sales
                    from sales_gathering force index (min__index)
                    where company_id = ". $this->company->id  ."  
                    GROUP by customer_name
                    having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1
                    and max(case when Year = ". ($this->year - 1) ."  then 1 else 0 end ) = 0 
                    and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 0 
                    and max(case when Year = ". ($this->year - 3) ." then 1 else 0 end ) = 1 
                    order by total_sales desc
                    ;
                    
                    "
            )
        );

        Cache::forever($this->deadReactivatedCustomerCashingName, $deadReactivatedCustomers);

        }
        else{
                  $deadReactivatedCustomers = Cache::get($this->deadReactivatedCustomerCashingName);
        }   
        return $deadReactivatedCustomers ; 
    }

    
  public function cacheDeadReactivatedCustomersForType()
    {
        $deadReactivatedForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
            
            $cacheKeyName = getDeadReactiveCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
            
            if(! Cache::has($cacheKeyName)){

                $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
                
                $deadReactivatedCustomers = DB::select(
            DB::raw(
          
                "
                    select (customer_name) , ". $typeToCache . " ,count(*) as no_customers, sum(case when year = ".  $this->year   ." then net_sales_value else 0 end ) total_sales
                    from sales_gathering ". $forceIndex ."
                    where company_id = ". $this->company->id  ."  
                    GROUP by customer_name ,".$typeToCache . " 
                    having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1
                    and max(case when Year = ". ($this->year - 1) ."  then 1 else 0 end ) = 0 
                    and max(case when Year = ". ($this->year - 2) ." then 1 else 0 end ) = 0 
                    and max(case when Year = ". ($this->year - 3) ." then 1 else 0 end ) = 1 
                    order by total_sales desc
                    ;
                    "
            )
        );


        Cache::forever($cacheKeyName, $deadReactivatedCustomers);

        }
        else{
                  $deadReactivatedCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $deadReactivatedForTypes))
                        {
                            array_push($deadReactivatedForTypes[$typeToCache] , $deadReactivatedCustomers) ;
                        }
                        else{
                             $deadReactivatedForTypes[$typeToCache] = $deadReactivatedCustomers ;
                        }


        
        }
        

        return $deadReactivatedForTypes ; 
    }

    public function cacheStopRepeatingCustomers()
    {
        if(! Cache::has($this->stopRepeatingCustomerCashingName)){
          $stopRepeatingCustomers = DB::select(
            DB::raw(
                "
                select (customer_name) , count(*) as no_customers,sum(case when year = ".  $this->year   ." then net_sales_value else 0 end) total_sales
                from sales_gathering force index (min__index)
                where company_id = ". $this->company->id  ."
                GROUP by customer_name
                having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1
                and max(case when Year = ". ($this->year - 1) ." then 1 else 0 end ) = 1 
                and max(case when Year = ". ($this->year - 2)  . " then 1 else 0 end ) = 0 
                and max(case when Year = ". ($this->year - 3)  . " then 1 else 0 end ) = 1 
                order by total_sales desc
                "
            )
        );

        Cache::forever($this->stopRepeatingCustomerCashingName, $stopRepeatingCustomers);

        }
        else{
                  $stopRepeatingCustomers = Cache::get($this->stopRepeatingCustomerCashingName);
        }

        return $stopRepeatingCustomers ; 
    }


    public function cacheStopRepeatingCustomersForType()
    {
        $deadRepeatingForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
            
            $cacheKeyName = getStopRepeatingCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
            
            if(! Cache::has($cacheKeyName)){

                $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
                
                $StopRepeatingCustomers = DB::select(
            DB::raw(
                "
                
                select (customer_name) , ". $typeToCache .", count(*) as no_customers,sum(case when year = ".  $this->year   ." then net_sales_value else 0 end) total_sales
                from sales_gathering ". $forceIndex ."
                where company_id = ". $this->company->id  ."
                GROUP by customer_name , ". $typeToCache ."
                having max(case when Year = ". $this->year ." then 1 else 0 end ) = 1
                and max(case when Year = ". ($this->year - 1) ." then 1 else 0 end ) = 1 
                and max(case when Year = ". ($this->year - 2)  . " then 1 else 0 end ) = 0 
                and max(case when Year = ". ($this->year - 3)  . " then 1 else 0 end ) = 1 
                order by total_sales desc
                
                "
            )
        );


        Cache::forever($cacheKeyName, $StopRepeatingCustomers);

        }
        else{
                  $StopRepeatingCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $deadRepeatingForTypes))
                        {
                            array_push($deadRepeatingForTypes[$typeToCache] , $StopRepeatingCustomers) ;
                        }
                        else{
                             $deadRepeatingForTypes[$typeToCache] = $StopRepeatingCustomers ;
                        }


        
        }
        

        return $deadRepeatingForTypes ; 
    }
    

    public function cacheStopCustomers()
    {

        if(! Cache::has($this->stopCustomerCashingName)){
            $stopCustomers = DB::select(
                        DB::raw(
                            "
            select (customer_name) , count(*) as no_customers, sum(case when year = ".  ($this->year - 1)   ." then net_sales_value else 0 end) total_sales
            from  sales_gathering force index (min__index)
            where company_id = ". $this->company->id  ." 
            GROUP by customer_name  
            having max(case when Year = " . $this->year .  " then 1 else 0 end ) = 0
            and max(case when Year = ". ($this->year - 1 ) ." then 1 else 0 end ) = 1 
            order by total_sales desc
            "
            )
        );

        Cache::forever($this->stopCustomerCashingName, $stopCustomers);

        }
        else{
                  $stopCustomers = Cache::get($this->stopCustomerCashingName);
        }
        return $stopCustomers ; 
    }

    
     public function cacheStopCustomersForType()
    {
        $newStopForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
             $cacheKeyName = getStopCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
         if(! Cache::has($cacheKeyName)){
             $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
       
            $StopCustomers = DB::select(
            DB::raw("
            select (customer_name) , ". $typeToCache ." , count(*) as no_customers, sum(case when year = ".  ($this->year - 1)   ." then net_sales_value else 0 end) total_sales
            from  sales_gathering force index (min__index)
            where company_id = ". $this->company->id  ." 
            GROUP by customer_name , ". $typeToCache ." 
            having max(case when Year = " . $this->year .  " then 1 else 0 end ) = 0
            and max(case when Year = ". ($this->year - 1 ) ." then 1 else 0 end ) = 1 
            order by total_sales desc
            ")
        );


        Cache::forever($cacheKeyName, $StopCustomers);

        }
        else{
                  $StopCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $newStopForTypes))
                        {
                            array_push($newStopForTypes[$typeToCache] , $StopCustomers) ;
                        }
                        else{
                             $newStopForTypes[$typeToCache] =$StopCustomers ;
                        }


        
        }
        

        return $newStopForTypes ; 
    }
    
    public function cacheDeadCustomers()
    {
        
          if(! Cache::has($this->deadCustomerCashingName)){

            
        $deadCustomers = DB::select(
     // sum form year - 2 ()
            DB::raw(
                "
                
                select (customer_name) , count(*) as no_customers, sum(case when Year = ". ($this->year - 2 )  ." then net_sales_value else 0 end ) total_sales
                from sales_gathering force index (min__index)
                where company_id = ". $this->company->id ."
                
                GROUP by customer_name
                having max(case when Year = " . $this->year  . " then 1 else 0 end ) = 0
                and max(case when Year = " . ($this->year - 1 ) ." then 1 else 0 end ) = 0 
                and max(case when Year = " . ($this->year - 2 ) ." then 1 else 0 end ) = 1 
                order by total_sales desc;
                
                "
            )
        );
  


        Cache::forever($this->deadCustomerCashingName, $deadCustomers);
        }
        else{
                  $deadCustomers = Cache::get($this->deadCustomerCashingName);
                  
        }

        return $deadCustomers ; 
        
    }


      public function cacheDeadCustomersForType()
    {
        $newDeadForTypes = [];
        foreach($this->typesOfCaching as $typeToCache)
        {
             $cacheKeyName = getDeadCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
         if(! Cache::has($cacheKeyName)){
             $possibleIndexName = 'min__index_'.$typeToCache;
              $forceIndex = \indexIsExistIn($possibleIndexName , 'sales_gathering') ? "force index (". $possibleIndexName .")" : '' ;
       
            $DeadCustomers = DB::select(
            DB::raw(
                "
                select (customer_name) , ".  $typeToCache ." , count(*) as no_customers, sum(case when Year = ". ($this->year - 2 )  ." then net_sales_value else 0 end ) total_sales
                from sales_gathering ". $forceIndex ."
                where company_id = ". $this->company->id ."
                
                GROUP by customer_name , ".$typeToCache."
                having max(case when Year = " . $this->year  . " then 1 else 0 end ) = 0
                and max(case when Year = " . ($this->year - 1 ) ." then 1 else 0 end ) = 0 
                and max(case when Year = " . ($this->year - 2 ) ." then 1 else 0 end ) = 1 
                order by total_sales desc;
                
                "
            )
        );


        Cache::forever($cacheKeyName, $DeadCustomers);

        }
        else{
                  $DeadCustomers = Cache::get($cacheKeyName);
        }

         if(\array_key_exists($typeToCache , $newDeadForTypes))
                        {
                            array_push($newDeadForTypes[$typeToCache] , $DeadCustomers) ;
                        }
                        else{
                             $newDeadForTypes[$typeToCache] =$DeadCustomers ;
                        }


        
        }
        

        return $newDeadForTypes ; 
    }

    

    public function cacheTotalCustomers()
    {
         if(! Cache::has($this->totalCustomerCashingName)){
      $totals = DB::select(DB::raw(
            "
                select customer_name ,
             sum(net_sales_value) as val , count(*) as no_customers,
              FORMAT((sum(net_sales_value) / (select sum(net_sales_value)  from sales_gathering force index (min__index) where company_id
               = ". $this->company->id ."  and  Year = ". $this->year ." ) * 100) , 1) as percentage
                from sales_gathering force index (min__index) where company_id = ". $this->company->id  ." and Year = ". $this->year ." 
                group by customer_name 
                order by val desc "
        ));
        Cache::forever($this->totalCustomerCashingName, $totals);
        }
        else{
                  $totals = Cache::get($this->totalCustomerCashingName);
        }
        return $totals  ; 
    }

    public function cacheAll($cacheType = []):array 
    {
        return [
            'newCustomers'=>$this->cacheNewCustomers() ,
            'RepeatingCustomers'=>$this->cacheRepeatingCustomers() ,
            'activeCustomers'=>$this->cacheActiveCustomers() ,
            'stopCustomers'=>$this->cacheStopCustomers(),
            'stopReactive'=>$this->cacheStopReactivatedCustomers() ,
            'deadReactivatedCustomers'=>$this->cacheDeadReactivatedCustomers(),
            'stopRepeatingCustomers'=>$this->cacheStopRepeatingCustomers(),
            'deadCustomers'=>$this->cacheDeadCustomers(),
            
            'newCustomersForType'=>$this->cacheNewCustomersForTypes(),
            'RepeatingForType'=>$this->cacheRepeatingCustomersForType(),
            'ActiveForType'=>$this->cacheActiveCustomersForType(),
            'StopForType'=>$this->cacheStopCustomersForType() ,
            'StopReactivatedForType'=>$this->cacheStopReactivatedCustomersForType(),
            'deadReactivatedForType'=>$this->cacheDeadReactivatedCustomersForType(),
            'StopRepeatingForType'=>$this->cacheStopRepeatingCustomersForType(),
            'DeadForType'=>$this->cacheDeadCustomersForType(),
            
            'totals'=>$this->cacheTotalCustomers(),
        ];
        
    }

    public function deleteAll()
    {
        Cache::forget($this->newCustomerCashingName);
        Cache::forget($this->repeatingCustomerCashingName);
        Cache::forget($this->activeCustomerCashingName);
        Cache::forget($this->stopReactivatedCustomerCashingName);
        Cache::forget($this->deadReactivatedCustomerCashingName);
        Cache::forget($this->stopRepeatingCustomerCashingName);
        Cache::forget($this->deadCustomerCashingName);
    }

}