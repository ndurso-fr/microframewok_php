<?php
// app/homeController.php

namespace app\Controllers;
use core\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        //$this->view('home', ['title' => 'Accueil', 'message' => 'Bienvenue sur la page d\'accueil!']);
                // Appel à la méthode `render` définie dans le contrôleur de base, utilisant Twig.

        $this->render('home.html.twig', [
            'title' => 'Accueil',
            'message' => 'Bienvenue sur la page d\'accueil !'
        ]);
    }
}



