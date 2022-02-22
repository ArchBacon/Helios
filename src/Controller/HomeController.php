<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private MessageRepository $repository
    )
    {
        $filePath = 'build/messageBox.js';
        $contents = file_get_contents($filePath);
        $contents = str_replace('PHP_REPLACE_HOST', $_SERVER['HTTP_HOST'], $contents);
        file_put_contents($filePath, $contents);
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $domains = $this->repository->findAllDomains();
        foreach ($domains as $key => $value) {
            $domains[$key]['messages'] = $this->repository->findMessageCount($value['domain']);
        }

        return $this->render('home/index.html.twig', [
            'domains' => $domains,
        ]);
    }

    #[Route('/domain/{domain}', name: 'domain')]
    public function view(string $domain, MessageRepository $repository): Response
    {
        $messages = $repository->findMessagesByDomain($domain);
        if (empty($messages)) {
            return $this->redirectToRoute('home');
        }

        return $this->render('home/domain.html.twig', [
            'domain' => $messages[0]->getDomain(),
            'messages' => $messages,
        ]);
    }

    #[Route('/embed', name: 'embed')]
    public function embed(): Response
    {
        return $this->render('embed/popup.html.twig');
    }
}
