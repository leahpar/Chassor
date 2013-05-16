<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

# Exceptions
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;

# Chassor
use Raf\ChassorBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;

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
        
        // controle de l'acces a l'enigme
        $reponse = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findBy(array('chassor' => $user, 'enigme' => $enigme));
        if ($reponse == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // gestion reponse
        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $reponse = $this->get('request')->request->get('reponse');
            $correction = explode("|", $enigme->getReponses());
            if (in_array($reponse, $correction))
            {
                // bonne reponse
            }
            else
            {
                // fausse reponse
            }
        }
        
        return $this->render('ChassorCoreBundle:Enigme:enigme-'.$enigme->getCode().'.html.twig',
            array(
                'enigme' => $enigme
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
    
}
