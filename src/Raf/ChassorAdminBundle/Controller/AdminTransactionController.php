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

    public function validerAction(Transaction $t)
    {
        $log = $this->get('session')->getFlashBag();
        $em  = $this->getDoctrine()->getManager();
        $t->setEtat(Transaction::$ETAT_VALIDE);
        $em->persist($t);
        $em->flush();
        
        $log->add('success', 'Transaction ['.$t->getLibelle().'] de '.$t->getChassor()->getPrenom().' OK');
        
        return $this->redirect($this->generateUrl('admin_transaction_lister'));
    }
}
