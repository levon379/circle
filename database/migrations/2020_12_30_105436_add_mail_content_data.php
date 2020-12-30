<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailContentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('mail_content')->insert(
            array(
                'subject' => 'TEST SUBJECT',
                'message' => 'TEST MESSAGE',
                'type'   => 'subscriber'
            ),
            array(
                'subject' => 'TEST SUBJECT FOR APP',
                'message' => 'TEST MESSAGE FOR APP',
                'type'   => 'application'
            )
        );
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
