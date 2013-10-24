#jsonStore
##Simple database like functionality on a json file.

###Create a jsonStore object
```php
$json = new jsonStore('filepath');
```
Do not include the '.json' in your filepath, for example 'folder/data.json' is just 'folder/data'.

If a file at that path allready exists, jsonStore will load the data.  Otherwise it will create a new empty json file.

###Select
####array select(array $whereEquals)
```php
//returns the row where the id is equal to five.
$json->select(array('id' => 5));
//returns all rows
$json->select();
```

###Insert
####insertID insert(array $row)
```php
$insertID = $json->insert(array('column' => 'value'));
```
if not given an 'id' column, jsonStore will generate one for you.  In either case, insert will throw an exception if a row with the same id allready exists.

###Update
####null update(array $updates, array $whereEquals)
```php
//changes the value of the 'col' column to 'edit'
//wherever the 'col' column equals 'foo'
$json->update(array('col' => 'edit'), array('col' => 'foo'));
```

###Delete
####null delete(array $whereEquals)
```php
$json->delete(array('id' => 7));
```
