<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Model\MessageModel;
use App\Factory\MessageFactory;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new MessageModel();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $message = MessageFactory::create($form->getData());

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->render('message/success.html.twig', [
                'id' => $message->getId(),
            ]);
        }

        return $this->render('message/index.html.twig', [
            'message_form' => $form->createView(),
        ]);
    }

    #[Route('/message/delete/{messageId}', name: 'message.delete')]
    public function remove(int $messageId, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Message::class);
        $message = $repository->find($messageId);
        if ($message === null)
        {
            throw new \InvalidArgumentException('Message does not exist.');
        }

        $company = $message->getCompany();

        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('company', [
            'company' => $company
        ]);
    }
}
