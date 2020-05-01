<?php

  $output = shell_exec('cat /home/fred/qrcode/qrcode_prestataire/qrcode' . $_GET['iduser'] . '.txt 2>&1');

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <?php echo '<pre' . $output . '</pre>'; ?>
  </body>
</html>
