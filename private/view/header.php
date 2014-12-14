<!DOCTYPE html>
<html>
    <head>
        <?php if (isset($style)) {echo "<link rel='stylesheet' type='text/css' href='../private/view/".$style."'>";}?>
        <?php if (isset($javascript)) {echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqztzPBx7b8KdCxTBCLXlXgl1IVrbq3zM&sensor=false"></script>';
            foreach ($javascript as $filename) {
                echo '<script type="text/javascript" src="'.$filename.'"></script>';
            }
        }?>
        <title><?php if (isset($title)) {echo $title;}?></title>
    </head>
    <body>
