<?php

  class VerificationAbonnement {
    private int $idAbonnement;
    private int $iduser;
    private float $price;

    function __construct(int $idAbonnement, int $iduser) {
      $this->idAbonnement = $idAbonnement;
      $this->iduser = $iduser;
    }

    public function checkEndDate():bool {
      $context = stream_context_create(array(
          'http' => array(
              'method' => "GET",
              'header'  => "Authorization: Basic " . base64_encode("user:pass"))
      ));

      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement?idabo=" . $this->idAbonnement, false, $context);
      $dateFinAbonnement = json_decode($json, true);

      if (strtotime($dateFinAbonnement['data'][0]['dtfin']) < time()) {
        return true;
      }
      else {
        return false;
      }
    }


    //Passer le statut de l'abonnement à 2 (en attente de paiement)
    public function updateStatut():void {
      $context = stream_context_create(array(
          'http' => array(
              'method' => "PUT",
              'header'  => "Authorization: Basic " . base64_encode("user:pass"))
      ));

      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement_facture?idabo=" . $this->idAbonnement . "&statut=2", false, $context);
    }

    public function calculPrix():void {
      $context = stream_context_create(array(
          'http' => array(
              'method' => "GET",
              'header'  => "Authorization: Basic " . base64_encode("user:pass"))
      ));

      //Récuperation des dates de début et de fin de l'abonnement de l'utilisateur
      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement?idabo=" . $this->idAbonnement, false, $context);
      $informations_tabAbonnement = json_decode($json, true);

      //Récupération des informations de toutes les interventions effectuées pendant la durée de l'abonnement
      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/interventions_between_date?iduser=" . $this->iduser . "&dtdebut=" . strftime("%Y-%m-%d", strtotime($informations_tabAbonnement['data'][0]['dtdebut'])) . "&dtfin=" . strftime("%Y-%m-%d", strtotime($informations_tabAbonnement['data'][0]['dtfin'])), false, $context);
      $interventions = json_decode($json, true);

      //Récupération de l'abonnement correspondant dans la table siège
      $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $informations_tabAbonnement['data'][0]['idabonnement'], false, $context);
      $abonnement_siege = json_decode($json, true);

      //Calcul des prix totaux des interventions (pour ajouter d'éventuels surplus)
      if ($interventions != []) {
        foreach ($interventions['data'] as $intervention) {
          $this->price += $intervention['montantpresta'] + $intervention['montantsurplus'];
        }
      }

      //Ajout du prix de l'abonnement
      $this->price += $abonnement_siege['data'][0]['prix'];
    }

    public function generateFacture():void {
      $context = stream_context_create(array(
          'http' => array(
              'method' => "GET",
              'header'  => "Authorization: Basic " . base64_encode("user:pass"))
      ));

      //Récupération des informations personnelles de l'utilisateur
      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $this->iduser, false, $context);
      $user_infos = json_decode($json, true);

      //Récuperation des dates de début et de fin de l'abonnement de l'utilisateur
      $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement?idabo=" . $this->idAbonnement, false, $context);
      $informations_tabAbonnement = json_decode($json, true);

      //Récupération de l'abonnement correspondant dans la table siège
      $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $informations_tabAbonnement['data'][0]['idabonnement'], false, $context);
      $abonnement_siege = json_decode($json, true);


      $context = stream_context_create(array(
          'http' => array(
              'method' => "POST",
              'header'  => "Authorization: Basic " . base64_encode("user:pass"))
      ));

      $request = str_replace(' ', '%20', "http://" . $_SESSION['ip_agence'] . "/abonnement_facture?iduser=" . $this->iduser . "&price=" . $this->price . "&cdtype=abo&lb=Abo " . $user_infos['data'][0]['nom'] . " " . $abonnement_siege['data'][0]['lb']);
      $json = file_get_contents($request, false, $context);
    }
  }

?>
