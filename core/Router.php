<?php

namespace core;
// core/router.php
// Un routeur minimaliste qui mappe les URL aux contrôleurs.

/*
 * BASE_PATH: est définie dans public/index.php : define('BASE_PATH', dirname(__DIR__));
 */
/*require_once __DIR__ . '/../core/Controller.php'; // appelé lors de la création de l'une des classes de controller, HomeController... qui hérite de base controller
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/AboutController.php';
*/


use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Router
{
    private array $routes = [];

    // Ajouter une route GET
    public function get($uri, $action): void
    {
        $this->routes['GET'][$uri] = $action;

//echo '<br>';
//var_dump($this->routes);
//echo '<br>';
////array(1) { ["GET"]=> array(1) { ["/"]=> string(20) "HomeController@index" } }
////array(1) { ["GET"]=> array(2) { ["/"]=> string(20) "HomeController@index" ["/about"]=> string(21) "AboutController@about" } }

    }

    public function post($uri, $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function put($uri, $action): void
    {
        $this->routes['PUT'][$uri] = $action;
    }

    public function delete($uri, $action): void
    {
        $this->routes['DELETE'][$uri] = $action;
    }


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */

    //Ancienne méthode run() avec la chaîne 'HomeController@index' :
    /*public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            // Analyser l'action qui est une chaîne de type 'ClassName@method'
            list($controllerName, $methodName) = explode('@', $action);

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    echo "Méthode $methodName non trouvée.";
                }
            } else {
                echo "Classe $controllerName non trouvée.";
            }
        }
    }*/


    // avec la nouvelle syntaxe des actions ([Controller::class, 'method']
    // public/index.php : "$router->get('/', [HomeController::class, 'index']);"


    public function run(): void
    {

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Ajout du bloc de débogage
        // http://127.0.0.1:8000/resourceController/
        /*echo "<pre>";
        var_dump($this->routes); // Vérifie les routes enregistrées
        var_dump($method);       // Vérifie la méthode HTTP (GET, POST, etc.)
        var_dump($uri);          // Vérifie l'URI demandée
        echo "</pre>";
        exit;
*/

        // Vérifie si la route existe pour la méthode HTTP et l'URI
        if (!isset($this->routes[$method][$uri])) {
            // Si la route n'existe pas, envoyer une réponse 404
            http_response_code(404);
            ErrorHandler::renderErrorPage(404, "Page non trouvée");
            return;
        }

        // Récupère l'action associée à la route
        $action = $this->routes[$method][$uri];

        // Vérifie si l'action est un tableau [Controller::class, 'method']
        if (is_array($action)) {
            list($controllerName, $methodName) = $action;
        } else {
            // Si l'action est encore une chaîne 'Controller@method' (pour compatibilité rétroactive)
            list($controllerName, $methodName) = explode('@', $action);
        }

        // Vérifie si la classe existe
        if (class_exists($controllerName)) {
            echo "<pre>";
            var_dump($controllerName);// string(30) "app\Controllers\HomeController"
            echo "</pre>";
            $controller = new $controllerName();

            // Vérifie si la méthode existe dans le contrôleur
            if (method_exists($controller, $methodName)) {
                // Appelle la méthode du contrôleur
                $controller->$methodName();
            } else {
                // Si la méthode n'existe pas dans le contrôleur
                http_response_code(404);
                echo "Méthode '$methodName' non trouvée dans la classe '$controllerName'.";
            }
        } else {
            echo "<pre>";
            var_dump($controllerName);//string(34) "App\Controllers\ResourceController"
            echo "</pre>";

            // Si la classe du contrôleur n'existe pas
            http_response_code(404);

            echo "Classe : '$controllerName' non trouvée.";
        }
    }


    // Appeler la méthode du contrôleur
    protected function callAction($action): void
    {
        list($controller, $method) = explode('@', $action);

echo '<br>';
var_dump($controller);
echo '<br>';

echo '<br>';
var_dump($method);
echo '<br>';

        // Créer une instance du contrôleur et appeler la méthode
        // Ici, si $controller qui contient 'HomeController', alors new $controller() crée une instance de HomeController
        $controller = new $controller();
        $controller->$method();
    }

    // todo
    /*public function post($route, $action)
    {
        $this->routes['POST'][$route] = $action;
    }*/

}
