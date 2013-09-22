<?php

namespace Carew\Plugin\BlogRoll;

use Carew\Event\Events;
use Carew\Document;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig_Environment;

class BlogRollEventSubscriber implements EventSubscriberInterface
{
    private $blogsList;
    private $twig;

    public function __construct(Twig_Environment $twig, Array $blogsList)
    {
        $this->twig = $twig;
        $this->blogsList = $blogsList;
    }

    public function onDocuments($event)
    {
        $this->buildBlogRoll();

        $twigGlobals = $this->twig->getGlobals();
        $globals = $twigGlobals['carew'];
        $globals->blogRoll = $this->blogsList;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::DOCUMENTS => array(
                array('onDocuments', 256),
            ),
        );
    }

    protected function buildBlogRoll()
    {
        $lists = array();
        foreach ($this->blogsList as $name => $url) {
            $lists[] = array('name' => $name, 'url' => $url);
        }
        $this->blogsList = $lists;
    }
}

