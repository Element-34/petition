<?php
namespace Petition;

require_once 'tailored/WhiteHouseTestCase.php';
require_once 'pages/HomePage.php';
require_once 'providers/AccountProvider.php';

class AuthenticationTest extends WhiteHouseTestCase {
    /**
    * @test
    * @group shallow
    * @group authentication
    */
    public function happy_login() {
        $home = new HomePage($this->session);
        $home->open();
        $home->wait_until_loaded();
        
        $login = $home->go_to_login();
        
        $csv = new AccountProvider("accounts.csv");
        $row = $csv->random_user();
        
        $home = $login->login_as($row["email"], $row["password"]);
        $this->assertTrue($home->is_logged_in());
    }

}
?>