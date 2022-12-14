<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('image')->nullable();
            $table->float('stock')->nullable();
            $table->text('description')->nullable();
            $table->float('purchase_price')->nullable()->default(0);
            $table->float('selling_price')->nullable()->default(0);
            $table->integer('sales')->nullable()->default(0);
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('products');
    }
}
