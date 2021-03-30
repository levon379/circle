<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurServicesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_services_list', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('our_services_id',false, true)->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->foreign('our_services_id')->references('id')->on('our_services')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('our_services_list');
    }
}
