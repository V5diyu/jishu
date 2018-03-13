<?php

namespace app\api\controller;

use think\Loader;

class Invoice extends Base
{
    private $mod;
    private $mod_audit;
    private $mod_approve;
    private $mod_plan;
    private $mod_log;

    public function __construct()
    {
        $this->mod = new \InvoiceDB();
        $this->mod_audit = new \DispatchAuditDB();
        $this->mod_approve = new \ApproveDB();
        $this->mod_plan = new \PlanDB();
        $this->mod_log = new \LogDB();
    }

    public function applyCode()
    {
        $arr = $this->mod->get();

        $list = [];
        foreach ($arr as $item) {
            $list[] = $item;
        }

        if (count($list) > 0 && array_key_exists('applyCode', $list[0])) {
            $number = explode('_', $list[0]['applyCode'])[2];
            $month = explode('_', $list[0]['applyCode'])[1];

            if (date('Y-m') != $month) {
                $month = date('Y-m');
                $number = 1;
            } else {
                $number = intval($number) + 1;
            }
        } else {
            $month = date('Y-m');
            $number = 1;
        }

        $applyCode = 'TLU-JSFU_' . $month . '_' . $number;

        return $applyCode;
    }

    public function operationSubmit()
    {
        Loader::import('dingdingSDK/TopSdk');
        $userId = input('userId');          //用户id
        $department = input('department');      //部门id
        $Approvers = array_column(iterator_to_array($this->mod_approve->get()), 'approve');
        $Approvers = implode(',', $Approvers);

        if (empty($userId) || empty($department)) {
            return json(error('缺少必要的参数'));
        }

        $name = input('name');             //申请人
        $time = date('Y-m-d H:i');       //申请时间
        $code = input('code');            //销售单号
        $customer = input('customer');            //客户名称
        $company = input('company');           //单位名称
        $place = input('place');            //前往地点
        $address = input('address');            //详细地址
        $contact_name = input('contact/a')[0]['name'];            //联系人
        $contact_tel = input('contact/a')[0]['tel'];            //联系方式
        $type = implode('/', input('type/a'));            //服务类型
        $number = input('number');            //单位数量
        $device_name = input('device/a')[0]['name'];            //设备名称
        $device_number = input('device/a')[0]['number'];              //设备数量
        $remark = input('remark');          //备注说明
        $days = input('days');              //服务天数
        $peoples = input('peoples');              //服务人数
        $traffic = input('traffic');             //交通费
        $stayCharge = input('stayCharge');              //住宿费（单日）
        $serviceCharge = input('serviceCharge');            //服务费（单日）
        $total = input('total');            //总费用

        $config = config('dingding');
        $c = new \DingTalkClient;
        $req = new \SmartworkBpmsProcessinstanceCreateRequest;
        $req->setAgentId($config['agentId']);
        $req->setProcessCode($config['processCode1']);
        $req->setOriginatorUserId($userId);
        $req->setDeptId($department);
        $req->setApprovers($Approvers);
        $form = [
            [
                'name' => '申请人',
                'value' => $name,
            ],
            [
                'name' => '申请时间',
                'value' => $time,
            ],
            [
                'name' => '销售单号',
                'value' => $code,
            ],
            [
                'name' => '客户名称',
                'value' => $customer,
            ],
            [
                'name' => '单位名称',
                'value' => $company,
            ],
            [
                'name' => '前往地点',
                'value' => $place,
            ],
            [
                'name' => '详细地址',
                'value' => $address,
            ],
            [
                'name' => '联系人',
                'value' => $contact_name,
            ],
            [
                'name' => '联系方式',
                'value' => $contact_tel,
            ],
            [
                'name' => '服务类型',
                'value' => $type,
            ],
            [
                'name' => '单位数量',
                'value' => $number,
            ],
            [
                'name' => '设备名称',
                'value' => $device_name,
            ],
            [
                'name' => '设备数量',
                'value' => $device_number,
            ],
            [
                'name' => '备注说明',
                'value' => $remark,
            ],
            [
                'name' => '服务天数',
                'value' => $days,
            ],
            [
                'name' => '服务人数',
                'value' => $peoples,
            ],
            [
                'name' => '交通费',
                'value' => $traffic,
            ],
            [
                'name' => '住宿费(单日)',
                'value' => $stayCharge,
            ],
            [
                'name' => '服务费(单日)',
                'value' => $serviceCharge,
            ],
            [
                'name' => '总费用',
                'value' => $total,
            ],
        ];
        $req->setFormComponentValues(json_encode($form));
        $result = $c->execute($req, $this->getAccessToken());
        $result = json_decode(json_encode($result), true);

        if (!$result['result']['is_success']) {
            return json(error($result['result']['error_msg']));
        }

        $insertData = [
            'applyCode' => $this->applyCode(),
            'pid' => '0',
            'userId' => $userId,
            'department' => $department,
            'name' => $name,
            'time' => $time,
            'code' => $code,
            'customer' => $customer,
            'company' => $company,
            'place' => $place,
            'address' => $address,
            'contact' => input('contact/a'),
            'type' => $type,
            'number' => $number,
            'device' => input('device/a'),
            'remark' => $remark,
            'days' => $days,
            'peoples' => $peoples,
            'traffic' => $traffic,
            'stayCharge' => $stayCharge,
            'serviceCharge' => $serviceCharge,
            'status' => 0, // 0 (等待审批) 1 (审批人1完成) 2 (审批人2完成)  3 (审批人1拒绝) 4 (审批2拒绝) 5(审批成功完成)
            'done' => 0, // 0 项目未完成 1 项目已结项
            /**
             * 0 （等待审批）
             * 1（等待指派人员）
             * 2（客户电话沟通）
             * 3（计划安排）
             * 4（借用设备申请）
             * 5（等待确定出发日期）
             * 6（现场问题沟通确认）
             * 7（技术支持进行）
             * 8（反馈销售确认结束）
             * 9（等待销售确认）
             * 10（确定返程日期）
             * 11（财务报销）
             * 12（项目总结）
             * 13（完成）
             */
            'progress' => 0,
            'create' => time(),
            'process_instance_id' => $result['result']['process_instance_id']
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function addDays()
    {
        Loader::import('dingdingSDK/TopSdk');
        $userId = input('userId');          //用户id
        $department = input('department');      //部门id
        $Approvers = array_column(iterator_to_array($this->mod_approve->get()), 'approve');
        $Approvers = implode(',', $Approvers);

        $time = date('Y-m-d H:i');       //申请时间
        $days = input('days');              //服务天数
        $peoples = input('peoples');              //服务人数
        $traffic = input('traffic');             //交通费
        $stayCharge = input('stayCharge');              //住宿费（单日）
        $serviceCharge = input('serviceCharge');            //服务费（单日）
        $total = input('total');            //总费用
        $process_instance_id = input('process_instance_id');

        if (empty($userId) || empty($department) || empty($process_instance_id)) {
            return json(error('缺少必要的参数'));
        }

        $info = $this->mod->getInfo(['process_instance_id' => $process_instance_id]);

        $config = config('dingding');
        $c = new \DingTalkClient;
        $req = new \SmartworkBpmsProcessinstanceCreateRequest;
        $req->setAgentId($config['agentId']);
        $req->setProcessCode($config['processCode2']);
        $req->setOriginatorUserId($userId);
        $req->setDeptId($department);
        $req->setApprovers($Approvers);

        $form = [
            [
                'name' => '申请人',
                'value' => $info['name'],
            ],
            [
                'name' => '申请时间',
                'value' => $time,
            ],
            [
                'name' => '销售单号',
                'value' => $info['code'],
            ],
            [
                'name' => '客户名称',
                'value' => $info['customer'],
            ],
            [
                'name' => '单位名称',
                'value' => $info['company'],
            ],
            [
                'name' => '前往地点',
                'value' => $info['place'],
            ],
            [
                'name' => '详细地址',
                'value' => $info['address'],
            ],
            [
                'name' => '联系人',
                'value' => $info['contact'][0]['name'],
            ],
            [
                'name' => '联系方式',
                'value' => $info['contact'][0]['tel'],
            ],
            [
                'name' => '服务类型',
                'value' => $info['type'],
            ],
            [
                'name' => '单位数量',
                'value' => $info['number'],
            ],
            [
                'name' => '设备名称',
                'value' => $info['device'][0]['name'],
            ],
            [
                'name' => '设备数量',
                'value' => $info['device'][0]['number'],
            ],
            [
                'name' => '备注说明',
                'value' => $info['remark'],
            ],
            [
                'name' => '新增服务天数',
                'value' => $days,
            ],
            [
                'name' => '新增服务人数',
                'value' => $peoples,
            ],
            [
                'name' => '新增交通费',
                'value' => $traffic,
            ],
            [
                'name' => '新增住宿费(单日)',
                'value' => $stayCharge,
            ],
            [
                'name' => '新增服务费(单日)',
                'value' => $serviceCharge,
            ],
            [
                'name' => '新增总费用',
                'value' => $total,
            ],
        ];
        $req->setFormComponentValues(json_encode($form));
        $result = $c->execute($req, $this->getAccessToken());
        $result = json_decode(json_encode($result), true);

        if (!$result['result']['is_success']) {
            return json(error($result['result']['error_msg']));
        }

        $insertData = [
            'days' => $days,
            'peoples' => $peoples,
            'traffic' => $traffic,
            'stayCharge' => $stayCharge,
            'serviceCharge' => $serviceCharge,
            'process_instance_id' => $result['result']['process_instance_id'],
            'status' => 0, // 0 (等待审批) 1 (审批人1完成) 2 (审批人2完成)  3 (审批人1拒绝) 4 (审批2拒绝) 5(审批成功完成)
            'progress' => 0, // 0 （等待审批）1（等待指派人员）2（添加天数成功）
            'pid' => $process_instance_id,
        ];

        $this->mod->add($insertData);
        return json(ok());

    }

    public function addPlan()
    {
        $userId = input('userId');
        $name = input('name');
        $invoiceId = input('invoiceId');
        $description = input('description');

        $count = $this->mod_plan->count(['invoiceId' => $invoiceId]);
        if ($count == 0) {
            $this->mod->update(['progress' => 4], ['id' => $invoiceId]);
        }

        $this->mod_plan->add([
            'userId' => $userId,
            'name' => $name,
            'invoiceId' => $invoiceId,
            'description' => $description
        ]);

        return json(ok());
    }

    public function getPlan()
    {
        $invoiceId = input('invoiceId');
        if (empty($invoiceId)) {
            return json(error('缺少必要参数'));
        }
        $data = $this->mod_plan->get(['invoiceId' => $invoiceId]);
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok($list));
    }

    public function aa()
    {

        //注册回调
        $url = 'https://oapi.dingtalk.com/call_back/get_call_back?access_token=' . $this->getAccessToken();
        $data = [
            'call_back_tag' => ['bpms_task_change', 'bpms_instance_change'],
            'token' => 'shengpi',
            'aes_key' => '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp',
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/invoice/approveCallback',
        ];
        $res = getHttpRequest($url);
        return $res;
    }

    public function bb()
    {
        //注册回调
        $url = 'https://oapi.dingtalk.com/call_back/register_call_back?access_token=' . $this->getAccessToken();
        $data = [
            'call_back_tag' => ['bpms_task_change', 'bpms_instance_change'],
            'token' => 'shengpi',
            'aes_key' => '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp',
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/Invoice/approveCallback',
        ];
        $res = postHttpRequestJson($url, json_encode($data));
        return $res;
    }

    public function dd()
    {
        //注册回调
        $url = 'https://oapi.dingtalk.com/call_back/delete_call_back?access_token=' . $this->getAccessToken();
        $data = [
            'call_back_tag' => ['bpms_task_change', 'bpms_instance_change'],
            'token' => 'shengpi',
            'aes_key' => '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp',
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/invoice/approveCallback',
        ];
        $res = getHttpRequest($url, json_encode($data));
        return $res;
    }

    public function approveCallback()
    {
        Loader::import('crypto/DingtalkCrypt');
        $con = mdb()->approveLog;
        $signature = $_GET["signature"];
        $timeStamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $postdata = file_get_contents("php://input");
        $postList = json_decode($postdata, true);
        $encrypt = $postList['encrypt'];
        $crypt = new \DingtalkCrypt('shengpi', '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp', config('dingding.corpid'));

        //解密数据
        $msg = "";
        $errCode = $crypt->DecryptMsg($signature, $timeStamp, $nonce, $encrypt, $msg);

        $msg = json_decode($msg, true);

        if ($msg['type'] === 'finish' && $msg['EventType'] === 'bpms_task_change') {

            $processInstanceId = $msg['processInstanceId'];
            $info = $this->mod->getInfo(['process_instance_id' => $processInstanceId]);

            if ($msg['result'] == 'agree') {
                $status = intval($info['status']) + 1;
                $setData = [
                    'status' => $status
                ];
                if ($status == 2) {
                    $setData['progress'] = 1;
                }

                $this->mod->update($setData, ['process_instance_id' => $processInstanceId]);
            } else if ($msg['result'] == 'refuse') {
                if ($info['status'] == 0) {
                    $setData['status'] = 3;
                } else {
                    $setData['status'] = 4;
                }
                $this->mod->update($setData, ['process_instance_id' => $processInstanceId]);
            }
            $con->insert(['msg' => $msg, 'errCode' => $errCode, 'invoiceId' => $info['id']]);
        }

        //业务处理


        //加密数据
        $res = "success";
        $encryptMsg = "";
        $crypt->EncryptMsg($res, $timeStamp, $nonce, $encryptMsg);
        return $encryptMsg;
    }

    public function getCurProjectList()
    {
        $userId = input('userId');

        if (empty($userId)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod->get(['appointIds' => $userId, 'done' => 0]);
        $list = [];
        foreach ($info as $item) {
            $list[] = $item;
        }
        return json(ok($list));
    }

    public function get()
    {
        $userId = input('userId');
        $done = input('done/d', 0);
        $auth = input('auth');
        $pn = input('pn/d', 1);
        $ps = 15;
        $start = ($pn - 1) * $ps;
        if (empty($userId) || empty($auth)) {
            return json(error('缺少必要的参数'));
        }

        $where = [];
        // 1（销售部） 2 （技术部） 3（Boos）4（技术经理）
        if ($auth == 1) {
            $where['userId'] = $userId;
        } else if ($auth == 2) {
            $where['appointIds'] = $userId;
        }
        $where['done'] = $done;
        $where['pid'] = "0"; // 一级审批 （排除新增天数审批）

        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $addDaysInfo = $this->mod->getInfo(['pid' => $item['process_instance_id']]);
            $item['addDaysInfo'] = $addDaysInfo;
            $item['logCount'] = $this->mod_log->count(['invoiceId' => $item['id']]);
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

        $flowList = [
            [
                'name' => '客户电话沟通',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 2 ? 2 : ($info['progress'] > 2 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '计划安排',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 3 ? 2 : ($info['progress'] > 3 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '借用设备申请',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 4 ? 2 : ($info['progress'] > 4 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '等待确定出发日期',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 5 ? 2 : ($info['progress'] > 5 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '现场问题沟通确认',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 6 ? 2 : ($info['progress'] > 6 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '技术支持进行',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 7 ? 2 : ($info['progress'] > 7 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '反馈销售确认结束',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 8 ? 2 : ($info['progress'] > 8 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '确定返程日期',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 10 ? 2 : ($info['progress'] > 10 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '财务报销',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 11 ? 2 : ($info['progress'] > 11 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ],
            [
                'name' => '项目总结',
                'time' => date('Y-m-d H:i:s'),
                'status' => $info['progress'] == 12 ? 2 : ($info['progress'] > 12 ? 1 : 3), // 1 （已结束）2（当前状态）3（剩余任务）
            ]
        ];

        $info['flowList'] = $flowList;

        return json(ok($info));
    }

    public function flow()
    {
        $id = input('id');
        $flow = input('flow');
        $progress = input('progress');
        $data = input('data/a');

        if (empty($id) || empty($flow) || empty($data) || empty($progress)) {
            return json(error('缺少必要参数'));
        }

        $data['create'] = time();

        $setData = [
            $flow => $data,
            'progress' => $progress
        ];

        if ($progress == 13) {
            $setData['done'] = 1;
        } else if ($progress == 12) {
            // 报销
            $userId = input('userId');
            $this->mod_audit->add([
                'userId' => $userId,
                'invoiceId' => $id,
                'status' => 0, // 0 未审核 1 已审核
                'create' => time()
            ]);
        }

        $this->mod->update($setData, $id);
        return json(ok());
    }

    // 指派技术人员
    public function appoint()
    {
        $id = input('id');
        $appoint = input('appoint/a');
        $appointIds = input('appointIds/a');

        if (empty($id) || empty($appoint) || empty($appointIds)) {
            return json(error('缺少必要参数'));
        }

        // 新增天数状态修改
        $info = $this->mod->getInfo(['id' => $id]);
        $this->mod->update([
            'progress' => 2
        ], ['pid' => $info['process_instance_id']]);


        // 申请技术申请修改
        $setData = [
            'progress' => $info['progress'] > 2 ? $info['progress'] : 2, // 技术流程开始
            'appoint' => $appoint,
            'appointIds' => $appointIds
        ];
        $this->mod->update($setData, $id);


        return json(ok());
    }

    // 销售确认结束
    public function saleConfirm()
    {
        $id = input('id');

        if (empty($id)) {
            return json(error('缺少必要参数'));
        }

        $setData = [
            'progress' => 10, // 销售确认结束后流程
        ];
        $this->mod->update($setData, $id);
        return json(ok());
    }

}