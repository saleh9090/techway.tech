<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomeCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(IncomeItem::class);
    }

    public function income(): HasMany
    {
        return $this->hasMany(Income::class);
    }
}
