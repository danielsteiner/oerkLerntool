<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ["title"];

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function test() {
        return $this->belongsToMany('App\Test');
    }
}
