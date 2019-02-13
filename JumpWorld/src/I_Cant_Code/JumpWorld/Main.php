<?php

declare(strict_types=1);

namespace I_Cant_Code\JumpWorld;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

	public function onEnable() : void{
		$this->getLogger()->info("Jump World activated.");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName() && $sender->isOp()){
			case "jump":
				if(!(isset($args[0]))) {
                    $sender->sendMessage("Use /jump <world name>");
                    return false;
                } else {
				    if($sender instanceof Player){
                        if ($this->getServer()->loadLevel($args[0]) != false){
                            $sender->teleport($this->getServer()->getLevelByName($args[0])->getSafeSpawn(), null, null);
                        } else {
                            if($this->getServer()->getLevelByName($args[0]) == false){
                                $sender->sendMessage("That world doesn't exist.");
                                return false;
                            } else {
                                $this->getServer()->loadLevel($args[0]);
                                $sender->sendMessage($args[0] ." world is being loaded. Please try again soon.");
                            }
                        }
                    }
                }
                break;
            case "create":
                if(!(isset($args[0]))){
                    $sender->sendMessage(TextFormat::GREEN."Use /create <world name>");
                    return false;
                } else {
                    if($this->getServer()->getLevelByName($args[0])){
                        $sender->sendMessage(TextFormat::GREEN."A world with that name already exists.");
                    }else {
                        $this->getServer()->generateLevel($args[0],null,"FLAT",["preset" => "2;0;1"]);
                        $sender->sendMessage($args[0]." has been created.");
                        }

                    }
                    break;
                }

		return true;
	}

	public function onDisable() : void{
		$this->getLogger()->info("Jump World deactivated.");
	}
}
