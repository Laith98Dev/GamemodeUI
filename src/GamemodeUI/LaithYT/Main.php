<?php

namespace GamemodeUI\LaithYT;

/*  Copyright (2018 - 2020) (C) LaithYoutuber
 *
 * Plugin By LaithYT , Gihhub:                                                                           
 *                                                                                                      
 *		88  		8855555555	88888889888	888888888888 88			88	 88888888888'8	888888888888'8  
 *		88			88		88		88			88		 88			88	 88		 	88	88			88  
 *		88			88		88		88			88	   	 88			88	 88			88	88			88  
 *		88			88		88		88			88		 88			88	 88			88	88			88  
 *		88			88		88		88			88		 88			88	 88			88	88			88  
 *		88			8855555588		88			88		 8855555555588   8888888855553	88555555555588	
 *		88			88		88		88			88		 88			88	 			88	88			88  
 *		88			88		88		88			88		 88			88	 			88	88			88  
 *		88			88		88		88			88		 88			88				88	88			88 
 *		85      	88		88		88			88		 88			88				88	88			88  
 *		8855555555	88		88	88888889888		88		 88			88   5555555555588	88888888888888  
 *		                                                                                                
 *		Youtube: Laith Youtuber                                                                         
 *		Facebook: Laith A Al Haddad                                                                     
 *		Discord: Laith.97#8167     
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Used to FormAPI Library virion by jojoe77777
 *
 */
use pocketmine\{Server, Player};

use pocketmine\plugin\{PluginBase, Plugin};
use pocketmine\event\Listener;

use pocketmine\utils\{TextFormat as TF, Config};

use pocketmine\command\{CommandSender, Command};

// FormAPI
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener
{
	/** @var bool */
	public $Enable = true;//TODO: If not found FormAPI plugin, set Enable false
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api == null){
			$this->Enable = false;
		} else {
			$this->Enable = true;
		}
	}
	
	
   /**
    * @parm CommandSender $sender
    * @parm Command       $cmd
    * @parm string        $label
    * @parm array         $args
    * @return             bool
	*/
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
		switch($cmd->getName()){
			case "gm":
				if($sender instanceof Player){
					if(!$sender->hasPermission("gm.cmd")){
						$sender->sendMessage(TF::RED . "you dont have permission to use the command");
						return true;
						}
						if(!isset($args[0])){
						     $this->OpenGamemodeUI($sender);
						}
						if(isset($args[0])){
							if(!in_array($args[0], array(0, 1, 2, 3))){
								$sender->sendMessage(TF::RED . "Usage: /gm [0|1|2|3]");
								return true;
							}
						}
				} else {
					$sender->sendMessage("Cannot use the command here!");
				}
			break;
		}
		return true;
	}
	
   /**
	* @parm Player $Player
	* @return FormAPI|bool
	*/
	public function OpenGamemodeUI(Player $player){
	if(!$this->Enable){
			$player->sendMessage(TF::RED . "Cannot Open UI Plugin FormAPI not Found, Please install FormAPI\nLink: https://poggit.pmmp.io/p/FormAPI/1.3.0");
		} else {
		$form = new SimpleForm(function(Player $player, int $data = null){
		if($data === null){
				return true;
			}
			switch($data){
				case 0:
					$player->setGamemode(0);
					$player->sendMessage("set own game mode to Survival Mode");
				break;
				
				case 1:
					$player->setGamemode(1);
					$player->sendMessage("set own game mode to Creative Mode");
				break;
				
				case 2:
					$player->setGamemode(2);
					$player->sendMessage("set own game mode to Adventure Mode");
				break;
				
				case 3:
					$player->setGamemode(3);
					$player->sendMessage("set own game mode to Selectetor Mode");
				break;
			}
		});
		$form->setTitle(TF::YELLOW . "GamemodeUI");
		$form->setContent(TF::GREEN . "Please Selecte Gamemode.");
		$form->addButton(TF::AQUA . "Survival");
		$form->addButton(TF::AQUA . "Creative");
		$form->addButton(TF::AQUA . "Adventure");
		$form->addButton(TF::AQUA . "Spectator");
		$form->sendToPlayer($player);
		return $form;
		}
	}
}
