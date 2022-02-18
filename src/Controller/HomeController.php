<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
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
}
