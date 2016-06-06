<?php
namespace AppBundle\Controllers;

use WebComposer\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->twig->render('home.html.twig');
    }
}