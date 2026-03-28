@extends ('comptable.selection')
@section('contenu2')

<div id="contenu">
<h3>Fiche de frais du mois {{ $numMois }}-{{ $numAnnee }}</h3>
<div class="encadre">
  @if(isset($message) && $message)
    <div class="message" style="margin-bottom:10px;">
      <input type="text" value="{{ $message }}" readonly style="width:100%;" />
    </div>
  @endif
  <p>
    Etat : <strong>{{ $libEtat }} depuis le {{ $dateModif }} </strong>
    <br> Montant validé : <strong>{{ $montantValide }} </strong>
    <br> Justificatifs : <strong>{{ $nbJustificatifs }}</strong>
  </p>  
  <table class="listeLegere">
    <caption>Eléments forfaitisés</caption>
    <tr>
      @foreach($lesFraisForfait as $unFraisForfait)
        <th>{{ $unFraisForfait['libelle'] }}</th>
      @endforeach
    </tr>
    <tr>
      @foreach($lesFraisForfait as $unFraisForfait)
        <td class="qteForfait">{{ $unFraisForfait['quantite'] }}</td>
      @endforeach
    </tr>
  </table>

  <form action="{{ route('chemin_comptable_valider') }}" method="post" style="margin-top:12px;">
    {{ csrf_field() }}
    <input type="hidden" name="idVisiteur" value="{{ $idVisiteur }}"/>
    <input type="hidden" name="leMois" value="{{ $leMois }}"/>
    <input type="submit" value="Valider la fiche"/>
  </form>
</div>
</div>
@endsection


