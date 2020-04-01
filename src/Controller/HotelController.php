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
     * @Route("/hotel/editHotel/{id}", name="app_hotel_editHotel")
     */
    public function formHotel(Hotel $hotel = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "hotel/newHotel";
        if($currentRoute == "app_hotel_newHotel")
            $route = "hotel/newHotel";
        else if($currentRoute == "app_hotel_editHotel/{id}")
            $route = "hotel/editHotel";

        if(!$hotel) {
            $hotel = new Hotel();
        }
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
            
        if($form->isSubmitted() && $form->isValid()) {
            if(!$hotel->getId()) {
                $hotel->setUpdateAt(new \DateTime());
                $editMode = 0;
            }
            else {
                $editMode = 1;
            }
           
            $manager->persist($hotel);        
            $manager->flush();

            return $this->redirectToRoute('hotel_listHotel');
        }
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $hotel->getId() !== null
        ]);
    }

     /**
     * @Route("/hotel/editHotel/{id}/deleteHotel", name="hotel_deleteHotel")
     */
    public function deleteHotel($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Hotel::class);
        $hotel = $repo->find($id);

        $Manager->remove($hotel);
        $Manager->flush();
        
        return $this->redirectToRoute('hotel_listHotel');
       
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
     * @Route("/hotel/editCategoryHotel/{id}", name="app_hotel_editCategoryHotel")
     */
    public function formCatHotel(CategoryHotel $categoryHotel = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "hotel/newCategoryHotel";
        if($currentRoute == "app_hotel_newCategoryHotel")
            $route = "hotel/newCategoryHotel";
        else if($currentRoute == "app_hotel_editCategoryHotel/{id}")
            $route = "hotel/editCategoryHotel";
        
        if(!$categoryHotel) {
            $categoryHotel = new CategoryHotel();
        }
        $form = $this->createForm(CategoryHotelType::class, $categoryHotel);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            
            if($categoryHotel->getId() == null) {
                $editMode = 0;      
            }
            else {
                $editMode = 1;
            }
            
            $manager->persist($categoryHotel);        
            $manager->flush();

            return $this->redirectToRoute('hotel_listCategoryHotel');
        }
        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $categoryHotel->getId() !== null
        ]);
    }

     /**
     * @Route("/hotel/editCategoryHotel/{id}/deleteCategoryHotel", name="hotel_deleteCategoryHotel")
     */
    public function deleteCatHotel($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryHotel::class);
        $categoryHotel = $repo->find($id);

        $Manager->remove($categoryHotel);
        $Manager->flush();
        
        return $this->redirectToRoute('hotel_listCategoryHotel');
       
    }
}
