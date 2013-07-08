<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        return $this->redirect($this->generateUrl('admin_chassor_lister'));
    }
    public function testAction()
    {
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('dataTable' => null
            ));
    }
}
