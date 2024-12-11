<?php
namespace core;
use ErrorException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class ErrorHandler
{
    public static function register()
    {
        // Configure le rapport d'erreurs
        ini_set('display_errors', 0); // N'affiche pas les erreurs par défaut
        error_reporting(E_ALL);

        // Enregistre les gestionnaires
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    /**
     * @throws ErrorException
     */
    public static function handleError($severity, $message, $file, $line)
    {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public static function handleException($exception)
    {
        http_response_code(500);
        if (defined('DEBUG') && DEBUG) {
            echo "<h1>Erreur d'exécution</h1>";
            echo "<p><strong>Message:</strong> {$exception->getMessage()}</p>";
            echo "<pre>{$exception->getTraceAsString()}</pre>";
        } else {
            // Afficher une page d'erreur générique
            echo "<h1>Une erreur est survenue</h1>";
            echo "<p>Nous nous excusons pour la gêne occasionnée.</p>";
        }

        // Log l'erreur si nécessaire
        error_log($exception->getMessage());
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public static function handleShutdown()
    {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR])) {
            http_response_code(500);

            if (defined('DEBUG') && DEBUG) {
                self::renderDebugException(new ErrorException(
                    $error['message'], 0, $error['type'], $error['file'], $error['line']
                ));
            } else {
                self::renderErrorPage(500, "Une erreur critique est survenue.");
            }
        }
    }

    private static function renderDebugException($exception)
    {
        echo "<h1>Erreur interne</h1>";
        echo "<p><strong>Message :</strong> {$exception->getMessage()}</p>";
        echo "<p><strong>Fichier :</strong> {$exception->getFile()}</p>";
        echo "<p><strong>Ligne :</strong> {$exception->getLine()}</p>";
        echo "<pre>{$exception->getTraceAsString()}</pre>";
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public static function renderErrorPage($code, $message)
    {
        //require_once __DIR__ . '/Controller.php'; // Pour utiliser Twig

        $loader = new FilesystemLoader(BASE_PATH . '/app/Views');
        $twig = new Environment($loader);

        echo $twig->render('error.html.twig', [
            'code' => $code,
            'message' => $message,
        ]);
    }


}
