<?php
namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Client;

class ClientFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // API USER
        $user = new User();
        $user->setUsername('Utilisateur');
        $user->setEmail('email@example.com');
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $user->setIsActive(true);
        $manager->persist($user);

        // CLIENTS
        $clients = [
            [
                'firstname'    => 'Xavier',
                'lastname'     => 'Durand',
                'address'      => 'Rue de la plaine',
                'post_code'    => '13000',
                'city'         => 'Marseille',
                'phone_number' => '0606060608',
                'email'        => 'xavier@durand.fr'
            ],
            [
                'firstname'    => 'Julie',
                'lastname'     => 'Dupont',
                'address'      => 'Rue des fleurs',
                'post_code'    => '75000',
                'city'         => 'Paris',
                'phone_number' => '0607033333',
                'email'        => 'julie@dupont.com'
            ],
            [
                'firstname'    => 'Marie',
                'lastname'     => 'Dujardin',
                'address'      => 'Impasse des lauriers',
                'post_code'    => '33000',
                'city'         => 'Bordeaux',
                'phone_number' => '0566345623',
                'email'        => 'marie@dujardin.fr'
            ],
            [
                'firstname'    => 'Guillaume',
                'lastname'     => 'Tell',
                'address'      => 'Rue de la pomme',
                'post_code'    => '75000',
                'city'         => 'Paris',
                'phone_number' => '',
                'email'        => 'guillaume@tell.com'
            ]
        ];

        foreach ($clients as $row) {
            $client = new Client();
            $client->setFirstname($row['firstname']);
            $client->setLastname($row['lastname']);
            $client->setAddress($row['address']);
            $client->setPostCode($row['post_code']);
            $client->setCity($row['city']);
            $client->setPhoneNumber($row['phone_number']);
            $client->setEmail($row['email']);
            $client->setUser($user);
            $manager->persist($client);
        }

        $manager->flush();
    }
}