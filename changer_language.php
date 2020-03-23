<?php
    include_once("lang.php");
    //Detecter si la session est deja etablie
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Detecter la langue choisit
    if(isset($_GET["lang"])){
        //Filter pour mesure de securité
        $lang = filter_var($_GET['lang'], FILTER_SANITIZE_STRING);
    }else{
        //En laisse a français par defaul si pas de language choisi
        $lang = DEFAULT_LANG;
    }
    //Apliquer le language en session
    $_SESSION["lang"] = $lang;

    //Redirection vers la page precedente
    header('Location: ' . $_SERVER['HTTP_REFERER']);