<?php
/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 10/4/15
 * Time: 7:20 PM
 */
//Account server API host
define('ACCOUNT_API_SERVER', '127.0.0.1');
//Account server API port
define('ACCOUNT_API_PORT', 9080);

//Billing server API host
define('BILLING_API_SERVER', '127.0.0.1');
//Billing server API port
define('BILLING_API_PORT', 7090);

//Get home folder
define('HOME', dirname(__FILE__));

//Require account API manager
require_once(HOME . '/classes/GameUserManager.php');

//Require billing API manager
require_once(HOME . '/classes/GameBillingManager.php');

//Initialization (Here we need to init managers)
//Account API manager
$gameUserManager = new \accountApi\GameUserManager();
//Billing API manager
$gameBillingManager = new \billingApi\GameBillingManager();

//Example 1. Create user | Account Server API
$login = "vasya1";
$pass = "vasya1";
$email = "vasya1@mail.ru";
if ($gameUserManager->createUser($login, $email, $pass)) {
    echo "User created. \n";
}

//Example 2. Change users password | Account Server API
$login = "vasya1";
$new_pass = "vasya2";
if ($gameUserManager->changePassword($login, $new_pass)) {
    echo "Password change: Operation success\n";
}

//Example 3. Get account info | Billing Server API
$login = "vasya1";
var_dump($gameBillingManager->getAccount($login));

//Example 4. Get account money (with currency) | Billing Server API
$login = "vasya1";
/*
 * May be 'MAIN', 'HAPPY', etc.
 */
$curr = "MAIN";
$acc_money = $gameBillingManager->getAccountMoney($login, $curr);
echo "Money:" . $acc_money . "\n";

//Example 5. Add money to account (currently is only MAIN currency) | Billing Server API
$login = "vasya1";
$money = 1000000000000;
if ($gameBillingManager->addMoney($login, $money)) {
    echo "Add money: Operation success";
}



