<?php
declare(strict_types=1);

use ClasseTechnique\InterfaceSystem;
use ClasseMetier\Inscription;
use ClasseMetier\Pdf;
use ClasseTechnique\Requete;

/** @noinspection PhpIncludeInspection */
require $_SERVER['DOCUMENT_ROOT'] . "/../bootstrap/bootstrap.php";

// Vérification de la transmission en GET de l'identifiant de l'inscription


// Récupération des données

// Vérification de la transmission en GET de l'identifiant de l'inscription



// Gestion de la photo de l'étudiant


// Gestion de la date de relance (seule valeur optionnelle)


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
                 
            </td>
        </tr>
        <tr>
            <td class="label">Nom et prénom</td>
            <td class="value"> 
            
            </td>
         </tr>
         <tr>
            <td class="label">Photo</td>
            <td class="value">
                
            </td>
        </tr>
        <tr>
            <td class="label">Sexe</td>
            <td class="value">
               
             </td>
        </tr>
        <tr>
            <td class="label">Responsable légal</td>
            <td class="value">


            </td>
        </tr>
        <tr>
            <td class="label">Date inscription</td>
            <td class="value">

            </td>
        </tr>
        <tr>
            <td class="label">Date relance</td>
            <td class="value">

            </td>
        </tr>
        <tr>
            <td class="label">État du dossier</td>
            <td class="value">

            </td>
        </tr>
    </table>
HTML;

// Génération du PDF
