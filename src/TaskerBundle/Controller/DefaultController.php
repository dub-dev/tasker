<?php

namespace TaskerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TaskerBundle:Default:index.html.twig');
    }

    public function dashboardAction()
    {
        return $this->render('TaskerBundle:Default:dashboard.html.twig');
    }
}
