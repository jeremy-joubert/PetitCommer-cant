<?php

namespace App\DataFixtures;

use App\Entity\CategorieBoutique;
use App\Entity\Commercant;
use App\Entity\Horaire;
use App\Entity\Image;
use App\Entity\Temoinage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \App\Entity\Boutique;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        $listCategorieBoutique = array();
        for ($k=0;$k<3;$k++){
            $categorieBoutique = new CategorieBoutique();
            $categorieBoutique->setNom($faker->jobTitle);
            array_push($listCategorieBoutique, $categorieBoutique);
            $manager->persist($categorieBoutique);
        }
        for($i =0 ;$i<100; $i++){
            $boutique = new Boutique();
            $boutique->setNom($faker->company);
            $boutique->setAdresse($faker->address);
            $boutique->setDescription($faker->text);

            $categorieBoutique=null;
            for ($j=0;$j<mt_rand(1,3);$j++){
                $categorieBoutique=$listCategorieBoutique[$j];
            }

            $jour = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi');
            for ($l=0;$l<5;$l++){
                $horaire=new Horaire();
                $horaire->setJour($jour[$l]);
                $horaire->setHeureDebutMatin(8);
                $horaire->setHeureFinMatin(12);
                $horaire->setHeureDebutApresMidi(14);
                $horaire->setHeureFinApresMidi(17);
                $horaire->addBoutique($boutique);
                $manager->persist($horaire);
            }

            $boutique->addCategorieBoutique($categorieBoutique);
            $manager->persist($boutique);

            $commercant = new Commercant();
            $commercant->setNom($faker->lastName);
            $commercant->setPrenom($faker->firstName);
            $commercant->setBoutique($boutique);

            $manager->persist($commercant);
            for ($j=0; $j<mt_rand(1,5);$j++){
                $img=new Image();
                $img->setLien("boutique.jpg");
                $img->setBoutique($boutique);
                $manager->persist($img);
            }
            for ($j=0; $j<mt_rand(1,3);$j++){
                $img=new Image();
                $img->setLien("commerce.jpg");
                $img->setCommercant($commercant);
                $manager->persist($img);
            }
        }

        for ($i=0;$i<3;$i++){
            $temoinage=new Temoinage();
            $temoinage->setNom($faker->lastName);
            $temoinage->setPrenom($faker->firstName);
            $temoinage->setObjet($faker->word);
            $temoinage->setCommentaire($faker->text);
            $temoinage->setPhoto('p'.mt_rand(1,2).'.jpg');
            $manager->persist($temoinage);
        }

        $manager->flush();
    }
}
