
function research(iddossier){
  var xhr = new XMLHttpRequest();
  const type_user = document.getElementById('type_user').options[document.getElementById('type_user').selectedIndex].value;
  // const folder = document.getElementById(iddossier).id;
  console.log(iddossier);
  xhr.open('GET', 'prestataire_verif.php?folder=' + iddossier + '&type_user=' + type_user);


  // Lorsqu'un réponse est émise par le serveur
  xhr.onreadystatechange = function() {
      if (xhr.status == 200 && xhr.readyState == 4) {
          document.getElementById('section1').innerHTML = xhr.responseText;
          console.log(xhr.responseText);
          // xhr.responseText contient exactement ce que la page PHP renvoi
      }
  };
  xhr.send('');
  // console.log('test');
}

function researchS(iddossier){
    var xhr = new XMLHttpRequest();
    const idagence = document.getElementById('agence_select').options[document.getElementById('agence_select').selectedIndex].value;
    // const folder = document.getElementById(iddossier).id;
    console.log(idagence);
    xhr.open('GET', 'service_verif.php?folder=' + iddossier + '&idagence=' + idagence);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            document.getElementById('section1').innerHTML = xhr.responseText;
            console.log(xhr.responseText);
            // xhr.responseText contient exactement ce que la page PHP renvoi
        }
    };
    xhr.send('');
    // console.log('test');
}

//corriger
function searchservice(){
    var xhr = new XMLHttpRequest();
    const idservice = document.getElementById('select_service').options[document.getElementById('select_service').selectedIndex].value;
    // const folder = document.getElementById(iddossier).id;
    console.log(idservice);
    xhr.open('GET', 'unique_service.php?folder=' + idservice);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            document.getElementById('info_service').innerHTML = xhr.responseText;
            console.log(xhr.responseText);
            // xhr.responseText contient exactement ce que la page PHP renvoi
        }
    };
    xhr.send('');
    // console.log('test');
}