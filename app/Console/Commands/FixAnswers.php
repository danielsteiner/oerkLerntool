<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

use App\Category;
use App\Question;

class FixAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'questions:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixes Questions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $questions = Question::all();
        foreach($questions as $i => $question) {
            $answers = $question->answers;
            $wasUpdated = false;
            foreach($answers as $j => $answer) {
                if(gettype($answer) == "object") {
                    if(strpos($answer->text,"\\")!==false) {
                        $answer->text = str_replace('\\', '', $answer->text);
                        $answers[$j] = $answer;
                        $wasUpdated = true;
                    }
                    if(strpos($answer->text,"#")!==false) {
                        $answer->text = explode('#', $answer->text)[0];
                        $answers[$j] = $answer;
                        $wasUpdated = true;
                    }
                }
            }
            if($wasUpdated) {
                $question->answers = $answers;
                $question->save();
            }
        }
    }
}
