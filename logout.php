<?php
require __DIR__ . '/vendor/autoload.php';
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

//destroy the session & redirect users to login.php
$session = new Session();
$session->start();
$session->clear();

$response = new RedirectResponse('login.php');
return $response->send();

?>