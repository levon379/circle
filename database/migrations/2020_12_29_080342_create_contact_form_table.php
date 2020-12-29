<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_form', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->boolean('status')->default(0)->nullable();
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
        Schema::dropIfExists('contact_form');
    }
}
