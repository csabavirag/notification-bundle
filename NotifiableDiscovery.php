<?php

namespace Mgilet\NotificationBundle;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;

class NotifiableDiscovery
{
    /**
     * @var array
     */
    private $notifiables = [];


    /**
     * WorkerDiscovery constructor.
     *
     * @param EntityManager $em
     * @param Reader        $annotationReader
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(private readonly EntityManagerInterface $em, private readonly \Mgilet\NotificationBundle\Annotation\AttributeReader $attributeReader)
    {
        $this->discoverNotifiables();
    }

    /**
     * Returns all the workers
     * @throws \InvalidArgumentException
     */
    public function getNotifiables()
    {
        return $this->notifiables;
    }

    /**
     * @param NotifiableInterface $notifiable
     *
     * @return string|null
     */
    public function getNotifiableName(NotifiableInterface $notifiable)
    {
        // fixes the case when the notifiable is a proxy
        $class = ClassUtils::getRealClass($notifiable::class);
        $attributes = $this->attributeReader->getClassAttributes($class, \Mgilet\NotificationBundle\Annotation\Notifiable::class);
        if (!empty($attributes)) {
            return $attributes[0]->getName();
        }

        return null;
    }

    /**
     * Discovers workers
     * @throws \InvalidArgumentException
     */
    private function discoverNotifiables()
    {
        /** @var ClassMetadata[] $entities */
        $entities = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($entities as $entity) {
            $class = $entity->getName();
            $attributes = $this->attributeReader->getClassAttributes($class, \Mgilet\NotificationBundle\Annotation\Notifiable::class);

            if (!empty($attributes)) {
                $this->notifiables[$attributes[0]->getName()] = [
                    'class' => $class,
                    'attribute' => $attributes[0],
                    'identifiers' => $entity->getIdentifier()
                ];
            }
        }
    }
}
