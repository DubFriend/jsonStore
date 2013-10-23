<?php
require_once 'jsonStore.php';
class jsonStore_Test extends PHPUnit_Framework_TestCase {
    function tearDown() {
        if(file_exists('test.json')) {
            unlink('test.json');
        }
    }

    private function row1() {
        return array('id' => 1, 'col' => 'a');
    }

    private function row2() {
        return array('id' => 2, 'col' => 'b');
    }

    private function createDefaultFile() {
        file_put_contents('test.json', json_encode(array(
            $this->row1(),
            $this->row2()
        )));
    }

    function testCreatesNewFileIfNotExist() {
        new jsonStore('test');
        $this->assertTrue(file_exists('test.json'));
        $this->assertEquals(file_get_contents('test.json'), '[]');
    }

    function testSelect() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $this->assertEquals($json->select(), array($this->row1(), $this->row2()));
        $this->assertEquals($json->select(array('id' => 2)), array($this->row2()));
    }

    function testInsert() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $this->assertEquals($json->insert(array('foo' => 'bar')), 3, 'returns insert id');
        $this->assertEquals(json_decode(file_get_contents('test.json'), true), array(
            $this->row1(), $this->row2(), array('id' => 3, 'foo' => 'bar')
        ), 'saves row to file');
    }

}
?>