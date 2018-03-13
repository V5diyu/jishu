<?php

namespace app\api\controller;


class Knowledge extends Base
{
    private $mod;
    private $mod_classify;

    public function __construct()
    {
        $this->mod = new \KnowledgeDB();
        $this->mod_classify = new \KnowledgeClassifyDB();
    }

    public function get()
    {
        $classifyId = input('classifyId');
        $title = input('title');
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($title)) {
            $where['title'] = ['$regex' => $title, '$options' => 'i'];
        }
        if (!empty($classifyId)) {
            $where['classifyId'] = $classifyId;
        }
        $data = $this->mod->get($where, $start, $ps);

        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y/m/d', $item['create']);
            $list[] = $item;
        }
        return json(ok($list));
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

}