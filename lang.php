<?php
    /**
     * Ce fichier vas permetre la detection de la langue choisis, et vas proceder a traduire les texts du site web.
     */

    //Definir le dossier qui contient les traductions
    define("LANG_DIR", __DIR__."/lang/");

    //Langage par default
    define("DEFAULT_LANG", 'French');

    //Detecter si la session est deja etablie
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Recuperer tout les traductions disponibles
    $fichierList = scandir(LANG_DIR);
    $traductions = [];
    foreach($fichierList as $key=>$fichier){
        if($fichier == '.' || $fichier == '..') {
            unset($fichierList[$key]);
            continue;
        }
        $traductions[] = explode(".", $fichier)[0];
    }

    //Stocker les traduciton dans une variable global
    $GLOBALS["traductions"] = $traductions;

    //Detection du language actuel depuis la session sinon appliquer le langage par default
    if(!isset($_SESSION['lang'])) $_SESSION['lang'] = DEFAULT_LANG;
    $lang = $_SESSION['lang'];
    $fileName = LANG_DIR.$lang.".json";

    //Si le fichier de traduction n'exist pas, on prend français par defaut
    if(!file_exists($fileName)){
        $lang = DEFAULT_LANG;
    }

    //Decodage du fichier de traduction
    $traductionMap = json_decode(file_get_contents(LANG_DIR.$lang.".json"), true);

    //La fonction qui va s'occuper a traduire le text, il l'appeler toujours si on veux afficher un text pour qu'il soit traduit
    function t($text){
        global $traductionMap;
        return $traductionMap[$text] ?? $text;
    }