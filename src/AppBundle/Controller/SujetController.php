<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sujets;
use AppBundle\Form\Type\SujetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class SujetController extends Controller
{
    /**
     * @Route("/add", name="addSujet")
     */
    public function addSujet(Request $request)
    {
        $session = new Session();
        $sujets = new Sujets();

        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(SujetType::class, $sujets);
        $form->handleRequest($request);

        if($form->isValid()) {
            $sujets = $form->getData();
            $sujets->setUser($this->getUser()->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($sujets);
            $em->flush();

            $session->getFlashBag()->add('info', 'Sujet ajouté.');

            return $this->redirectToRoute('allSujet');
        }

        return $this->render('sujets/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/sujets", name="allSujet")
     */
    public function getAllSujet(Request $request){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Sujets');
        $sujets = $repository->findAll();

        return $this->render('sujets/listall.html.twig', ['sujets' => $sujets]);
    }

    /**
     * @Route("/sujets/{id}", name="oneSujet")
     */
    public function getOneSujet(Request $request, $id){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Sujets');
        $sujet = $repository->find($id);

        return $this->render('sujets/list.html.twig', ['sujet' => $sujet]);
    }

    /**
     * @Route("/sujets/modify/{id}", name="modifySujet")
     */
    public function modifySujet(Request $request, $id){
        $session = new Session();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Sujets');
        $sujets = $repository->find($id);
        
        $form = $this->createForm(SujetType::class, $sujets);
        $form->handleRequest($request);

        if($form->isValid()) {
            $sujets = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($sujets);
            $em->flush();

            $session->getFlashBag()->add('info', 'Sujet modifié.');

            return $this->redirectToRoute('allSujet');
        }

        return $this->render('sujets/modify.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/sujets/remove/{id}", name="removeSujet")
     */
    public function removeSujet(Request $request, $id){
        $session = new Session();

        $this->denyAccessUnlessGranted('ROLE_USER');

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repository = $doctrine->getRepository('AppBundle:Sujets');
        
        $sujet = $repository->find($id);

        if ($sujet->isAuthor($this->getUser())){
            $em->remove($sujet);
            $em->flush();

            $session->getFlashBag()->add('info', 'Sujet supprimé.');
        }else{
            $session->getFlashBag()->add('errors', 'Nope c\'est pas a toi.');
        }       

        return $this->redirectToRoute('allSujet');
    }

}
