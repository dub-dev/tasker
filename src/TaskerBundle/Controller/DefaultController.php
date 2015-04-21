<?php

namespace TaskerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ( $this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('board'));
        }
        return $this->render('TaskerBundle:Default:index.html.twig');
    }
}
