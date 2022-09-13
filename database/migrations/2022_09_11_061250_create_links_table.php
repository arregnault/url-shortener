<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'links',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('code', 6)->unique();
                $table->text('url');
                $table->timestamps();
            }
        );

    }//end up()


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');

    }//end down()


}//end class
