@extends ('sommairecomptable')
@section('contenu1')
  <div id="contenu">
    <h2>Générer l'état quotidien (PDF)</h2>
    <h3>Visiteur et mois validé à sélectionner : </h3>
    <form action="{{ route('chemin_etat_quotidien_dl') }}" method="post">
      {{ csrf_field() }}
      <div class="corpsForm"><p>
        <label for="idVisiteur">Visiteur : </label>
        <select id="idVisiteur" name="idVisiteur" onchange="this.form.submit()" formaction="{{ route('chemin_etat_quotidien') }}">
            @foreach($visiteurs as $v)
              <option value="{{ $v['id'] }}" {{ $v['id']==$idVisiteur ? 'selected' : '' }}>
                {{ $v['nom'] }} {{ $v['prenom'] }}
              </option>
            @endforeach
        </select>
      </p></div>
      <div class="corpsForm"><p>
        <label for="lstMois">Mois : </label>
        <select id="lstMois" name="lstMois">
            @foreach($lesMois as $mois)
              <option value="{{ $mois['mois'] }}" {{ $mois['mois']==$leMois ? 'selected' : '' }}>
                {{ $mois['numMois'] }}/{{ $mois['numAnnee'] }}
              </option>
            @endforeach
        </select>
      </p></div>
      <div class="piedForm">
        <p>
          <input id="ok" type="submit" value="Télécharger le PDF" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p>
      </div>
    </form>
  </div>
@endsection


