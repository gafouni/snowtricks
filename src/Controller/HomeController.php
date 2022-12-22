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
        
        $full = $request->query->get('full') ?? false;
        $page = 1;
        
        return $this->render('home/index.html.twig', [
            'tricks' =>$trickRepository->findByLimit($full, $page),
            //['createdAt' => 'desc'],
            'full'=>$full
                   
        ]);
    }
}
