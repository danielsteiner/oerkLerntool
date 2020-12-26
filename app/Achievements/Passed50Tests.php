<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Passed50Tests extends Achievement
{
      /*
     * The achievement name
     */
    public $name = "Fünfzig Prüfungssimulationen bestanden!";

    /*
     * A small description for the achievement
     */
    public $description = "Fünfzig erfolgreiche Prüfungssimulationen - Das RK sollte sich an dich wenden wenn es Fragen zur Lehrmeinung hat, nicht umgekehrt!.";

    /*
     * The amunt of "points" a user needs to obtain to complete this achievement
     */
    public $points = 50;

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {

    }
}
