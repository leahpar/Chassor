<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Transaction;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

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
    /*
     * @ParamConverter("user",  options={"mapping": {"user":  "id"}})
     * @ParamConverter("trans", options={"mapping": {"trans": "id"}})
     */
    public function retourPaiementAction(Chassor $user, Transaction $trans, $etat)
    {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('ChassorCoreBundle:Transaction')
                          ->findOneBy(array('chassor' => $user, 'id' => $trans->getId()));
        if ($transaction != null)
        {
            $transaction->setEtat($etat);
            $em->persist($transaction);
            $em->flush();
        }
        return new Response("OK", 200);
    }
    
    
}
