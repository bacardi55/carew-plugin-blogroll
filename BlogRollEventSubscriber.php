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

    public function onDocument($event)
    {
        $document = $event->getSubject();

        if (Document::TYPE_POST == $document->getType()) {
            $this->buildBlogRoll($document);
        } elseif (Document::TYPE_PAGE == $document->getType()) {
            $this->buildBlogRoll($document);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::DOCUMENT => array(
                array('onDocument', 256),
            ),
        );
    }


    protected function buildBlogRoll($document) {
        $lists = array();
        foreach ($this->blogsList as $name => $url) {
            $lists[] = array('name' => $name, 'url' => $url);
        }
        $this->twig->addGlobal('blogRoll', $lists);
    }
}

