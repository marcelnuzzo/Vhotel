<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use App\Repository\CategoryRoomRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    /**
     * @Route("/room", name="room")
     */
    public function index()
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }

     /**
     * @Route("/room/listRoom", name="room_listRoom")
     */
    public function listRoom(RoomRepository $RoomRepository)
    {
        $room = $RoomRepository->findBy([
            'status' => 'actif'
        ]);

        return $this->render('room/listRoom.html.twig', [
            'room' => $room,
        ]);
    }

     /**
     * @Route("/room/lisCategorytRoom", name="room_listCategoryRoom")
     */
    public function listCatRoom(CategoryRoomRepository $categoryRoomRepository)
    {
        return $this->render('room/listCategoryRoom.html.twig', [
            'categoryRoom'=> $categoryRoomRepository->findAll(),
            'categoryRoomss' => $categoryRoomRepository->findAll(),
        ]);
    }
}
