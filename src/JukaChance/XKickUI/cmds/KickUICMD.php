<?php

namespace JukaChance\XKickUI\cmds;

use JukaChance\XKickUI\XKickUILoader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class KickUICMD extends Command
{

    public $selected;

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct("xkickui", "Kick a player!", "/xkickui <playername>", $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!count($args) >= 1) {
            $sender->sendMessage("§4Usage: /xkickui <playername>");
        }

        if (!$sender->hasPermission("XKickUI.xkickui.cmd")) {
            $sender->sendMessage("Yo don't have permissions to use this command!");
        }
        if (!$sender instanceof Player) {
            $sender->sendMessage("You can use this commmand only In-Game!");
        }
        $selected = XKickUILoader::getInstance()->getServer()->getPlayer($args[0]);
        if ($selected == null) {
            $sender->sendMessage("§4Please select a online player!");
        }
        $this->selected = $selected;
        XKickUILoader::getInstance()->kickui($sender, $selected);
    }

    public static function getMgr() {
        return new KickUICMD();
    }

    public function getSelected() {
        return $this->selected;
    }
}