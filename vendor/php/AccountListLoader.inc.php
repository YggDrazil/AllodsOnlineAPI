<?php

class DBException extends Exception {
}

class AccountListLoader {
  private $connString;
  private $conn;

  public function __construct($host, $port, $dbname, $user, $password) {
    $this->connString = "host='$host' port='$port' dbname='$dbname' user='$user' password='$password' options='--client_encoding=UTF8'";
    $this->conn = null;
  }           

  public function connect() {
    $this->conn = pg_connect($this->connString);
    if ($this->conn === FALSE) {      
      throw new DBException("Failed to connect to $this->connString");
    }
    if (pg_set_client_encoding($this->conn, "UTF-8") != 0) {
      throw new DBException("Failed to set UTF-8 client encoding: " . pg_last_error($this->conn));   
    }
  }

  public function disconnect() {
    pg_close($this->conn);
  }

  public function loadAccounts($fromGmTime, $days) {
    $tillExclusive = strtotime("+$days day", $fromGmTime);

    $from = date("Y-m-d", $fromGmTime);
    $till = date("Y-m-d", $tillExclusive);

    $sql = 
      "Select
      account
      from (Select
        avatar.\"login\" as account,
        cast (\"openTimestamp\" as date) as login_date
        from \"statistics\".v_session_avatar session
        join \"statistics\".v_avatar avatar on session.avatar = avatar.id
        where \"openTimestamp\" >= '$from' and \"openTimestamp\" < '$till'
          and \"closeTimestamp\" >= '$from' and \"closeTimestamp\" < '$till'
          and avatar.\"isDeleted\" = false
        group by 1, 2) logins
      group by 1
      having count (login_date) = $days";

    $result = pg_query($this->conn, $sql);
    if (!$result) {
      throw new DBException("Failed to query accounts: " + pg_last_error($this->conn));
    }
  
    $accounts = array();

    while ($row = pg_fetch_assoc($result)) {
      $accounts[] = $row['account'];
    }

    return $accounts;
  }

  public function loadAvatars($accounts) {
    $avatars = array();

    $accountParts = array_chunk($accounts, 10);
    foreach ($accountParts as $accountPart) {

      $logins = $this->makeLoginQuery($accountPart);

      $sql = 
        "select \"avatarId\", \"title\", \"race\", \"class\", \"shardName\", level from \"statistics\".v_avatar where $logins and \"isDeleted\" = false";

      $result = pg_query($this->conn, $sql);
      if (!$result) {
        throw new DBException("Failed to query avatars: " + pg_last_error($this->conn));
      }    

      while ($row = pg_fetch_assoc($result)) {
        $avatar = array();
        $avatar['id'] = $row['avatarId'];
        $avatar['title'] = $row['title'];
        $avatar['race'] = $row['race'];
        $avatar['class'] = $row['class'];
        $avatar['shard'] = $row['shardName'];
        $avatar['level'] = intval($row['level']);
        $avatars[] = $avatar;
      }
    }

    return $avatars;
  }

  public function loadAvatarsWithMaxLevel($accounts) {
    $avatars = array(); // we will map account to avatar

    $accountParts = array_chunk($accounts, 10);
    foreach ($accountParts as $accountPart) {

      $logins = $this->makeLoginLikeQuery($accountPart);

      $sql = 
        "select \"avatarId\", \"title\", \"race\", \"class\", \"shardName\", level, login from \"statistics\".v_avatar where $logins and \"isDeleted\" = false";

      $result = pg_query($this->conn, $sql);
      if (!$result) {
        throw new DBException("Failed to query avatars: " + pg_last_error($this->conn));
      }    

      while ($row = pg_fetch_assoc($result)) {
        $avatar = array();
        $avatar['id'] = $row['avatarId'];
        $avatar['title'] = $row['title'];
        $avatar['race'] = $row['race'];
        $avatar['class'] = $row['class'];
        $avatar['shard'] = $row['shardName'];
        $avatar['level'] = intval($row['level']);

        $account = $row['login'];

        $old = @$avatars[$account];

        if (isset($old)) {
          if ($old['level'] < $avatar['level']) {
            $avatars[$account] = $avatar;
          }
        } else {
          $avatars[$account] = $avatar;
        }
      }
    }

    return $avatars;
  }

  private function makeLoginQuery($accounts) {
    $q = "(";
    foreach ($accounts as $account) {
      if ($q != "(") {
        $q .= " OR ";
      }
      $q .= "login = '$account'";
    }
    $q .= ")";
    if ($q == "()") {
      $q = "(1 = 0)";
    }
    return $q;
  }

  private function makeLoginLikeQuery($accounts) {
    $q = "(";
    foreach ($accounts as $account) {
      $uppercased = strtoupper($account);
      if ($q != "(") {
        $q .= " OR ";
      }
      $q .= "upper(login) = '$uppercased'";
    }
    $q .= ")";
    if ($q == "()") {
      $q = "(1 = 0)";
    }
    return $q;
  }
};


?>