<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('ward_id')->nullable();
            $table->text('address')->nullable();
            $table->text('full_name')->nullable();
            $table->string('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('ward_id');
            $table->dropColumn('address');
            $table->dropColumn('full_name');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
    }
}
