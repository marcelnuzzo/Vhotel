<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\Role;
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
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstname('Marcel')
                  ->setLastname('Nuzzo')
                  ->setEmail('nuzzo.marcel@aliceadsl.fr')
                  ->setPicture('https://lh3.googleusercontent.com/a-/AOh14Giy3pomEF4DFzKVvYb03_ATPsjRYypTILMxlnD_=s60-cc-rg')
                  ->setHash($this->encoder->encodePassword($adminUser, '1234'))
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);

        $faker = Factory::create('FR-fr');
        $indiceImage = 200;
        $indiceImage2 = 240;

        $users = [];
        $user = new User();
        $hash = $this->encoder->encodePassword($user, '1234');
        $user->setFirstname('Marcel')
             ->setLastname('Nuzzo')
             ->setEmail('nuzzo.marcel@aliceadsl.fr')
             ->setHash($hash)
             ->setPicture('https://lh3.googleusercontent.com/a-/AOh14Giy3pomEF4DFzKVvYb03_ATPsjRYypTILMxlnD_=s60-cc-rg');

        $manager->persist($user);
        $users[] = $user;

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

            $manager->persist($ad);

        }
        $manager->flush();
    }
}
