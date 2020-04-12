<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Entity\CategoryRoom;
use App\Entity\CategoryHotel;
use App\Form\CategoryRoomType;
use App\Form\CategoryHotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRoomRepository;
use App\Repository\CategoryHotelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHotelController extends AbstractController
{
    /**
     * @Route("/admin/hotel", name="admin_hotel")
     */
    public function index()
    {
        return $this->render('admin/hotel/index.html.twig', [
            'controller_name' => 'AdminHotelController',
        ]);
    }

     /**
     * @Route("/admin/hotel/newHotel", name="app_admin_hotel_newHotel")
     * @Route("/admin/hotel/editHotel/{id}", name="app_admin_hotel_editHotel")
     */
    public function formHotel(Hotel $hotel = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/hotel/newHotel";
        if($currentRoute == "app_admin_hotel_newHotel")
            $route = "admin/hotel/newHotel";
        else if($currentRoute == "app_admin_hotel_editHotel/{id}")
            $route = "admin/hotel/editHotel";

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

            return $this->redirectToRoute('admin_hotel_listHotel');
        }
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $hotel->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/hotel/editHotel/{id}/deleteHotel", name="admin_hotel_deleteHotel")
     */
    public function deleteHotel($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Hotel::class);
        $hotel = $repo->find($id);

        $Manager->remove($hotel);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_hotel_listHotel');
       
    }

     /**
     * @Route("/admin/hotel/listHotel", name="admin_hotel_listHotel")
     */
    public function list(HotelRepository $hotelRepository)
    {
        return $this->render('admin/hotel/listHotel.html.twig', [
            'hotels'=> $hotelRepository->findAll(),
            'hotel' => $hotelRepository->findAll(),
        ]);
    }

     /**
     * @Route("/admin/hotel/lisCategorytHotel", name="admin_hotel_listCategoryHotel")
     */
    public function listCatHotel(CategoryHotelRepository $categoryHotelRepository)
    {
        return $this->render('admin/hotel/listCategoryHotel.html.twig', [
            'categoryHotel'=> $categoryHotelRepository->findAll(),
            'categoryHotels' => $categoryHotelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/hotel/newCategoryHotel", name="app_admin_hotel_newCategoryHotel")
     * @Route("/admin/hotel/editCategoryHotel/{id}", name="app_admin_hotel_editCategoryHotel")
     */
    public function formCatHotel(CategoryHotel $categoryHotel = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/hotel/newCategoryHotel";
        if($currentRoute == "app_admin_hotel_newCategoryHotel")
            $route = "admin/hotel/newCategoryHotel";
        else if($currentRoute == "app_admin_hotel_editCategoryHotel/{id}")
            $route = "admin/hotel/editCategoryHotel";
        
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

            return $this->redirectToRoute('admin_hotel_listCategoryHotel');
        }
        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $categoryHotel->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/hotel/editCategoryHotel/{id}/deleteCategoryHotel", name="admin_hotel_deleteCategoryHotel")
     */
    public function deleteCatHotel($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryHotel::class);
        $categoryHotel = $repo->find($id);

        $Manager->remove($categoryHotel);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_hotel_listCategoryHotel');
       
    }

     /**
     * @Route("/admin/room/lisCategorytRoom", name="admin_room_listCategoryRoom")
     */
    /*
    public function listCatRoom(CategoryRoomRepository $categoryRoomRepository)
    {
        return $this->render('admin/hotel/listCategoryRoom.html.twig', [
            'categoryRoom'=> $categoryRoomRepository->findAll(),
            'categoryRooms' => $categoryRoomRepository->findAll(),
        ]);
    }
    */

    /**
     * @Route("/admin/hotel/newCategoryRoom", name="app_admin_hotel_newCategoryRoom")
     * @Route("/admin/hotel/editCategoryRoom/{id}", name="app_admin_hotel_editCategoryRoom")
     */
    /*
    public function formCatRoom(CategoryRoom $categoryRoom = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/hotel/newCategoryRoom";
        if($currentRoute == "app_admin_hotel_newCategoryRoom")
            $route = "admin/hotel/newCategoryRoom";
        else if($currentRoute == "app_admin_hotel_editCategoryRoom/{id}")
            $route = "admin/hotel/editCategoryRoom";
        
        if(!$categoryRoom) {
            $categoryRoom = new CategoryRoom();
        }
        $form = $this->createForm(CategoryRoomType::class, $categoryRoom);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            
            if($categoryRoom->getId() == null) {
                $editMode = 0;      
            }
            else {
                $editMode = 1;
            }
            
            $manager->persist($categoryRoom);        
            $manager->flush();

            return $this->redirectToRoute('admin_hotel_listCategoryRoom');
        }
        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $categoryRoom->getId() !== null
        ]);
    }
    */

    /**
     * @Route("/admin/hotel/editCategoryRoom/{id}/deleteCategoryRoom", name="admin_hotel_deleteCategoryRoom")
     */
    /*
    public function deleteCatRoom($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryRoom::class);
        $categoryRoom = $repo->find($id);

        $Manager->remove($categoryRoom);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_hotel_listCategoryRoom');
       
    }
    */
}
