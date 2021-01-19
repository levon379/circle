<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('people')->count();
        if (Schema::hasTable('people') && !$tableData) {
            DB::table('people')->insert(
                array(
                    'title' => 'Tahweel\'s People',
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
