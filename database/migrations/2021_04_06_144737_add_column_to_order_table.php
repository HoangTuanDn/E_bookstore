<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->string('order_code');
            $table->integer('ship_id');
            $table->integer('coupon_id')->nullable();
            $table->integer('payment_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_code');
            $table->dropColumn('ship_id');
            $table->dropColumn('coupon_id');
            $table->dropColumn('payment_id');
            $table->dropColumn('deleted_at');
        });
    }
}
