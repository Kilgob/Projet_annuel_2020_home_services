function finAgence(){
    let xhr = new XMLHttpRequest();

    const idagence = document.getElementById('agence_select_service').options[document.getElementById('agence_select_service').selectedIndex].value;
    console.log("id de l'agence : " + idagence);
    // const folder = document.getElementById('dosssier').innerHTML;
    xhr.open('GET', 'updtNewService.php?idagence=' + idagence);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            //console.log("la reponse : " + xhr.responseText);
            document.getElementById('categ_service_updt').innerHTML = xhr.responseText;
        }
    };
    xhr.send('');
}

function finPrest(){
    let xhr = new XMLHttpRequest();

    const idagence = document.getElementById('agence_select').options[document.getElementById('agence_select_service').selectedIndex].value;
    console.log("id de l'agence : " + idagence);
    // const folder = document.getElementById('dosssier').innerHTML;
    xhr.open('GET', 'prestataire_agence_verif.php?idagence=' + idagence);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            //console.log("la reponse : " + xhr.responseText);
            document.getElementById('new_prest').innerHTML = xhr.responseText;
        }
    };
    xhr.send('');
}