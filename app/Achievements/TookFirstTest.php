<?php

namespace App\Achievements;

use App\Events\AchievementUnlocked;
use Gstt\Achievements\Achievement;

class TookFirstTest extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Test absolviert!";

    /*
     * A small description for the achievement
     */
    public $description = "Glückwunsch, du hast deine erste Prüfungssimulation abgeschlossen - weiter so!";

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {
        event(new AchievementUnlocked($this));
    }
}
