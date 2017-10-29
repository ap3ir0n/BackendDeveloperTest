<?php
/**
 * Created by PhpStorm.
 * User: PatrickLuca
 * Date: 29/10/2017
 * Time: 12:52
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Grade;
use AppBundle\Event\GradesUpdatedEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StudentNotifierSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EngineInterface
     */
    private $renderer;

    /**
     * @var string
     */
    private $adminEmail;

    /**
     * StudentNotifierSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $renderer
     * @param string $adminEmail
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $renderer, $adminEmail)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Sends the email. (To really send the mail use php bin/console swiftmailer:spool:send --env=dev)
     * @param Grade $grade
     */
    public function notifyStudent(GradesUpdatedEvent $event) {
        $body = $this->renderer->render(
            'emails/grade_update.html.twig', [
            'student' => $event->getStudent()
        ]);

        $message = \Swift_Message::newInstance()
            ->setSubject('Ci sono variazioni nei tuoi voti')
            ->setFrom($this->adminEmail)
            ->setTo($event->getStudent()->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'grades.updated' => 'notifyStudent'
        ];
    }
}