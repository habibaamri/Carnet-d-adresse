<?php

namespace AnimalBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Model\UserInterface;


class RegistrationController extends Controller
{
    /**
     * Inscription job
     *
     * @param $request Request
     * @return Response
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $email = $request->query->get('email');
        if(isset($email)){
            $user->setEmail($email);
        }

        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();

            $infoMail = array('email' => $data->getEmail(), 'pass' => $data->getplainPassword());
            $from_sender = $this->container->getParameter('prod_email');
            $to_recipient = $this->container->getParameter('contact_email');
            $message = \Swift_Message::newInstance()
                ->setSubject("Confirmation d'inscription sur AddressAnimal")
                ->setFrom(array($from_sender => "AddressAnimal"))
                ->setTo($data->getEmail())
                ->setBcc(array($to_recipient))
                ->setBody($this->get('templating')->render('AnimalBundle:Mail:confirmation-inscription.html.twig', $infoMail),
                    'text/html'
                );

            $this->get('mailer')->send($message);

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
