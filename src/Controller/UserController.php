<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/sinscrire",name="inscription")
     */
    public function inscription(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        //Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form['mail']->getData();
            $prenom=$form['prenom']->getData();
            $nom = $form['nom']->getData();
            $dateDeNaissance=$form['dateDeNaissance']->getData();
            $password = $form['plainPassword']->getData();
            $case = $em->getRepository(User::class)->checkMail($mail);
            if($case==1) {

                $user->setMail($mail);
                $user->setRoles((array)"ROLE_FORMATEUR");
                $user->setFormateur(1);
                $user->setPrenom($prenom);
                $user->setNom($nom);
                $user->setDateDeNaissance($dateDeNaissance);
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $em->persist($user);
                $em->flush();
                $this->addFlash("success", "Inscription réussite avec succès !");
                return $this->redirectToRoute('scraper');

            }elseif ($case==2){
                $user->setMail($mail);
                $user->setRoles((array)"ROLE_STAGIAIRE");
                $user->setFormateur(0);
                $user->setPrenom($prenom);
                $user->setNom($nom);
                $user->setDateDeNaissance($dateDeNaissance);
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $em->persist($user);
                $em->flush();
                $this->addFlash("success", "Inscription réussite avec succès !");
                return $this->redirectToRoute('scraper');
            }else{
                $this->addFlash('error','Votre email est invalide !');
                return $this->redirectToRoute('app_login');
            }




        }
        return $this->render("user/userForm.html.twig", [
            'userForm' => $form->createView()]);
    }

//     * @IsGranted("ROLE_USER")

    /**
     * @Route("/User/Profile", name="userProfile")
     */
    public function userModif(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        //Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Profil updated !");
            return $this->redirectToRoute('userProfile');
        }
        return $this->render("user/userForm.html.twig", [
            'userForm' => $form->createView()]);
    }

    //     * @IsGranted("ROLE_USER")
    /**
     * @Route("/User/Details/{id}", name="userDetails")
     */
    public function userDetails(EntityManagerInterface $em, Request $request, $id)
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);
        /*
        $currentUrl = $request->query->get('request_uri');
        $path = var_dump($currentUrl); ,
            'path' => $path ,$slug
*/
        return $this->render('user/userDetails.html.twig', ["user" => $user]);
    }

}
