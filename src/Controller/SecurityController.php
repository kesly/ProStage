<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {

    }


    /**
    *@Route("/inscription", name="app_inscription")
    */
    public function inscription(Request $requetteHttp, ObjectManager $manager)
    {

      $utilisateur=new User();

      // création du formulaire
      $formulaireUser=$this->createForm(UserType::class, $utilisateur);

      // verifier la dernier requete http pour hydrater l'objet $utilisateur

      $formulaireUser->handleRequest($requetteHttp);

      // verifier que le formulaire est soumis et valider pou rl'enreigistrer en BD

      if ($formulaireUser->isSubmitted() &&  $formulaireUser->isValid())
      {
        // enreigistrer l'objet en BD
        $manager->persist($utilisateur);
        $manager->flush();

        // rediriger vers la page de Connexion
        return $this->RedirectToRoute('app_login');
      }

      return $this->render('security/inscription.html.twig', ['vueFormulaire' => $formulaireUser->createView()]);
    }

}
