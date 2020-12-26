<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ["catalog_id",  "question", "answers"];
    protected $casts = [
        'answers' => 'object'
   ];

    //relations
    public function category() {
        return $this->belongsTo('App\Category');
    }
    public function level(){
        return $this->hasMany('App\Level');
    }
}
