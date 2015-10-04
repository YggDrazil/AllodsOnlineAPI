<?php

require_once( '../hessian/HessianClient.php' );
require_once( './accountApi.inc.php' );

class CollectionEditionInfo {
  public $resourceId;
  public $info;
}

class CollectionEditionList extends ExecuteResult {
  public $editions;
}

class EditionOfAccountList extends ExecuteResult {
  public $editionResourceIds;
}

function registerEditionMethods($fullPath) {
  Hessian::remoteMethod($fullPath, 'getCollectionEditions');
  Hessian::remoteMethod($fullPath, 'addEdition');
  Hessian::remoteMethod($fullPath, 'removeEdition');
  Hessian::remoteMethod($fullPath, 'getEditionsOfAccount');
  Hessian::remoteMethod($fullPath, 'addEditionToAccount');
  Hessian::remoteMethod($fullPath, 'removeEditionFromAccount');
}

Hessian::mapRemoteType('api.collectionEditions.CollectionEditionInfo', 'CollectionEditionInfo');
Hessian::mapRemoteType('api.collectionEditions.CollectionEditionList', 'CollectionEditionList');
Hessian::mapRemoteType('api.collectionEditions.EditionOfAccountList',  'EditionOfAccountList');

?>