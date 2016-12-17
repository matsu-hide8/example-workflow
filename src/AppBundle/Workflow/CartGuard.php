<?php

namespace AppBundle\Workflow;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

class CartGuard implements EventSubscriberInterface
{
    public function guard(GuardEvent $event)
    {
        /* @var \AppBundle\Entity\Cart $cart */
        $cart = $event->getSubject();

        if (count($cart->getProducts()) == 0) {
            $event->setBlocked(true);
        }
    }

    public static function getSubscribedEvents()
    {
        return ['workflow.cart.guard.confirm' => 'guard'];
    }
}
