<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdoGsb;
use MyDate;

class ComptableController extends Controller
{
    public function selection()
    {
        $visiteurs = PdoGsb::getLesVisiteurs();
        if (empty($visiteurs)) {
            return view('message')->with('message', "Aucun visiteur trouvé");
        }
        $visiteur = $visiteurs[0];
        $lesMois = PdoGsb::getLesMoisDisponibles($visiteur['id']);
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles ? $lesCles[0] : null;

        return view('comptable.selection')
            ->with('visiteurs', $visiteurs)
            ->with('idVisiteur', $visiteur['id'])
            ->with('lesMois', $lesMois)
            ->with('leMois', $moisASelectionner);
    }

    public function chargerMois(Request $request)
    {
        $idVisiteur = $request->input('idVisiteur');
        $visiteurs = PdoGsb::getLesVisiteurs();
        $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles ? $lesCles[0] : null;
        return view('comptable.selection')
            ->with('visiteurs', $visiteurs)
            ->with('idVisiteur', $idVisiteur)
            ->with('lesMois', $lesMois)
            ->with('leMois', $moisASelectionner);
    }

    public function voirFiche(Request $request)
    {
        $idVisiteur = $request->input('idVisiteur');
        $leMois = $request->input('lstMois');
        $visiteurs = PdoGsb::getLesVisiteurs();
        $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
        $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = MyDate::extraireAnnee($leMois);
        $numMois = MyDate::extraireMois($leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'] ?? '';
        $montantValide = $lesInfosFicheFrais['montantValide'] ?? 0;
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'] ?? 0;
        $dateModif = $lesInfosFicheFrais['dateModif'] ?? null;
        $dateModifFr = $dateModif ? MyDate::getFormatFrançais($dateModif) : '';

        return view('comptable.fiche')
            ->with('visiteurs', $visiteurs)
            ->with('lesMois', $lesMois)
            ->with('leMois', $leMois)
            ->with('numAnnee', $numAnnee)
            ->with('numMois', $numMois)
            ->with('libEtat', $libEtat)
            ->with('montantValide', $montantValide)
            ->with('nbJustificatifs', $nbJustificatifs)
            ->with('dateModif', $dateModifFr)
            ->with('lesFraisForfait', $lesFraisForfait)
            ->with('idVisiteur', $idVisiteur);
    }

    public function validerFiche(Request $request)
    {
        $idVisiteur = $request->input('idVisiteur');
        $leMois = $request->input('leMois');
        PdoGsb::majEtatFicheFrais($idVisiteur, $leMois, 'VA');
        // Recharger la fiche validée avec message de confirmation
        $visiteurs = PdoGsb::getLesVisiteurs();
        $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
        $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = MyDate::extraireAnnee($leMois);
        $numMois = MyDate::extraireMois($leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'] ?? '';
        $montantValide = $lesInfosFicheFrais['montantValide'] ?? 0;
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'] ?? 0;
        $dateModif = $lesInfosFicheFrais['dateModif'] ?? null;
        $dateModifFr = $dateModif ? MyDate::getFormatFrançais($dateModif) : '';

        return view('comptable.fiche')
            ->with('message', "Fiche validée et date de modification mise à jour.")
            ->with('visiteurs', $visiteurs)
            ->with('lesMois', $lesMois)
            ->with('leMois', $leMois)
            ->with('numAnnee', $numAnnee)
            ->with('numMois', $numMois)
            ->with('libEtat', $libEtat)
            ->with('montantValide', $montantValide)
            ->with('nbJustificatifs', $nbJustificatifs)
            ->with('dateModif', $dateModifFr)
            ->with('lesFraisForfait', $lesFraisForfait)
            ->with('idVisiteur', $idVisiteur);
    }

    public function genererEtatQuotidien(Request $request)
    {
        $visiteurs = PdoGsb::getLesVisiteurs();
        if (empty($visiteurs)) {
            return view('message')->with('message', "Aucun visiteur trouvé");
        }
        $visiteur = $visiteurs[0];
        $lesMois = PdoGsb::getLesMoisValides($visiteur['id']);
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles ? $lesCles[0] : null;
        return view('comptable.pdf')
            ->with('visiteurs', $visiteurs)
            ->with('idVisiteur', $visiteur['id'])
            ->with('lesMois', $lesMois)
            ->with('leMois', $moisASelectionner);
    }

    public function telechargerEtat(Request $request)
    {
        $idVisiteur = $request->input('idVisiteur');
        $leMois = $request->input('lstMois');
        $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur, $leMois);
        $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur, $leMois);

        $data = [
            'idVisiteur' => $idVisiteur,
            'leMois' => $leMois,
            'infos' => $lesInfosFicheFrais,
            'frais' => $lesFraisForfait,
        ];

        if (class_exists('Dompdf\\Dompdf')) {
            $html = view('comptable.pdf_export', $data)->render();
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'etat_quotidien_' . $leMois . '_' . $idVisiteur . '.pdf';
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        }

        return view('comptable.pdf_export', $data);
    }
}


