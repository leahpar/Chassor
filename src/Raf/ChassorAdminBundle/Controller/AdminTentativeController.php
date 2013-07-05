<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Tentative;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Transaction;

class AdminTentativeController extends Controller
{
    public function listerAction()
    {
        $request = $this->getRequest();
        $chassor = $request->query->get('chassor');
        $enigme  = $request->query->get('enigme');
  
        $filtre = array();
        ($chassor != '') ? $filtre['chassor'] = $chassor : null;
        ($enigme  != '') ? $filtre['enigme']  = $enigme  : null;
        
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Tentative')
                      ->findBy($filtre, array('date' => 'DESC'));
       
        return $this->render('ChassorAdminBundle:Tentative:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function listerEnigmeAction(Enigme $enigme)
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Tentative')
                      ->findBy(array('enigme' => $enigme), array('date' => 'DESC'));
       
        return $this->render('ChassorAdminBundle:Tentative:lister.html.twig',
            array(
                    'liste' => $liste
            ));
    }

    /**
     * @ParamConverter("enigme",    options={"mapping": {"idE": "id"}})
     * @ParamConverter("tentative", options={"mapping": {"idT": "id"}})
     * @ParamConverter("user",      options={"mapping": {"idC": "id"}})
     */
    public function validerAction(Tentative $tentative, Enigme $enigme, Chassor $user)
    {
        $em = $this->getDoctrine()->getManager();
        
        $chassorEnigme = $em->getRepository('ChassorCoreBundle:ChassorEnigme')
                            ->findOneBy(array('chassor' => $user,
                                              'enigme'  => $enigme));
        $chassorEnigme->setValide(true);
        $chassorEnigme->setTentative(-1 - $chassorEnigme->getTentative());
        $chassorEnigme->setReponse($tentative->getReponse());
        $chassorEnigme->setDate($tentative->getDate());
        
        $tentative->setValide(true);
        $tentative->setReponse('[X] '.$tentative->getReponse());
        
        $em->persist($chassorEnigme);
        $em->persist($tentative);
        $em->flush();
        
        // mail au chassor
        $message = \Swift_Message::newInstance()
            ->setSubject('Chassor.com - Validation de l\'enigme '.$enigme->getCode())
            ->setFrom('contact@chassor.com')
            ->setTo($user->getEmail())
            ->setContentType('text/html')
            ->setBody($this->renderView('ChassorCoreBundle:MailData:email-validation-enigme.html.twig',
                array('chassor' => $user,
                      'enigme'  => $enigme)));

        $this->get('mailer')->send($message);
        
        return $this->redirect($this->generateUrl('admin_tentative_lister'));
    }
}

