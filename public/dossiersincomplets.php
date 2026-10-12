<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

// Chaque ligne correspond à une pièce manquante : un dossier de 3 pièces occupe 3 lignes
$lesLignes = Inscription::getLesDossiersIncomplets();
if (count($lesLignes) === 0) {
    $titre = "Dossiers incomplets";
    $message = "Aucun dossier incomplet pour le moment.";
    $type = "avertissement";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// En-tête du tableau
$corps = <<<HTML
<table >
    <thead> 
        <tr>
            <th style="width: 30%;">Étudiant</th>
            <th style="width: 70%;">Pièces manquantes</th>
        </tr>
    </thead>
    <tbody>
HTML;

// Corps du tableau : une ligne du tableau par dossier
$i = 0;
$nb = count($lesLignes);

while ($i < $nb) {
    // données du dossier en cours
    $id     = $lesLignes[$i]['id'];
    $nom    = $lesLignes[$i]['nom'];
    $prenom = $lesLignes[$i]['prenom'];
    $lesPieces = [];

    // tant que l'on reste sur le même dossier, on stocke les pièces dans le tableau $lesPieces
    while ($i < $nb && $lesLignes[$i]['id'] === $id) {
        $lesPieces[] = $lesLignes[$i]['libelle'];
        $i++;
    }

    // toutes les pièces du dossier dans la même cellule, une par ligne
    $pieces = implode("<br>", $lesPieces);

    $corps .= <<<ROW
        <tr>
            <td>$nom $prenom</td>
            <td>$pieces</td>
        </tr>
ROW;
}

$corps.= <<<HTML
    </tbody>
</table>
HTML;

// génération du PDF
Pdf::genererTableau($corps, "Liste des dossiers incomplets", "dossiers_incomplets.pdf");