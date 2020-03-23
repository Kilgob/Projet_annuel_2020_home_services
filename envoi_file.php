<?php 
  include_once("./lang.php");
?>
<form method="post" action="verif_file.php" enctype="multipart/form-data">
  <input type="file" placeholder="<?= t("envoyer un fichier(8Mo max)")?>" name="fichier" />
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input class="btn btn-secondary" type="submit" name="submit" value="<?= t("Envoyer")?>" />
</form>
