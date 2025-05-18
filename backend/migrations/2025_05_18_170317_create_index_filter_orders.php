<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_orders_user_status');
            $table->index(['departure_date', 'arrival_date'], 'idx_orders_dates');
            $table->index('destination', 'idx_orders_destination');
            $table->index(['destination', 'departure_date', 'arrival_date'], 'idx_orders_destination_dates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user_status');
            $table->dropIndex('idx_orders_dates');
            $table->dropIndex('idx_orders_destination');
            $table->dropIndex('idx_orders_destination_dates');
        });
    }
};
