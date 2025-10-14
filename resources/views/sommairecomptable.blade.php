@extends ('modeles/visiteur')
    @section('menu')
            <!-- Division pour le sommaire comptable -->
        <div id="menuGauche">
            <div id="infosUtil">
                  
             </div>  
               <ul id="menuList">
                   <li >
                    <strong>Espace comptable</strong>
                   </li>
                  <li class="smenu">
                      <a href="{{ route('chemin_comptable_selection') }}" title="Valider fiches de frais">Valider fiches de frais</a>
                  </li>
                  <li class="smenu">
                      <a href="{{ route('chemin_etat_quotidien') }}" title="Générer l'état quotidien (PDF)">Générer l'état quotidien (PDF)</a>
                  </li>
                  <li class="smenu">
                    <a href="{{ route('chemin_deconnexion') }}" title="Se déconnecter">Déconnexion</a>
                  </li>
                </ul>
               
        </div>
    @endsection          


