
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


//supprimer un fichier
function delete_file(nmfic){
  var delete_file_xhr = new XMLHttpRequest();

  // const folder = document.getElementById(iddossier).id;
  console.log(nmfic);
  // const folder = document.getElementById('dosssier').innerHTML;
  delete_file_xhr.open('GET', 'file_delete.php?file=' + nmfic);


  // Lorsqu'un réponse est émise par le serveur
  delete_file_xhr.onreadystatechange = function() {
    const children = document.getElementById(nmfic);
    const button_children = document.getElementById(nmfic + "_button");
    const parent = children.parentNode;

      if (delete_file_xhr.status == 200 && delete_file_xhr.readyState == 4) {
          // parent.innerHTML = delete_file_xhr.responseText;
          parent.removeChild(children);
          parent.removeChild(button_children);
          alert('fichier supprimé');

      }
  };
  delete_file_xhr.send('');
  // console.log('test');
}


// function envoi_file(){
//   var xhr_file = new XMLHttpRequest();
//
//
//   console.log(iddossier);
//
//   xhr_file.open('GET', 'prestataire_verif.php?folder=' + iddossier);
//
//
//   // Lorsqu'un réponse est émise par le serveur
//   xhr_file.onreadystatechange = function() {
//       if (xhr_file.status == 200 && xhr_file.readyState == 4) {
//           document.getElementById('section1').innerHTML = xhr_file.responseText;
//           console.log(xhr_file.responseText);
//           // xhr.responseText contient exactement ce que la page PHP renvoi
//       }
//   };
//   xhr_file.send('');
//   // console.log('test');
//
// }


// Methode jquery envoi de fichier
// $("form#files").submit(function(){
//
//     var formData = new FormData($(this)[0]);
//
//     $.ajax({
//         url: window.location.pathname,
//         type: 'POST',
//         data: formData,
//         async: false,
//         success: function (data) {
//             alert(data)
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//
//     return false;
// });
//
// <form id="files" method="post" enctype="multipart/form-data">
//     <input name="image" type="file" />
//     <button>Submit</button>
// </form>
