<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // $questions = Question::all();
        $question->category = $question->category();
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    /**
     * Returns all Questions of given test for a PDF Export.
     */
    public function exportTest($test_id, $prechecked = false) {
        $export = [];
        $test = Test::find($test_id);
        $export["name"] = $test->title;
        $export["time"] = \Carbon\Carbon::now()->format("d.m.Y H:i");
        $export["categoryCount"] = count($test->categories);
        $export["questionCount"] = 0;
        foreach($test->categories as $category) {
            $cat = [];
            $cat["name"] = $category->title;
            $cat["questionCount"] = count($category->questions);
            $export["questionCount"] += count($category->questions);
            $cat["questions"] = [];
            foreach($category->questions as $question) {
                $q = [];
                $q["catalogid"] = $question->catalog_id;
                $q["question"] = $question->question;
                $q["answers"] = $question->answers;
                $cat["questions"][] = $q;
            }
            $export["categories"][] = $cat;
        }
        // $pdf = PDF::loadView('pages.export.test', ['data' => $export, 'prechecked' => $prechecked]);
        // if($prechecked) {
        //     return $pdf->download('Fragenkatalog '.$export["name"].' mit Antworten.pdf');
        // } else {
        //     return $pdf->download('Fragenkatalog '.$export["name"].' ohne Antworten.pdf');
        // }
        return view('pages.export.test', ['data' => $export, 'prechecked' => $prechecked]);
    }

}
