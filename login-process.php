<?php
//if logged in --> redirect to Dashboard
//else --> redirect to login page

//if valid credentials passed
//  store username, email, unix timestamp of logged in time
//  redirect to dashboard.php
//  display flash message "You have successfully logged in!"
//else
//  redirect to login.php with flash message "Incorrect credentials"
require_once 'db.php';


require __DIR__ . '/vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use ITP\Auth;
use Carbon\Carbon;

$request = Request::createFromGlobals();

$session = new Session();
$session->start(); // session_start()



//if valid credentials passed
$auth = new Auth($pdo);
$username = $request->request->get('username');
$valid = $auth->attempt($username, SHA1($request->request->get('password')));

echo $request;

//redirects to dashboard if a session
if($session->has('fullname')) {
    $response = new RedirectResponse('dashboard.php');
    return $response->send();
} elseif(!($request->request->has('username') && $request->request->has('password'))) {
    $response = new RedirectResponse('login.php');
    return $response->send();
}


if($valid) {

    $session->set('fullname', $auth->getUsername());
    $session->set('email', $auth->getEmail());
    $session->set('loginTime',Carbon::now());
    $session->getFlashBag()->add('valid', 'You have successfully logged in!');
    $response = new RedirectResponse('dashboard.php');
    return $response->send();
} else {
    $session->getFlashBag()->add('invalid', 'Incorrect credentials');
    $response = new RedirectResponse('login.php');
    return $response->send();
}
?>
