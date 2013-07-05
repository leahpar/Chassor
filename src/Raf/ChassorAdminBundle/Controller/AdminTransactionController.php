<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Raf\ChassorCoreBundle\Entity\Transaction;

class AdminTransactionController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Transaction')
                      ->findBy(array(), array('date' => 'DESC'));
       
        return $this->render('ChassorAdminBundle:Transaction:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }

    public function validerAction(Transaction $t, $etat)
    {
        $log = $this->get('session')->getFlashBag();
        $em  = $this->getDoctrine()->getManager();
        if ($etat == 'V')
            $t->setEtat(Transaction::$ETAT_VALIDE);
        else if ($etat == 'X')
            $t->setEtat(Transaction::$ETAT_INVALIDE);
        
        $em->persist($t);
        $em->flush();
        
        $log->add('success', 'Transaction ['.$t->getLibelle().'] de '.$t->getChassor()->getPrenom().' modifiee');
        
        return $this->redirect($this->generateUrl('admin_transaction_lister'));
    }
}
