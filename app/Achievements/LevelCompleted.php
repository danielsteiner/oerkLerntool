<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class LevelCompleted extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Lernkartei Level abgeschlossen";

    /*
     * A small description for the achievement
     */
    public $description = "Glückwunsch, du hast alle Fragen in dem Level richtig beantwortet!";

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {

    }
}
