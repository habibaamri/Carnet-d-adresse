<?php
namespace Acme\AnimalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\staticController;
use Acme\AnimalBundle\Entity\Animal;
use Acme\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use  Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class DefaultController extends Controller
{


	public function translationAction($name)
  {
    return $this->render('AcmeAnimalBundle:Default:translation.html.twig', array('name' => $name
    ));
  }
    public function indexAction($name)
    {
        return $this->render('AcmeAnimalBundle:Default:index.html.twig', array('name' => $name));
   }
   public function emailAction($name)
    {
        return $this->render('AcmeAnimalBundle:static:quikemail.html.twig', array('name' => $name));
   }
   public function emailenvoieAction(Request $request)
    {   $data = $request->request->get($form->getName());
		$email = $data ["email"]->getData();
		$message = $data ["message"]->getData();
		$subject = $data ["subject"]->getData();
		 $message = \Swift_Message::newInstance()
        ->setSubject($subject)
        ->setFrom(array('amri.habiba1995@gmail.com' =>"amri"))
        ->setTo($email)
        ->setBody($message);
          $this->get('mailer')->send($message);
        return $this->render('AcmeAnimalBundle:static:quikemail.html.twig', array('name' => $name));
   }
    public function adminaccueilAction()
    {
        return $this->render('AcmeAnimalBundle:Default:admin.html.twig');
   }
  public function adminAction($name)
    {
        return $this->render('AcmeAnimalBundle:Default:admin.html.twig', array('name' => $name));
   }




public function inscriptionAction(Request $request)
    {   $task = new Animal();
        $form = $this->createFormBuilder($task)

			->add('login', 'text')
			->add('MPD', 'text')
			 ->add('connexion', 'submit', array('label' => 'connexion'))

            ->getForm();
			 $form->handleRequest($request);

        if($form->isValid())
        {
            $entitymanager= $this->getDoctrine()->getManager();
            $entitymanager->persist($structure);
            $entitymanager->flush();
            return $this->redirect($this->generateUrl("inscription"));
           }
		 return $this->render('AcmeAnimalBundle:static:inscription.html.twig', array('form' => $form->createView(),));


	}

		public function voirAction($form)
    {
        return $this->render('AcmeAnimalBundle:static:contact.html.twig', array('name' => $form));
    }

	public function contactAction($name)
    {
        return $this->render('AcmeAnimalBundle:static:contact.html.twig', array('name' => $name));
    }

public function envoiemail_verifierAction($name,$e)
{          return $this->redirect($this->generateUrl("envoiemail_verifier2", array('name' => $name,'e'=>$e)));
}

 public function listAction()
       {
		   $em= $this->getDoctrine()->getManager();
       $animal= $em->getRepository("AcmeAnimalBundle:Animal")->findAll();
        return $this->render("AcmeAnimalBundle:static:list.html.twig",array("Animal" => $animal));

    }

}
