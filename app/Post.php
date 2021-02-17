<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\

class Post extends Model
{
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('body');
        $table->timestamps();
    });
}
