<?php
namespace Petition;

require_once 'tailored/WhiteHouseTestCase.php';
require_once 'pages/HomePage.php';
require_once 'providers/AccountProvider.php';

class RegistrationTest extends WhiteHouseTestCase {
    /**
    * @test
    * @group shallow
    * @group authentication
    * @group registration
    */
    public function happy_registration() {
        $home = new HomePage($this->session);
        $home->open();
        $home->wait_until_loaded();
        
        $registration = $home->go_to_registration();
        $options = array(
          "email" => "frog4@chicken.org",
          "firstname" => "frog",
          "lastname" => "chicken",
          "zip" => "90210",
          "email updates" => FALSE
        );
        $home = $registration->register($options);
        $this->assertEquals("IMPORTANT: You have not finished creating your account. You will receive an email from us within a few minutes. You must click on the link in that email to continue.", $home->registration_thanks);
    }
}
?>