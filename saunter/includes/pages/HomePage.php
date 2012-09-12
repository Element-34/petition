<?php
namespace Petition;

include_once 'SaunterPHP/Framework/PO/WebDriver/Page.php';
include_once 'pages/LoginPage.php';
require_once('PHPWebDriver/WebDriverWait.php');
require_once('PHPWebDriver/WebDriverBy.php');

class HomePage extends \WebDriver\SaunterPHP_Framework_PO_WebDriver_Page {
  private $locators = array(
    "login_link" => array(\PHPWebDriver_WebDriverBy::CSS_SELECTOR, '.loginout a[href="/user/login?destination="]'),
    "logout_link" => array(\PHPWebDriver_WebDriverBy::CSS_SELECTOR, '.loginout a[href="/user/logout?destination="]'),
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

  function open() {
    self::$session->open($GLOBALS['settings']['webserver']);
  }

  function wait_until_loaded() {
    $w = new \PHPWebDriver_WebDriverWait(self::$session, 30, 0.5, array("locator" => $this->locators['login_link']));
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
  
  function go_to_login() {
    list($type, $string) = $this->locators['login_link'];
    $e = self::$session->element($type, $string);
    $e->click();

    $login_page = new LoginPage(self::$session);
    $login_page->wait_until_loaded();
    return $login_page;
  }

  function is_logged_in() {
    try {
      list($type, $string) = $this->locators['logout_link'];
      $e = self::$session->element($type, $string);
      if ($e->displayed()) {
        return true;
      }
      return false;
    } catch (\PHPWebDriver_NoSuchDriverWebDriverError $e) {
      return false;
    }
    
  }
}
?>