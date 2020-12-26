<?php

namespace App\Http\Controllers;

use App\Level;
use App\User;
use App\Test;
use App\TestsTaken;
use DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        $weather =" 36° Celsius bei klarem Himmel";
        //Todo grab real weather data from owm
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('http://api.openweathermap.org/data/2.5/weather?q=Vienna,at&APPID=34eef609e9f7eb175d9d25add5e4f8fb&units=metric');

        $result = json_decode((string)$result->getBody());
        $temp = $result->main->temp;
        $weather = $result->weather[0]->description;
        $wstring= $temp."° bei ".$weather;
        return view('pages.admin.index')->with('weather', $wstring);
    }

    public function users(){
        $users = User::all();
        return view('pages.admin.users')->with('users', $users);
    }

}
