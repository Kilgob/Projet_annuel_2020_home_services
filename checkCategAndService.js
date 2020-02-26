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
    console.log("debut finprest");
    const idagence = document.getElementById('agence_select').options[document.getElementById('agence_select').selectedIndex].value;
    console.log("id de l'agence : " + idagence);
    // const folder = document.getElementById('dosssier').innerHTML;

    const type = document.getElementById('type_user').options[document.getElementById('type_user').selectedIndex].value;
    console.log("type de requete : " + type);

    switch(type){
        case '1':
            document.getElementById('title_list').innerHTML = "Mes prestataires";
            // xhr.open('GET', 'prestataire_agence_verif.php?idagence=' + idagence + '&type_user=' + type_user);
            break;
        case '2':
            document.getElementById('title_list').innerHTML = "Mes clients";
            // xhr.open('GET', 'prestataire_agence_verif.php?idagence=' + idagence + '&type_user=' + type_user);
            break;
        case '3':
            document.getElementById('title_list').innerHTML = "Mes services";
            // xhr.open('GET', 'prestataire_agence_verif.php?idagence=' + idagence + '&type_user=' + type_user);
            break;
    }
    xhr.open('GET', 'prestataire_agence_verif.php?idagence=' + idagence + '&type_user=' + type);
    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
            console.log("la reponse : " + xhr.responseText);
            document.getElementById('new_prest').innerHTML = xhr.responseText;
        }
    };
    xhr.send('');
}