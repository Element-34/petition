<?php
namespace Petition;

require_once 'SaunterPHP/Framework/PO/WebDriver/Page.php';
require_once 'PHPWebDriver/WebDriverWait.php';
require_once 'PHPWebDriver/WebDriverBy.php';
require_once 'providers/AccountProvider.php';

class LoginPage extends \WebDriver\SaunterPHP_Framework_PO_WebDriver_Page {
  private $locators = array(
    "email_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-name'),
    "password_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-pass'),
    "log_in_button" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-submit'),
  );

  function __construct($session) {
    parent::__construct($session);
  }
  
  function __get($property) {
    switch($property) {
      case "results":
        return self::$session->getText($this->locators[$property]);
      default:
        return $this->$property;
    }
  }

  function __set($property, $value) {
    switch($property) {
      case "email_field":
      case "password_field":
        list($type, $string) = $this->locators[$property];
        $e = self::$session->element($type, $string);
        $e->sendKeys($value);
        break;
      default:
        $this->$property = $value;
    }
  }

  function open() {
    self::$session->open($GLOBALS['settings']['webserver'] . '/user/login?destination=');
    return $this;
  }

  function wait_until_loaded() {
    $w = new \PHPWebDriver_WebDriverWait(self::$session, 30, 0.5, array("locator" => $this->locators['email_field']));
    $w->until(
    function($session, $extra_arguments) {
    list($type, $string) = $extra_arguments['locator'];
    return $session->element($type, $string);
    }
    );
    return $this;
  }

  function validate() {
    return $this;
  }
  
  function login_as($username, $password, $success=true) {
    $this->email_field = $username;
    $this->password_field = $password;
    
    list($type, $string) = $this->locators['log_in_button'];
    $e = self::$session->element($type, $string);
    $e->click();
    
    if ($success) {
        $h = new HomePage(self::$session);
        $h->wait_until_loaded();
        return $h;
    } else {
        return $this;
    }
  }
}
?>