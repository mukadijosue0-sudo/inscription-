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

// Récupération des données concernant l'inscription à partir de l'identifiant
$dossier = Inscription::getById($id);

// Si aucune inscription n'est trouvée, affichage d'un message d'erreur
if (!$dossier) {
    $titre = "Lettre de confirmation";
    $message = "Aucune inscription trouvée pour l'identifiant $id";
    $type = "erreur";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}

// Construction du destinataire de la lettre
$destinataire = $dossier['titre_responsable'] . ' ' . $dossier['nom_responsable'];
$destinataire .= '<br>' . nl2br($dossier['rue_responsable']);
$destinataire .= '<br>' . $dossier['cp_responsable'] . ' ' . $dossier['ville_responsable'];
$genre = $dossier['genre'];
$inscrit = $dossier['inscrit'];
$prenom = $dossier['prenom'];
$nom = $dossier['nom'];
$dateLimite = date('d/m/Y', strtotime('next friday + 7 days'));

// Construction du contenu HTML de la lettre
$corps = <<<HTML
    <div class="objet">Objet : confirmation d'inscription</div>

    <!-- Corps de la lettre -->
    <div class="corps">
        <p>Madame, Monsieur,</p>

        <p>
            Nous avons bien reçu le dossier d'inscription concernant votre $genre $prenom $nom 
            et nous vous en remercions.
        </p>

        <p>
            Nous vous informons qu'il est complet et par conséquent que votre $genre
            est définitivement $inscrit pour la rentrée prochaine sous réserve du passage accordé par le conseil de classe et/ou la commission d'appel, et du respect des éventuelles observations indiquées sur la fiche d'inscription.
        </p>
HTML;

// Mise à jour : confirmation en base
Inscription::confirmer($dossier['id']);

// Génération du PDF
$nomFichier = "confirmation $nom $prenom.pdf";
Pdf::genererLettre($corps, $destinataire, $nomFichier);


