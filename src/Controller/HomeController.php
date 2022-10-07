<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(TrickRepository $trickRepository): Response
    {
        // $full = $this->GET['full'] ?? false;

        return $this->render('home/index.html.twig', [
            'tricks' =>$trickRepository->findAll()
        ]);
    }
}
