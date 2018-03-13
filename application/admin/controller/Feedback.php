<?php

namespace app\admin\controller;


class Feedback extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \FeedbackDB();
    }

    public function create()
    {
        $type = input('type');
        $description = input('description');
        $suggest = input('suggest');

        if (empty($type) || empty($description) || empty($suggest)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'type' => $type,
            'description' => $description,
            'suggest' => $suggest,
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
        $where = [];

        $data = $this->mod->get($where, $start, $ps);
        $count = $this->mod->count($where);
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok(['list' => $list, 'count' => $count]));
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