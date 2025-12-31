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
        // Add indexes only if they don't exist
        Schema::table('products', function (Blueprint $table) {
            if (!$this->indexExists('products', 'products_brand_index')) {
                $table->index('brand');
            }
            if (!$this->indexExists('products', 'products_is_active_index')) {
                $table->index('is_active');
            }
        });
        
        Schema::table('orders', function (Blueprint $table) {
            if (!$this->indexExists('orders', 'orders_status_index')) {
                $table->index('status');
            }
            if (!$this->indexExists('orders', 'orders_created_at_index')) {
                $table->index('created_at');
            }
        });
    }
    
    private function indexExists($table, $index)
    {
        $indexes = Schema::getIndexes($table);
        foreach ($indexes as $idx) {
            if ($idx['name'] === $index) {
                return true;
            }
        }
        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if ($this->indexExists('products', 'products_brand_index')) {
                $table->dropIndex(['brand']);
            }
            if ($this->indexExists('products', 'products_is_active_index')) {
                $table->dropIndex(['is_active']);
            }
        });
        
        Schema::table('orders', function (Blueprint $table) {
            if ($this->indexExists('orders', 'orders_status_index')) {
                $table->dropIndex(['status']);
            }
            if ($this->indexExists('orders', 'orders_created_at_index')) {
                $table->dropIndex(['created_at']);
            }
        });
    }
};
