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

      return $this->render();
    }



    /**
    *@Route("stages", name="pro_stage_stages")
    */
    public function showStages()
    {

      return $this->render();
    }



    /**
    *@Route("entreprise/{id}", name="pro_stage_entreprise")
    */
    public function showStageParEntreprise()
    {


      return $this->render();
    }


    /**
    *@Route("entreprise/{id}", name="pro_stage_formation")
    */
    public function showStageParFormation()
    {

    }


}
