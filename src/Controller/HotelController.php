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
     * @Route("/hotel/listHotel", name="hotel_listHotel")
     */
    public function listHotel(HotelRepository $hotelRepository)
    {
        $hotel = $hotelRepository->findBy([
            'status' => 'actif'
        ]);

        return $this->render('hotel/listHotel.html.twig', [
            'hotel' => $hotel,
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

}
