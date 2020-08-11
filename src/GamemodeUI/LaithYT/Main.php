<?php

namespace GamemodeUI\LaithYT;

use pocketmine\{Server, Player};

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\utils\{TextFormat as TF, Config};

use pocketmine\command\{CommandSender, Command};

// FormAPI
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

// Plugin Update
use JackMD\UpdateNotifier\UpdateNotifier;

class Main extends PluginBase implements Listener
{
	/** @var bool */
	public $Enable = true;//TODO: If not found FormAPI plugin, set Enable false
	
	public function onEnable(){
		UpdateNotifier::checkUpdate($this->getDescription()->getName(), $this->getDescription()->getVersion());
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
					if($sender->hasPermission("gm.cmd")){
						$this->OpenGamemodeUI($sender);
					} else {
						$sender->sendMessage(TF::RED . "you dont have permission to use the command");
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
	* @return FormAPI
	*/
	public function OpenGamemodeUI(Player $player){
	if(!$this->Enable){
			$player->sendMessage(TF::RED . "Cannot Open UI Plugin FormAPI not Found, Please install FormAPI\nLink: https://poggit.pmmp.io/p/FormAPI/1.3.0");
			return true;
		}
		$form = new SimpleForm(function(Player $player, int $data = null){
		if($data === null){
				return true;
			}
			switch($data){
				case 0:
					$player->setGamemode(0);
				break;
				
				case 1:
					$player->setGamemode(1);
				break;
				
				case 2:
					$player->setGamemode(2);
				break;
				
				case 3:
					$player->setGamemode(3);
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
