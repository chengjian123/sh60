<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->string('commit_content');
            $table->string('commit_time');
            $table->tinyInteger('type_id')->default(3);
            $table->integer('commit_users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_comment');
    }
}
