<?php

namespace App\Models\Repositories;

use App\Interfaces\Models\IBaseModel;
use App\Interfaces\Repositories\IBaseRepository;
use App\Models\BalanceSheet;
use App\Models\CashFlowStatement;
use App\Models\FinancialStatement;
use App\Models\FinancialStatementItem;
use App\Models\IncomeStatement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FinancialStatementRepository implements IBaseRepository
{

	public function all(): Collection
	{
		return FinancialStatement::withAllRelations()->onlyCurrentCompany()->get();
	}

	public function allFormatted(): array
	{
		return FinancialStatement::onlyCurrentCompany()->get()->pluck('name', 'id')->toArray();
	}
	public function allFormattedForSelect()
	{
		$financialStatements = $this->all();
		return formatOptionsForSelect($financialStatements, 'getId', 'getName');
	}

	public function getAllExcept($id): ?Collection
	{
		return FinancialStatement::onlyCurrentCompany()->where('id', '!=', $id)->get();
	}

	public function query(): Builder
	{
		return FinancialStatement::onlyCurrentCompany()->query();
	}
	public function Random(): Builder
	{
		return FinancialStatement::onlyCurrentCompany()->inRandomOrder();
	}

	public function find(?int $id): IBaseModel
	{
		return FinancialStatement::onlyCurrentCompany()->find($id);
	}

	public function getLatest($column = 'id'): ?FinancialStatement
	{
		return FinancialStatement::onlyCurrentCompany()->latest($column)->first();
	}
	public function store(Request $request): IBaseModel
	{
		$financialStatement = new FinancialStatement();

		$incomeStatement = new IncomeStatement();

		$cashFlowStatement = new CashFlowStatement();

		$balanceSheet = new BalanceSheet();

		$financialStatementName = $request->name;

		$financialStatement = $financialStatement->storeMainSection($request)->storeMainItems($request);

		$request['financial_statement_id'] = $financialStatement->id;

		$request['name'] = $financialStatementName . ' IncomeStatement';
		$incomeStatement = $incomeStatement->storeMainSection($request)->storeMainItems($request);

		$request['name'] = $financialStatementName . ' CashFlowStatement';
		$cashFlowStatement = $cashFlowStatement->storeMainSection($request)->storeMainItems($request);

		$request['name'] = $financialStatementName . ' BalanceSheet';
		$balanceSheet = $balanceSheet->storeMainSection($request)->storeMainItems($request);


		return $financialStatement;
	}

	public function storeReport(Request $request): IBaseModel
	{
		$financialStatement = App(FinancialStatement::class);

		$financialStatement
			->storeReport($request);

		return $financialStatement;
	}

	public function update(IBaseModel $financialStatement, Request $request): void
	{
		// $financialStatement
		// 	->updateProfitability($request);
	}

	public function paginate(Request $request): array
	{

		$filterData = $this->commonScope($request);

		$allFilterDataCounter = $filterData->count();

		$datePerPage = $filterData->skip(Request('start'))->take(Request('length'))->get()->each(function (FinancialStatement $financialStatement, $index) {
			$financialStatement->creator_name = $financialStatement->getCreatorName();
			$financialStatement->financial_statement_able_id = $financialStatement->cashFlowStatement ? $financialStatement->cashFlowStatement->id : 0;
			$financialStatement->financial_statement_able_id = $financialStatement->balanceSheet ? $financialStatement->balanceSheet->id : 0;
			$financialStatement->financial_statement_able_id = $financialStatement->incomeStatement ? $financialStatement->incomeStatement->id : 0;
			$financialStatement->created_at_formatted = formatDateFromString($financialStatement->created_at);
			$financialStatement->updated_at_formatted = formatDateFromString($financialStatement->updated_at);
			$financialStatement->order = $index + 1;
		});
		return [
			'data' => $datePerPage,
			"draw" => (int)Request('draw'),
			"recordsTotal" => FinancialStatement::onlyCurrentCompany()->count(),
			"recordsFiltered" => $allFilterDataCounter,
		];
	}

	public function paginateReport(Request $request, FinancialStatement $financialStatement): array
	{

		$filterData = $this->commonScopeForReport($request, $financialStatement);

		$allFilterDataCounter = $filterData->count();

		$dataWithRelations = collect([]);
		$datePerPage = $filterData->get()->each(function (FinancialStatementItem $financialStatementItem, $index) use ($dataWithRelations, $financialStatement) {
			$financialStatementItem->creator_name = $financialStatementItem->getCreatorName();
			$financialStatementItem->created_at_formatted = formatDateFromString($financialStatementItem->created_at);
			$financialStatementItem->updated_at_formatted = formatDateFromString($financialStatementItem->updated_at);
			$financialStatementItem->order = $index + 1;

			$dataWithRelations->add($financialStatementItem);
			$financialStatementItem->getSubItems($financialStatement->id)->each(function ($subItem) use ($dataWithRelations, $financialStatementItem) {
				$subItem->isSubItem = true; // isSubRow

				if ($financialStatementItem->has_depreciation_or_amortization) {
					$subItem->pivot->can_be_depreciation = true;
				}
				$dataWithRelations->add($subItem);
			});
		});
		return [
			'data' => $dataWithRelations,
			"draw" => (int)Request('draw'),
			"recordsTotal" => FinancialStatementItem::count(),
			"recordsFiltered" => $allFilterDataCounter,
		];
	}
	public function commonScope(Request $request): builder
	{
		return FinancialStatement::onlyCurrentCompany()->when($request->filled('search_input'), function (Builder $builder) use ($request) {

			$builder
				->where(function (Builder $builder) use ($request) {
					$builder->when($request->filled('search_input'), function (Builder $builder) use ($request) {
						$keyword = "%" . $request->get('search_input') . "%";
						$builder;
					});
				});
		})
			->orderBy('financial_statements.' . getDefaultOrderBy()['column'], getDefaultOrderBy()['direction']);
	}

	public function commonScopeForReport(Request $request, FinancialStatement $financialStatement): builder
	{

		return FinancialStatementItem::with(['subItems' => function ($builder) use ($financialStatement) {
			$builder->where('financial_statement_id', $financialStatement->id);
		}])->whereHas('financialStatements', function (Builder $builder) use ($financialStatement) {
			$builder->where('financial_statements.id', $financialStatement->id);
		})
			->orderBy('financial_statement_items.id', 'asc');
	}
}
