<?php

namespace Blog\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogGeneralBundle:Default:index.html.twig');
    }
}
