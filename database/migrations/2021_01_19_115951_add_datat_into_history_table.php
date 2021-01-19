<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatatIntoHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('history')->count();
        if (Schema::hasTable('history') && !$tableData) {
            DB::table('history')->insert(
                array(
                    'title' => 'History',
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
