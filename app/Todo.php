<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
      'id', 'title', 'answer', 'completed',
    ];
    
}
