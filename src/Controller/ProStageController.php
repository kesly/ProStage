<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }


    /**
    *@Route("stage/{id}", name="pro_stage_stage")
    */
    public function showStageEnDetail(Stage $stage)
    {
      return $this->render("pro_stage/detailStage.html.twig", ['stage'=>$stage]);
    }



    /**
    *@Route("stages", name="pro_stage_stages")
    */
    public function showStages(StageRepository $repoStages)
    {
      $stages=$repoStages->findAllStageOptimiserQB(); dump($stages);

      return $this->render("pro_stage/stages.html.twig", ['stages' => $stages ]);
    }



    /**
    *@Route("entreprise/{id}", name="pro_stage_stages_entreprise")
    */
    public function showStageParEntreprise(Entreprise $entreprise)
    {
      // recupérer tout les stages en BD pour l'entreprise ayant pour id, l'id passé en parametre
      $stages=$entreprise->getStages();

      return $this->render("pro_stage/stagesPourEntreprise.html.twig", ['stages'=>$stages, 'entreprise'=> $entreprise]);
    }


    /**
    *@Route("formation/{id}", name="pro_stage_stages_formation")
    */
    public function showStageParFormation(Formation $formation)
    {

      $stages=$formation->getStages();

      return $this->render("pro_stage/stagesPourFormation.html.twig", ['stages'=>$stages, 'formation'=>$formation]);
    }


    /**
    *@Route("entreprises", name="pro_stage_entreprises")
    */
    public function showEntreprises(EntrepriseRepository $repoEntreprise)
    {

      $entreprises=$repoEntreprise->findAll();

      return $this->render("pro_stage/listeEntreprise.html.twig", ['entreprises'=>$entreprises]);
    }

    /**
    *@Route("formations", name="pro_stage_formation")
    */
    public function showFormations(FormationRepository $repoFormation)
    {
      $formations=$repoFormation->findAll();

      return $this->render("pro_stage/listeFormations.html.twig", ['formations'=>$formations]);
    }

//---------------------------------------------------------------------------------------------------------------//
    /**
    *@Route("entrepriseNom/{nom}", name="pro_stage_nom_entreprise")
    */
    public function showStageParNomEntreprise($nom, StageRepository $repoStage)
    {

      $stages=$repoStage->findByNomEntrepriseDQL($nom);

      return $this->render("pro_stage/stagesPourEntreprise.html.twig", ['stages'=>$stages, 'entreprise'=>$nom]);
    }



   /**
   *@Route("formationNom/{nom}", name="pro_stage_nom_formation")
   */

   public function showStageParNomFormation($nom, StageRepository $repoStage)
   {

     //$nom=$formation->getNomCourt();

     $stages=$repoStage->findStageParNomFormationQB($nom);

     return $this->render("pro_stage/stagesPourFormation.html.twig", ['stages'=>$stages, 'formation'=>$nom]);

   }
//----------------------------------FORMULAIRE---------------------------------------//
   /**
   *@Route("ajouterEntreprise", name="pro_stage_ajouter_entreprise")
   */
   public function ajouterEntreprise(Request $request, ObjectManager $manager)
   {

     // créer l'objet à hydrater (entreprise vierge)

     $entreprise= new Entreprise();

     // créer le formulaire

    $formulaireEntreprise= $this->createFormBuilder($entreprise)
                   ->add('nom', TextType::class, ['attr'=>['placeholder'=>'nom de l\'entreprise']])
                   ->add('activite', TextType::class)
                   ->add('adresse', TextType::class)
                   //->add('sauver', SubmitType::class, ['label'=>"Ajouter entreprise"])
                   ->getForm(); // generer le formulaire créer avec les different champs indique par la methode add()

                  // On deménde au formulaire d'analyser la dernier requetete http,
                  //si le tabaleau post contenu dans cette requette contient des variables nom, activite,
                  //adresse alors la methode handleRequest
                  // recupere les valeurs de ces variables et les affecte à l'objet Entreprise
                   $formulaireEntreprise->handleRequest($request); // analyser la derniere requete realitsé our recuperer si cest necessaire les valeurs du formulaires

                   dump($entreprise);

                   if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
                   {
                     // créer l'entreprise en base de données

                      $manager->persist($entreprise);
                      $manager->flush();

                      // Rediriger l'utilisateur vers la page listant les entreprises

                      return $this->RedirectToRoute("pro_stage_entreprises");
                   }

    // renvoyer le formation a la vue (representation graphique du formulaire generer avant avec la methode createView()  )

      return $this->render("pro_stage/ajoutModifEntreprise.html.twig",['formEntreprise'=> $formulaireEntreprise->createView(), 'action'=>"ajouter"]);
   }


   /**
   *@Route("modifierEntreprise/{id}", name="pro_stage_modifier_entreprise")
   */
   public function modifierEntreprise(Entreprise $entreprise, Request $request, ObjectManager $manager)
   {

     // créer le formulaire

    $formulaireEntreprise= $this->createFormBuilder($entreprise)
                   ->add('nom', TextType::class, ['attr'=>['placeholder'=>'nom de l\'entreprise']])
                   ->add('activite', TextType::class)
                   ->add('adresse', TextType::class)
                   //->add('sauver', SubmitType::class, ['label'=>"Ajouter entreprise"])
                   ->getForm(); // generer le formulaire créer avec les different champs indique par la methode add()

                  // On deménde au formulaire d'analyser la dernier requetete http,
                  //si le tabaleau post contenu dans cette requette contient des variables nom, activite,
                  //adresse alors la methode handleRequest
                  // recupere les valeurs de ces variables et les affecte à l'objet Entreprise
                   $formulaireEntreprise->handleRequest($request); // analyser la derniere requete realitsé our recuperer si cest necessaire les valeurs du formulaires

                   dump($entreprise);

                   if($formulaireEntreprise->isSubmitted())
                   {
                     // créer l'entreprise en base de données

                      $manager->persist($entreprise);
                      $manager->flush();

                      // Rediriger l'utilisateur vers la page listant les entreprises

                      return $this->RedirectToRoute("pro_stage_entreprises");
                   }

    // renvoyer le formation a la vue (representation graphique du formulaire generer avant avec la methode createView()  )

      return $this->render("pro_stage/ajoutModifEntreprise.html.twig",['formEntreprise'=> $formulaireEntreprise->createView(), 'action'=>"modifier"]);
   }







}
