<?php

namespace Mgilet\NotificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class NotifiableEntity
 * @package Mgilet\NotificationBundle\Entity
 */
#[ORM\Entity(repositoryClass: \Mgilet\NotificationBundle\Entity\Repository\NotifiableRepository::class)]
#[UniqueEntity(fields: ['identifier', 'class'])]
class NotifiableEntity implements \JsonSerializable
{
    /**
     * @var string $id
     */
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Id]
    protected $id;

    /**
     * @var NotifiableNotification[]|ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: \Mgilet\NotificationBundle\Entity\NotifiableNotification::class, mappedBy: 'notifiableEntity', cascade: ['persist'])]
    protected $notifiableNotifications;

    /**
     * AbstractNotifiableEntity constructor.
     *
     * @param $identifier
     * @param $class
     * @param string $identifier
     * @param string $class
     */
    public function __construct(#[ORM\Column(type: 'string', length: 255)]
    protected $identifier, #[ORM\Column(type: 'string', length: 255)]
    protected $class)
    {
        $this->notifiableNotifications = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return NotifiableEntity
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return NotifiableEntity
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ArrayCollection|NotifiableNotification[]
     */
    public function getNotifiableNotifications()
    {
        return $this->notifiableNotifications;
    }

    /**
     * @param NotifiableNotification $notifiableNotification
     *
     * @return $this
     */
    public function addNotifiableNotification(NotifiableNotification $notifiableNotification)
    {
        if (!$this->notifiableNotifications->contains($notifiableNotification)) {
            $this->notifiableNotifications[] = $notifiableNotification;
            $notifiableNotification->setNotifiableEntity($this);
        }

        return $this;
    }

    /**
     * @param NotifiableNotification $notifiableNotification
     *
     * @return $this
     */
    public function removeNotifiableNotification(NotifiableNotification $notifiableNotification)
    {
        if ($this->notifiableNotifications->contains($notifiableNotification)) {
            $this->notifiableNotifications->removeElement($notifiableNotification);
            $notifiableNotification->setNotifiableEntity(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'id'         => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'class'      => $this->getClass()
        ];
    }
}
