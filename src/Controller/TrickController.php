<?php

namespace App\Controller;


use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{id}", name="showTrick")
     */
    public function showTrick(int $id, TrickRepository $trickRepository): Response
    {
        

        return $this->render('trick/show.html.twig', [
            'trick' =>$trickRepository->find($id)
            // 'controller_name' => 'trickController',
        ]);
    }

}
