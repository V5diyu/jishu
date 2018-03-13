<?php

namespace app\api\controller;


class KnowledgeClassify extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \KnowledgeClassifyDB();
    }

    public function create()
    {
        $name = input('name');
        $url = input('url');

        if (empty($name) || empty($url)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'name' => $name,
            'url' => $url,
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
        $list = [];
        foreach ($data as $item) {
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

    public function update()
    {
        $id = input('id');
        $name = input('name');
        $url = input('url');

        if (empty($id) || empty($name) || empty($url)) {
            return json(error('缺少必要参数'));
        }

        $setData = [
            'name' => $name,
            'url' => $url,
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