<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataHealthSafetyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('health_safety')->count();
        if (Schema::hasTable('health_safety') && !$tableData) {
            DB::table('health_safety')->insert(
                array(
                    'title' => 'Environment Health & Safety',
                    'description' => 'TEST TITLE',
                    'text1' => 'TEST TITLE',
                    'text2' => 'TEST TITLE',
                    'text3' => 'TEST TITLE',
                    'text4' => 'TEST TITLE'
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
