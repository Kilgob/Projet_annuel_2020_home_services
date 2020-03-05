
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