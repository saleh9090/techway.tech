<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'date',
        'income_category_id',
        'income_item_id',
        'amount',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(IncomeItem::class, 'income_item_id');
    }
}
