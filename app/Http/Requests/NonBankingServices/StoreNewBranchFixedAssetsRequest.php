<?php

namespace App\Http\Requests\NonBankingServices;

use App\Models\NonBankingService\Study;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewBranchFixedAssetsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
	public function prepareForValidation()
	{
		// $study = Study::find($this->study_id);
		$fixedAssets = $this->get('fixedAssets');
		foreach($fixedAssets as $index => &$fixedAssetArr){
			$fixedAssetArr['ffe_counts'] =$fixedAssetArr['ffe_counts'] ? (array)json_decode($fixedAssetArr['ffe_counts']) : [];
		}
		
		$this->merge([
			'fixedAssets'=>$fixedAssets 
		]);
	}
    public function rules()
    {
        return [
            //
        ];
    }
}
