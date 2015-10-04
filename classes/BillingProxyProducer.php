<?php
/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 10:53 PM
 */
namespace billingApi;
require_once(HOME . '/vendor/hessian/HessianClient.php');
require_once(HOME . '/vendor/php/billingApi.inc.php');
require_once(HOME . '/vendor/php/ServerVersion.inc.php');
require_once 'IProxyProducer.php';

class BillingProxyProducer implements \IProxyProducer
{

    static function create()
    {
        $url = 'http://' . BILLING_API_SERVER . ':' . BILLING_API_PORT;
        $version = 3;
        $serverVer = new \ServerVersion($url, 'BillingServerAPI');
        $path = $serverVer->getVersionPath($version);
        if (is_null($path)) {
            error_log("Supported versions are:\n");
            $versions = $serverVer->getSupportedVersions();
            error_log(implode("|", $versions));
        }
        if (is_null($path)) {
            throw new \BadFunctionCallException("api version $version not supported");
        }
        $proxy = new \HessianClient($url . $path);
        registerBillingMethods($url . $path);
        return $proxy;
    }
}