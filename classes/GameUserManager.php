<?php
/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 6:57 PM
 */
namespace accountApi;
require_once 'AccountProxyProducer.php';
require_once 'AbstractGameManager.php';

/**
 * Class GameUserManager
 */
class GameUserManager extends \AbstractGameManager
{

    /**
     * GameUserManager constructor.
     */
    public function __construct()
    {
        //Creating proxy
        $this->proxy = AccountProxyProducer::create();
    }

    /**
     * Create user
     * @param string $login
     * @param $email
     * @param string $password
     * @return bool
     */
    public function createUser($login, $email, $password)
    {
        $result = $this->proxy->createAccountEx($login, $password, AccessLevel::User(), AccountStatus::Active(), $email, null);
        return $result->isOk();
    }

    /**
     * Change user password
     * @param string $login
     * @param string $new_password
     * @return bool
     */
    public function changePassword($login, $new_password)
    {
        $result = $this->proxy->changePassword($login, $new_password);
        return $result->isOk();
    }

}