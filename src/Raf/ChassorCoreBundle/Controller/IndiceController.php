<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# Chassor
use Raf\ChassorUserBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Entity\Enigme;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;

class IndiceController extends Controller
{
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */   
    public function indicesAction()
    {
        $user = $this->getUser();
                
        return $this->render('ChassorCoreBundle:Indice:indices.html.twig',
            array(
                'indices' => $user->getIndices()
            ));
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function indiceAction(Enigme $enigme)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        
        return $this->render('ChassorCoreBundle:indice:indice-'.$indice->getCode().'.html.twig',
            array(
                'indice' => $indice,
                'proposition' => $chassorindice
            ));
    }
    
    
    
}






















