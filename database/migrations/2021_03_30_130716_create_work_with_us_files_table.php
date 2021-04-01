<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkWithUsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_with_us_files', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('work_with_us_id',false, true)->nullable();
            $table->string('image');
            $table->string('origin_name');
            $table->string('ext');
            $table->timestamps();

            $table->foreign('work_with_us_id')->references('id')->on('work_with_us')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_with_us_files');
    }
}
