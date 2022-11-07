<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, TrickRepository $trickRepository): Response
    {
        
        // $full = $this->request->query->get('full') ?? false;
        $full = $request->query->get('full') ?? false;
        $limit = 12;
        

        return $this->render('home/index.html.twig', [
            'tricks' =>$trickRepository->findAll($full, $limit),
            ['createdAt' => 'desc'],
            'full'=>$full
        ]);
    }
}
