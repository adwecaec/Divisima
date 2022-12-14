<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacteristicsFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('products','product_color_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->bigInteger('product_color_id')->unsigned();
                $table->bigInteger('product_season_id')->unsigned();
             });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('products')
            && Schema::hasColumns('products', ['product_season_id', 'product_color_id'])
        ){
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('product_season_id');
                $table->dropColumn('product_color_id');
            });
        }
    }
}
