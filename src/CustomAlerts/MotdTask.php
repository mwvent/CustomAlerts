<?php

/*
 * CustomAlerts (v1.6) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 05/06/2015 10:51 AM (UTC)
 * Copyright & License: (C) 2014-2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/CustomAlerts/blob/master/LICENSE)
 */

namespace CustomAlerts;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

use CustomAlerts\Events\CustomAlertsMotdUpdateEvent;

class MotdTask extends PluginTask {
	
    public function __construct(CustomAlerts $plugin){
    	parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->plugin = $this->getOwner();
        $this->counter = 0;
    }
    
    public function onRun($tick){
    	$cfg = $this->plugin->getConfig()->getAll();
    	$this->counter += 1;
    	if($this->counter >= $cfg["Motd"]["update-timeout"]){
    		//Check if Motd message is custom
    		if(CustomAlerts::getAPI()->isMotdCustom()){
    			CustomAlerts::getAPI()->setMotdMessage(CustomAlerts::getAPI()->getDefaultMotdMessage());
    		}
			$this->plugin->getServer()->getPluginManager()->callEvent(new CustomAlertsMotdUpdateEvent($this->plugin->getServer()->getMotd()));
    		$this->counter = 0;
    	}
    }
}
?>
