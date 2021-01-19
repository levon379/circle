<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatatIntoIntegratedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableData = DB::table('integrated')->count();
        if (Schema::hasTable('integrated') && !$tableData) {
            DB::table('integrated')->insert(
                array(
                    'title' => 'TEST TITLE',
                    'description1' => 'TEST TITLE',
                    'description2' => 'TEST TITLE'
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
