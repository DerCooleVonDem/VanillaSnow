<?php

namespace derc\vanillasnow;


use derc\pbwe\pattern\Block;
use pocketmine\block\Air;
use pocketmine\block\BlockIds;
use pocketmine\block\Leaves;
use pocketmine\block\Leaves2;
use pocketmine\block\SnowLayer;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }


    public function updateEvent(BlockUpdateEvent $event){
        $block = $event->getBlock();
        $level = $block->getLevel();
        $vec3 = $block->asVector3();
        if($block instanceof SnowLayer){
            if($level->getBlock(new Vector3($vec3->x,$vec3->y-1,$vec3->z)) instanceof Air){
                $nbt = Entity::createBaseNBT($vec3->add(0.5, 0, 0.5));
                $nbt->setInt("TileID", $block->getId());
                $nbt->setByte("Data", $block->getDamage());

                $fall = Entity::createEntity("FallingSand", $block->getLevelNonNull(), $nbt);

                if($fall !== null){
                    $fall->spawnToAll();
                }
            }
        }
    }

}