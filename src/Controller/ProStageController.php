<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function showStageEnDetail()
    {


      return $this->render("pro_stage/detailStage.html.twig");
    }



    /**
    *@Route("stages", name="pro_stage_stages")
    */
    public function showStages()
    {

      return $this->render("pro_stage/stages.html.twig", ['stages' => $stages ]);
    }



    /**
    *@Route("entreprise/{id}", name="pro_stage_entreprise")
    */
    public function showStageParEntreprise()
    {


      return $this->render("pro_stage/StagesPourEntreprise.html.twig", ['stages'=>$stage, 'entreprise'=> $entreprise]);
    }


    /**
    *@Route("entreprise/{id}", name="pro_stage_formation")
    */
    public function showStageParFormation()
    {

      return $this->render("pro_stage/StagesPourFormtion.html.twig", ['stages'=>$stage, 'entreprise'=>$formation]);
    }

    


}
