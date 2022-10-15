<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->bigInteger('size_id')->unsigned();
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('product_sizes')){
            Schema::table('product_sizes', function (Blueprint $table) {
                $table->dropForeign('product_sizes_product_id_foreign');
                $table->dropForeign('product_sizes_size_id_foreign');
            });
        }
        Schema::dropIfExists('product_sizes');
    }
}
