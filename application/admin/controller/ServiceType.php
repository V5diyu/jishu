<?php

namespace app\admin\controller;


class ServiceType extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \ServiceTypeDB();
    }

    public function create()
    {
        $name = input('name');

        if (empty($name)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'name' => $name,
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $name = input('name');
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($name)) {
            $where['name'] = ['$regex' => $name, '$options' => 'i'];
        }
        $data = $this->mod->get($where, $start, $ps);
        $count = $this->mod->count($where);
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function getInfo()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod->getInfo($id);
        return json(ok($info));
    }

    public function update()
    {
        $id = input('id');
        $name = input('name');

        if (empty($id) || empty($name)) {
            return json(error('缺少必要参数'));
        }

        $setData = [
            'name' => $name,
        ];
        $this->mod->update($setData, $id);
        return json(ok());
    }

    public function delete()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $this->mod->delete($id);
        return json(ok());
    }
}