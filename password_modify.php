<?php
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

if(is_null($_POST['old_password']) && is_null($_POST['password']) && is_null($_POST['confirm_password']) ) {
    header('Location: user_profil.php?error=error_task');
    exit;
} else {
    if ($_POST['password'] == $_POST['confirm_password'] && $_SESSION['pass'] == hash("sha256", $_POST['old_password'])) {
        $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/upt_pass_user?iduser=" . $_SESSION['nmuser'] . "&pass=" . hash("sha256", $_POST['password']), false, $context);
    }
}
$_SESSION['pass'] = hash("sha256", $_POST['password']);
header('Location: user_profil.php?error=update_success');
exit;

?>