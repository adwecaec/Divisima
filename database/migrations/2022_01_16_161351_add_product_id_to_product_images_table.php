<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('product_images', 'product_id')) {
            Schema::table('product_images', function (Blueprint $table) {
                $table->bigInteger('product_id')->unsigned()->after('url');
                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');
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
        Schema::table('product_images', function (Blueprint $table) {
            //
        });
    }
}
