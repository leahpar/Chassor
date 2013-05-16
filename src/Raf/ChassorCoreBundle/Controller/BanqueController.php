<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;

class BanqueController extends Controller
{
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function listerAction()
    {
        $user = $this->getUser();
        
        $transactions = $this->getDoctrine()
                             ->getManager()
                             ->getRepository('ChassorCoreBundle:Transaction')
                             ->findBy(array('chassor' => $user));

        return $this->render('ChassorCoreBundle:Banque:transactions.html.twig',
            array(
                'transactions' => $transactions
            ));
    }
}
