<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Passed10Tests extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Zehn Prüfungssimulationen bestanden!";

    /*
     * A small description for the achievement
     */
    public $description = "Zehn erfolgreiche Prüfungssimulationen - dir steht nichts mehr im weg.";

    /*
     * The amunt of "points" a user needs to obtain to complete this achievement
     */
    public $points = 10;

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {

    }
}
