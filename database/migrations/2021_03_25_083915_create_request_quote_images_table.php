<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestQuoteImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_quote_images', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('request_quotes_id',false, true)->nullable();
            $table->string('image');
            $table->timestamps();

            $table->foreign('request_quotes_id')->references('id')->on('request_quote')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_quote_images');
    }
}
