<?php

namespace ML\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('MLCoreBundle:Core:index.html.twig');
    }

}