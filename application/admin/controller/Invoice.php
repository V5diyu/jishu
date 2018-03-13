<?php

namespace app\admin\controller;

class Invoice extends Base
{
    private $mod;
    private $mod_audit;
    private $mod_dispatch;
    private $mod_plan;

    public function __construct()
    {
        $this->mod = new \InvoiceDB();
        $this->mod_audit = new \DispatchAuditDB();
        $this->mod_dispatch = new \DispatchDB();
        $this->mod_plan = new \PlanDB();
    }

    public function get()
    {
        $done = input('done/d', 0);
        $pn = input('pn/d', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;

        $where['done'] = $done;

        $data = $this->mod->get($where, $start, $ps);
        $count = $this->mod->count($where);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d H:i:s', $item['create']);
            $list[] = $item;
        }
        return json(ok(['list'=>$list, 'count'=>$count]));
    }

    public function getInfo()
    {
        $id = input('id');
        $status = input('status/d', 0);

        // 获取该技术人员在此次出差中报销列表
        $where['status'] = $status;
        if (!empty($id)) {
            $where['invoiceId'] = $id;
        }
        $data = $this->mod_dispatch->get($where);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d H:i:s', $item['create']);
            $list[] = $item;
        }

        // 获取该出差的详情
        $info = $this->mod->getInfo(['id' => $id]);
        $info['create'] = date('Y-m-d H:i:s', $info['create']);
        $info['dispatchList'] = $list;

        // 获取计划安排
        $planList = [];
        $planData = $this->mod_plan->get(['invoiceId'=>$id]);
        foreach ($planData as $item) {
            $planList[] = $item;
        }
        $info['flow2'] = $planList;

        // 获取新增加天数
        $addDaysInfo = $this->mod->getInfo(['pid' => $info['process_instance_id']]);
        $info['addDaysInfo'] = $addDaysInfo;

        return json(ok($info));
    }
}