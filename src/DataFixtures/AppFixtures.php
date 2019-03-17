<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\User;
//use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

      $kesly= new User();
      $kesly->setNom("gassant");
      $kesly->setPrenom("kesly");
      $kesly->setEmail("kesly@hotmail.com");
      $kesly->setPassword('$2y$10$cdd1CxuBAUYKTquGG402dO6CCSzxdtt0a/PLzLK64mO/SpFA5lR5u');
      $kesly->setRoles(['ROLE_ADMIN']);
      $manager->persist($kesly);

      $david= new User();
      $david->setNom("poo");
      $david->setPrenom("david");
      $david->setEmail("david@hotmail.com");
      $david->setPassword('$2y$10$SpyUWABU1UNoswsXVh2qbOeCuEz9rXOWgCNVASRF1UXpc7BDB.JKO');
      $david->setRoles(['ROLE_USER']);
      $manager->persist($david);

      $pierre= new User();
      $pierre->setNom("lapegue");
      $pierre->setPrenom("pierre");
      $pierre->setEmail("pierre@hotmail.com");
      $pierre->setPassword('$2y$10$vaKQdxZJaIqcfxpY7.nJ7O.Nt09iDEVQCW1w8GYQe7.ipPNQwx7Pu');
      $pierre->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
      $manager->persist($pierre);

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


        // tableau pour pouvoir choisir aleatoirement des formations pour un stage
        $tabNumeroFormation=[];
        for ($i=0; $i < sizeof($formations); $i++)
        {
          $tabNumeroFormation[]=$i;
        }

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
            // on mélange le tableau
            $tabNumeroFormation=$faker->shuffle($tabNumeroFormation);

            // on prend les nbFormation premier valeur de $tabNumeroFormation
            for ($k=0; $k < $nbFormation; $k++)
            {
              // configurer le stage
             $stage->addFormation($formations[ $tabNumeroFormation[$k] ]);

              // configurer la formation
            $formations[$tabNumeroFormation[$k]]->addStage($stage);
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
