<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseTechnique\Page;
use ClasseTechnique\Requete;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

// Vérification de la transmission en GET de l'identifiant de l'inscription
$id = Requete::getInt('id');

// Récupération des données
$dossier = Inscription::getById($id);

if (!$dossier) {
    $titre = "Pièces manquantes";
    $message = "Aucune inscription trouvée pour l'identifiant $id";
    $type = "erreur";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}


// alimentation et affichage de l'interface
