<?php

namespace App\Models;

use App\Interfaces\Models\IBaseModel;
use App\Interfaces\Models\IExportable;
use App\Interfaces\Models\IHaveAllRelations;
use App\Interfaces\Models\IShareable;
use App\Models\Traits\Accessors\FinancialStatementAccessor;
use App\Models\Traits\Mutators\FinancialStatementMutator;
use App\Models\Traits\Relations\FinancialStatementRelation;
use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\withAllRelationsScope;
use Illuminate\Database\Eloquent\Model;

class  FinancialStatement extends Model implements IBaseModel, IHaveAllRelations, IExportable, IShareable
{
	use  FinancialStatementAccessor, FinancialStatementMutator, FinancialStatementRelation, CompanyScope, withAllRelationsScope;

	protected $guarded = [
		'id'
	];
	public static function getShareableEditViewVars($model): array
	{

		return [
			'pageTitle' => FinancialStatement::getPageTitle(),
		];
	}

	public function getRouteKeyName()
	{
		return 'financial_statements.id';
	}
	public static function exportViewName(): string
	{
		return __('Financial Statement');
	}
	public static function getFileName(): string
	{
		return __('Financial Statement');
	}

	protected static function booted()
	{
		// static::addGlobalScope(new StateCountryScope);
	}

	public static function getCrudViewName(): string
	{
		return 'admin.financial-statement.create';
	}

	public static function getViewVars(): array
	{
		// dd('e');
		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.financial.statement', ['company' => $currentCompanyId]),
			'modelName' => 'FinancialStatement',
			'exportRoute' => route('admin.export.financial.statement', $currentCompanyId),
			'createRoute' => route('admin.create.financial.statement', $currentCompanyId),
			'storeRoute' => route('admin.store.financial.statement', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => FinancialStatement::getPageTitle(),
			'redirectAfterSubmitRoute' => route('admin.view.financial.statement', $currentCompanyId),
			'type' => 'create',
			'company' => Company::find($currentCompanyId),
			'redirectAfterSubmitRoute' => route('admin.view.financial.statement', ['company' => getCurrentCompanyId()]),
			'durationTypes' => getDurationIntervalTypesForSelect()
		];
	}
	public static function getReportViewVars(array $options = []): array
	{

		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.financial.statement.report', ['company' => $currentCompanyId, 'financialStatement' => $options['financial_statement_id']]),
			'modelName' => 'FinancialStatementReport',
			'exportRoute' => route('admin.export.financial.statement.report', $currentCompanyId),
			'createRoute' => route('admin.create.financial.statement.report', [
				'company' => $currentCompanyId,
				'financialStatement' => $options['financial_statement_id']
			]),
			'storeRoute' => route('admin.store.financial.statement.report', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => __('Financial Statement Report'),
			'redirectAfterSubmitRoute' => route('admin.view.financial.statement', $currentCompanyId),
			'type' => 'create',
			'financialStatement' => $options['financialStatement'],
			'interval' => getIntervalForSelect($options['financialStatement']->getDurationType()),
		];
	}
	public static function getPageTitle(): string
	{
		return __('Financial Statement');
	}

	public function getAllRelationsNames(): array
	{
		return [
			// 'revenueBusinessLine',
			// 'serviceCategory','serviceItem','serviceNatureRelation','currency','otherVariableManpowerExpenses',
			// 'directManpowerExpenses','salesAndMarketingExpenses','otherDirectOperationExpenses','generalExpenses','freelancerExpensePositions',
			// 'directManpowerExpensePositions','freelancerExpenses','profitability'
		];
	}
}
