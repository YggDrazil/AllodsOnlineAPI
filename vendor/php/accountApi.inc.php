<?php
namespace accountApi;
require_once(PHOME. '/vendor/hessian/HessianClient.php' );
class APIResult {
  public $name;

  public function isSucceeded() {
    return $this->name == "SUCCESS";
  }

  public function toString() {
    return $this->name;
  }
}

class AccessLevel {
  public $name;

  public function __construct($value = 'User') {
    $this->name = $value;
  }

  public static function User() {
    return new AccessLevel('User');
  }

  public static function Master() {
    return new AccessLevel('Master');
  }

  public static function Developer() {
    return new AccessLevel('Developer');
  }

}

class AccountStatus {
  public $name;

  public function __construct($value = 'Inactive') {
    $this->name = $value;
  }

  public static function Inactive() {
    return new AccountStatus('Inactive');
  }

  public static function Active() {
    return new AccountStatus('Active');
  }

  public function equals($status) {
    return $this->name == $status->name;
  }
}

class ExecuteResult {
  public $reason;
  public $status; // type = APIResult

  public function isOk() {
    return $this->status->isSucceeded();
  }

  public function toString() {
    return $this->status->toString() . ": " . $this->reason;
  }
}

class AccountStatusResult extends ExecuteResult {
  public $accountStatus;

  public function getAccountStatus() {
    return $this->accountStatus;
  }
}

function registerAccountMethods($fullPath) {
  \Hessian::remoteMethod($fullPath, 'createAccountWithAccessLevel');
  \Hessian::remoteMethod($fullPath, 'createAccountEx');
  \Hessian::remoteMethod($fullPath, 'getAccountStatus');
  \Hessian::remoteMethod($fullPath, 'setAccountStatus');
  \Hessian::remoteMethod($fullPath, 'createAccountEx3');
  \Hessian::remoteMethod($fullPath, 'addSubscriptionTime');
  \Hessian::remoteMethod($fullPath, 'addSubscriptionTimeToAll');
  // TODO: register other methods
}

class UserRole {
  public $name;

  public function __construct($value = 'User') {
    $this->name = $value;
  }

  public static function User() {
    return new UserRole('User');
  }

  public static function Tester() {
    return new UserRole('Tester');
  }

  public static function Master() {
    return new UserRole('Master');
  }

  public static function Developer() {
    return new UserRole('Developer');
  }

  public static function Statistic() {
    return new UserRole('Statistic');
  }

  public static function SuperUser() {
    return new UserRole('SuperUser');
  }
}

\Hessian::mapRemoteType('api.APIResult', '\accountApi\APIResult');
\Hessian::mapRemoteType('api.ExecuteResult', '\accountApi\ExecuteResult');
\Hessian::mapRemoteType('replicationAnnotations.AccessLevel', '\accountApi\AccessLevel');
\Hessian::mapRemoteType('api.account.AccountStatus', '\accountApi\AccountStatus');
\Hessian::mapRemoteType('api.account.AccountStatusResult', '\accountApi\AccountStatusResult');
\Hessian::mapRemoteType('replicationAnnotations.UserRole', '\accountApi\UserRole');

?>
