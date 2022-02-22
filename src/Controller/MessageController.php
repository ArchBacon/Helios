<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message/delete/{messageId}', name: 'message.delete')]
    public function remove(int $messageId, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Message::class);
        $message = $repository->find($messageId);
        if ($message === null) {
            throw new \InvalidArgumentException('Message does not exist.');
        }

        $domain = $message->getDomain();

        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('domain', [
            'domain' => $domain
        ]);
    }
}
