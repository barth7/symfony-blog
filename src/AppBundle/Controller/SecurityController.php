<?php
/**
 * Created by PhpStorm.
 * User: Bartek
 * Date: 06.02.2016
 * Time: 13:29
 */
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }

    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

}