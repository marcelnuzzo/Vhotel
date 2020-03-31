<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        //$repo = $this->getDoctrine()->getRepository(Ad::class);
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        
        $ads = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
             15 /*limit per page*/
        );
        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
            'ads' => $ads,
        ]);
    }

    /**
     * Permet d'qfficher une seule annonce
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */
    public function show(Ad $ad) {
       
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
