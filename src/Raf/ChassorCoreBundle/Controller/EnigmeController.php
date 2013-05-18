<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

# Exceptions
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;

# Chassor
use Raf\ChassorUserBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Symfony\Component\Validator\Constraints\DateTime;

class EnigmeController extends Controller
{
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */   
    public function enigmesAction()
    {
        $user = $this->getUser();
        
        // controle de l'acces a l'enigme
        $enigmes = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findByChassor2($user);
        
        return $this->render('ChassorCoreBundle:Enigme:enigmes.html.twig',
            array(
                'enigmes' => $enigmes
            ));
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeAction(Enigme $enigme)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        // controle de l'acces a l'enigme
        $chassorEnigme = $em->getRepository('ChassorCoreBundle:ChassorEnigme')
                            ->findOneBy(array('chassor' => $user, 'enigme' => $enigme));
        if ($chassorEnigme == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // gestion reponse
        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $reponse = $this->get('request')->request->get('reponse');
            $correction = explode("|", $enigme->getReponses());
            $date = new \DateTime();
            if ($enigme->getDelai() > 0
             && $chassorEnigme->getDate() != null
             && $date < $chassorEnigme->getDate()->add(new \DateInterval('PT'.$enigme->getDelai().'H'))) 
            {
                // trop rapide
                $this->get('session')->getFlashBag()->add(
                        'warning',
                        'Trop tôt ! Vous pourrez reproposer une autre solution le '
                        .$chassorEnigme->getDate()->format('d/m')
                        .' à '.$chassorEnigme->getDate()->format('H:i'));
            }
            elseif (in_array($reponse, $correction))
            {
                // bonne reponse
                $chassorEnigme->setValide(true);
                $chassorEnigme->setTentative($chassorEnigme->getTentative() + 1);
                $chassorEnigme->setDate($date);
                $chassorEnigme->setReponse(mysql_real_escape_string($reponse));
                $em->persist($chassorEnigme);
                $em->flush();
                
                // nouvelles enigmes
                $this->deverouillerAction($enigme, $user);
                $this->get('session')->getFlashBag()->add('success', 'Bonne réponse !');
            }
            else
            {
                // fausse reponse
                $this->get('session')->getFlashBag()->add('error', 'Mauvaise réponse...');
                $chassorEnigme->setValide(false);
                $chassorEnigme->setTentative($chassorEnigme->getTentative() + 1);
                $chassorEnigme->setDate($date);
                $chassorEnigme->setReponse(mysql_real_escape_string($reponse));
                $em->persist($chassorEnigme);
                $em->flush();
            }
        }
        
        return $this->render('ChassorCoreBundle:Enigme:enigme-'.$enigme->getCode().'.html.twig',
            array(
                'enigme' => $enigme,
                'proposition' => $chassorEnigme
            ));
    }
    
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeImageAction(Enigme $enigme, $image_id)
    {
        $user = $this->getUser();
        
        // controle de l'acces a l'enigme
        $acces = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findBy(array('chassor' => $user, 'enigme' => $enigme));
        $reponse = new Response();
        $reponse->headers->add(array('Content-Type' => 'image/jpg'));
        if ($acces == null)
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/403.jpg');
            $reponse->setStatusCode(403);
        }
        elseif (file_exists($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg'))
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg');
            $reponse->setStatusCode(200);
        }
        else
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/404.jpg');
            $reponse->setStatusCode(404);
        }
        $reponse->setContent($image);
        
        return $reponse;
    }
    
    public function deverouillerAction(Enigme $enigme, Chassor $user)
    {
        $em = $this->getDoctrine()->getManager();
        
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findBy(array('depend' => $enigme));
        
        foreach ($enigmes as $e)
        {
            $chassorEnigme = new \Raf\ChassorCoreBundle\Entity\ChassorEnigme();
            $chassorEnigme->setChassor($user);
            $chassorEnigme->setEnigme($e);
            $em->persist($chassorEnigme);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info',
                "L'énigme [".$e->getTitre()."] est débloquée !");
        }
    }
    
}






















