<?php

namespace app\admin\controller;


class Knowledge extends Base
{
    private $mod;
    private $mod_classify;

    public function __construct()
    {
        $this->mod = new \KnowledgeDB();
        $this->mod_classify = new \KnowledgeClassifyDB();
    }

    public function create()
    {
        $classifyId = input('classifyId');
        $title = input('title');
        $url = input('url');
        $content = input('content');

        if (empty($classifyId) || empty($title) || empty($url) || empty($content)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'classifyId' => $classifyId,
            'title' => $title,
            'url' => $url,
            'content' => $content,
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $title = input('title');
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($title)) {
            $where['title'] = ['$regex' => $title, '$options' => 'i'];
        }
        $data = $this->mod->get($where, $start, $ps);
        $count = $this->mod->count($where);

        $classifyList = $this->mod_classify->getAll();
        $c = [];
        foreach ($classifyList as $item) {
            $c[$item['id']] = $item['name'];
        }

        $list = [];
        foreach ($data as $item) {
            $item['classifyTxt'] = $c[$item['classifyId']];
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
        $classifyId = input('classifyId');
        $title = input('title');
        $url = input('url');
        $content = input('content');

        if (empty($id) || empty($classifyId) || empty($title)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'classifyId' => $classifyId,
            'title' => $title,
            'url' => $url,
            'content' => $content,
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