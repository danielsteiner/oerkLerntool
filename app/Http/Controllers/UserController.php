<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\TestsTaken;
use Illuminate\Http\Request;
use App\User;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  User $userid
     * @return \Illuminate\Http\Response
     */
    public function show($userid)
    {
        $user = User::find($userid);
        $email = md5(strtolower(trim($user->email)));
        $user->avatar_url = "https://www.gravatar.com/avatar/".$email;
        $tests_taken = TestsTaken::where('user_id', $user->id)->get();
        $passed_tests = TestsTaken::where('user_id', $user->id)->where('reachedPoints', '>=', 23)->get();
        foreach($user->achievements as $k => $achievement){

            $ach = Achievement::find($achievement->achievement_id);
            $user->achievements[$k]->data = $ach;
            if($ach->points > 0) {
                $user->achievements[$k]->percent = ($achievement->points / $ach->points)*100;
            }
            if($achievement->points == 0) {
                unset($user->achievements[$k]);
            }
        }

        return view("pages.user.show")->with("user", $user)->with("tests_taken", $tests_taken)->with("passed_tests", $passed_tests);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
