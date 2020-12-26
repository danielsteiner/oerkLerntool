<?php

namespace App\Events;

use App\Achievement;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public function __construct($achievement) {
    }
}
