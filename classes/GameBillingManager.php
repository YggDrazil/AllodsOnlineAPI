<?php

/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 10:30 PM
 */
namespace billingApi;
require_once 'BillingProxyProducer.php';
require_once 'AbstractGameManager.php';

class GameBillingManager extends \AbstractGameManager
{

    /**
     * GameBillingManager constructor.
     */
    public function __construct()
    {
        $this->proxy = BillingProxyProducer::create();
    }

    /**
     * @param $login
     * @param $sum
     * @return bool
     */
    public function addMoney($login, $sum)
    {
        $result = $this->proxy->addMoneyWithCurrency($login, CurrencyValue::valueOf(ItemMallCurrency::MAIN(), $sum), 3, time());

        if ($result->status['name'] === 'Ok') {
            return true;
        } else {
            throw new \BadFunctionCallException("I don't know, what the fuck!");
        }
    }

    public function getAccount($login)
    {
        $result = $this->proxy->getAccount($login);
        if ($result->status['name'] === 'Ok') {
            return $result;
        } else {
            throw new \BadFunctionCallException("This is real shit!");
        }
    }

    public function getAccountMoney($login, $type)
    {
        $currency = $type;
        $result = 0;
        $accountInfo = $this->getAccount($login);
        if (!empty($accountInfo->account) && $accountInfo->account === $login) {
            $r = array_filter($accountInfo->moneys, function ($val) use ($currency) {
                return ($val->currency->name === $currency);
            });
            //OMG
            $r = reset($r);

            if ($r && !empty($r->value) && $r->value > 0) {
                $result = $r->value;
            }
        }
        return $result;
    }
}