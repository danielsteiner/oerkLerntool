<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Passed5Tests extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Fünf Prüfungssimulationen bestanden!";

    /*
     * A small description for the achievement
     */
    public $description = "Wow, du hast schon 5 Prüfungssimulationen positiv absolviert - weiter so!";

    /*
     * The amunt of "points" a user needs to obtain to complete this achievement
     */
    public $points = 5;

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {

    }

}
