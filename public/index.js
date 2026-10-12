"use strict";

// -----------------------------------------------------------------------------------
// Import des fonctions nécessaires
// -----------------------------------------------------------------------------------

import { getData } from "/composant/fonction/page.js";

// -----------------------------------------------------------------------------------
// Déclaration des variables globales
// -----------------------------------------------------------------------------------

const dossiers = getData('dossiers');
const lesLignes = document.getElementById('lesLignes');
const template = document.getElementById('tplLigneEleve');

// -----------------------------------------------------------------------------------
// Programme principal
// -----------------------------------------------------------------------------------

for (const dossier of dossiers) {
    // Clonage du contenu du template
    const clone = template.content.cloneNode(true);

    // Remplissage des données textuelles avec concaténation
    clone.querySelector('.nom').textContent = dossier.nom + ' ' + dossier.prenom;
    clone.querySelector('.date-inscription').textContent = dossier.date_inscription|| '';
    clone.querySelector('.date-relance').textContent = dossier.date_relance || '';
    clone.querySelector('.etat').textContent = dossier.libelle;

    // Bouton Fiche (systématique)
    const btnFiche = clone.querySelector('.btn-fiche');
    btnFiche.href = 'fiche.php?id=' + dossier.id_dossier;
    btnFiche.target = 'Fiche';

    // Récupération des boutons conditionnels
    const btnIncomplet = clone.querySelector('.btn-incomplet');
    const btnConfirmation = clone.querySelector('.btn-confirmation');
    const btnRelance = clone.querySelector('.btn-relance');

    const etat = parseInt(dossier.id_etat, 10);

    // Condition 1 : Gestion des pièces manquantes et confirmation (si id_etat !== 3)
    if (etat !== 3) {
        btnIncomplet.href = 'piecesmanquantes/?id=' + dossier.id_dossier;
        btnConfirmation.href = 'confirmation.php?id=' + dossier.id_dossier;
        btnConfirmation.target = 'Confirmation';
        // la page est rechargée après 3 secondes pour mettre à jour l'interface ; seul le bouton Fiche reste affcihé
        btnConfirmation.addEventListener('click', () => {
            setTimeout(() => location.reload(), 3000);
        });
    } else {
        btnIncomplet.remove();
        btnConfirmation.remove();
    }

    // Condition 2 : Relance de l'élève (si id_etat === 0 et delai > 8)
    if (etat === 0 && dossier.delai > 8) {
        btnRelance.target = 'Relance';
        btnRelance.href = 'relance.php?id=' + dossier.id_dossier;
    } else {
        btnRelance.remove();
    }

    // Ajout de la ligne complétée au tableau
    lesLignes.appendChild(clone);
}