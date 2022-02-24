<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\MessageFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->hasValidToken($request->getContent())) {
            return $this->json('Invalid or no token provided.', 401);
        }

        $message = MessageFactory::fromJson($request->getContent());

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json('Message received.');
    }

    /**
     * @throws \JsonException
     */
    public function hasValidToken(string $json): bool
    {
        $token = 'XmOzUXi-4kOLlc6<l=|w(_+ey_fsGy';
        $contents = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (!\array_key_exists('_token', $contents)) {
            return false;
        }

        return $contents['_token'] === $token;
    }
}
