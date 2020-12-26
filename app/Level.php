<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ["user_id", "test_id", "question_id", "currentLevel"];

    public function question(){
        return $this->belongsTo('App\Question');
    }
}
