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
        $message = MessageFactory::fromJson($request->getContent());

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json('Message received.');
    }
}
