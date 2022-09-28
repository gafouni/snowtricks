<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
        {
            $this->encoder = $encoder;
        }

    public function load(ObjectManager $manager): void
    {
        //Utilisation de Faker
        $faker = Faker\Factory::create('fr_FR');

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
