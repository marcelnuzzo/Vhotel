<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\CategoryHotel;
use App\Entity\CategoryRoom;
use App\Entity\Image;
use App\Entity\Role;
use App\Entity\Typelit;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $superAdminRole = new Role();
        $superAdminRole->setTitle('ROLE_SUPER_ADMIN');
        $manager->persist($superAdminRole);
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        $role = new Role();
        $role->setTitle('ROLE_USER');
        $manager->persist($role);

        $superAdminUser = new User();
        
        $superAdminUser->setFirstname('marcel')
                  ->setLastname('nuzzo')
                  ->setEmail('nuzzo.marcel@aliceadsl.fr')
                  ->setPicture('https://lh3.googleusercontent.com/a-/AOh14Giy3pomEF4DFzKVvYb03_ATPsjRYypTILMxlnD_=s60-cc-rg')
                  ->setHash($this->encoder->encodePassword($superAdminUser, '1234'))
                  ->addUserRole($superAdminRole)
                  ->addUserRole($adminRole)
                  ->addUserRole($role);
        $manager->persist($superAdminUser);

        $users = [];
        $users[] = $superAdminUser;
        $adminUser = $superAdminUser;
        $user = $superAdminUser;
        $users[] = $adminUser;
        $users[] = $user;
        
        $faker = Factory::create('FR-fr');
        $indiceImage = 200;
        $indiceImage2 = 240;

        for ($i=1; $i<=30; $i++) {
            $ad = new Ad();

            $image = "http://placekitten.com/".$indiceImage."/200";
            $indiceImage++;
            $title = $faker->sentence();
            $introduction = $faker->paragraph(2);
            $contenu = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $ad->setTitle($title)
                ->setCoverImage($image)
                ->setIntroduction($introduction)
                ->setContenu($contenu)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));

            for($j=1; $j<=mt_rand(2, 5); $j++) {
                $image = new Image();

                $image2 = "http://placekitten.com/".$indiceImage2."/200";
                $indiceImage2++;
                $image->setUrl($image2)
                      ->setCaption($faker->sentence())
                      ->setAd($ad);

                $manager->persist($image);

            } 
            
            // gestion des réservations
            for($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();
                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration = mt_rand(3, 10);

                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $ad->getPrice() * $duration;
                $booker = $users[mt_rand(0, count($users) -1)];
                $comment = $faker->paragraph();
                $booking->setBooker($booker)
                        ->setAd($ad)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setCreatedAt($createdAt)
                        ->setAmount($amount)
                        ->setComment($comment);

                    $manager->persist($booking);
            }

            $manager->persist($ad);

        }
        // liste des catégories d'hotel
        $catHotel = [
            '1' => '2 étoiles',
            '2' => '3 étoiles',
            '3' => '4 étoiles',
            '4' => '5 étoiles',
            '5' => 'Palace'
        ];
        foreach ($catHotel as $data) {
            $catHotel = new CategoryHotel();
            $catHotel->setLabel($data);
            $manager->persist($catHotel);
        }

        //liste des catégories de chambre
        $catRoom = [
            '1' => 'Standard',
            '2' => 'Supérieure',
            '3' => 'Luxe',
            '4' => 'Suite'
        ];
        foreach ($catRoom as $data) {
            $catRoom = new CategoryRoom();
            $catRoom->setLabel($data);
            $manager->persist($catRoom);
        }

        //liste des types de lit
        $typeBed = [
            '1' => '2 lits simples',
            '2' => 'Lit double standard Queen Size',
            '3' => 'Lit double Confort',
            '4' => 'Lit double King Size',
            '5' => '1 lit double et un lit simple'
        ];
        foreach ($typeBed as $data) {
            $typeBed = new Typelit();
            $typeBed->setLabel($data);
            $manager->persist($typeBed);
        }
        
        $manager->flush();
    }
}
