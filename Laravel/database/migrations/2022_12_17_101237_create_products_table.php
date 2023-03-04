<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id'); //ジュースのID
            $table->string('company_id'); //自販機ID
            $table->string('product_name'); //名前
            $table->integer('price'); //価格
            $table->integer('stock'); //在庫数
            $table->text('comment'); //コメント
            $table->string('img_path'); //画像
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
        Schema::dropIfExists('products');
    }
}