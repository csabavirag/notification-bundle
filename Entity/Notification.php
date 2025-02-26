<?php

namespace Mgilet\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Model\Notification as NotificationModel;

/**
 * Class Notification
 *
 * @package Mgilet\NotificationBundle\Entity
 */
#[ORM\Entity]
class Notification extends NotificationModel implements NotificationInterface
{

}