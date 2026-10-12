<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

$lesLignes = Inscription::getLesDossiers();
if (count($lesLignes) === 0) {
    $titre = "Demandes reçues";
    $message = "Aucune demande d'inscription n'a été reçue pour le moment.";
    $type = "avertissement";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// En-tête du tableau
$corps = <<<HTML
<table >
    <thead> 
        <tr>
            <th style="width: 35%;">Étudiant</th>
            <th style="width: 8%;" class="center">Sexe</th>
            <th style="width: 16%;" class="center">Demandée le</th>
            <th style="width: 16%;" class="center">Relancée le</th>
            <th style="width: 25%;">État</th>
        </tr>
    </thead>
    <tbody>
HTML;

// Corps du tableau
foreach ($lesLignes as $ligne) {
    $nom        = $ligne['nom'];
    $prenom     = $ligne['prenom'];
    $sexe       = $ligne['sexe'];
    $demande    = $ligne['date_inscription'];
    $relance    = $ligne['date_relance'] ? $ligne['date_relance'] : '';
    $etat       = $ligne['libelle'];

    $corps .= <<<ROW
        <tr>
            <td>$nom $prenom</td>
            <td class="center">$sexe</td>
            <td class="center">$demande</td>
            <td class="center">$relance</td>
            <td>$etat</td>
        </tr>
ROW;
}

$corps.= <<<HTML
    </tbody>
</table>
HTML;

// génération du PDF
Pdf::genererTableau($corps, "Demandes reçues", "demandes_reçues.pdf");

