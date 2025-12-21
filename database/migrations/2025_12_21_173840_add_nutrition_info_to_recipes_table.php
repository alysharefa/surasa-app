<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('calories')->nullable()->after('servings'); // kcal
            $table->integer('protein')->nullable()->after('calories'); // grams
            $table->integer('fat')->nullable()->after('protein'); // grams
            $table->integer('carbs')->nullable()->after('fat'); // grams
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['calories', 'protein', 'fat', 'carbs']);
        });
    }
};
