<?php

class ApproveDB
{

    private $con;

    public function __construct()
    {
        $this->con = mdb()->approve;
    }

    public function add($insertData)
    {
        $id        = uniqueID();
        $insertData = array_merge(['id' => $id], $insertData);
        $this->con->insert($insertData);
        return $id;
    }

    public function get($where = [], $skip = 0, $limit = 0, $sort = ['_id' => -1], $fields = ['_id' => false])
    {
        if ($limit == 0) {
            return $this->con->find($where)->fields($fields)->sort($sort);
        }
        return $this->con->find($where)->fields($fields)->sort($sort)->skip($skip)->limit($limit);
    }

    public function getAll($where = [], $sort = ['_id' => -1], $fields = ['_id' => false])
    {
        return $this->con->find($where)->fields($fields)->sort($sort);
    }

    public function count($where = [])
    {
        return $this->con->count($where);
    }

    public function getInfo($where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        return $this->con->findOne($where);
    }

    public function update($setData, $where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        $this->con->update($where, ['$set' => $setData]);
    }

    public function updateInc($setData, $where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        $this->con->update($where, ['$inc' => $setData]);
    }

    public function delete($where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        $this->con->remove($where);
    }
}