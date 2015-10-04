<?php

/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 7:17 PM
 */
namespace accountApi;
require_once(HOME . '/vendor/hessian/HessianClient.php');
require_once(HOME . '/vendor/php/accountApi.inc.php');
require_once(HOME . '/vendor/php/ServerVersion.inc.php');
require_once('IProxyProducer.php');

/**
 * Class AccountProxyProducer
 *
 * Produces HessianProxy instances for AccountServer API
 */
class AccountProxyProducer implements \IProxyProducer
{

    public static function create()
    {
        $url = 'http://' . ACCOUNT_API_SERVER . ':' . ACCOUNT_API_PORT;
        $version = 8;
        $serverVer = new \ServerVersion($url, 'AccountAPI');
        $path = $serverVer->getVersionPath($version);
        if (is_null($path)) {
            throw new \BadFunctionCallException("api version $version not supported");
        }
        $proxy = new \HessianClient($url . $path);
        registerAccountMethods($url . $path);
        return $proxy;
    }
}