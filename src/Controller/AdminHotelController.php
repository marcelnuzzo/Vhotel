<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Entity\CategoryRoom;
use App\Entity\CategoryHotel;
use App\Entity\Service;
use App\Form\CategoryRoomType;
use App\Form\CategoryHotelType;
use App\Form\ServiceType;
use App\Repository\HotelRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRoomRepository;
use App\Repository\CategoryHotelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            //$services = $form['services']->getData();
            //$hotel = $hotel->addService($services);
            if(!$hotel->getId()) {
                $hotel->setUpdateAt(new \DateTime());
                $editMode = 0;
            }
            else {
                $editMode = 1;
            }
           
            $manager->persist($hotel);        
            $manager->flush();

            $this->addFlash(
                'success',
                "L'hôtel <strong>{$hotel->getName()}</strong> a bien été créé !"
            );
        
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
    public function deleteHotel($id, Hotel $hotel, EntityManagerInterface $manager)
    {
        
        $repo = $this->getDoctrine()->getRepository(Hotel::class);
        $hotel = $repo->find($id);

        $manager->remove($hotel);
        $manager->flush();
        
        return $this->redirectToRoute('admin_hotel_listHotel');
       
    }

     /**
     * @Route("/admin/hotel/listHotel", name="admin_hotel_listHotel")
     */
    public function listHotel(ServiceRepository $serviceRepo, HotelRepository $hotelRepo, EntityManagerInterface $manager)
    {
        
        return $this->render('admin/hotel/listHotel.html.twig', [
            'hotels'=> $hotelRepo->findAll(),
            'hotel' => $hotelRepo->findAll(),
            'service' => $serviceRepo->findAll(),
            'services' => $serviceRepo->findAll(),
            ]);
    }

     /**
     * @Route("/admin/hotel/lisCategorytHotel", name="admin_hotel_listCategoryHotel")
     */
    public function listCatHotel(CategoryHotelRepository $categoryHotelRepository, EntityManagerInterface $manager)
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
     * @Route("/admin/hotel/listService", name="admin_hotel_listService")
     */
    public function listService(ServiceRepository $repo, EntityManagerInterface $manager)
    {
       
        return $this->render('admin/hotel/listService.html.twig', [
            'services'=> $repo->findAll(),
            'service' => $repo->findAll(),
            ]);
    }

     /**
     * @Route("/admin/hotel/editService/{id}/deleteService", name="admin_hotel_deleteService")
     */
    public function deleteService($id, Service $service, EntityManagerInterface $manager)
    {
        
        $repo = $this->getDoctrine()->getRepository(ServiceType::class);
        $service = $repo->find($id);

        $manager->remove($service);
        $manager->flush();
        
        return $this->redirectToRoute('admin_hotel_listService');
       
    }

    /**
     * @Route("/admin/hotel/newService", name="app_admin_hotel_newService")
     * @Route("/admin/hotel/editService/{id}", name="app_admin_hotel_editService")
     */
    public function formService(Service $service = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/hotel/newService";
        if($currentRoute == "app_admin_hotel_newService")
            $route = "admin/hotel/newService";
        else if($currentRoute == "app_admin_hotel_editService/{id}")
            $route = "admin/hotel/editService";
        
        if(!$service) {
            $service = new Service();
        }
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
           
            if($service->getId() == null) {
                $editMode = 0;      
            }
            else {
                $editMode = 1;
            }
            
            $manager->persist($service);        
            $manager->flush();

            return $this->redirectToRoute('admin_hotel_listService');
        }
        
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $service->getId() !== null
        ]);
    }

}
