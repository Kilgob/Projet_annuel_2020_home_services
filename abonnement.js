function displayModal(idAbo) {
  let alert = document.getElementById('subscribe_alert');
  let lb = document.getElementById('abo_title' + idAbo).innerHTML;
  let days = document.getElementById('abo_days' + idAbo).innerHTML;
  let duration = document.getElementById('abo_duration' + idAbo).innerHTML;
  let price = document.getElementById('abo_price' + idAbo).innerHTML;

  alert.innerHTML = "<div id='subscribe_modal' class='modal fade show' id='subscribe_alert_modal' tabindex='-1' role='dialog' aria-labelledby='subscribe_alert_modal' style='display: block;'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header'><h5 class='modal-title' id='subscribe_alert_modal'>Souhaitez-vous prendre cet abonnement ?</h5><button type='button' class='btn' data-dismiss='modal' aria-label='Close' onclick='exitModal()'><span aria-hidden='true'>&times;</span></button></div><div class='modal-body'><h5>" + lb + "</h5><p>" + days + "</p><p>" + duration + "</p><p>" + price + "</p></div><div class='modal-footer'><button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='exitModal()'>Annuler</button><button type='button' class='btn btn-primary' onclick='selectAbonnement(" + idAbo + ")'>Confirmer</button></div></div></div></div>";

  document.body.className += "modal-open";

  let div_fade = document.createElement('div');
  div_fade.id = 'div_fade'
  div_fade.className = "modal-backdrop fade show";
  div_fade.setAttribute('onclick','exitModal()');

  document.body.appendChild(div_fade);

}

function exitModal() {
  document.getElementById('subscribe_alert').innerHTML = "";
  document.body.removeChild(document.getElementById('div_fade'));
  document.body.className = "";
}

function selectAbonnement(idAbo) {

}
