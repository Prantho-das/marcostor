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

                Schema::table('orders', function (Blueprint $table) {
            // 🧍 Customer Info Fields
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->after('user_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'mobile')) {
                $table->string('mobile', 50)->after('name')->nullable();
            }
            if (!Schema::hasColumn('orders', 'area')) {
                $table->string('area')->after('mobile')->nullable();
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address', 500)->after('area')->nullable();
            }

            // 💰 Delivery + Shipping
            if (!Schema::hasColumn('orders', 'delivery_charge')) {
                $table->decimal('delivery_charge', 10, 2)->default(0.00)->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0.00)->after('delivery_charge');
            }

            // 🧾 Order Number (unique)
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('user_id');
            }

            // 💳 Payment flags
            if (!Schema::hasColumn('orders', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('payment_method');
            }
        });
        

          Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->unsignedBigInteger('order_id')->after('id');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            }

            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->unsignedBigInteger('product_id')->after('order_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            }

            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->default(1);
            }

            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->default(0.00);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['name', 'mobile', 'area', 'address', 'delivery_charge', 'shipping_cost', 'order_number', 'is_paid'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            $columns = ['order_id', 'product_id', 'quantity', 'price'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('order_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
