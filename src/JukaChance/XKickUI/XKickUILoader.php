<?php

namespace JukaChance\XKickUI;

use JukaChance\XKickUI\cmds\KickUICMD;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class XKickUILoader extends PluginBase implements Listener
{

    public static $instance;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->registerAll("XKickUILoader", [
            new KickUICMD("kickui")
        ]);
        self::$instance = $this;
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function kickui(Player $sender, $selected)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $sender, array $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            $reason = $data[1];
            $this->kick($sender, $reason);
        });
        $form->setTitle("§l§7Kick§2UI");
        $form->setContent("Here you can kick a player!");
        $form->addInput("Reason");
        $form->sendToPlayer($sender);
        return $form;
    }

    public function kick(Player $sender, $reason) {
        $selected = KickUICMD::getMgr()->selected;
        $selected->kick("You  was kicked by" . $sender->getName() . "!\nReason:" . $reason, false);
        $sender->sendMessage("The player " . $selected->getName() . "was kicked by you! Reason" . $reason);
    }
}