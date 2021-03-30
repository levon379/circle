<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurServicesListItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_services_list_item', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('our_services_list_id',false, true)->nullable();
            $table->string('name');
            $table->timestamps();
            $table->foreign('our_services_list_id')->references('id')->on('our_services_list')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('our_services_list_item');
    }
}
