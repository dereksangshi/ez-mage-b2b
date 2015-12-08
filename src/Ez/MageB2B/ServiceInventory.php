<?php

namespace Ez\MageB2B;

use Ez\Service\InventoryAbstract;

/**
 * Class ServiceInventory
 *
 * @package Ez\Service
 * @author Derek Li
 */
class ServiceInventory extends InventoryAbstract
{
    protected function init()
    {
        $this->getConfig()->setNamespace('Ez\MageB2B\Service', __DIR__.DIRECTORY_SEPARATOR.'Service');
    }
}