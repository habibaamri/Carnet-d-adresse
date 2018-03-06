<?php

namespace AnimalBundle\Controller;

use AnimalBundle\Controller\Controller;

use AnimalBundle\Entity\Animal;
use AnimalBundle\Event\FormEvent;
use AnimalBundle\Event\UserEvent;
use AnimalBundle\Util\SlugHandler;
use AnimalBundle\Form\Type\ProfilInscriptionFormType;
use Symfony\Component\HttpFoundation\Request;


class InscriptionController extends Controller
{

    /**
     * Display form to complete profil
     *
     * @param $request Request
     * @return Response
     */
    public function createProfilAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $form = $this->createForm ( new ProfilInscriptionFormType($em, $user), $user,  array('validation_groups' => array('EditProfile'),));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $setRegistered = $this->getAnimalRepository()->findOneBy(array(
                'Animal' => $data->getAnimal()
            ));
            if(!empty($setRegistered)) {
                $this->getAnimalRepository()->updateStateByAnimal($data->getAnimal(), Animal::STATE_REGISTERED);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $user->setIp($request->getClientIp());

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('Animal_address_index'));
        }

        return $this->render('AnimalBundle:inscription:profil.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
