<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('author');
            $table->text('title');
            $table->string('discount');
            $table->string('quantity');
            $table->string('quantity_sold');
            $table->string('type');
            $table->string('publisher');
            $table->date('publish_date');
            $table->string('page');
            $table->string('dimensions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('author');
            $table->dropColumn('title');
            $table->dropColumn('quantity');
            $table->dropColumn('type');
            $table->dropColumn('publisher');
            $table->dropColumn('publish_date');
            $table->dropColumn('page');
            $table->dropColumn('dimensions');
        });
    }
}
