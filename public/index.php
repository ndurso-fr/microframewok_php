<?php

//test de l'autoload:
/*require_once __DIR__ . '/../core/autoload.php';
var_dump(class_exists('core\ErrorHandler'));
exit;*/


// Inclure l'autoload
require_once __DIR__ . '/../core/autoload.php';
// pour include l'autoload de Twig:
require_once __DIR__ . '/../vendor/autoload.php';


// public/index.php
// Ce fichier est le point d'entrée principal, il initialise le système et utilise le routeur.
// echo 'public/index.php  <br>';
//exit;


/*if (file_exists(__DIR__ . '/../core/Router.php')) {
    echo "Fichier core/Router.php trouvé!";
    echo '<br>';
} else {
    echo "Fichier non trouvé!";
    exit;
}*/

/*require_once __DIR__ . '/../core/ErrorHandler.php';
require_once __DIR__ . '/../core/Router.php'; // classe Router() y est crée
require_once __DIR__ . '/../core/Controller.php';*/



use core\Router;
use app\Controllers\AboutController;
use app\Controllers\HomeController;
use core\ErrorHandler;


// Configuration de base
define('BASE_PATH', dirname(__DIR__));
const DEBUG = true; // Passe à `false` en production

//var_dump(BASE_PATH);
// BASE_PATH === /home/nathalie/Programmation/comgocom/microframework_php/

// Enregistre le gestionnaire d'erreurs
ErrorHandler::register();

try {

    // Démarrage du routeur
    $router = new Router();

    // Routes définies
    //$router->get('/', 'HomeController@index');
    //$router->get('/about', 'AboutController@about');
    // Routes définies avec les contrôleurs utilisant les namespaces complets
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/about', [AboutController::class, 'about']);

    // Démarre l'application
    $router->run();

} catch (Throwable $e) {
    if (DEBUG) {
        // Afficher les détails de l'erreur en mode debug
        echo "<h1>Erreur : {$e->getMessage()}</h1>";
        echo "<pre>{$e->getTraceAsString()}</pre>";
    } else {
        // Rediriger vers une page d'erreur avec le gestionnaire d'erreurs
        ErrorHandler::handleException($e);
    }
}
