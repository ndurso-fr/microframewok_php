<?php
 // core/controller.php
 // Classe de base pour tous les contrôleurs.

namespace core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class Controller
{

    protected $twig;

    public function __construct()
    {
        // Configure Twig
        $loader = new FilesystemLoader(BASE_PATH . '/app/Views');
        $this->twig = new Environment($loader, [
            'cache' => false, // Désactive le cache pour le développement
            'debug' => true,  // Active les outils de debug (facultatif)
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render($template, $data = [])
    {
        echo $this->twig->render($template, $data);
    }

    /*protected function view($view, $data = [])
    {
    // avant l'intégration de Twig, la méthode view de la classe de base Controller était appelée directement par les contrôleurs enfants,

        // La fonction extract() prend un tableau associatif comme entrée et crée des variables individuelles à partir des clés et des valeurs de ce tableau.
        // Par exemple, si $data est : $data = ['title' => 'Accueil', 'message' => 'Bienvenue!'];
        // Après l'exécution de extract($data), cela crée deux variables :
        //       $title = 'Accueil';
        //       $message = 'Bienvenue!';
        extract($data);

        // BASE_PATH est définie dans public/index.php : define('BASE_PATH', dirname(__DIR__));
        require_once BASE_PATH . "/app/Views/$view.php";
    }*/


}
