var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value + " €"; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value + " €";
}


var slider2 = document.getElementById("timer");
var output2 = document.getElementById("timer_label");
output2.innerHTML = slider.value + " h"; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider2.oninput = function() {
    output2.innerHTML = this.value + " h";
}




function devis(id) {
    var devis = document.getElementById("iddevis");
    devis.setAttribute("value", id);
}

function deviscli(id) {
    // devis.setAttribute("value", id);
    var devis = document.getElementById("form_devis");

    var xhr = new XMLHttpRequest();
    // const folder = document.getElementById(iddossier).id;
    // console.log(idservice);
    xhr.open('GET', 'devis_back.php?id=' + id);


    // Lorsqu'un réponse est émise par le serveur
    xhr.onreadystatechange = function() {
        if (xhr.status == 200 && xhr.readyState == 4) {
            document.getElementById('interventions_statut').innerHTML = xhr.responseText;
            console.log(xhr.responseText);
            // xhr.responseText contient exactement ce que la page PHP renvoi
        }
    };
    xhr.send('');
    // console.log('test');
}