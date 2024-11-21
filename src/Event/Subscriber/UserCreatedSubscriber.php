<?php
/**
 * User: smerteliko
 * Date: 18.06.2024
 * Time: 20:29
 */

namespace App\Event\Subscriber;

use App\Entity\UserVerification;
use App\Event\UserCreatedEvent;
use App\Service\CodeGenerator;
use App\Service\Mail\EmailNotification\EmailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserCreatedSubscriber implements EventSubscriberInterface {
	private MessageBusInterface $bus;

	private EntityManagerInterface $emi;

	private CodeGenerator $codeGenerator;

	private string $mailerFrom;

	private TranslatorInterface $translator;

	public function __construct(
		MessageBusInterface $bus,
		EntityManagerInterface $emi,
		CodeGenerator $codeGenerator,
		TranslatorInterface $translator,
		string $mailerFrom
	) {
		$this->bus = $bus;
		$this->emi = $emi;
		$this->codeGenerator = $codeGenerator;
		$this->mailerFrom = $mailerFrom;
		$this->translator = $translator;
	}

	/**
	 * @return string[]
	 *
	*/
    public static function getSubscribedEvents(): array
    {
	    return [
		    UserCreatedEvent::class => 'onUserCreated'
	    ];
    }

    public function onUserCreated(UserCreatedEvent $event): void
    {
	    $code = new UserVerification();
	    $code->setCode(
		    $this->codeGenerator
			    ->getToken(8)
	    );
	    $code->setVerificationUser($event->getUser());
	    $this->emi->persist($code);
	    $this->emi->flush();

	    $this->dispatch($event, $code);
    }
	
	private function dispatch(UserCreatedEvent $event, $code): void {
		$user = $event->getUser();

		$subject =$this->translator->trans('email.verification.code.subject',  [], 'mail');

		$verifyAccount = $this->translator->trans('email.verification.code.explanation',  [], 'mail');

		$this->bus->dispatch(
			new EmailNotification(
				$user->getEmail(),
				$subject,
				[
					'subject' => $subject,
					'verifyAccount' => $verifyAccount,
					'code' => $code->getCode()
				],
				'user_account_confirmation'
			),
			[new AmqpStamp('user-email', AMQP_NOPARAM, [])]
		);
	}
}