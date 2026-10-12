"use strict";

// -----------------------------------------------------------------------------------
// Import des fonctions nécessaires
// -----------------------------------------------------------------------------------

import { getData } from "/composant/fonction/page.js";

// -----------------------------------------------------------------------------------
// Déclaration des variables globales
// -----------------------------------------------------------------------------------

const dossier = getData("dossier");
const lesPieces = getData("lesPieces");
const lesPiecesManquantes = getData("lesPiecesManquantes");

let msg = document.getElementById('msg');
let listePieces = document.getElementById('listePieces');
let nom = document.getElementById('nom');
let form = document.getElementById('formDossier');
let idDossier = document.getElementById('idDossier');
let pieces = document.getElementById('pieces');
let templatePiece = document.getElementById('templatePiece');

// -----------------------------------------------------------------------------------
// Procédures évènementielles
// -----------------------------------------------------------------------------------

form.onsubmit = (e) => {
    // récupération des cases cochées


    // Vérification qu'au moins une case est cochée



    msg.innerText = "";

    // Extraction fraîche et garantie de l'ID et du libellé depuis le DOM




    // Redirection sécurisée après un court délai pour laisser l'onglet s'ouvrir

};

// -----------------------------------------------------------------------------------
// Programme principal
// -----------------------------------------------------------------------------------

idDossier.value = dossier.id;
nom.innerText = `${dossier.nom} ${dossier.prenom}`;

// Générer les cases à cocher à partir du template HTML
for (const piece of lesPieces) {
    const clone = templatePiece.content.cloneNode(true);
    const input = clone.querySelector('input');
    const span = clone.querySelector('.libelle-piece');

    input.id = piece.id;
    input.value = piece.libelle; // On stocke bien le libellé dans la valeur de l'input
    span.textContent = piece.libelle;

    listePieces.appendChild(clone);
}

// Cocher les pièces déjà signalées manquantes
