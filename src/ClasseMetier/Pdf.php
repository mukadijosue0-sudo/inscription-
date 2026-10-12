<?php
declare(strict_types=1);

namespace ClasseMetier;

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class Pdf
{
    /**
     * Génère une lettre PDF avec entête + coordonnées + signature
     */
    public static function genererLettre(string $corps, string $destinataire, string $nomFichier = 'lettre.pdf', bool $telecharger = false): void
    {
        $mpdf = new Mpdf([
            'margin_top' => 15,
            'margin_bottom' => 20,
            'margin_left' => 25,
            'margin_right' => 25,
        ]);

        // partie commune à toutes les lettres
        $html = <<<HTML
<html>
<head>
    <style>
        body        { font-family: helvetica, sans-serif; font-size: 12pt; }
        .coordonnees, .objet, .corps, .signature { margin-bottom: 15px; }
        .coordonnees, .signature { margin-top: 20px; margin-left: 10cm; }
        .objet       { font-weight: bold; margin-top: 40px; }
        .corps       { margin-top: 20px; }
        p {text-indent: 2em; text-align: justify; line-height: 35px; margin: 10px 0; }
        .footer      { margin-top: 30px; font-size: 10pt; }
    </style>
</head>
<body>

    <!-- Entête avec logo et coordonnées de l’établissement -->
    <img src="/data/logo.png" style="width: 100px;" alt="Logo"><br>

    <div>
        Lycée Sacré Cœur<br>
        2, rue des Augustins<br>
        BP 40178<br>
        80007 Amiens cedex 1
    </div>

    <!-- Coordonnées du destinataire -->
    <div class="coordonnees">
    $destinataire      
    </div>
HTML;
        // ajout du corps de la lettre
        $html .= $corps;

        // Pied : signature du directeur
        $pied = <<<HTML
            <p>
            Veuillez croire, Madame, Monsieur, en l’expression de nos salutations distinguées.
            </p>
        </div>
        <div class="signature" style="margin-top: 20px;">
                <p>
                    Le Directeur<br><br>
                    <img src="/data/signature.png" style="width: 150px;" alt="Signature">
                </p>
        </div>
HTML;
        // ajout du pied
        $html .= $pied;

        // génération du document avec sécurisation du nom du fichier
        $mpdf->WriteHTML($html);
        $nomFichierSecurise = rawurlencode($nomFichier);
        $mpdf->Output($nomFichierSecurise, $telecharger ? Destination::DOWNLOAD : Destination::INLINE);
    }


    /**
     * Génère un tableau ou une liste PDF avec entête (logo + titre) et pied (pagination)
     */
    public static function genererTableau(string $corps, string $titre, string $nomFichier = 'document.pdf', bool $telecharger = false): void
    {
        $mpdf = new Mpdf([
            'margin_top' => 40,
            'margin_bottom' => 20,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        // Pour l'en-tête répété des tableaux, mPDF supporte bien le chemin absolu système également
        $cheminLogo = $_SERVER['DOCUMENT_ROOT'] . '/data/logo.png';

        // 1. Ajout des styles CSS spécifiques aux tableaux
        $styles = <<<CSS
        <style>
            body {
                font-family: helvetica, sans-serif;
                font-size: 11pt;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10pt;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #000;
                padding: 6px 4px;
                text-align: left;
            }
            th {
                background-color: #dde;
            }
            td {
                vertical-align: top;
            }
            .center {
                text-align: center;
            }
        </style>
CSS;

        $mpdf->WriteHTML($styles, HTMLParserMode::HEADER_CSS);

        // 2. Entête : logo + titre (affiché sur chaque page)
        $entete = <<<HTML
    <table style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #aaa;">
        <tr>
            <td style="width: 20%; vertical-align: middle; border: none;">
                <img src="{$cheminLogo}" style="max-height: 70px;" alt="Logo">
            </td>
            <td style="text-align: left; font-size: 14pt; vertical-align: middle; border: none;">
                <strong>{$titre}</strong>
            </td>
        </tr>
    </table>
HTML;

        $mpdf->SetHTMLHeader($entete);

        // 3. Pied : pagination automatique
        $pied = <<<HTML
        <div style="text-align: right; font-size: 10pt; border-top: 1px solid #aaa; padding-top: 5px;">
            Page {PAGENO} / {nb}
        </div>
HTML;
        $mpdf->SetHTMLFooter($pied);

        // 4. Contenu principal (tableau ou liste)
        $mpdf->WriteHTML($corps);

        // 5. Génération du fichier avec nom sécurisé
        $nomFichierSecurise = rawurlencode($nomFichier);
        $mpdf->Output($nomFichierSecurise, $telecharger ? Destination::DOWNLOAD : Destination::INLINE);
    }
}