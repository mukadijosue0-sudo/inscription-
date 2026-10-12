# Étude de la génération de documents PDF

L'application consiste à générer des documents PDF à partir d'informations contenues dans une base de données MySQL

Elle met en œuvre le framework MPDF pour la génération des documents PDF

L'application consiste à gérer les dossiers d'inscription au sein d'un établissement scolaire.

Les familles ayant fait une demande doivent envoyer un dossier complet comprenant les pièces suivantes :
* Photocopie de la JAPD (Journée d'Appel de Préparation à la défense) ou l'Attestation du recensement
* Chèque pour frais de dossier : 40 euros, à l'ordre de l'OGEC
* Copie des bulletins de première
* Copie des bulletins de terminale
* Photocopie du diplôme de bachelier

Si le dossier n'est pas parvenu dans les 15 jours une lettre de relance est envoyée.  
Si le dossier reçu est incomplet, les pièces manquantes sont saisies et une lettre indiquant les pièces manquantes est envoyée.  
Si le dossier reçu est complet une lettre de confirmation est envoyée et le dossier est validé.  

Les fonctionnalités de l'application
*   Génération au format PDF de la liste des demandes reçues.
*   Génération au format PDF de la liste des demandes relancées.
*   Génération au format PDF de la liste des dossiers incomplets.
*   Génération au format PDF de la liste des dossiers acceptés.
*   Génération au format Word de la fiche d'inscription.
*   Génération au format Word de la lettre de relance.
*   Saisie des pièces manquantes dans une fenêtre modale et génération au format Word de la lettre envoyée aux familles indiquant les pièces manquantes.
*   Génération au format word de la confirmation d'inscription.