<?php

namespace JaiUneIdee\UtilisateurBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JaiUneIdeeUtilisateurBundle extends Bundle
{
	 public function getParent()
    {
        return 'FOSUserBundle';
    }
}
