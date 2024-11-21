<?php
/**
 * User: smerteliko
 * Date: 22.05.2024
 * Time: 12:18.
 */

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $response = new RedirectResponse('/');
        $event->setResponse($response);
    }
}
