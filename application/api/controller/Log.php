<?php

namespace app\api\controller;

class Log extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \LogDB();
    }

    public function create()
    {
        $invoiceId = input('invoiceId');
        $userId = input('userId');
        $name = input('name');
        $type = input('type');
        $company = input('company');
        $description = input('description');
        $status = input('status');

        if (empty($userId) || empty($name) || empty($type) || empty($company) || empty($description) || empty($status)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'invoiceId' => $invoiceId,
            'userId' => $userId,
            'name' => $name,
            'type' => $type,
            'company' => $company,
            'description' => $description,
            'status' => $status,
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $invoiceId = input('invoiceId');
        $pn = input('pn', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($invoiceId)) {
            $where['invoiceId'] = $invoiceId;
        }

        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $today = strtotime(date('Y-m-d')); // 一天中的零时零分零秒
            if ($today > $item['create']) {
                $item['isUpdate'] = false;
            }else{
                $item['isUpdate'] = true;
            }
            $item['create'] = date('Y-m-d', $item['create']);
            $list[] = $item;
        }
        return json(ok($list));
    }

    public function update()
    {
        $id = input('id');
        $type = input('type');
        $company = input('company');
        $description = input('description');
        $status = input('status');

        if (empty($type) || empty($company) || empty($description) || empty($status)) {
            return json(error('缺少必要参数'));
        }

        $setData = [
            'type' => $type,
            'company' => $company,
            'description' => $description,
            'status' => $status,
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