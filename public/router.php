<?php

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');


// public/router.php
// Ce fichier intercepte les requêtes et route tout vers index.php si ce n'est pas un fichier physique existant.
//echo  'public/router.php <br>';


if (php_sapi_name() === 'cli-server') {
    // Récupérer le chemin du fichier demandé
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Vérifier si le fichier existe et est un fichier statique
    if (is_file($file)) {
        // Envoyer le fichier directement
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'svg':
                header('Content-Type: image/svg+xml');
                break;
            case 'woff':
            case 'woff2':
                header('Content-Type: font/woff2');
                break;
            default:
                header('Content-Type: application/octet-stream');
        }
        readfile($file);
        exit;
    }
}


/*
 La constante __DIR__ en PHP fait référence au répertoire dans lequel se trouve le fichier actuellement exécuté.
 Cela permet de récupérer facilement le chemin absolu du dossier contenant le script PHP en cours.

 require_once : Inclut et exécute le fichier index.php une seule fois. Cela permet de centraliser des fonctionnalités ou du code réutilisable.

 si on a
/ton-projet
  /public
    /router.php
    /index.php

 alors :
 require_once __DIR__ . '/index.php';
 ===
 require_once '/ton-projet/public/index.php';
*/
require_once __DIR__ . '/index.php';


