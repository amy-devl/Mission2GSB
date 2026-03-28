<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Fiches validées du {{ $date }}</title>
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
      h1 { font-size: 18px; margin: 0 0 12px 0; }
      h2 { font-size: 14px; margin: 16px 0 6px 0; }
      table { width: 100%; border-collapse: collapse; margin-top: 6px; }
      th, td { border: 1px solid #333; padding: 6px; text-align: left; }
      caption { text-align: left; font-weight: bold; margin-bottom: 4px; }
      .section { page-break-inside: avoid; margin-bottom: 10px; }
    </style>
  </head>
  <body>
    <h1>Fiches validées le {{ $date }}</h1>

    @forelse($details as $item)
      <div class="section">
        <h2>{{ $item['nom'] }} {{ $item['prenom'] }} — Mois {{ substr($item['mois'],4,2) }}/{{ substr($item['mois'],0,4) }}</h2>
        <p>
          Etat: {{ $item['infos']['libEtat'] ?? '' }} —
          Justificatifs: {{ $item['infos']['nbJustificatifs'] ?? 0 }} —
          Montant validé: {{ $item['infos']['montantValide'] ?? 0 }}
        </p>

        <table>
          <caption>Eléments forfaitisés</caption>
          <tr>
            @foreach($item['frais'] as $f)
              <th>{{ $f['libelle'] }}</th>
            @endforeach
          </tr>
          <tr>
            @foreach($item['frais'] as $f)
              <td>{{ $f['quantite'] }}</td>
            @endforeach
          </tr>
        </table>
      </div>
    @empty
      <p>Aucune fiche validée aujourd'hui.</p>
    @endforelse
  </body>
  </html>


