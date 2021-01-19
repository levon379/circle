<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatatIntoOverviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('overview')->count();
        if (Schema::hasTable('overview') && !$tableData) {
            DB::table('overview')->insert(
                array(
                    'title' => 'TEST TITLE',
                    'text1' => 'TEST TITLE',
                    'text2' => 'TEST TITLE',
                    'text3' => 'TEST TITLE'
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
