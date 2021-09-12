<?php

namespace LunarMoon72\EnchantUI2;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentEntry;
use pocketmine\item\enchantment\EnchantmentList;

use pocketmine\item\Item;

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
        $inv = $player->getInventory();
        $item = $inv->getItemInHand();
        $sharpness = Enchantment::getEnchantment(9);
        $unbreaking = Enchantment::getEnchantment(17);

        $form = new CustomForm(function (Player $player, array $data = null){
            if($data === null){
                return true;
            }

            switch($data){
                case 0:
                $item->addEnchantment($sharpness);
                $sharpness->setLevel($data[1]);
                break;

                case 2:
                    $item->addEnchantment($unbreaking);
                    $unbreaking->setLevel($data[3]);
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
