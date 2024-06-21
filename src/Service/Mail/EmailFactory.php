<?php
/**
 * User: smerteliko
 * Date: 18.06.2024
 * Time: 20:37
 */

namespace App\Service\Mail;

use App\Service\Mail\EmailNotification\EmailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailFactory {
	public const SUBJECT_PREFIX = '[Symfony fakestore] ';

	/**
	 * @var string
	 */
	private $mailerFrom;

	public function __construct(string $mailerFrom)
	{
		$this->mailerFrom = $mailerFrom;
	}

	public function createEmailFromMessage(EmailNotification $email): TemplatedEmail
	{
		return $this->createEmailFromData(
			$email->recipient(),
			$email->subject(),
			$email->payload(),
			$email->template(),
			$email->sender(),
		);
	}

	/**
	 * @param string $recipient The recipient.
	 * @param string $subject   The subject.
	 * @param array  $payload   The email content.
	 * @param string $template  The email template to use.
	 * @param string $from      The email sender.
	 *
	 * @return TemplatedEmail
	 */
	public function createEmailFromData(
		string $recipient,
		string $subject,
		array $payload,
		string $template,
		?string $from = null
	): TemplatedEmail {
		return (new TemplatedEmail())
			->from($from ?? $this->mailerFrom)
			->to($recipient)
			->subject(self::SUBJECT_PREFIX . $subject)
			->htmlTemplate('emails/'.$template.'.html.twig')
			->textTemplate('emails/'.$template.'.txt.twig')
			->context($payload);
	}
}