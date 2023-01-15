<?php

namespace App\Models;

use App\Interfaces\Models\IBaseModel;
use App\Interfaces\Models\IExportable;
use App\Interfaces\Models\IHaveAllRelations;
use App\Interfaces\Models\IShareable;
use App\Models\Traits\Accessors\BalanceSheetAccessor;
use App\Models\Traits\Mutators\BalanceSheetMutator;
use App\Models\Traits\Relations\BalanceSheetRelation;
use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\withAllRelationsScope;
use Illuminate\Database\Eloquent\Model;

class  BalanceSheet extends Model implements IBaseModel, IHaveAllRelations, IExportable, IShareable
{
	use  BalanceSheetAccessor, BalanceSheetMutator, BalanceSheetRelation, CompanyScope, withAllRelationsScope;

	protected $guarded = [
		'id'
	];
	public static function getShareableEditViewVars($model): array
	{

		return [
			'pageTitle' => BalanceSheet::getPageTitle(),

		];
	}
	public function getRouteKeyName()
	{
		return 'balance_sheets.id';
	}
	public static function exportViewName(): string
	{
		return __('Balance Sheet');
	}
	public static function getFileName(): string
	{
		return __('Balance Sheet');
	}

	protected static function booted()
	{
		// static::addGlobalScope(new StateCountryScope);
	}

	public static function getCrudViewName(): string
	{
		return 'admin.balance-sheet.create';
	}

	public static function getViewVars(): array
	{
		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.balance.sheet', ['company' => $currentCompanyId]),
			'modelName' => 'BalanceSheet',
			'exportRoute' => route('admin.export.balance.sheet', $currentCompanyId),
			'createRoute' => route('admin.create.balance.sheet', $currentCompanyId),
			'storeRoute' => route('admin.store.balance.sheet', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => BalanceSheet::getPageTitle(),
			'redirectAfterSubmitRoute' => route('admin.view.balance.sheet', $currentCompanyId),
			'type' => 'create',
			'company' => Company::find($currentCompanyId),
			'redirectAfterSubmitRoute' => route('admin.view.balance.sheet', ['company' => getCurrentCompanyId()]),
			'durationTypes' => getDurationIntervalTypesForSelect()
		];
	}
	public static function getReportViewVars(array $options = []): array
	{
		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.balance.sheet.report', ['company' => $currentCompanyId, 'balanceSheet' => $options['balance_sheet_id']]),
			'modelName' => 'BalanceSheetReport',
			'exportRoute' => route('admin.export.balance.sheet.report', $currentCompanyId),
			'createRoute' => route('admin.create.balance.sheet.report', [
				'company' => $currentCompanyId,
				'balanceSheet' => $options['balance_sheet_id']
			]),
			'storeRoute' => route('admin.store.balance.sheet.report', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => __('Balance Sheet Report'),
			'redirectAfterSubmitRoute' => route('admin.view.balance.sheet', $currentCompanyId),
			'type' => 'create',
			'balanceSheet' => $options['balanceSheet'],
			'interval' => [
				[
					'value' => 'monthly',
					'title' => __('Monthly')
				], [
					'value' => 'quarterly',
					'title' => __('Quarterly')
				], [
					'value' => 'semi-annually',
					'title' => __('Semi-annually')
				],
				[
					'value' => 'annually',
					'title' => __('Annually')
				],
			]
		];
	}
	public static function getPageTitle(): string
	{
		return __('Balance Sheet');
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
