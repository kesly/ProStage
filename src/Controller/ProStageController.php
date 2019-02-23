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
    *
    */
    public function showStages()
    {


      return $this->render();

    }

    /**
    *
    */
    public function showStageEnDetail()
    {

      return $this->render();
    }



    /**
    *@Route("", nome="pro_stage")
    */
    public function showStage()
    {

      return $this->render();
    }



    /**
    *@Route
    */
    public function showStageParEntreprise()
    {


      return $this->render();
    }


    /**
    *
    */
    public function showStageParFormation()
    {

    }


}
