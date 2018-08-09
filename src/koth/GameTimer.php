<?php
/**
 * Created: 
 * User: 
 * Date: 
 * Time: 
 */
namespace koth;
use pocketmine\scheduler\Task;
class GameTimer extends Task
{
    private $plugin;
    private $arena;
    private $time;
    public function __construct(KothMain $owner, KothArena $arena){
        $this->plugin = $owner;
        $this->arena = $arena;
        $this->time = $owner->getData("game_time") * 60;
    }
    public function onRun(int $currentTick) : void{
        $time = $this->time--;
        if ($time < 1){
            $this->arena->endGame();
            $this->getHandler()->cancel();
            return;
        }
        $msg = $this->plugin->getData("game_bar");
        $msg = str_replace("{time}", gmdate("i:s", $time), $msg);
        $this->arena->sendPopup($msg);
        $this->arena->checkPlayers();
    }
}
