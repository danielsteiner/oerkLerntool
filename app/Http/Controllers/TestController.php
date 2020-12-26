<?php

namespace App\Http\Controllers;


use App\Test;
use App\Question;
use App\User;
use App\TestsTaken;
use App\Level;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Input;

use App\Achievements\Passed5Tests;
use App\Achievements\Passed10Tests;
use App\Achievements\Passed50Tests;
use App\Achievements\TookFirstTest;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tests = Test::all();
        return view('pages.test.index', ["tests" => $tests]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test) {
        $simulation_attempts = TestsTaken::where('user_id', auth()->user()->id)->where('test_id', $test->id)->orderBy('created_at', 'desc')->get();

        $numOfLevels = config('lernkartei.numOfLevels');

        $levels = [];
        $i=1;
        while($numOfLevels > 0) {
            $levels[$i] = ["questions" => []];
            $i++;
            $numOfLevels--;
        }
        $questions = [];
        $categories = $test->categories;
        foreach($categories as $category) {
            $questions = array_merge($questions, json_decode(json_encode($category->questions), true));
        }
        foreach($questions as $question) {
            $question_level = Level::where('user_id', auth()->user()->id)->where('test_id', $test->id)->where('question_id', $question["id"])->first();
            if(!is_null($question_level)) {
                $levels[$question_level->currentLevel]["questions"][] = $question;
            } else {
                $levels[1]["questions"][] = $question;
            }
        }

        return view('pages.test.show', ["test" => $test, "levels" => $levels, "attempts" => $simulation_attempts]);

    }

    public function simulation($testId) {
        $test = Test::find($testId);
        $questions = [];
        $testsimulation = [];
        $categories = $test->categories()->get();
        foreach($categories as $category) {
            $q = json_decode(json_encode($category->questions()->get()), true);
            $questions = array_merge($questions, $q);
        }
        shuffle($questions);
        $testsimulation = array_slice($questions, 0, 30);

        return view('pages.test.simulation', ["test"=>$test, "questions" => $testsimulation]);
    }

    public function auswerten() {
        $data = Input::all();
        $reachedPoints = 0;
        $test = Test::find($data["test_id"]);
        $user = User::find($data["user_id"]);

        $question = [];
        $questions = json_decode($data["questions"]);
        foreach($questions as $question) {
            if(array_key_exists($question->catalog_id, $data["answers"])){
                $answers = $data["answers"][$question->catalog_id];
                $question->givenAnswers = $answers;

                $qanswers = $question->answers;
                //check if answer was selected
                foreach($answers as $answer) {
                    $a = $question->answers[$answer];
                    $a->wasAnswered = true;
                    $qanswers[(int)$answer] = $a;
                }

                $correctAnswers = [];
                $question->answers = $qanswers;
                foreach($question->answers as $key => $answer) {
                    if($answer->correct) {
                        $correctAnswers[] = $key;
                    }
                }

                if($this->checkAnswer($answers, $correctAnswers)) {
                    $reachedPoints++;
                    $question->answeredCorrectly = true;
                } else {
                    $question->answeredCorrectly = false;
                }
                $question->correctAnswerCount = count($correctAnswers);
            } else {
                $correctAnswers = [];
                foreach($question->answers as $key => $answer) {
                    if($answer->correct) {
                        $correctAnswers[] = $key;
                    }
                }
                $question->answeredCorrectly = false;
                $question->correctAnswerCount = count($correctAnswers);

            }


        }
        $testresult = new TestsTaken();
        $testresult->test_id = $test->id;
        $testresult->user_id = $user->id;
        $testresult->reachedPoints = $reachedPoints;
        $testresult->questions = json_encode($questions);
        $testresult->save();
        if($testresult->reachedPoints >= 23) {
            $user->addProgress(new Passed5Tests(), 1);
            $user->addProgress(new Passed10Tests(), 1);
            $user->addProgress(new Passed50Tests(), 1);
        }
        // Check if achievement is applicable
        $testsTaken = TestsTaken::where('user_id', $data["user_id"])->get();
        $amountOfTests = count($testsTaken);
        if($amountOfTests == 1) {
            $user->unlock(new TookFirstTest());
        }

        return view('pages.test.simulationresult', ["test" => $test, "reachedPoints" => $reachedPoints, "questions" => $questions]);
    }

    public function result($test_id, $attempt_id) {
        $attempt = TestsTaken::find($attempt_id);
        $test = Test::find($test_id);
        $questions = json_decode($attempt->questions);
        $reachedPoints = $attempt->reachedPoints;
        return view('pages.test.simulationresult', ["test" => $test, "reachedPoints" => $reachedPoints, "questions" => $questions]);

    }

    public function lernkartei($test_id, $level_id) {
        $test = Test::find($test_id);

        //!: Prepopulate Levels at first attempt. Without this, there are no questions in the levels. Might be hard on the DB
        $qil = Level::where('user_id', auth()->user()->id)->where('test_id', $test->id)->get();
        if(count($qil) == 0) {
            //User has no Quesiton in any Level. Prepopulate Level 1 with all Questions.
            $questions = [];
            $categories = $test->categories()->get();
            foreach($categories as $category) {
                $q = json_decode(json_encode($category->questions()->get()), true);
                $questions = array_merge($questions, $q);
            }
            $data = [];
            foreach($questions as $question) {
                $level = new Level();
                $q = [
                    "user_id" => auth()->user()->id,
                    "test_id" => $test->id,
                    "question_id" => $question["id"],
                    "currentLevel" => 1,
                    "updated_at" => Carbon::now(),
                    "created_at" => Carbon::now()
                ];
                $data[] = $q;
            }
            Level::insert($data);
        }
        $question = Level::where('user_id', auth()->user()->id)->where('test_id', $test->id)->where('currentLevel', $level_id)->inRandomOrder()->first();

        if(!is_null($question)) {
            //There are Questions left
            $correctAnswers = [];
            foreach($question->question->answers as $key => $answer) {
                if($answer->correct) {
                    $correctAnswers[] = $key;
                }
            }
            $category = $question->question->category->title;
            $question->question->correctAnswerCount = count($correctAnswers);

            $question->question = json_decode(json_encode($question->question), true);
            $category = Category::find($question->question['category_id']);
            return view('pages.test.lernkartei', ['test' => $test, 'level' => $level_id, 'question' => $question, 'category' => $category->title]);
        } else {
            //done with this level. return to test overview
            return view('pages.test.lernkartei_done', ['test' => $test, 'level' => $level_id]);
        }
    }

    public function karteianswer(){
        $data = Input::all();
        if(!array_key_exists("answers", $data)) {
            return redirect()->action(
                'TestController@lernkartei', ['test_id' => $data["test_id"], 'level_id' => $data["currentLevel"]]);
        }
        $catalog_id = key($data["answers"]);
        $question = Question::where('catalog_id', $catalog_id)->first();

        $givenAnswers = $data["answers"][$catalog_id];
        $correctAnswers = [];

        foreach($question->answers as $key => $answer) {
            if($answer->correct) {
                $correctAnswers[] = $key;
            }
        }
        $level = Level::firstOrNew(['user_id' => auth()->user()->id, 'question_id' => $question->id, 'test_id' => $data["test_id"]]);
        if($this->checkAnswer($givenAnswers, $correctAnswers)) {
            $level->currentLevel = $level->currentLevel+1;
        } else {
            if($level->currentLevel > 1) {
                $level->currentLevel = $level->currentLevel-1;
            } else {
                $level->currentLevel = 1;
            }
        }
        $level->save();
        return redirect()->action(
            'TestController@lernkartei', ['test_id' => $data["test_id"], 'level_id' => $data["currentLevel"]]);
    }

    private function checkAnswer($givenAnswers, $correctAnswers) {
        foreach($givenAnswers as $key => $a) {
            $givenAnswers[$key] = (int)$a;
        }
        return $givenAnswers == $correctAnswers;
    }


}
