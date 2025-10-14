<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Etat quotidien</title>
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
      h1 { font-size: 18px; margin-bottom: 6px; }
      table { width: 100%; border-collapse: collapse; margin-top: 10px; }
      th, td { border: 1px solid #333; padding: 6px; text-align: left; }
      caption { text-align: left; font-weight: bold; margin-bottom: 4px; }
    </style>
  </head>
  <body>
    <h1>Etat quotidien - Fiche validée</h1>
    <p>
      Visiteur: {{ $idVisiteur }}<br/>
      Mois: {{ substr($leMois,4,2) }}/{{ substr($leMois,0,4) }}<br/>
      Etat: {{ $infos['libEtat'] ?? '' }}<br/>
      Justificatifs: {{ $infos['nbJustificatifs'] ?? 0 }}<br/>
      Montant validé: {{ $infos['montantValide'] ?? 0 }}
    </p>

    <table>
      <caption>Eléments forfaitisés</caption>
      <tr>
        @foreach($frais as $unFraisForfait)
          <th>{{ $unFraisForfait['libelle'] }}</th>
        @endforeach
      </tr>
      <tr>
        @foreach($frais as $unFraisForfait)
          <td>{{ $unFraisForfait['quantite'] }}</td>
        @endforeach
      </tr>
    </table>
  </body>
  </html>


