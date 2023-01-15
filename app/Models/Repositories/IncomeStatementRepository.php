<?php

namespace App\Models\Repositories;

use App\Interfaces\Models\IBaseModel;
use App\Interfaces\Repositories\IBaseRepository;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IncomeStatementRepository implements IBaseRepository
{

	public function all(): Collection
	{
		return IncomeStatement::withAllRelations()->onlyCurrentCompany()->get();
	}

	public function allFormatted(): array
	{
		return IncomeStatement::onlyCurrentCompany()->get()->pluck('name', 'id')->toArray();
	}
	public function allFormattedForSelect()
	{
		$incomeStatements = $this->all();
		return formatOptionsForSelect($incomeStatements, 'getId', 'getName');
	}

	public function getAllExcept($id): ?Collection
	{
		return IncomeStatement::onlyCurrentCompany()->where('id', '!=', $id)->get();
	}

	public function query(): Builder
	{
		return IncomeStatement::onlyCurrentCompany()->query();
	}
	public function Random(): Builder
	{
		return IncomeStatement::onlyCurrentCompany()->inRandomOrder();
	}

	public function find(?int $id): IBaseModel
	{
		return IncomeStatement::onlyCurrentCompany()->find($id);
	}

	public function getLatest($column = 'id'): ?IncomeStatement
	{
		return IncomeStatement::onlyCurrentCompany()->latest($column)->first();
	}
	public function store(Request $request): IBaseModel
	{
		$incomeStatement = App(IncomeStatement::class);

		$incomeStatement = $incomeStatement
			->storeMainSection($request)->storeMainItems($request);
		return $incomeStatement;
	}

	public function storeReport(Request $request): IBaseModel
	{
		$incomeStatement = App(IncomeStatement::class);

		$incomeStatement
			->storeReport($request);

		return $incomeStatement;
	}

	public function update(IBaseModel $incomeStatement, Request $request): void
	{
		$incomeStatement
			->updateProfitability($request);
	}

	public function paginate(Request $request): array
	{

		$filterData = $this->commonScope($request);

		$allFilterDataCounter = $filterData->count();

		$datePerPage = $filterData->skip(Request('start'))->take(Request('length'))->get()->each(function (IncomeStatement $incomeStatement, $index) {
			$incomeStatement->creator_name = $incomeStatement->getCreatorName();
			$incomeStatement->created_at_formatted = formatDateFromString($incomeStatement->created_at);
			$incomeStatement->updated_at_formatted = formatDateFromString($incomeStatement->updated_at);
			$incomeStatement->order = $index + 1;
		});
		return [
			'data' => $datePerPage,
			"draw" => (int)Request('draw'),
			"recordsTotal" => IncomeStatement::onlyCurrentCompany()->count(),
			"recordsFiltered" => $allFilterDataCounter,
		];
	}

	public function paginateReport(Request $request, IncomeStatement $incomeStatement): array
	{

		$filterData = $this->commonScopeForReport($request, $incomeStatement);

		$allFilterDataCounter = $filterData->count();

		$dataWithRelations = collect([]);

		$datePerPage = $filterData->get()->each(function (IncomeStatementItem $incomeStatementItem, $index) use ($dataWithRelations, $incomeStatement) {
			$incomeStatementItem->creator_name = $incomeStatementItem->getCreatorName();
			$incomeStatementItem->created_at_formatted = formatDateFromString($incomeStatementItem->created_at);
			$incomeStatementItem->updated_at_formatted = formatDateFromString($incomeStatementItem->updated_at);
			$incomeStatementItem->order = $index + 1;
			$dataWithRelations->add($incomeStatementItem);
			$incomeStatementItem->getSubItems($incomeStatement->id)->each(function ($subItem) use ($dataWithRelations, $incomeStatementItem) {
				$subItem->isSubItem = true; // isSubRow
				if ($incomeStatementItem->has_depreciation_or_amortization) {
					$subItem->pivot->can_be_depreciation = true;
				}
				$dataWithRelations->add($subItem);
			});
		});
		return [
			'data' => $dataWithRelations,
			"draw" => (int)Request('draw'),
			"recordsTotal" => IncomeStatementItem::count(),
			"recordsFiltered" => $allFilterDataCounter,
		];
	}
	public function commonScope(Request $request): builder
	{
		return IncomeStatement::onlyCurrentCompany()->when($request->filled('search_input'), function (Builder $builder) use ($request) {

			$builder
				->where(function (Builder $builder) use ($request) {
					$builder->when($request->filled('search_input'), function (Builder $builder) use ($request) {
						$keyword = "%" . $request->get('search_input') . "%";
						$builder;
					});
				});
		})
			->orderBy('income_statements.' . getDefaultOrderBy()['column'], getDefaultOrderBy()['direction']);
	}

	public function commonScopeForReport(Request $request, IncomeStatement $incomeStatement): builder
	{

		return IncomeStatementItem::with(['subItems' => function ($builder) use ($incomeStatement) {
			$builder->where('income_statement_id', $incomeStatement->id);
		}])->whereHas('incomeStatements', function (Builder $builder) use ($incomeStatement) {
			$builder->where('income_statements.id', $incomeStatement->id);
		})
			->orderBy('income_statement_items.id', 'asc');
	}
}
