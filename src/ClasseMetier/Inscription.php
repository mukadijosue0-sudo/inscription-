<?php
namespace ClasseMetier;

use ClasseTechnique\Database;
use ClasseTechnique\Select;

class Inscription
{
    /**
     * Récupération de tous les dossiers
     * @return array
     */
    public static function getLesDossiers(): array
    {
        $sql = <<<SQL
            SELECT dossier.id AS id_dossier, nom, prenom, sexe, nom_responsable, titre_responsable, rue_responsable, 
                    cp_responsable, ville_responsable, 
                    date_format(date_inscription, '%d/%m/%Y') as date_inscription,
                    date_format(date_relance, '%d/%m/%Y') as date_relance,
                    DateDiff(curdate(), date_inscription) as delai,
                    dossier.id_etat, libelle 
            FROM dossier 
                JOIN etat ON etat.id = dossier.id_etat 		
            ORDER BY nom, prenom;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Récupération des dossiers acceptés
     * @return array
     */
    public static function getLesDossiersAcceptes(): array
    {
        $sql = <<<SQL
            SELECT id, nom, prenom, sexe, nom_responsable, titre_responsable, rue_responsable, 
                    cp_responsable, ville_responsable, 
                    date_format(date_inscription, '%d/%m/%Y') as date_inscription,
                    date_format(date_relance, '%d/%m/%Y') as date_relance
            FROM dossier  
            where id_etat = 3
            order by nom,  prenom;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    // Les dossiers incomplets : dossier + piece manquante

    /**
     * Récupération des dossiers incomplets
     * @return array
     */

    public static function getLesDossiersIncomplets(): array
    {




    }


    /**
     * Récupération des dossiers relancés
     * @return array
     */
    public static function getLesDossiersRelances()
    {
        $sql = <<<SQL
            SELECT id, nom, prenom, sexe, nom_responsable, titre_responsable, rue_responsable, 
                    cp_responsable, ville_responsable, 
                    date_format(date_inscription, '%d/%m/%Y') as date_inscription,
                    date_format(date_relance, '%d/%m/%Y') as date_relance
            FROM dossier  
            where id_etat = 1
            order by nom,  prenom;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Récupération des papiers à fournir
     * @return array
     */
    public static function getLesPieces()
    {


    }

    /**
     * Récupération des inforation sur un élève
     * @param int $id
     * @return array
     */
    public static function getById(int $id): array | null
    {
        $sql = <<<SQL
            SELECT dossier.id,  nom, prenom, sexe, nom_responsable, titre_responsable, rue_responsable, 
                    cp_responsable, ville_responsable, 
                    dateformatLong(date_inscription) as date_inscription,
                    if (date_relance is null, 'Aucune relance', dateFormatLong(date_relance))as date_relance,
                    if(sexe = 'F', 'fille', 'fils') as genre,
                    if(sexe = 'F', 'inscrite', 'inscrit') as inscrit,
                    dossier.id_etat, libelle 
            FROM dossier 
                JOIN etat ON etat.id = dossier.id_etat 	
            where dossier.id = :id;	
SQL;
        $select = new Select();
        return $select->getRow($sql, ['id' => $id]);
    }



    /**
     * Récupération des pièces manquantes pour l'élève passé en paramètre
     * @param int $id
     * @return array
     */
    public static function getLesPiecesManquantes(int $id)
    {


    }

    /**
     * Confirmation d'un dossier l'état passe à trois et les pièces manquantes sont supprimées
     * @param int $id
     */
    public static function confirmer(int $id)
    {
        // Mise à jour de id_etat qui passe à 3


        // Suppression des éventuelles pièces manquantes


    }

    /**
     * Passage du dossier à l'état Incomplet : l'état passe à 2 et on mémorise les pièces manquantes
     * @param $id
     * @param $lesPieces
     */
    public static function setIncomplet($id, $lesPieces)
    {
        // Mise à jour de id_etat qui passe à 2


        // Suppression des éventuelles pièces manquantes précédentes


        // Mémorisation des pièces manquantes

    }

    /**
     * Passage du dossier à l'état relancé : l'état passe à 1 et on mémorise la date de la relance
     * @param int $id
     * @return void
     */
    public static function setRelance(int $id)
    {
        // Mise à jour de id_etat qui passe à 1

    }
}

