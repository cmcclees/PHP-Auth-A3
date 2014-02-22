<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .songs table, .songs td, .songs th
        {
            border:1px solid black;
            border-collapse:collapse;
            text-align:center;
        }
        table {
            width:100%;
            margin:auto;
        }
        #right_panel {
            width:20%;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
<?php

require __DIR__ . '/vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Carbon\Carbon;


require_once 'db.php';

$session = new Session();
$session->start();

if(!($session->has('fullname'))) {
    $response = new RedirectResponse('login.php');
    return $response->send();
}

    $songQuery = new ITP\Songs\SongQuery($pdo);
    $songs = $songQuery
        ->withArtist()
        ->withGenre()
        ->orderBy('title')
        ->all();
?>
<table>
    <tr>
        <td></td>
        <td>
            <h1>Dashboard</h1>
        </td>
        <td id="right_panel">
            <?php
            foreach ($session->getFlashBag()->get('valid', array()) as $message) {
                echo "<p class='flash-notice' style='color: blue;'>$message</p>";
            }
            ?>

                <b>Username:</b> <?php echo $session->get('fullname');?> <br/>
                <b>Email:</b> <?php echo $session->get('email');?> <br/>
                <b>Last Login:</b>
            <?php
             $session->get('loginTime');
             $time = $session->get('loginTime');
            $formated = $time->diffForHumans($time);
           //$time = Carbon::createFromDate($session->get('loginTime'));
            echo $time->diffForHumans();

            ?> <br/>
                <a href="logout.php">Logout</a>

        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <table class="songs">
                <th class="songs">Title</th>
                <th class="songs">Artist</th>
                <th class="songs">Genre</th>
                <th class="songs">Price</th>
                <?php foreach ($songs as $song) : ?>
                    <tr>
                        <td class="songs"> <?php echo $song->title; ?></td>
                        <td class="songs"><?php echo $song->artist_name; ?></td>
                        <td class="songs"><?php echo $song->genre; ?></td>
                        <td class="songs"> <?php echo $song->price; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
        <td></td>
    </tr>
</table>








</body>
</html>