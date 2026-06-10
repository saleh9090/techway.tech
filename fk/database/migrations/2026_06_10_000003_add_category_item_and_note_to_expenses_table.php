<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')->nullable()->after('date')->constrained()->nullOnDelete();
            $table->foreignId('expense_item_id')->nullable()->after('expense_category_id')->constrained('expense_items')->nullOnDelete();
            $table->text('note')->nullable()->after('details');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('expense_item_id');
            $table->dropConstrainedForeignId('expense_category_id');
            $table->dropColumn('note');
        });
    }
};
