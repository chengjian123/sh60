<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHuiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hui', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('say_id');
            $table->string('addtime');
            $table->string('hui_content');
            $table->integer('commit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hui');
    }
}
