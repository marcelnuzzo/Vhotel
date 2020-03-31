<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Entity\CategoryHotel;
use App\Form\CategoryHotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryHotelRepository;
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

     /**
     * @Route("/hotel/lisCategorytHotel", name="hotel_listCategoryHotel")
     */
    public function listCatHotel(CategoryHotelRepository $categoryHotelRepository)
    {
        return $this->render('hotel/listCategoryHotel.html.twig', [
            'categoryHotel'=> $categoryHotelRepository->findAll(),
            'categoryHotels' => $categoryHotelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/hotel/newCategoryHotel", name="app_hotel_newCategoryHotel")
     * 
     */
    public function formCatHotel(CategoryHotel $categoryHotel = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$categoryHotel) {
            $categoryHotel = new CategoryHotel();
        }
        $form = $this->createForm(CategoryHotelType::class, $categoryHotel);
        $form->handleRequest($request);
            
        if($form->isSubmitted() && $form->isValid()) {
           
            $manager->persist($categoryHotel);        
            $manager->flush();

            return $this->redirectToRoute('hotel_listCategoryHotel');
        }

    return $this->render("hotel/newCategoryHotel.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
