<?php

namespace Ciaompe\Helpers;

use RedBeanPHP\R;

/**
* Database helper
*/

class Database
{
    private $_results = [];
    private $_count = 0;
    private $_insertid = 0;

    public function __construct($config)
    {
        if ($config->get('db.type') == 'mysql') {
            R::setup(
                'mysql:host='.$config->get('db.host').';dbname='.$config->get('db.database'),
                $config->get('db.username'),
                $config->get('db.password')
            );
        }
        if ($config->get('db.type') == 'sqlite') {
            R::setup('sqlite:'.$config->get('db.file'));
        }
    }

    //insert
    public function insert($table, $data)
    {
        $object = R::dispense($table);
        $object->import($data);
        $this->_insertid = R::store($object);
        return $this;
    }

    //update direct obj
    public function updateObj($obj)
    {
        R::store($obj);
    }

    //get
    public function get($table, $method = '', $data = array())
    {
        $this->_results = R::find($table, $method, $data);
        $this->_count = R::count($table, $method, $data);
        return $this;
    }
    
    //Custom get row by Primary Key
    public function getByid($table, $id)
    {
        $this->_results = R::load($table, $id);
        $this->_count = R::count($table, 'id = ?', [$id]);
        return $this;
    }

    //get all
    public function getAll($table, $method = '', $data = array())
    {
        $this->_results = R::findAll($table, $method, $data);
        $this->_count = R::count($table);
        return $this;
    }

    //update
    public function update($table, $id, $data)
    {
        $object = R::load($table, $id);
        $object->import($data);
        R::store($object);

        return $this;
    }

    //delete
    public function delete($table, $id)
    {
        $object = R::load($table, $id);
        R::trash($object);

        return $this;
    }

    public function deleteAll($table, $method, $data)
    {
        $object = R::find($table, $method, $data);
        R::trashAll($object);

        return $this;
    }

    //custom SQl With Bind Params
    public function custom($sql, $bindings = array())
    {
        return R::getAll($sql, $bindings);
    }

    //get batch rows
    public function batch($table, array $ids)
    {
        return R::batch($table, $ids);
    }

    //get row Count by Table name
    public function rowCount($table)
    {
        $this->_count = R::count($table);
        return $this;
    }

    //accessing data
    public function results()
    {
        if ($this->_count == 0) {
            return null;
        }
        return $this->_results;
    }

    public function first()
    {
        if ($this->_count == 0) {
            return null;
        }
        return (object)R::exportAll($this->_results)[0];
    }

    //convert readbean obj to stdClass
    public function convert($obj)
    {
        return (object)R::exportAll($obj)[0];
    }

    public function toArray()
    {
        if ($this->_count == 0) {
            return null;
        }

        return R::exportAll($this->_results, true);
    }

    //accessing row count
    public function count()
    {
        return $this->_count;
    }

    //last insert id
    public function lastInsertid()
    {
        return $this->_insertid;
    }

}
