<?php
function render($viewpage,$data=array()) {
    $path = '../private/view/'.$viewpage.'.php';
    if (file_exists($path)) {
        extract($data);
        require($path);
    } else {
        header('Location: index.php');
    }
}
function validLogin($email,$password) {
    if (strlen($email) < 5) {
        return false;
    } if (strlen($password) < 5) {
        return false;
    }
    return true;
}
