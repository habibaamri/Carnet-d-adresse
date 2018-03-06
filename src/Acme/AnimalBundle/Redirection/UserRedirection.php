<?php
namespace AnimalBundle\Redirection;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Animal\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router){
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token){
        $redirection = new RedirectResponse($this->router->generate('animal_address_index'));

        return $redirection;
    }
}
