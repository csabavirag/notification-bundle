<?php

namespace Mgilet\NotificationBundle\Event;

use Mgilet\NotificationBundle\Entity\NotificationInterface;
use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Contracts\EventDispatcher\Event;

class NotificationEvent extends Event
{
    /**
     * NotificationEvent constructor.
     *
     * @param NotificationInterface    $notification
     * @param NotifiableInterface|null $notifiable
     */
    public function __construct(private readonly NotificationInterface $notification, private readonly ?\Mgilet\NotificationBundle\NotifiableInterface $notifiable = null)
    {
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return NotifiableInterface
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }
}
