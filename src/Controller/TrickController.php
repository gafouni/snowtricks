<?php

namespace App\Controller;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{id}", name="trick")
     */
    public function showTrick(int $id, TrickRepository $trickRepository, Trick $trick): Response
    {
        

        return $this->render('trick/show.html.twig', [
            'trick' =>$trickRepository->find($id)
            // 'controller_name' => 'trickController',
        ]);
    }

}
