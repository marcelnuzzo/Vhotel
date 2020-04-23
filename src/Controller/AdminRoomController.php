<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Price;
use App\Form\RoomType;
use App\Entity\Typelit;
use App\Form\TypelitType;
use App\Entity\CategoryRoom;
use App\Service\ListProperty;
use App\Form\CategoryRoomType;
use App\Service\ListPricePerDay;
use App\Repository\RoomRepository;
use App\Repository\TypelitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRoomRepository;
use App\Repository\PriceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use App\Service\ListProperty;

class AdminRoomController extends AbstractController
{
    /**
     * @Route("/admin/room", name="admin_room")
     */
    public function index() {
        return $this->render('admin/room/index.html.twig', [
            'controller_name' => 'AdminRoomController',
        ]);
    }

    /**
     * @Route("/admin/room/newRoom", name="app_admin_room_newRoom")
     * @Route("/admin/room/editRoom/{id}", name="app_admin_room_editRoom")
     */
    public function formRoom(Room $room = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        $route = "admin/room/newRoom";
        if($currentRoute == "app_admin_room_newRoom")
            $route = "admin/room/newRoom";
        else if($currentRoute == "app_admin_room_editRoom/{id}")
            $route = "admin/room/editRoom";

        if(!$room) {
            $room = new Room();
        }
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);         
        if($form->isSubmitted() && $form->isValid()) {
            if(!$room->getId()) {
                $room->setUpdateAt(new \DateTime());
                $editMode = 0;
            }
            else {
                $editMode = 1;
            }      
            $manager->persist($room);        
            $manager->flush();

            return $this->redirectToRoute('admin_room_listRoom');
        }
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $room->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/room/editRoom/{id}/deleteRoom", name="admin_room_deleteRoom")
     */
    public function deleteRoom($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Room::class);
        $room = $repo->find($id);
        $Manager->remove($room);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_room_listRoom');     
    }

    /**
     * @Route("/admin/room/listRoom", name="admin_room_listRoom")
     */
    public function listRoom(RoomRepository $room)
    {
        
        return $this->render('admin/room/listRoom.html.twig', [
            'rooms'=> $room->findAll(),
            'room' => $room->findAll(),
        ]);
    }

     /**
     * @Route("/admin/room/lisCategorytRoom", name="admin_room_listCategoryRoom")
     */
    public function listCatRoom(CategoryRoomRepository $categoryRoom, EntityManagerInterface $manager)
    {
        
        //$categoryRoomRepository = $manager->getRepository(CategoryRoom::class)->find(1);
        //dd($categoryRoomRepository);
        return $this->render('admin/room/listCategoryRoom.html.twig', [
            'categoryRoom'=> $categoryRoom->findAll(),
            'categoryRooms' => $categoryRoom->findAll(),
        ]);
    }

    /**
     * @Route("/admin/room/newCategoryRoom", name="app_admin_room_newCategoryRoom")
     * @Route("/admin/room/editCategoryRoom/{id}", name="app_admin_room_editCategoryRoom")
     */
    public function formCatRoom(CategoryRoom $categoryRoom = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');        
        $route = "admin/room/newCategoryRoom";
        if($currentRoute == "app_admin_room_newCategoryRoom")
            $route = "admin/room/newCategoryRoom";
        else if($currentRoute == "app_admin_room_editCategoryRoom/{id}")
            $route = "admin/room/editCategoryRoom";
        
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

            return $this->redirectToRoute('admin_room_listCategoryRoom');
        }        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $categoryRoom->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/room/editCategoryRoom/{id}/deleteCategoryRoom", name="admin_room_deleteCategoryRoom")
     */
    public function deleteCatRoom($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryRoom::class);
        $categoryRoom = $repo->find($id);
        $Manager->remove($categoryRoom);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_room_listCategoryRoom');
    }

    /**
     * @Route("/admin/room/listTypelit", name="admin_room_listTypelit")
     */
    public function typelit(TypelitRepository $typelit) {
        return $this->render('admin/room/listTypelit.html.twig', [
            'typelit'=> $typelit->findAll(),
            'typelits' => $typelit->findAll(),
        ]);
    }

    /**
     * @Route("/admin/room/editTypelit/{id}/deleteTypelit", name="admin_room_deleteTypelit")
     */
    public function deleteTypelit($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Typelit::class);
        $typelit = $repo->find($id);
        $Manager->remove($typelit);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_room_listTypelit');
    }

    /**
     * @Route("/admin/room/newTypelit", name="app_admin_room_newTypelit")
     * @Route("/admin/room/editTypelit/{id}", name="app_admin_room_editTypelit")
     */
    public function formTypelit(Typelit $typelit = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');        
        $route = "admin/room/newTypelit";
        if($currentRoute == "app_admin_room_newTypelit")
            $route = "admin/room/newTypelit";
        else if($currentRoute == "app_admin_room_editTypelit/{id}")
            $route = "admin/room/editTypelit";
        
        if(!$typelit) {
            $typelit = new Typelit();
        }
        $form = $this->createForm(TypelitType::class, $typelit);
        $form->handleRequest($request);  
        if($form->isSubmitted() && $form->isValid()) {     
            if($typelit->getId() == null) {
                $editMode = 0;      
            }
            else {
                $editMode = 1;
            }        
            $manager->persist($typelit);        
            $manager->flush();

            return $this->redirectToRoute('admin_room_listTypelit');
        }        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $typelit->getId() !== null
        ]);
    }
}

