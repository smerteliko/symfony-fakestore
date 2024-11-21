<?php
/**
 * User: smerteliko
 * Date: 18.11.2024
 * Time: 13:57
 */

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorsEventListener implements EventSubscriberInterface {

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::RESPONSE => 'onResponse'
		];
	}

	public function onResponse(ResponseEvent $event): void {
		$response = $event->getResponse();
		$response->headers->set('Access-Control-Allow-Origin', '*');
	}
}