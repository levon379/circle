<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatatIntoAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('about_us')->count();
        if (Schema::hasTable('about_us') && !$tableData) {
            DB::table('about_us')->insert(
                array(
                    'title' => 'TEST TITLE',
                    'description' => 'TEST Descr'
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
