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
        Schema::table('products', function (Blueprint $table) {
            $table->string('badge_text', 50)->nullable()->after('is_active')
                ->comment('Custom badge text like "GOOD PRICE", "NEW", "SALE", etc.');
            $table->string('badge_type', 20)->default('discount')->after('badge_text')
                ->comment('Badge style: discount, price, new, sale, hot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'badge_type']);
        });
    }
};
