<?php

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Mobile;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $mobiles = [
            [
                'brand'       => 'Apple',
                'model'       => 'iPhone X',
                'memory'      => '64 Go',
                'description' => 'Apple a conçu un smartphone pour vous offrir l\'expérience la plus immersive. L\'iPhone X est le plus grand changement dans l\'histoire de la conception des téléphones intelligents d\'Apple, et il marquera sans aucun doute un avant et un après. La coque arrière est fabriquée en acier inoxydable recouvert d\'un verre seulement par résistance. C\'est la raison pour laquelle l\'apparition du nouvel iPhone X est si imposante. Ceci sans abandonner l\'élégance et le bon goût qui caractérisent les créations d\'Apple. En outre, le tout nouvel iPhone X est résistant à l\'eau et à la poussière avec un certificat IP67.',
                'price'       => 1229
            ],
            [
                'brand'       => 'Samsung',
                'model'       => 'Galaxy Note 8',
                'memory'      => 'NC',
                'description' => 'Samsung Galaxy Note8 - Nouveau S Pen précis et intelligent - Ecran infinity 6.3" incurvé - Double capteur photo avec zoom optique',
                'price'       => 859
            ],
            [
                'brand'       => 'Xiaomi',
                'model'       => 'Smartphone 4G MI A1',
                'memory'      => '64 Go',
                'description' => 'Système d\'exploitation Android™ 7.1 Nougat - Processeur Octa Core Processeur - Nombre de cœurs 8 - Cadence de traitement du processeur 2 GHz - Écran (cm) 14 cm / 5.5 pouces - Résolution écran 1920 x 1080 pix - Mode de résolution d\'affichage Full HD - Resolution camera 12 MPix - Résolution caméra frontale 5 MPix - Capacité mémoire 64 Go',
                'price'       => 1160
            ],
            [
                'brand'       => 'Google',
                'model'       => 'Pixel 2 XL',
                'memory'      => '128 Go',
                'description' => 'Découvrez une meilleure façon de capturer, stocker et voir le monde.  Pixel 2 XL dispose d\'une caméra intelligente qui prend de belles photos dans n\'importe quelle lumière, une batterie à charge rapide et l\'Assistant Google intégré.',
                'price'       => 1049
            ],
            [
                'brand'       => 'Apple',
                'model'       => 'iPhone 8 Plus',
                'memory'      => '256 Go',
                'description' => 'Le spectaculaire Apple iPhone 8 Plus 256 Go Gris Spatial avec son design en verre, son processeur ultra-rapide et son appareil photo amélioré.',
                'price'       => 999
            ],
            [
                'brand'       => 'Sony',
                'model'       => 'Xperia XZ',
                'memory'      => '64 Go',
                'description' => 'Sony XZ, Xperia. Taille de l\'écran: 13,2 cm (5.2"), Résolution de l\'écran: 1920 x 1080 pixels, Fréquence du processeur: 2,2 GHz, Famille de processeur: Qualcomm Snapdragon. Capacité de la RAM: 3 Go, Taille maximale de la carte mémoire: 256 Go. Type de caméra arrière: Caméra unique, Résolution de la caméra arrière (numerique): 23 MP, Résolution de la caméra avant (numerique): 13 MP',
                'price'       => 975
            ],
            [
                'brand'       => 'Samsung',
                'model'       => 'Galaxy S9',
                'memory'      => '64 Go',
                'description' => 'Design épuré, des courbes lisses et sans bordures, le Galaxy S9+ présente des performances solides avec un processeur octo-core, 6Go de mémoire RAM et un appareil photo double capteur avec mode super slow motion qui n’a pas fini de vous éblouir par sa qualité d’image ! Le magnifique Galaxy S9+ saura vous surprendre et vous émerveiller… Vivez une expérience visuelle incroyable et en totale immersion !',
                'price'       => 959
            ],
            [
                'brand'       => 'Huawey',
                'model'       => 'Mate 9 Pro',
                'memory'      => '64 Go',
                'description' => 'Huawei présente un remarquable écran incurvé de 2,5 pouces inspiré de notre engagement à défier constamment notre savoir-faire et nos compétences.  Maintenant, vous ne ralentirez pas, grâce au nouveau processeur Kirin 960 et à l\'algorithme intelligent d\'apprentissage automatique. Ce jeu innovant entre le matériel et le logiciel signifie que votre Huawei Mate 9 Pro est né rapidement et reste rapide.',
                'price'       => 925
            ],
            [
                'brand'       => 'LG',
                'model'       => 'V30',
                'memory'      => '64 Go',
                'description' => 'Le LG V30 est un concentré de technologies qui vous aide dans votre vie quotidienne à en faire toujours plus ! Son écran de 6" QHD couplé à un son 32 bits HI FI Quad DAC émerveille tous vos sens et vous fait redécouvrir toute votre bibliothèque multimédia. Plus rien ne vous arrête, tout le contenu disponible sur le WEB est disponible avec une fluidité hors norme :  processeur octo-core puissant et compatibilité sur les réseaux 4G+ cat. 16 avec un débit théorique allant jusqu\'à 1 Gbits/s. Son appareil photo est composé de deux capteurs 16 Mpixels et 13 Mpixels qui vous permet de capturer tous vos souvenirs comme si vous y étiez encore.',
                'price'       => 899
            ],
            [
                'brand'       => 'Apple',
                'model'       => 'iPhone 7 Red Edition',
                'memory'      => '128 Go',
                'description' => 'L’iPhone 7 inaugure des systèmes photographiques ultra-sophistiqués. Il offre des performances et une autonomie jamais vues sur un iPhone. Il intègre des haut‑parleurs stéréo, pour une immersion sonore totale. Il est doté de l’écran d’iPhone le plus éclatant et le plus lumineux. Il résiste aux éclaboussures et à l’eau. Et sa puissance est à la hauteur de son look.  Vous attendiez l’iPhone 7, le voici.',
                'price'       => 933
            ],
        ];

        foreach ($mobiles as $row) {
            $mobile = new Mobile();
            $mobile->setBrand($row['brand']);
            $mobile->setModel($row['model']);
            $mobile->setMemory($row['memory']);
            $mobile->setDescription($row['description']);
            $mobile->setPrice($row['price']);
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}