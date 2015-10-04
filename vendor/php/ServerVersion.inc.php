<?php

require_once( PHOME.'/vendor/hessian/HessianClient.php' );


/**
 * Helps to check what versions of api provided by server.
 */
class ServerVersion {
  private $fullUrl;
  private $options;

  public function __construct($url, $api, $options = false) {
    $this->fullUrl = $url . "/" . $api . "Version";
    $this->options = $options;
    Hessian::remoteMethod($this->fullUrl, 'getSupportedVersions');
    Hessian::remoteMethod($this->fullUrl, 'getVersionInfo');
  }

  public function getVersionPath($version) {
    $proxy = new HessianClient($this->fullUrl, $this->options); 

    $verInfo = $proxy->getVersionInfo((int)$version);

    if (is_array($verInfo)) {
      return $verInfo['path'];
    } else {
      return null;
    }
    
    unset($proxy);
  }

  public function getSupportedVersions() {
    $proxy = new HessianClient($this->fullUrl); 
    $versions = $proxy->getSupportedVersions();
    unset($proxy);

    return $versions;
  }
}

?>
