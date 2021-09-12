<?php

namespace LunarMoon72\EnchantUI2;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase {

    public function onEnabled() : void {
        $this->getLogger()->info("Plugin Enabled");
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
        switch($cmd->getName()){
            case "enchantui":
                if($sender instanceof Player){
                    $this->select($sender);
                } else {
                    $this->getLogger()->info("Use this ingame");
                }
        }
        return true;
    }

    public function select($player){
        $form = new SimpleForm(function (Player $player, $data){
            if($data === null){
                return true;
            }

            switch($data){
                case 0:
                    $this->weapon($player);
                break;
            }
        });
        $form->setTitle("Enchant UI Remastered");
        $form->setContent("Choose an Enchant Type");
        $form->addButton("Weapon Enchants");
        $form->sendToPlayer($player);
        return $form;
        
    }

    public function weapon($player){
        $console = new ConsoleCommandSender();
        $form = new CustomForm(function (Player $player, array $data = null){
            if($data === null){
                return true;
            }

            switch($data){
                case 0:
                    $this->getServer()->dispatchCommand($console, "enchant " . $player->getName() . " 9 " . $data[1]);
                break;

                case 2:
                    $this->getServer()->dispatchCommand($console, "enchant " . $player->getName() . " 17 " . $data[3]);
                break;

            }
        });
        $form->setTitle("Enchant UI Remastered");
        $form->addToggle("Sharpness");
        $form->addSlider("LVL", 0, 5);
        $form->addToggle("Unbreaking");
        $form->addSlider("LVL", 0, 3);
        $form->sendToPlayer($player);
        return $form;
    }
}
