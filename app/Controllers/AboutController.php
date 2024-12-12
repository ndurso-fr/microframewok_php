<?php

namespace app\Controllers;
use core\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AboutController extends Controller
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(): void
    {
        //$this->view('home', ['title' => 'Accueil', 'message' => 'Bienvenue sur la page d\'accueil!']);
                // Appel à la méthode `render` définie dans le contrôleur de base, utilisant Twig.
        $this->render('about.html.twig', [
            'title' => 'Accueil',
            'message' => 'Bienvenue sur la page d\'accueil !'
        ]);
    }
    /*public function about()
    {
        $this->view('about', ['title' => 'À propos', 'description' => 'Ceci est une application MVC légère.']);
    }*/
}

