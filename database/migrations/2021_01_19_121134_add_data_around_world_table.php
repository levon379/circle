<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataAroundWorldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('around_world')->count();
        if (Schema::hasTable('around_world') && !$tableData) {
            DB::table('around_world')->insert(
                array(
                    'title' => 'Around The World',
                    'description' => 'TEST TITLE'
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
