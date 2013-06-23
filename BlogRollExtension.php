<?php

namespace Carew\Plugin\BlogRoll;

use Carew\ExtensionInterface;
use Carew\Carew;

class BlogRollExtension implements ExtensionInterface
{
    public function register(Carew $carew)
    {
        $container = $carew->getContainer();
        $blogRoll = isset($container['config']['blogRoll']) ?
            $container['config']['blogRoll'] : array();

        $eventDispatcher = $carew->getEventDispatcher()
            ->addSubscriber(new BlogRollEventSubscriber(
                $container['twig'], $blogRoll
            ));
    }
}
