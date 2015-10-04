<?php
namespace billingApi;
require_once(PHOME. '/vendor/hessian/HessianClient.php' );

class AccountStatus {
  public $name;

  public function __construct($name = 'Normal') {
    $this->name = $name;
  }

  public static function Normal() {
    return new AccountStatus('Normal');
  }

  public static function Locked() {
    return new AccountStatus('Locked');
  }

  public function equals($status) {
    return $this->name == $status->name;
  }

  public function toString() {
    return $this->name;
  }
}

class CurrencyValue {
  public $currency;
  public $value;
  public static function valueOf($currency, $value) {
    $res = new CurrencyValue();
    $res->currency = $currency;
    $res->value = $value;
    return $res;
  }
}

class ItemMallCurrency {
  public $name;

  public function __construct($name = 'MAIN') {
    $this->name = $name;
  }

  public static function MAIN() {
    return new ItemMallCurrency('MAIN');
  }

  public static function REFERRAL() {
    return new ItemMallCurrency('REFERRAL');
  }

  public static function HAPPY() {
    return new ItemMallCurrency('HAPPY');
  }

  public function equals($currency) {
    return $this->name == $currency->name;
  }

  public function toString() {
    return $this->name;
  }
}


class ResultStatus {
  public $name;

  public function __construct($value = 'Error') {
    $this->name = $value;
  }

  public function isOk() {
    return $this->name == 'Ok';
  }

  public function toString() {
    return $this->name;
  }
}


class Result {
  public $status; // type = ResultStatus
  public $message;

  public function isOk() {
    return $this->status->isOk();
  }

  public function toString() {
    return $this->status->toString() . ": " . $this->message;
  }
}


class AccountInfoResult extends Result {
  public $account;
  public $moneys;
  public $money;
  public $accountStatus; // type = AccountStatus
}


class AddMoneyResult extends Result {
}


class SubMoneyResult extends Result {
}


class ChangeAccountResult extends Result {
}


function registerBillingMethods($fullPath) {
  \Hessian::remoteMethod($fullPath, 'getAccount');
  \Hessian::remoteMethod($fullPath, 'addMoney');
  \Hessian::remoteMethod($fullPath, 'subMoney');
  \Hessian::remoteMethod($fullPath, 'subMoneyWithCurrency');
  \Hessian::remoteMethod($fullPath, 'setStatus');
  \Hessian::remoteMethod($fullPath, 'addMoneyWithTranType');
  \Hessian::remoteMethod($fullPath, 'addMoneyWithCurrency');
  \Hessian::remoteMethod($fullPath, 'addMoneyToAll');
  \Hessian::remoteMethod($fullPath, 'getAccountBonuses');
  \Hessian::remoteMethod($fullPath, 'createAccountBonus');
  \Hessian::remoteMethod($fullPath, 'removeAccountBonus');
}

\Hessian::mapRemoteType('billingserver.billingdb.manager.AccountStatus', '\billingApi\AccountStatus');
\Hessian::mapRemoteType('billingserver.billingserverapi.Result$Status', '\billingApi\ResultStatus');
\Hessian::mapRemoteType('billingserver.billingserverapi.Result', '\billingApi\Result');

\Hessian::mapRemoteType('billingserver.billingserverapi.AccountInfoResult',   '\billingApi\AccountInfoResult');

\Hessian::mapRemoteType('billingserver.billingserverapi.AddMoneyResult',      '\billingApi\AddMoneyResult');
\Hessian::mapRemoteType('billingserver.billingserverapi.SubMoneyResult',      '\billingApi\SubMoneyResult');
\Hessian::mapRemoteType('billingserver.billingserverapi.ChangeAccountResult', '\billingApi\ChangeAccountResult');
\Hessian::mapRemoteType('billingserver.commons.CurrencyValue', '\billingApi\CurrencyValue');
\Hessian::mapRemoteType('billingserver.commons.ItemMallCurrency', '\billingApi\ItemMallCurrency');


?>