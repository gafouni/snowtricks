<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class TricksFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        //Utilisation de Faker
        $faker = Faker\Factory::create('fr_FR');

        //Creation des categories (trickGroup)//
        for($j=0; $j<=4; $j++){

            $trickGroup = new TrickGroup();

            $trickGroup->setName($faker->name)
                        ->setDescription($faker->description)
                        ->setSlug($faker->slug);
            
            $manager->persist(trickGroup);   
            
                //Creation des 

        }


        //Creation des utilisateurs//
        for($i = 1; $i<=15; $i++){
            // $user = new UserPasswordEncoderInterface();
            // $user->setPassword($this->encoder->encodePassword($user, 'gafouni'));

            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('motdepasse');
            
            if($i === 1)
                $user->setRoles(['ROLE_ADMIN']);
            else
                $user->setRoles(['ROLE_USER']);    
       
            // $password = $this->encoder->encodePassword($user, 'password');
            // $user->setPassword($password);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPictureFile('maphoto');
            $user->setIsVerified($faker->numberBetween(0,1));

            $manager->persist($user);
        }     
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
