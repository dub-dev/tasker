<?php

namespace TaskerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TaskerBundle:Default:index.html.twig', array('name' => $name));
    }
}
