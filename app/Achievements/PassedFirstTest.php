<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class PassedFirstTest extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Erster Test bestanden!";

    /*
     * A small description for the achievement
     */
    public $description = "Gratuliere, du hast deinen ersten Test bestanden!";

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {

    }
}
