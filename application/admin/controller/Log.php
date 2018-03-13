<?php

namespace app\admin\controller;

class Log extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \LogDB();
    }

    public function get()
    {
        $company = input('company');
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($company)) {
            $where['company'] = ['$regex' => $company, '$options' => 'i'];
        }

        $count = $this->mod->count($where);
        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d', $item['create']);
            $list[] = $item;
        }
        return json(ok(['list'=>$list, 'count'=>$count]));
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