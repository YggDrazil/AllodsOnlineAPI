<?php

/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 10:46 PM
 */

interface IProxyProducer
{
    /**
     * Creates proxy instance
     * @return mixed
     */
    static function create();
}