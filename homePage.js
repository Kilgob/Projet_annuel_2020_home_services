function finFile(iddossier){
  let xhr = new XMLHttpRequest();

  // const folder = document.getElementById(iddossier).id;
  console.log(iddossier);
  // const folder = document.getElementById('dosssier').innerHTML;
  xhr.open('GET', 'homePageDossier_verif.php?folder=' + iddossier);


  // Lorsqu'un réponse est émise par le serveur
  xhr.onreadystatechange = function() {
    if (xhr.status == 200 && xhr.readyState == 4) {
      document.getElementById('info_doss').innerHTML = xhr.responseText;
      console.log(xhr.responseText);
      document.getElementById('iddossier_lb').innerHTML = "Dossier n°" + iddossier;
      if(document.getElementById('verif_type_file').value == 1){
        document.getElementById('close_button').setAttribute("onclick","close_directory(" + iddossier + ")");
        document.getElementById('close_button').innerHTML = 'Clore le dossier';
        // xhr.responseText contient exactement ce que la page PHP renvoi
      }
      else{
        document.getElementById('close_button').setAttribute("onclick","open_directory(" + iddossier + ")");
        document.getElementById('close_button').innerHTML = 'Réouvrir le dossier';
      }
    }
  };
  xhr.send('');
  // console.log('test');
}
