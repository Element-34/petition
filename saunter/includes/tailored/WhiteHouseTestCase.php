<?php
namespace Petition;

require_once 'SaunterPHP/Framework/TestCase/WebDriver.php';

class WhiteHouseTestCase extends \WebDriver\SaunterPHP_Framework_SaunterTestCase {
    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();        
    }
}

?>