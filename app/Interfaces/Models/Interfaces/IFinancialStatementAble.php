<?php

namespace App\Interfaces\Models\Interfaces;

use App\Models\FinancialStatement;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface IFinancialStatementAble
{
	public function getMainItemTableClassName(): string;
	public function mainRows(): BelongsToMany;
	public function subItems(): BelongsToMany;
	public function mainItems(): BelongsToMany;
	public function FinancialStatement(): FinancialStatement;
	public function withSubItemsFor(int $financialStatementAbleItemId, string $subItemType = '', string $subItemName = ''): BelongsToMany;
}
