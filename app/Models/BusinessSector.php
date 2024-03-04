<?php

namespace App\Models;

use App\Interfaces\Models\IBaseModel;
use App\Models\Repositories\CustomerRepository;
use App\Models\Traits\Accessors\BusinessSectorAccessor;
use App\Models\Traits\Mutators\BusinessSectorMutator;
use App\Models\Traits\Relations\BusinessSectorRelation;
use App\Models\Traits\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class BusinessSector extends Model  implements IBaseModel
{
    use BusinessSectorRelation ,BusinessSectorAccessor  , BusinessSectorMutator , CompanyScope;

    protected $guarded = [
        'id'
    ];

    public static function getCrudFormName():string 
    {
        return 'admin.business-sectors.form';
    }
    public static function getPageTitle()
    {
        return __('Business Sectors');
    }
     public static function getViewVars():array 
    {
        $currentCompanyId =  getCurrentCompanyId();
        return [
            'modelName'=>'BusinessSector',
            'storeRoute'=>route('admin.store.business.sector',$currentCompanyId),
            'pageTitle'=>static::getPageTitle(),
            'type'=>'create'
        ];
        
    }

    
}
