<?php

// Cette fonction recherche automatiquement les classes en suivant leur namespace et leur nom.
// Les fichiers doivent correspondre à la structure des namespaces.

// La fonction anonyme: (function ($class) {...}) est une façon d’écrire une fonction "jetable",
// qui n’a pas de nom, et qui est directement passée en paramètre.
// Le rôle de la fonction : Elle prend un argument, $class,
// qui est le nom complet (y compris le namespace) de la classe que PHP essaie de charger.

spl_autoload_register(function ($class) {
    // Base directory for the namespace prefix
    $baseDir = __DIR__ . '/../';

    // Convert namespace to file path
    // example $class === 'App\Controllers\HomeController'
    // Convertit le nom de la classe en chemin de fichier, en remplaçant les \ par /
    // Ajoute une extension .php pour obtenir quelque chose comme /mon-projet/app/Controllers/HomeController.php
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    error_log("Tentative de chargement de : $class --> $file");

    // Si le fichier existe, il est inclus avec require, et la classe devient disponible.
    // Include the file if it exists
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Fichier introuvable : $file");
    }
});


