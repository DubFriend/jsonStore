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

    private function row3() {
        return array('id' => 3, 'col' => 'b');
    }

    private function createDefaultFile() {
        file_put_contents('test.json', json_encode(array(
            $this->row1(),
            $this->row2(),
            $this->row3()
        )));
    }

    private function getData() {
        return json_decode(file_get_contents('test.json'), true);
    }

    function testCreatesNewFileIfNotExist() {
        new jsonStore('test');
        $this->assertTrue(file_exists('test.json'));
        $this->assertEquals(file_get_contents('test.json'), '[]');
    }

    function testSelect() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $this->assertEquals(
            $json->select(),
            array($this->row1(), $this->row2(), $this->row3())
        );
        $this->assertEquals($json->select(array('id' => 2)), array($this->row2()));
        $this->assertEquals(
            $json->select(array('col' => 'b')),
            array($this->row2(), $this->row3())
        );
        $this->assertEquals(
            $json->select(array('id' => 3, 'col' => 'b')),
            array($this->row3())
        );
    }

    function testInsert() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $insertId = $json->insert(array('foo' => 'bar'));
        $this->assertTrue($insertId != null);
        $this->assertEquals($this->getData(), array(
            $this->row1(),
            $this->row2(),
            $this->row3(),
            array('id' => $insertId, 'foo' => 'bar')
        ), 'saves row to file');
    }

    function testUpdate() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $json->update(array('col' => 'edit'), array('col' => 'b'));
        $this->assertEquals($this->getData(), array(
            $this->row1(),
            array('id' => 2, 'col' => 'edit'),
            array('id' => 3, 'col' => 'edit')
        ));
    }

    function testDelete() {
        $this->createDefaultFile();
        $json = new jsonStore('test');
        $json->delete(array('col' => 'b'));
        $this->assertEquals($this->getData(), array($this->row1()));
    }
}
?>