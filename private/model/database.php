<?php
function connect() {
    $dns = 'mysql:dbname=SocialPost;host=localhost';
    try {
        $dbh = new PDO($dns, "root", "root");
    } catch (PDOException $e) {
        $error = 'Connection failed: '.$e->getMessage();
        print $error;
        exit();
    }
    return $dbh;
}

function login($email,$password) {
    $dbh = connect();
    $s = $dbh->prepare('SELECT * FROM users WHERE email=:email');
    $s->bindValue(':email',$email,PDO::PARAM_STR);
    $s->execute();
    $results = $s->fetchAll();
    if (count($results) == 1) {
        if ($results[0][1] == $email && $results[0][2] == $password) {
        $dbh = null;
            return $results[0];
        }
    }
    $dbh = null;
    return null;
}
?>
