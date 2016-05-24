<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sujets;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SujetController extends Controller
{
    /**
     * @Route("/add", name="addsujet")
     */
    public function addSujet(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('Titre', TextType::class)
            ->add('Description', TextType::class)
            ->add('Utilisateur', IntegerType::class)
            ->add('Valider', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isValid()) {
            $data = $form->getData();

            $sujets = new Sujets();
            $sujets->setTitle($data['Titre']);
            $sujets->setUser($data['Utilisateur']);
            $sujets->setDescription($data['Description']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sujets);
            $em->flush();
        }

        // replace this example code with whatever you need
        return $this->render('sujets/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/sujets", name="sujet")
     */
    public function getSujet(Request $request){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Sujets');
        $sujets = $repository->findAll();

        return $this->render('sujets/list.html.twig', ['sujets' => $sujets]);
    }
}
