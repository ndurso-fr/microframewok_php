<?php

namespace app\Controllers;

use core\Controller;

class ResourceController extends Controller
{
    public function index(): void
    {
        echo "Liste des ressources";
    }

    public function create(): void
    {
        echo "Formulaire pour créer une ressource";
    }

    public function store(): void
    {
        $data = $_POST; // Données envoyées via POST
        echo "Créer une ressource avec : " . json_encode($data);
    }

    public function update(): void
    {
        parse_str(file_get_contents('php://input'), $data); // Récupérer les données PUT
        echo "Mettre à jour une ressource avec : " . json_encode($data);
    }

    public function delete(): void
    {
        parse_str(file_get_contents('php://input'), $data); // Récupérer les données DELETE
        echo "Supprimer une ressource avec : " . json_encode($data);
    }
}
