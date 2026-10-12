<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

$lesLignes = Inscription::getLesDossiersAcceptes();
if (count($lesLignes) === 0) {
    $titre = "Dossiers acceptés";
    $message = "Aucun dossier d'inscription n'a été accepté pour le moment.";
    $type = "avertissement";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// En-tête du tableau
$corps = <<<HTML
<table >
    <thead> 
        <tr>
            <th style="width: 20%;">Nom</th>
            <th style="width: 20%;">Prénom</th>
            <th style="width: 30%;">Rue</th>
            <th style="width: 15%;">Code Postal</th>
            <th style="width: 15%;">Ville</th>
        </tr>
    </thead>
    <tbody>
HTML;

// Corps du tableau
foreach ($lesLignes as $ligne) {
    $nom        = $ligne['nom'];
    $prenom     = $ligne['prenom'];
    $rue        = $ligne['rue_responsable'];
    $codePostal = $ligne['cp_responsable'];
    $ville      = $ligne['ville_responsable'];

    $corps .= <<<ROW
        <tr>
            <td>$nom</td>
            <td>$prenom</td>
            <td>$rue</td>
            <td>$codePostal</td>
            <td>$ville</td>
        </tr>
ROW;
}

$corps.= <<<HTML
    </tbody>
</table>
HTML;

// génération du PDF
Pdf::genererTableau($corps, "Dossiers acceptés", "dossiers_acceptés.pdf");