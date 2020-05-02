
function researchService(iddossier){
    var xhr = new XMLHttpRequest();
    const idcateg = document.getElementById('categ_service_updt').options[document.getElementById('categ_service_updt').selectedIndex].value;
    console.log(idcateg);
    xhr.open('GET', 'getServiceFromCateg_rdv.php?id=' + idcateg);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            document.getElementById('section_service').innerHTML = xhr.responseText;
            console.log(xhr.responseText);
            // xhr.responseText contient exactement ce que la page PHP renvoi
        }
    };
    xhr.send('');
}

function checkAbo(){
  var xhr = new XMLHttpRequest();

  let date = document.getElementById('date').value;
  let hour = document.getElementById('hours').options[document.getElementById('hours').selectedIndex].value;
  let service = document.querySelector('input[name=service]:checked').value;
  let description = document.getElementById('description_service').value;
  let id_categ = document.getElementById('categ_service_updt').value;

  let date_hour = date + '%20' + hour;

  xhr.open('GET', 'create_devis.php?date=' + date_hour + '&service=' + service);

  xhr.onreadystatechange = function() {
    if (xhr.status == 200 && xhr.readyState == 4) {
      displayModal(xhr.responseText, description, service, date_hour, id_categ);
    }
  };
  xhr.send('');
}

function AcceptedService() {
  var xhr = new XMLHttpRequest();

  let date = document.getElementById('date').value;
  let hour = document.getElementById('hours').options[document.getElementById('hours').selectedIndex].value;
  let idservice = document.querySelector('input[name=service]:checked').value;
  let description = document.getElementById('description_service').value;
  let id_categ = document.getElementById('categ_service_updt').value;

  let date_hour = date + '%20' + hour;

  xhr.open('GET', 'create_devis.php?description=' + description + '&idservice=' + idservice + '&date=' + date_hour + '&id_categ=' + id_categ);

  xhr.onreadystatechange = function() {
    if (xhr.status == 200 && xhr.readyState == 4) {
      alert("Service pris avec succès !");
      exitModal();
    }
  };
  xhr.send('');
}

function displayModal(response, description, service, date_hour, id_categ) {
  let alert = document.getElementById('service_alert');

  if (description === '') {
    description = "Pas de description saisie";
  }

  alert.innerHTML = "<div id='subscribe_modal' class='modal fade show' id='subscribe_alert_modal' tabindex='-1' role='dialog' aria-labelledby='subscribe_alert_modal' style='display: block;'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header'><h5 class='modal-title' id='subscribe_alert_modal'>Souhaitez-vous prendre ce service ?</h5><button type='button' class='btn' data-dismiss='modal' aria-label='Close' onclick='exitModal()'><span aria-hidden='true'>&times;</span></button></div><div class='modal-body'>" + response + "</div><div class='modal-footer'><button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='exitModal()'>Annuler</button><button type='button' class='btn btn-primary' onclick='AcceptedService()'>Confirmer</button></div></div></div></div>";

  document.body.className += "modal-open";

  let div_fade = document.createElement('div');
  div_fade.id = 'div_fade'
  div_fade.className = "modal-backdrop fade show";
  div_fade.setAttribute('onclick','exitModal()');

  document.body.appendChild(div_fade);

}

function exitModal() {
  document.getElementById('service_alert').innerHTML = "";
  document.body.removeChild(document.getElementById('div_fade'));
  document.body.className = "";
}
