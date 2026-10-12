<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;
use ClasseTechnique\Requete;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

// Récupération sécurisée de l'identifiant et des pièces via Requete


// Récupération du dossier


// Vérification de l'existence du dossier


// formatage et échappement des données


// Construction du contenu HTML de la lettre
$corps = <<<HTML
    <div class="objet">Objet : dossier d’inscription incomplet</div>

    <!-- Corps de la lettre -->
    <div class="corps">
        <p>Madame, Monsieur,</p>

        <p>
            Après examen du dossier de votre $genre $prenom $nom, nous constatons que les pièces suivantes sont manquantes :
        </p>

        <ul>
HTML;
foreach ($pieces as $piece) {
    $corps .= "<li>" . $piece['libelle'] . "</li>";
}
$corps .= <<<HTML
    </ul>
    <p>
        Nous vous remercions de bien vouloir nous faire parvenir ces éléments dans les plus brefs délais afin de finaliser l’inscription.
    </p>
HTML;

// Mise à jour de la base

// Génération du PDF
