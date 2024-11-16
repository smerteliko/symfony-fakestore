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

	public function __construct(
		private readonly MailerInterface $mailer,
		private readonly EmailFactory    $factory
	) {
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