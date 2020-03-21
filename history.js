function findHistory(iduser){
  var xhr = new XMLHttpRequest();

  var statut;
  var radios_button = document.getElementsByName('statut');

  for (var i = 0; i < radios_button.length; i++){
    if (radios_button[i].checked) {
      statut = radios_button[i].value;
    }
  }

  xhr.open('GET', 'display_history.php?iduser=' + iduser + '&statut=' + statut);


  // Lorsqu'un réponse est émise par le serveur
  xhr.onreadystatechange = function() {
      if (xhr.status == 200 && xhr.readyState == 4) {
          document.getElementById('history').innerHTML = xhr.responseText;
          //console.log(xhr.responseText);
          // xhr.responseText contient exactement ce que la page PHP renvoi
      }
  };
  xhr.send('');
}
