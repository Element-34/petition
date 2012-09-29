<?php
namespace Petition;

require_once 'SaunterPHP/Framework/PO/WebDriver/Page.php';
require_once 'PHPWebDriver/WebDriverWait.php';
require_once 'PHPWebDriver/WebDriverBy.php';

class RegistrationPage extends \WebDriver\SaunterPHP_Framework_PO_WebDriver_Page {
  private $locators = array(
    "email_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-mail'),
    "firstname_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-profile-main-field-first-name-und-0-value'),
    "lastname_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-profile-main-field-last-name-und-0-value'),
    "zip_field" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-profile-main-field-zip-und-0-value'),
    "create_account_button" => array(\PHPWebDriver_WebDriverBy::ID, 'edit-submit'),
  );

  function __construct($session) {
    parent::__construct($session);
  }
  
  function __get($property) {
    switch($property) {
      default:
        return $this->$property;
    }
  }

  function __set($property, $value) {
    switch($property) {
      case "email_field":
      case "firstname_field":
      case "lastname_field":
      case "zip_field":
        if (! is_null($value)) {
          list($type, $string) = $this->locators[$property];
          $e = self::$session->element($type, $string);
          $e->sendKeys($value);
        }
        break;
      default:
        $this->$property = $value;
    }
  }

  function open() {
    self::$session->open($GLOBALS['settings']['webserver'] . '/user/register?destination=');
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
    // check for the captcha
    return $this;
  }
  
  function register($options, $success=true) {
    $this->email_field = (array_key_exists('email', $options)) ? $options['email'] : null;
    $this->firstname_field = (array_key_exists('firstname', $options)) ? $options['firstname'] : null;
    $this->lastname_field = (array_key_exists('lastname', $options)) ? $options['lastname'] : null;
    $this->zip_field = (array_key_exists('zip', $options)) ? $options['zip'] : null;
    list($type, $string) = $this->locators['create_account_button'];
    $e = self::$session->element($type, $string);
    $e->click();
    if ($success) {
        $h = new HomePage(self::$session);
        $h->wait_for_thanks();
        return $h;
    } else {
        return $this;
    }
  }
}
?>