<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
//use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      // création d'un generateur de donnée
      $faker = \Faker\Factory::create('fr_FR');

      // créer les formations

      $tabFormations=["DUT INFO"=>"DUT Informatique",
                      "DUT GIM"=>"DUT GÉNIE INDUSTRIEL ET MAINTENANCE",
                      "DUT GEA"=>"DUT GESTION DES ENTREPRISES ET DES ADMINISTRATIONS",
                      "DUT TC"=>"DUT TECHNIQUES DE COMMERCIALISATION",
                      "LP ABF"=>"LP ASSURANCE, BANQUE, FINANCE",
                      "LP PA"=>"LP PROGRAMMATION AVANCÉE",
                      "LP MU"=>"LP MÉTIERS DU NUMÉRIQUE",
                      "LP LO"=>"LP LOGISTIQUE",
                      "LP GS"=>"LP GESTION SALARIALE",
                      "LP GEO"=>"LP GEO 3D",
                      "LP EVT"=>"LP EVÈNEMENTIEL"
                    ];

        // initialisation du tableau pour stocker les objet formations
        $formations=[];
        // créer formations a partir du tabFormations
        foreach ($tabFormations as $nomCourt => $nomComplet)
        {
          $formation=new Formation();
          $formation->setnomCourt($nomCourt);
          $formation->setNomLong($nomComplet);

          // rajouter dans un tableau pour stocker les $formations
          $formations[]=$formation;
        }

        // créer les entreprises  et stages-- on généra les stages pour les entre prises lors de la création d'une entreprise

        $nbEntreprise=10;
        $nbStageMaxParEntreprise=10;

        for ($i=0; $i <$nbEntreprise ; $i++)
        {
          $entreprise=new Entreprise();

          //set les valeurs pour une entreprise
          $entreprise->setNom($faker->company);
          $entreprise->setActivite($faker->catchPhrase);
          $entreprise->setAdresse($faker->address);

          // definir le nom de stage pour cette entreprise

          $nbStage=$faker->numberBetween($min = 1, $max = $nbStageMaxParEntreprise);

          for($j=1; $j<$nbStage;$j++ )
          {
            $stage=new Stage();
            $stage->setTitre($faker->realText($maxNbChars = 40, $indexSize = 2));
            $stage->setEmail($faker->email);
            $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));

            // definir l'entreprise pour le stage
            $stage->setEntreprise($entreprise);

            // definir le stage pour l'entreprise
            $entreprise->addStage($stage);

            // lancer aléatoirement le nombre de formation associé au stages

            $nbFormation= $faker->numberBetween($min = 1, $max = 5);
            for ($i=0; $i < $nbFormation; $i++)
            {
              // get a random digit, but always a new one, to avoid duplicates
              $values []= $faker->unique()->randomDigit;
            }

            for ($i=0; $i < $nbFormation; $i++)
            {
              // configurer le stage
              $stage->addFormation($formations[$i]);

              // configurer la formation
              $formations[$i]->addStage($stage);
            }

            // persister le stage
            $manager->persist($stage);


          }

          // persister l'entreprise
          $manager->persist($entreprise);

        }


        // persister les formation
        foreach ($formations as $f)
        {
          $manager->persist($f);
        }

        $manager->flush();
    }
}
