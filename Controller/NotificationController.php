<?php

namespace Mgilet\NotificationBundle\Controller;

use Mgilet\NotificationBundle\Entity\NotifiableNotification;
use Mgilet\NotificationBundle\Entity\Notification;
use Mgilet\NotificationBundle\Manager\NotificationManager;
use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class NotificationController
 * the base controller for notifications
 */
class NotificationController extends AbstractController
{
    /**
     * List of all notifications
     *
     * @param EntityManagerInterface $em
     * @param NotifiableInterface $notifiable
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route(path: '/{notifiable}', name: 'notification_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em, $notifiable): \Symfony\Component\HttpFoundation\Response
    {
        $notifiableRepo = $em->getRepository(NotifiableNotification::class);
        $notificationList = $notifiableRepo->findAllForNotifiableId($notifiable);
        return $this->render('@MgiletNotification/notifications.html.twig', [
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList // deprecated: alias for backward compatibility only
        ]);
    }

    /**
     * Set a Notification as seen
     *
     * @param NotificationManager $manager
     * @param int           $notifiable
     * @param Notification  $notification
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \LogicException
     */
    #[Route(path: '/{notifiable}/mark_as_seen/{notification}', name: 'notification_mark_as_seen', methods: ['POST'])]
    public function markAsSeen(NotificationManager $manager, $notifiable, $notification): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $manager->markAsSeen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            $manager->getNotification($notification),
            true
        );

        return new JsonResponse(true);
    }

    /**
     * Set a Notification as unseen
     *
     * @param NotificationManager $manager
     * @param $notifiable
     * @param $notification
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \LogicException
     */
    #[Route(path: '/{notifiable}/mark_as_unseen/{notification}', name: 'notification_mark_as_unseen', methods: ['POST'])]
    public function markAsUnSeen(NotificationManager $manager, $notifiable, $notification): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $manager->markAsUnseen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            $manager->getNotification($notification),
            true
        );

        return new JsonResponse(true);
    }

    /**
     * Set all Notifications for a User as seen
     *
     * @param NotificationManager $manager
     * @param $notifiable
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    #[Route(path: '/{notifiable}/markAllAsSeen', name: 'notification_mark_all_as_seen', methods: ['POST'])]
    public function markAllAsSeen(NotificationManager $manager, $notifiable): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $manager->markAllAsSeen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            true
        );

        return new JsonResponse(true);
    }
}
