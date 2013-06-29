<?php

namespace Raf\ChassorCoreBundle\OCB;

class OCBChaine
{
    public function normaliza($texte)
    {
        $texte = htmlentities($texte, ENT_NOQUOTES);
        $texte = trim($texte);
        // Enlève les accents
        $texte = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $texte);
        // pour les ligatures (le e dans le o)
        $texte = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $texte);
        // supprime les autres caractères
        $texte = preg_replace('#&[^;]+;#', '', $texte);
        // On remplace les caracteres non-alphanumériques par le tiret
        $texte = preg_replace( "/[^A-Za-z0-9]+/", "-", $texte );
        // On convertit le tout en minuscules
        $texte = strtolower( $texte );
        // Supprime les tirets en début ou en fin de chaine
        $texte = trim($texte, '-');
        // suppression doublons
        $texte = preg_replace( "#-+#", "-", $texte );
        return $texte;
    }
    
    
}