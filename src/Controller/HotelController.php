<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index()
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

     /**
     * @Route("/hotel/newHotel", name="app_hotel_newHotel")
     * 
     */
    public function formHotel(Hotel $hotel = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$hotel) {
            $hotel = new Hotel();
        }
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
       
        
        if($form->isSubmitted() && $form->isValid()) {

            if(!$hotel->getId()) {
                $hotel->setUpdateAt(new \DateTime());
            }
           
            $manager->persist($hotel);
           
            $manager->flush();

            return $this->redirectToRoute('hotel_listHotel');
        }

    return $this->render("hotel/newHotel.html.twig", [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/hotel/listHotel", name="hotel_listHotel")
     */
    public function list(HotelRepository $hotelRepository)
    {

        return $this->render('hotel/listHotel.html.twig', [
            'hotels'=> $hotelRepository->findAll(),
            'hotel' => $hotelRepository->findAll(),
        ]);
    }
}
