<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('category_id',false, true)->nullable();
            $table->string('title', 191);
            $table->text('description');
            $table->string('logo');
            $table->tinyInteger('show',4);
            $table->string('price', 191);
            $table->enum('currency',['amd', 'usd'])->default(0);
            $table->string('link', 191);
            $table->integer('ordering')->nullable();
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
        Schema::dropIfExists('shop');
    }
}
