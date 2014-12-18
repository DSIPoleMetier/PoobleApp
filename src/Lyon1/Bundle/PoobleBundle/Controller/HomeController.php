<?php

namespace Lyon1\Bundle\PoobleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="hello", requirements={"name" = "^[a-zA-Z]+$"})
     * @Route("/hello", defaults={"name" = "John Doe"})
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }
}
