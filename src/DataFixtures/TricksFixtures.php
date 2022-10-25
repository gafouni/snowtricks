<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Message;
use App\Entity\TrickGroup;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class TricksFixtures extends Fixture
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
        for($i = 1; $i<=12; $i++){
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
            // $user->setFirstName($faker->firstName);
            // $user->setLastName($faker->lastName);
            // $user->setPictureFile('maphoto');
            $user->setIsVerified($faker->numberBetween(0,1));

            $manager->persist($user);

        }    

        //Creation des categories (trickGroup)//
        for($j=0; $j<=3; $j++){

            $trickGroup = new TrickGroup();

            $trickGroup->setName($faker->word)
                        ->setDescription($faker->words(10, true))
                        ->setSlug($faker->slug());
            
            $manager->persist($trickGroup);   
            
            //Creation des tricks (5 trikcs maximum par trickGroups)//
            for($k=0; $k<=4; $k++){
                // $user = $this->getReference('user'. $faker->numberBetween(1,20));

                $trick = new Trick();

                $trick->setTrickName($faker->words(6, true))
                        ->setDescription($faker->text())
                        ->setImgFile('/assets/img/ImagesBD/manipulation-g67b941e5c_1920.jpg')
                        ->setVideoFile('/assets/img/ImagesBD/manipulation-g67b941e5c_1920.jpg')
                        // ->setSlug($faker->slug())
                        ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                        ->setTrickGroup($trickGroup)
                        ->setUser($user);
                        

                $manager->persist($trick);  
                
                    //Creation des messages: maximum 15 messages par annonce//
                    for($h=0; $h<=14; $h++){
                        $message = new Message();

                        $message->setContent($faker->text())
                                ->setCreatedAd($faker->datetimeBetween('-6 month', 'now'))
                                ->setTrick($trick)
                                ->setUser($user);

                        $manager->persist($message);  


                    }
            }

        }

        $manager->flush();
    }
}
