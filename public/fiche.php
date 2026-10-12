<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;
use ClasseTechnique\Requete;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

// Vérification de la transmission en GET de l'identifiant de l'inscription
$id = Requete::getInt('id');

// Récupération des données
$dossier = Inscription::getById($id);

// Vérification de l'existence du dossier
if (!$dossier) {
    $titre = "Fiche élève";
    $message = "Aucune inscription trouvée pour l'identifiant $id";
    $type = "erreur";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// Gestion de la photo de l'étudiant : id.png (ou id.jpg), sinon photo par défaut
$dossierPhoto = $_SERVER['DOCUMENT_ROOT'] . '/data/photo/';
$photo = $dossierPhoto . '0.png';
foreach (['png', 'jpg'] as $extension) {
    if (is_file($dossierPhoto . $id . '.' . $extension)) {
        $photo = $dossierPhoto . $id . '.' . $extension;
        break;
    }
}

// Gestion de la date de relance (seule valeur optionnelle)
$dateRelance = $dossier['date_relance'] ?? 'Aucune relance';

// Préparation des valeurs affichées (échappement des caractères spéciaux HTML)
$nomPrenom = htmlspecialchars($dossier['nom'] . ' ' . $dossier['prenom']);
$responsable = htmlspecialchars($dossier['titre_responsable'] . ' ' . $dossier['nom_responsable'])
    . '<br>' . htmlspecialchars($dossier['rue_responsable'])
    . '<br>' . htmlspecialchars($dossier['cp_responsable'] . ' ' . $dossier['ville_responsable']);

// En-tête et corps du tableau HTML (utilisation directe des clés du tableau $dossier)
$corps = <<<HTML
        <style>
            td.label {
                width: 35%;
                font-weight: bold;
            }
            td.value {
                width: 65%;
                text-align: justify;
            }
            .photo {
                display: block;
                margin-top: 10px;
                max-width: 120px;
                max-height: 120px;
                border: 1px solid #000;
                object-fit: cover;
            }
        </style>

    <table>
        <tr>
            <td class="label">Numéro du dossier</td>
            <td class="value">
                {$dossier['id']}
            </td>
        </tr>
        <tr>
            <td class="label">Nom et prénom</td>
            <td class="value"> 
                $nomPrenom
            </td>
         </tr>
         <tr>
            <td class="label">Photo</td>
            <td class="value">
                <img class="photo" src="$photo" alt="Photo de l'élève">
            </td>
        </tr>
        <tr>
            <td class="label">Sexe</td>
            <td class="value">
                {$dossier['sexe']}
             </td>
        </tr>
        <tr>
            <td class="label">Responsable légal</td>
            <td class="value">
                $responsable
            </td>
        </tr>
        <tr>
            <td class="label">Date inscription</td>
            <td class="value">
                {$dossier['date_inscription']}
            </td>
        </tr>
        <tr>
            <td class="label">Date relance</td>
            <td class="value">
                $dateRelance
            </td>
        </tr>
        <tr>
            <td class="label">État du dossier</td>
            <td class="value">
                {$dossier['libelle']}
            </td>
        </tr>
    </table>
HTML;

// Génération du PDF
$nomFichier = "fiche {$dossier['nom']} {$dossier['prenom']}.pdf";
Pdf::genererTableau($corps, "Fiche élève", $nomFichier);