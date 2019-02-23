<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

      // créer les formations

      $tabFormations=["DUT INFO"=>"DUT InFormatique"
                      "DUT GIM"=>"DUT GÉNIE INDUSTRIEL ET MAINTENANCE"
                      "DUT GEA"=>"DUT GESTION DES ENTREPRISES ET DES ADMINISTRATIONS"
                      "DUT TC"=>"DUT TECHNIQUES DE COMMERCIALISATION"
                      "LP ABF"=>"LP ASSURANCE, BANQUE, FINANCE"
                      "LP PA"=>"LP PROGRAMMATION AVANCÉE"
                      "LP MU"=>"LP MÉTIERS DU NUMÉRIQUE"
                      "LP LO"=>"LP LOGISTIQUE"
                      "LP GS"=>"LP GESTION SALARIALE"
                      "LP GEO"=>"LP GEO 3D"
                      "LP EVT"=>"LP EVÈNEMENTIEL"
                    ];

        // créer formations a partir du tabFormations
        foreach ($tabFormations as $nomCourt => $nomComplet)
        {
          $formation=new Formation();
          $formation->setTitre("");
          $formation->setNomComplet();
          
        }



        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
