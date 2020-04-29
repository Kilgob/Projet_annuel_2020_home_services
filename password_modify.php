<?php
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

if($_POST['old_password'] == NULL && $_POST['password'] == NULL && $_POST['confirm_password'] == NULL ) {
    header('Location: user_profil.php?error=empty');
    exit;
} else {
    if ($_POST['password'] == $_POST['confirm_password'] && $_SESSION['pass'] == hash("sha256", $_POST['old_password'])) {
        $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/upt_pass_user?iduser=" . $_SESSION['nmuser'] . "&pass=" . hash("sha256", $_POST['password']), false, $context);

        $_SESSION['pass'] = hash("sha256", $_POST['password']);
        header('Location: user_profil.php?msg=password_modify_succes');
    } else {
        $_SESSION['pass'] = hash("sha256", $_POST['password']);
        header('Location: user_profil.php?error=password_dont_correspond');
    }

}

exit;

?>