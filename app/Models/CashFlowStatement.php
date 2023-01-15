<?php

namespace App\Models;

use App\Interfaces\Models\IBaseModel;
use App\Interfaces\Models\IExportable;
use App\Interfaces\Models\IHaveAllRelations;
use App\Interfaces\Models\IShareable;
use App\Models\Traits\Accessors\CashFlowStatementAccessor;
use App\Models\Traits\Mutators\CashFlowStatementMutator;
use App\Models\Traits\Relations\CashFlowStatementRelation;
use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\Globals\StateCountryScope;
use App\Models\Traits\Scopes\withAllRelationsScope;
use Illuminate\Database\Eloquent\Model;

class  CashFlowStatement extends Model implements IBaseModel, IHaveAllRelations, IExportable, IShareable
{
	use  CashFlowStatementAccessor, CashFlowStatementMutator, CashFlowStatementRelation, CompanyScope, withAllRelationsScope;

	protected $guarded = [
		'id'
	];
	public static function getShareableEditViewVars($model): array
	{

		return [
			'pageTitle' => CashFlowStatement::getPageTitle(),

		];
	}
	public function getRouteKeyName()
	{
		return 'cash_flow_statements.id';
	}
	public static function exportViewName(): string
	{
		return __('Cash Flow Statement');
	}
	public static function getFileName(): string
	{
		return __('Cash Flow Statement');
	}

	protected static function booted()
	{
		// static::addGlobalScope(new StateCountryScope);
	}

	public static function getCrudViewName(): string
	{
		return 'admin.cash-flow-statement.create';
	}

	public static function getViewVars(): array
	{
		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.cash.flow.statement', ['company' => $currentCompanyId]),
			'modelName' => 'CashFlowStatement',
			'exportRoute' => route('admin.export.cash.flow.statement', $currentCompanyId),
			'createRoute' => route('admin.create.cash.flow.statement', $currentCompanyId),
			'storeRoute' => route('admin.store.cash.flow.statement', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => CashFlowStatement::getPageTitle(),
			'redirectAfterSubmitRoute' => route('admin.view.cash.flow.statement', $currentCompanyId),
			'type' => 'create',
			'company' => Company::find($currentCompanyId),
			'redirectAfterSubmitRoute' => route('admin.view.cash.flow.statement', ['company' => getCurrentCompanyId()]),
			'durationTypes' => getDurationIntervalTypesForSelect()
		];
	}
	public static function getReportViewVars(array $options = []): array
	{
		$currentCompanyId =  getCurrentCompanyId();

		return [
			'getDataRoute' => route('admin.get.cash.flow.statement.report', ['company' => $currentCompanyId, 'incomeStatement' => $options['cash_flow_statement_id']]),
			'modelName' => 'CashFlowStatementReport',
			'exportRoute' => route('admin.export.cash.flow.statement.report', $currentCompanyId),
			'createRoute' => route('admin.create.cash.flow.statement.report', [
				'company' => $currentCompanyId,
				'incomeStatement' => $options['cash_flow_statement_id']
			]),
			'storeRoute' => route('admin.store.cash.flow.statement.report', $currentCompanyId),
			'hasChildRows' => false,
			'pageTitle' => __('Cash Flow Statement Report'),
			'redirectAfterSubmitRoute' => route('admin.view.cash.flow.statement', $currentCompanyId),
			'type' => 'create',
			'incomeStatement' => $options['incomeStatement'],
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
		return __('Cash Flow Statement');
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
