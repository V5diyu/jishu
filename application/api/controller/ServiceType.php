<?php

namespace app\api\controller;


class ServiceType extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \ServiceTypeDB();
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
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok($list));
    }
}