<?php

namespace app\api\controller;


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

}