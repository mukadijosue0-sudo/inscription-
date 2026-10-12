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

if (!$dossier) {
    $titre = "Realnce";
    $message = "Aucune inscription trouvée pour l'identifiant $id";
    $type = "erreur";
    $interface = new InterfaceSystem($titre, $message, $type);
    $interface->afficher();
}


// Formatage et échappement des données
$destinataire = $dossier['titre_responsable'] . ' ' . $dossier['nom_responsable'];
$destinataire .= '<br>' . nl2br($dossier['rue_responsable']);
$destinataire .= '<br>' . $dossier['cp_responsable'] . ' ' . $dossier['ville_responsable'];
$genre = $dossier['genre'];
$prenom = $dossier['prenom'];
$nom = $dossier['nom'];
$dateLimite = date('d/m/Y', strtotime('next friday + 7 days'));

// Construction du contenu HTML de la lettre
$corps = <<<HTML
    <!-- Objet de la lettre -->
    <div class="objet">Objet : relance pour dossier incomplet</div>

    <!-- Corps de la lettre -->
    <div class="corps">
        <p>Madame, Monsieur,</p>

        <p>
            Nous n’avons à ce jour pas reçu l’ensemble des pièces du dossier d’inscription de
            votre {$genre} {$prenom} {$nom}.
        </p>

        <p>
            Nous vous remercions de bien vouloir compléter ce dossier dans les plus brefs délais
            et au plus tard pour le <strong>{$dateLimite}</strong>.
        </p>

        <p>
            Sans retour de votre part, nous ne pourrons garantir l’inscription de votre enfant à la rentrée.
        </p>
    </div>
HTML;

// Mise à jour en base : on enregistre la relance
Inscription::setRelance($dossier['id']);

// Génération du PDF
$nomFichier = "relance $nom $prenom.pdf";
Pdf::genererLettre($corps, $destinataire, $nomFichier);


