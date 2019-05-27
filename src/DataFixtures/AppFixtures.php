<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder;
    }
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $faker = Factory::create("FR-fr");

        //User
        $users = [];
        $manOrGirl =[];
        $manOrGirl[1]="men";
        $manOrGirl[0]='women';
        for ($i=1;$i<=15; $i++){
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->email);
            $user->setIntroduction($faker->sentence());
            $user->setDescription('<p>' . join('</p><p>',$faker->paragraphs(3)) . '</p>');
            $user->setHash('password');
            $user->setPicture('https://randomuser.me/api/portraits/'. $manOrGirl[mt_rand(0,1)] .'/' . mt_rand(1,90). '.jpg');
            $manager->persist($user);
            $users[] = $user;
        }

        //Annonces
        for ($i=1;$i<=30; $i++){
        $ad = new Ad();

        $title = $faker->sentence();
        $slug = $slugify->slugify($title);
        $img = $faker->imageUrl(1000,350);
        $introduction = $faker->paragraph(2);
        $content = '<p>' . join('</p><p>',$faker->paragraphs(5)) . '</p>';

        $ad->setTitle($title);
        $ad->setSlug($slug);
        $ad->setCoverImage($img);
        $ad->setIntroduction($introduction);
        $ad->setContent($content);
        $ad->setPrice(mt_rand(40,200));
        $ad->setRooms(mt_rand(1,5));
        $ad->setAuthor($users[mt_rand(0,sizeof($users)-1 )]);
        for($j = 1; $j<= mt_rand(2,5);$j++){
            $image = new Image();

            $image->setUrl($faker->imageUrl());
            $image->setCaption($faker->sentence);
            $image->setAd($ad);

            $manager->persist($image);
        }

        $manager->persist($ad);
        }
        $manager->flush();

    }
}
