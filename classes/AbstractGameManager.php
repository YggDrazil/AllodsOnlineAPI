<?php

/**
 * Created by PhpStorm.
 * User: Allods Unity
 * Date: 9/20/15
 * Time: 10:31 PM
 */

/**
 * Class AbstractGameManager
 */
abstract class AbstractGameManager
{
    protected  $proxy;

    /**
     * @return mixed
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param mixed $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

}