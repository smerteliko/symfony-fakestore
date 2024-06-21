<?php
/**
 * User: smerteliko
 * Date: 18.06.2024
 * Time: 20:39
 */

namespace App\Service\Mail\EmailNotification;

use App\Service\Mail\EmailFactory;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EmailNotificationHandler
{
	private MailerInterface $mailer;

	private EmailFactory $factory;

	public function __construct(
		MailerInterface $mailer,
		EmailFactory $factory
	) {
		$this->mailer = $mailer;
		$this->factory = $factory;
	}

	/**
	 * @throws TransportExceptionInterface
	 */
	public function __invoke(EmailNotification $emailNotification): void {
		$email = $this
			->factory
			->createEmailFromMessage($emailNotification);

		$this->mailer->send($email);
	}
}