<?php

namespace app\admin\controller;


class Dispatch extends Base
{
    private $mod;
    private $mod_invoice;
    private $mod_audit;
    private $mod_plan;
    private $mod_user;

    public function __construct()
    {
        $this->mod = new \DispatchDB();
        $this->mod_invoice = new \InvoiceDB();
        $this->mod_audit = new \DispatchAuditDB();
        $this->mod_plan = new \PlanDB();
        $this->mod_user = new \UserDB();
    }

    public function create()
    {
        $userId = input('userId');
        $place = input('place');
        $type = input('type');
        $amount = input('amount', 0);
        $bill = input('bill');
        $remark = input('remark');
        $invoiceId = input('invoiceId');

        if (empty($userId) || empty($type) || empty($invoiceId)) {
            return json(error('缺少必要参数'));
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
            'create' => time(),
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function getInfo()
    {
        $userId = input('userId');
        $invoiceId = input('invoiceId');
        $status = input('status/d', 0);

        if (empty($userId) || empty($invoiceId)) {
            return json(error('缺少必要的参数'));
        }
        // 获取该技术人员在此次出差中报销列表
        // $where['status'] = $status;
        $where['invoiceId'] = $invoiceId;
        $where['userId'] = $userId;

        $data = $this->mod->get($where);
        $list = [];
        foreach ($data as $item) {
            $item['create'] = date('Y-m-d H:i:s', $item['create']);
            $list[] = $item;
        }

        // 获取该出差的详情
        $info = $this->mod_invoice->getInfo(['id' => $invoiceId]);
        $info['create'] = date('Y-m-d H:i:s', $info['create']);
        $info['dispatchList'] = $list;

        // 获取计划安排
        $planList = [];
        $planData = $this->mod_plan->get(['invoiceId' => $invoiceId]);
        foreach ($planData as $item) {
            $planList[] = $item;
        }
        $info['flow2'] = $planList;

        // 获取新增加天数
        $addDaysInfo = $this->mod_invoice->getInfo(['pid' => $info['process_instance_id']]);
        $info['addDaysInfo'] = $addDaysInfo;

        return json(ok($info));
    }

    public function get()
    {
        $status = input('status/d', 0);
        $pn = input('pn/d', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;

        $where['status'] = $status;

        $data = $this->mod_audit->get($where, $start, $ps);
        $count = $this->mod_audit->count($where);

        $list = [];
        foreach ($data as $item) {
            $arr = [];
            $info = $this->mod_invoice->getInfo(['id' => $item['invoiceId']]);
            $arr['id'] = $item['id'];
            $arr['invoiceId'] = $item['invoiceId'];
            $arr['userId'] = $item['userId'];
            $arr['status'] = $item['status'];
            $arr['create'] = date('Y-m-d H:i:s', $item['create']);
            $arr['appoint'] = $info['appoint'];
            $arr['customer'] = $info['customer'];
            $arr['type'] = $info['type'];
            $list[] = $arr;
        }
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function audit()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }

        $auditInfo = $this->mod_audit->getInfo(['id' => $id]);
        $dispatchList = $this->mod->get([
            'userId' => $auditInfo['userId'],
            'invoiceId' => $auditInfo['invoiceId']
        ]);
        $ids = array_column(iterator_to_array($dispatchList), 'id');

        $this->mod->update([
            'status' => 1
        ], ['id' => ['$in' => $ids]], ['multiple' => true]);

        $this->mod_audit->update([
            'status' => 1
        ], [
            'id' => $id
        ]);
        return json(ok($ids));
    }

    public function export1()
    {
        $userId = input('userId');
        $invoiceId = input('invoiceId');

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();

        $name = '出差相关费用';
        setExcelTitleStyle($PHPSheet, 9);
        $PHPSheet->setCellValue("A1", "序号")->setCellValue("B1", "日期")->setCellValue("C1", "地点")->setCellValue("D1", "费用类型")->setCellValue("E1", "酒店名称/乘车方式")->setCellValue("F1", "金额")->setCellValue("G1", "票据")->setCellValue("H1", "描述");

        $PHPSheet->setTitle($name);

        $where = ['userId' => $userId, 'invoiceId' => $invoiceId];
        $data = $this->mod->get($where);
        $i = 1;
        foreach ($data as $item) {
            $i++;
            $PHPSheet->setCellValue("A$i", $i)->setCellValue("B$i", date('Y-m-d H:i', $item['create']))->setCellValue("C$i", $item['place'])->setCellValue("D$i", $item['type'])->setCellValue("E$i", $item['consume'])->setCellValue("F$i", $item['amount'])->setCellValue("G$i", $item['bill'])->setCellValue("H$i", $item['remark']);
        }

        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }

    public function ex(){
        $userId = input('userId');
        $invoiceId = input('invoiceId');

        $userInfo = $this->mod_user->getInfo(['userId' => $userId]);
        $invoiceInfo = $this->mod_invoice->getInfo(['id' => $invoiceId]);

        $xs = $this->mod_user->getInfo(['userId' => $invoiceInfo['userId']]);

        $info['jishu'] = $userInfo['name'];
        $info['xiaoshou'] = $xs['name'];
        $info['kehu'] = $invoiceInfo['customer'];
        $info['danhao'] = $invoiceInfo['applyCode'];

        $where = ['userId' => $userId, 'invoiceId' => $invoiceId];
        $data = $this->mod->get($where);

        $list = [];
        foreach ($data as $key => $item){
            $list[] = [
                'key' => $key + 1,
                'create' => date('Y-m-d H:i', $item['create']),
                'place' => $item['place'],
                'type' => $item['type'],
                'consume' => isset($item['consume']) ? $item['consume'] : '',
                'amount' => $item['amount'],
                'bill' => $item['bill'],
                'remark' => $item['remark']
            ];
        }

        $fileName = '出差相关费用';


        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=$fileName.xls");
        $titleList = ['序号', '日期', '地点', '费用类型', '酒店名称/乘车方式', '金额', '票据', '描述'];
        echo $this->export($titleList, $list, 1400, $info);
    }

    function export($title, $data, $width = 1000, $info)
    {
        $str = '';
        $str .= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>无标题文档</title>
<style type='text/css'>
td{
 text-align:center;
 font-size:12px;
 font-family:Arial, Helvetica, sans-serif;
 border:#1C7A80 1px solid;
 color:#152122;
 width:100px;
}
table,tr{
 border-style:none;
}
.title{
 background:#7DDCF0;
 color:#FFFFFF;
 font-weight:bold;
}
</style>
</head>

<body>
<table width='$width' border='1'>
    <tr><td colspan='".count($title)."'>技术员：". $info['jishu'] ."       对应销售：". $info['xiaoshou'] ."</td></tr>
    <tr><td colspan='".count($title)."'>客户名称：". $info['kehu'] ."       对应技术支持单号". $info['danhao'] ."</td></tr>

   <tr> ";

        foreach ($title as $item) {
            $str .= "
    <td class='title'>$item</td>
    ";
        }
        $str .= "  </tr>";


        foreach ($data as $item) {
            $str .= "<tr>";
            foreach ($item as $k => $v) {
                $str .= " <td>$v</td>";
            }

            $str .= "</tr>";
        }
        $str .= '
        </table>
        </body>
        </html>';

        return $str;
    }

}