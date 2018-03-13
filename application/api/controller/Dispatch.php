<?php

namespace app\api\controller;


class Dispatch extends Base
{
    private $mod;
    private $mod_invoice;
    private $mod_audit;
    private $mod_user;

    public function __construct()
    {
        $this->mod = new \DispatchDB();
        $this->mod_invoice = new \InvoiceDB();
        $this->mod_audit = new \DispatchAuditDB();
        $this->mod_user = new \UserDB();
    }

    public function create()
    {
        $userId = input('userId');
        $place = input('place');
        $type = input('type');
        $amount = input('amount');
        $bill = input('bill');
        $remark = input('remark');
        $consume = input('consume');

        if (empty($userId) || empty($type) || empty($amount)) {
            return json(error('缺少必要参数'));
        }

        $info = $this->mod_invoice->get(['appointIds' => $userId, 'done' => 0]);
        $data = [];
        foreach ($info as $item) {
            $data[] = $item;
        }
        if (count($data) == 1) {
            $invoiceId = count($data) > 0 ? $data[0]['id'] : 0;
        } else {
            $invoiceId = input('invoiceId');
        }

        $insertData = [
            'userId' => $userId,
            'place' => $place,
            'type' => $type,
            'amount' => $amount,
            'bill' => $bill,
            'remark' => $remark,
            'invoiceId' => $invoiceId,
            'status' => 0,
            'consume' => $consume,
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $userId = input('userId');
        $invoiceId = input('invoiceId');
        $status = input('status/d', 0);
        $pn = input('pn/d', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;

        if (empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        $where['status'] = $status;

        if (!empty($invoiceId)) {
            $where['invoiceId'] = $invoiceId;
        }

        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d H:i:s', $item['create']);
            $item['user'] = $this->mod_user->getInfo(['userId' => $item['userId']]);
            $list[] = $item;
        }
        return json(ok($list));
    }

    public function getAuditList()
    {
        $status = input('status/d', 0);
        $pn = input('pn/d', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;

        $where['status'] = $status;

        $data = $this->mod_audit->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $arr = [];
            $info = $this->mod_invoice->getInfo(['id' => $item['invoiceId']]);
            $arr['id'] = $item['id'];
            $arr['invoiceId'] = $item['invoiceId'];
            $arr['userId'] = $item['userId'];
            $arr['appoint'] = $info['appoint'];
            $arr['customer'] = $info['customer'];
            $arr['type'] = $info['type'];
            $list[] = $arr;
        }
        return json(ok($list));
    }

}