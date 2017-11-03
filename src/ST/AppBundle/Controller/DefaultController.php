<?php

namespace ST\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('STAppBundle:Default:index.html.twig');
    }
}
