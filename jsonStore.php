<?php
class jsonStore {
    private $path, $data, $nextId;
    function __construct($path) {
        $this->path = $path . '.json';
        if(!file_exists($this->path)) {
            file_put_contents($this->path, '[]');
            $this->data = array();
        }
        else {
            $this->data = $this->load();
        }
        $this->nextId = count($this->data) === 0 ?
            1 : $this->data[count($this->data) - 1]['id'] + 1;
    }

    function select(array $whereEquals = array()) {
        $results = array();
        foreach($this->data as $row) {
            $results[] = $row;
            foreach($whereEquals as $column => $value) {
                if(!array_key_exists($column, $row) || $row[$column] != $value) {
                    array_pop($results);
                    break;
                }
            }
        }
        return $results;
    }

    function insert(array $row = array()) {
        if(!array_key_exists('id', $row)) {
            $row['id'] = $this->nextId;
            $this->nextId += 1;
        }
        if(count($this->select(array('id' => $row['id']))) > 0) {
            throw new Exception("id " . $row['id'] . " allready exists");
        }
        else {
            $this->data[] = $row;
        }
        $this->save($this->data);
        return $row['id'];
    }

    function update(array $row = array(), array $whereEquals = array()) {

    }

    function delete(array $whereEquals = array()) {

    }

    private function load() {
        return json_decode(file_get_contents($this->path), true);
    }

    private function save(array $data = array()) {
        file_put_contents($this->path, json_encode($data));
    }
}
?>
