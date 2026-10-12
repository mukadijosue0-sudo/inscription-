<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

$lesLignes = Inscription::getLesDossiersRelances();
if (count($lesLignes) === 0) {
    $titre = "Demandes relancées";
    $message = "Aucune demande d'inscription n'a été relancée pour le moment.";
    $type = "avertissement";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// En-tête du tableau
$corps = <<<HTML
<table >
    <thead> 
        <tr>
            <th style="width: 40%;">Étudiant</th>
            <th style="width: 10%;" class="center">Sexe</th>
            <th style="width: 25%;" class="center">Demandée le</th>
            <th style="width: 25%;" class="center">Relancée le</th>
        </tr>
    </thead>
    <tbody>
HTML;

// Corps du tableau
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
Pdf::genererTableau($corps, "Demandes Relancer", "demandes_Relancer.pdf");
