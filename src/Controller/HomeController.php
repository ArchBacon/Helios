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
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $companies = $this->repository->findAllCompanies();
        foreach ($companies as $key => $value) {
            $companies[$key]['messages'] = $this->repository->findMessageCount($value['company']);
        }

        return $this->render('home/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    #[Route('/company/{company}', name: 'company')]
    public function view(string $company, MessageRepository $repository): Response
    {
        $messages = $repository->findMessagesByCompany($company);
        if (empty($messages)) {
            $this->addFlash('notice', sprintf('Company `%s` does not have any messages or the company does not exists.', $company));

            return $this->redirectToRoute('home');
        }

        return $this->render('home/company.html.twig', [
            'companyName' => $messages[0]->getCompany(),
            'messages' => $messages,
        ]);
    }

    #[Route('/embed', name: 'embed')]
    public function embed(): Response
    {
        return $this->render('embed/popup.html.twig');
    }
}
