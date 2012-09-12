<?php
namespace Petition;

require_once 'SaunterPHP/Framework/Exception.php';
require_once 'SaunterPHP/Framework/Providers/CSV.php';

class AccountProvider extends \SaunterPHP_Framework_Providers_CSV {
  function random_user() {
    $user = array();
    foreach ($this->data as $row) {
      array_push($user, $row);
    }
    if (count($user) == 0) {
      throw new Exception('No user records were found');
    }
    $shuffled = $this->shuffle_assoc($user);
    return $shuffled[array_rand($shuffled)];
  }
  
}