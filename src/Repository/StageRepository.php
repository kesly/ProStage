<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // requette en QueryBuilder qui permet de recuperer tout les stages pour une entreprise données (le nom de l'entreprise)

    public function findStageParNomEntrepriseQB($nom)
    {
      return $this->createQueryBuilder('s')
           ->join('s.entreprise','e')
           ->where('e.nom = :nomEntreprise')
           ->setParameter('nomEntreprise', $nom)
           ->getQuery()
           ->getResult()
       ;

    }


        // requette en DQL qui permet de recuperer tout les stages pour une entreprise données (le nom de l'entreprise)

        public function findByNomEntepriseDQL($nom)
        {
          // recuper le gestionnaire d'entité

          $entityManager= $this->getEntityManager();

          // construction de la requete

        }
/*
        // requette en DQL qui permet de recuperer tout les stages pour une formation données (le nom de la formation)
        public function findByNomFormationDQL($nom)
        {

          // recuperer le gestionnaire d'entité

          $gestionnaireEntite= $this->getEntityManager();

          // construction de la requette

          $requete= $gestionnaireEntite->createQuery(
                  'SELECT s
                  FROM App\Entity\Stage s
                  WHERE s.entreprise.nom=$nom'



            );

            // executer la requete et reourner le oci_get_implicit_resultset
            return $requete->execute();

        }

          // requette en QueryBuider qui permet de recuperer tout les stages pour une formation données (le nom de la formation)

        public function findByNomFormationQB($nom)
        {
            return $this->createQueryBuider('s')
                        ->
                        ->
                        ->getQuery()
                        -> getResult()

                ;
        }

*/

}
