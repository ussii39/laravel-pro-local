<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');// idという名前の主キー、bigint型のカラムを作成
            $table->bigInteger('user_id'); // user_idというbigint型のカラム作成
            $table->string('message'); // messageというvarchar型のカラム作成
            $table->timestamps(); // create_at, update_atカラム作成
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
