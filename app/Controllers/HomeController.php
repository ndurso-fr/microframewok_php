<?php
// app/homeController.php

namespace app\Controllers;
use core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        //$this->view('home', ['title' => 'Accueil', 'message' => 'Bienvenue sur la page d\'accueil!']);
                // Appel à la méthode `render` définie dans le contrôleur de base, utilisant Twig.

        $this->render('home.html.twig', [
            'title' => 'Accueil',
            'message' => 'Bienvenue sur la page d\'accueil !'
        ]);
    }
}



