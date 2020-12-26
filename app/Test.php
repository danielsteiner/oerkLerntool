<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $appends = ["questionCount"];

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    public function getQuestionCountAttribute() {
        $categories = $this->categories()->get();
        $questions = 0;
        foreach($categories as $category) {
            $questions += count($category->questions()->get());
        }
        return $questions;
    }
}
