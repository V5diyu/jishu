<?php

namespace app\admin\controller;


class Approve extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \ApproveDB();
    }

    public function create()
    {
        $approve = input('approve');
        $name = input('name');

        if (empty($approve) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'approve' => $approve,
            'name' => $name,
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;

        $data = $this->mod->get([], $start, $ps);
        $count = $this->mod->count([]);
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function update()
    {
        $id = input('id');
        $approve = input('approve');
        $name = input('name');

        if (empty($id) || empty($approve) || empty($name)) {
            return json(error('缺少必要参数'));
        }

        $setData = [
            'approve' => $approve,
            'name' => $name,
        ];
        $this->mod->update($setData, $id);
        return json(ok());
    }
}