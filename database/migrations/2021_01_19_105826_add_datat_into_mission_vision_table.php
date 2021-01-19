<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatatIntoMissionVisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('mission_vision')->count();
        if (Schema::hasTable('mission_vision') && !$tableData) {
            DB::table('mission_vision')->insert(
                array(
                    'title' => 'TEST TITLE',
                    'mission_text' => 'TEST TITLE',
                    'vision_text' => 'TEST TITLE'
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
