<?php
/**
 * User: smerteliko
 * Date: 14.11.2024
 * Time: 22:59
 */

namespace App\EventListener;

use App\Repository\UserRepository;
use JetBrains\PhpStorm\NoReturn;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\Response;

class JWTAuthenticationFailureListener {

	public function __construct(private readonly UserRepository $userRepository) {}

	/**
	 * @throws \JsonException
	 */
	#[NoReturn]
	public function onAuthenticationFailureResponse(
		AuthenticationFailureEvent $event): void {

		$data = json_decode($event->getRequest()?->getContent(),
		                    TRUE,
		                    512,
		                    JSON_THROW_ON_ERROR);

		$userByEmail = $this->userRepository->findOneBy(['email' => $data['username']]);
		if(!$userByEmail) {
			$response = new JWTAuthenticationFailureResponse(
				sprintf('User with email "%s" doesnt exists', $data['username']),
				Response::HTTP_UNAUTHORIZED);
			$event->setResponse($response);
			return;
		}

		$userByPassword = $this->userRepository->findOneBy(['password' => $data['password']]);
		if(!$userByPassword) {
			$response = new JWTAuthenticationFailureResponse(
				'Wrong password',
				Response::HTTP_UNAUTHORIZED);
			$event->setResponse($response);
		}
	}
}