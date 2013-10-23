<?php
require_once 'jsonStore.php';
class jsonStore_Test extends PHPUnit_Framework_TestCase {
    function tearDown() {
        if(file_exists('test.json')) {
            unlink('test.json');
        }
    }

    function testSetupNewFile() {
        new jsonStore('test');
        $this->assertTrue(file_exists('test.json'));
        $this->assertEquals(file_get_contents('test.json'), '[]');
    }

}
?>