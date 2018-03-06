<?php

namespace AnimalBundle\Controller;

use CoreBundle\Controller\Controller;

use UserBundle\Entity\Animal;
use CoreBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnimalController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->redirect($this->generateUrl('Animal_address_index'));
    }


}
