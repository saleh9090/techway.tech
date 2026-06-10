<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('income_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('income_item_id')->constrained('income_items')->restrictOnDelete();
            $table->decimal('amount', 12, 2)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
