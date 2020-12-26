<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

use App\Category;
use App\Question;

class ParseQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'questions:parse {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses given question file.';

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
        $filename = $this->argument('filename');
        if(Storage::exists($filename)){
            $content = Storage::get($filename);
            $rawQuestions = explode("// question: ", $content);
            $questionTree = [];
            $currentCategory = null;
            $currentCategoryId = null;
            foreach($rawQuestions as $rawQuestion) {
                $lines = explode("\n", $rawQuestion);
                foreach($lines as $i => $line) {
                    if(empty($line)) unset($lines[$i]);
                }
                if(!empty($lines)){
                    if($lines[0][0] === "0") {
                        // Category
                        $lines[1] = str_replace("\$CATEGORY: \$system\$/top", "", $lines[1]);
                        if(!empty($lines[1])) {
                            $parts = explode("/", $lines[1]);
                            unset($parts[0]);
                            $parts = array_reverse($parts);
                            if(strpos($parts[0], "Kategorie wählen") === false) {
                                $category['title'] = $parts[0];
                                $category['questions'] = [];

                                $category = Category::firstOrNew(['title' => $parts[0]]);
                                $category->title = $parts[0];
                                $category->save();

                                $currentCategoryId = $category->id;
                                $currentCategory = $category->title;

                                $questionTree[] = $category;
                            } else {
                                //Root Category, not needed.
                            }
                        }
                    } else {
                        // Question
                        if($lines[count($lines)-1] === "}") unset($lines[count($lines)-1]);


                        $question = [];
                        $question['catalog_id'] = substr($lines[0], 0, strpos($lines[0], "  "));
                        $question['question'] = explode("::", $lines[1])[1];

                        //unset question text
                        unset($lines[0]);
                        unset($lines[1]);
                        $answers = [];
                        foreach($lines as $answer) {
                            $answer = str_replace("\t", "", $answer);
                            $a = [];

                            $answer = str_replace('[moodle]', '', $answer);

                            if($answer[0] === "=") {
                                // this is the correct answer and there is only one answer.
                                $a['text'] = substr($answer, 1);
                                $a['correct'] = true;
                            } else if (strpos($answer, "~%-100%") !== false ) {
                                // this answer is wrong and theoretically brings -100% of the max given points;
                                $a['text'] = substr($answer, 7);
                                $a['correct'] = false;
                            } else if (strpos($answer, "~%100%") !== false ) {
                                // this answer is wrong and theoretically brings -100% of the max given points;
                                $a['text'] = substr($answer, 6);
                                $a['correct'] = true;
                            } else if (strpos($answer, "~%50%") !== false ) {
                                // this answer is wrong and theoretically brings -100% of the max given points;
                                $a['text'] = substr($answer, 5);
                                $a['correct'] = true;
                            } else if (strpos($answer, "~%33.33333%") !== false ) {
                                // this answer is wrong and theoretically brings -100% of the max given points;
                                $a['text'] = substr($answer, 11);
                                $a['correct'] = true;
                            } else if (strpos($answer, "~%25%") !== false ) {
                                // this answer is wrong and theoretically brings -100% of the max given points;
                                $a['text'] = substr($answer, 5);
                                $a['correct'] = true;
                            }

                            $answers[] = $a;

                        }
                        $question['category_id'] = $currentCategoryId;
                        $question['answers'] = $answers;
                        $q = Question::firstOrNew(['catalog_id' => $question['catalog_id']]);
                        $q->question = $question['question'];
                        $q->answers = $question['answers'];
                        $q->category_id = $question['category_id'];
                        $q->save();
                        // $questionTree[$this->searchForId($currentCategory, $questionTree)]['questions'][] = $question;
                    }
                }
            }
            print_r("Done!");
        } else {
            print_r("File not found");
        }


    }

    public function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['title'] === $id) {
                return $key;
            }
        }
        return null;
     }
}
