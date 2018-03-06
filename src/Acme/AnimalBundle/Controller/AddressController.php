<?php

namespace AnimalBundle\Controller;

use UserBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CoreBundle\Util;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AnimalBundle\Entity\Animal;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AddressController extends Controller
{

    /**
     * Lists all address
     *
     * @param $request Request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if(!empty($user))
            $user_id = $user->getId();
        else
            $user_id = null;
        $Animals = $this->getAnimalRepository()->findBy(array(
            'user' => $user_id
        ));

        return $this->render('AnimalBundle:Address:index.html.twig', array(
            'Animals' => $Animals,
            'user' => $user
        ));
    }

    /**
     * Displays the form to add a Address
     *
     * @param $request Request
     * @return Response
     *
     */
    public function addAction(Request $request)
    {
        $Animal = new Animal();

        $user = $this->getUser();
        $form = $this->createForm('address_form_type', $Animal, array('validation_groups' => array('AddAddress')));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $contact = $data->getAnimal();
            $isAnimalRegistered = $this->getUserRepository ()->findOneBy ( array (
                'Animal' => $contact
            ));
            if(!empty($isAnimalRegistered))
                $Animal->setState(Animal::STATE_REGISTERED);
            $em = $this->getDoctrine()->getManager();
            $dispatcher = $this->getDispatcher();

            $animal->setUser($this->getUser());

            $dispatcher->dispatch(AddressEvent::ADDRESS_ADD_SUCCESS,
            new FormEvent($form));
            $em->persist($animal);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Le contact a été ajouté à votre carnet d'adresses.");

            return $this->redirect($this->generateUrl('Animal_address_index'));
        }

        return $this->render('AnimalBundle:Address:add.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Show contact
     *
     * @param $address Animal
     * @return Response
     */
    public function showAction(Animal $address)
    {
        $user = $this->getUser();
        if (!$address->getId()) {
            throw $this->createNotFoundException('Page non trouvé');
        }

        $address = $this->getAnimalRepository()->findOneBy(array(
            'id' => $address->getId()
        ));

        return $this->render('AnimalBundle:Address:show.html.twig', array(
            'address' => $address,
            'user' => $user
        ));
    }

    /**
     * Invite contact
     *
     * @param $request Request
     * @param $address Animal
     * @return RedirectResponse
     *
     */
    public function inviteAction(Request $request, Animal $address)
    {
        if (!$this->getCsrfProvider()->isCsrfTokenValid('address_invite', $request->request->get('_token'))) {
            return $this->redirect($this->generateUrl('Animal_address_index'));
        }

        $em = $this->getDoctrine()->getManager();
        $address->invite();

        $this->getDispatcher()->dispatch(AddressEvent::ADDRESS_INVITE_SUCCESS, new AddressEvent($address));
        $em->flush();
        $this->getDispatcher()->dispatch(AddressEvent::ADDRESS_INVITE_COMPLETED, new AddressEvent($address));

        $infoMail = array('Animal' => $address->getUser()->getAnimal());
        $from_sender = $this->container->getParameter('prod_Animal');
        $to_recipient = $this->container->getParameter('contact_Animal');
        $message = \Swift_Message::newInstance()
            ->setSubject('Invitation à rejoindre AddressBook')
            ->setFrom(array($from_sender => "AddressBook"))
            ->setTo($address->getAnimal())
            ->setBcc(array($to_recipient))
            ->setBody($this->get('templating')->render('AnimalBundle:Mail:invitation-contact.html.twig', $infoMail),
                'text/html'
            );

        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('success', "Un Animal contenant une invitation a été envoyé au contact.");

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * Delete contact
     *
     * @param $request Request
     * @param $address Animal
     * @return RedirectResponse
     *
     */
    public function deleteAction(Request $request, Animal $address)
    {
        if (!$this->getCsrfProvider()->isCsrfTokenValid('address_delete', $request->request->get('_token'))) {
            return $this->redirect($this->generateUrl('Animal_address_index'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($address);

        $this->getDispatcher()->dispatch(AddressEvent::ADDRESS_DELETE_SUCCESS, new AddressEvent($address));
        $em->flush();
        $this->getDispatcher()->dispatch(AddressEvent::ADDRESS_DELETE_COMPLETED, new AddressEvent($address));

        $this->get('session')->getFlashBag()->add('success', "Le contact a été supprimé de votre carnet d'adresse.");

        return $this->redirect($this->generateUrl('Animal_address_index'));
    }

    /**
     * Displays the form to edit a contact
     *
     * @param $request Request
     * @param $address Animal
     * @return Response
     *
     */
    public function editAction(Request $request, Animal $address)
    {
        $user = $this->getUser();
        $form = $this->createForm('address_form_type', $address, array('validation_groups' => array('EditAddress')));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(AddressEvent::ADDRESS_EDIT_SUCCESS, new FormEvent($form));
            $em->flush();
            $dispatcher->dispatch(AddressEvent::ADDRESS_EDIT_COMPLETED, new AddressEvent($address));

            $this->get('session')->getFlashBag()->add('success', "Le contact a été modifié avec succès.");

            return $this->redirect($this->generateUrl('Animal_address_show', array('id' => $address->getId())));
        }

        return $this->render('AnimalBundle:Address:edit.html.twig', array(
            'form' => $form->createView(),
            'address' => $address,
            'user' => $user
        ));
    }
}
