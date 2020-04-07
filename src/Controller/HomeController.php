<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {


    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function home() {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        return $this->render('home.html.twig', [
            'user' => $user
        ]);
    }
}

?>