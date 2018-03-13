<?php

namespace app\api\controller;


class Rules extends Base
{
    private $mod;
    private $mod_classify;

    public function __construct()
    {
        $this->mod = new \RulesDB();
        $this->mod_classify = new \RulesClassifyDB();
    }


    public function get()
    {
        $data_rules = $this->mod->get();
        $list_rules = [];
        foreach ($data_rules as $item) {
            $list_rules[$item['classifyId']][] = $item;
        }

        $data_classify = $this->mod_classify->get();
        $list_classify = [];
        foreach ($data_classify as $item) {
            $list_classify[] = [
                'classifyId' => $item['id'],
                'classifyName' => $item['name'],
                'rulesList' => isset($list_rules[$item['id']]) ? $list_rules[$item['id']] : []
            ];
        }
        return json(ok($list_classify));
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