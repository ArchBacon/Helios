<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Model\MessageModel;
use App\Factory\MessageFactory;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(Request $request): Response
    {
        $message = new MessageModel();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $message = MessageFactory::create($form->getData());

            // persist

            return $this->render('message/success.html.twig', [
                'id' => $message->getId(),
            ]);
        }

        return $this->render('message/index.html.twig', [
            'message_form' => $form->createView(),
        ]);
    }
}
