<?php

namespace app\api\controller;

use think\Loader;

class Test extends Base
{
    private $mod;


    public function __construct()
    {
        $this->mod = new \InvoiceDB();
    }

    public function aa()
    {
        Loader::import('dingdingSDK/TopSdk');

        $config = config('dingding');
        $c      = new \DingTalkClient;
        $req    = new \SmartworkBpmsProcessinstanceCreateRequest;
        $req->setAgentId($config['agentId']);
        $req->setProcessCode($config['processCode']);
        $req->setOriginatorUserId('14603304471051984');
        $req->setDeptId('57597413');
        // 02376769251038628
        $req->setApprovers('162423286138193306,01275865371232039');
        $form = [
            [
                'name'  => '申请人',
                'value' => '123123',
            ],
            [
                'name'  => '申请时间',
                'value' => '123123',
            ],
            [
                'name'  => '销售单号',
                'value' => '123123',
            ],
            [
                'name'  => '客户名称',
                'value' => '123123',
            ],
            [
                'name'  => '单位名称',
                'value' => '123123',
            ],
            [
                'name'  => '前往地点',
                'value' => '123123',
            ],
            [
                'name'  => '详细地址',
                'value' => '123123',
            ],
            [
                'name'  => '联系人',
                'value' => '123123',
            ],
            [
                'name'  => '联系方式',
                'value' => '123123',
            ],
            [
                'name'  => '服务类型',
                'value' => '123123',
            ],
            [
                'name'  => '单位数量',
                'value' => '123123',
            ],
            [
                'name'  => '设备名称',
                'value' => '123123',
            ],
            [
                'name'  => '设备数量',
                'value' => '123123',
            ],
            [
                'name'  => '备注说明',
                'value' => '12312',
            ],
            [
                'name'  => '服务天数',
                'value' => '123123',
            ],
            [
                'name'  => '服务人数',
                'value' => '123123',
            ],
            [
                'name'  => '交通费',
                'value' => '12312',
            ],
            [
                'name'  => '住宿费(单日)',
                'value' => '123123',
            ],
            [
                'name'  => '服务费(单日)',
                'value' => '12123',
            ],
        ];
        $req->setFormComponentValues(json_encode($form));
        $result = $c->execute($req, $this->getAccessToken());
        $result = json_decode(json_encode($result), true);
        return json(ok($result));
    }

    public function bb()
    {
        Loader::import('dingdingSDK/TopSdk');
        $id  = 'c90c83bc-1311-4368-8764-ca144418cc3d';
        $c   = new \DingTalkClient();
        $req = new \SmartworkBpmsProcessinstanceGetRequest();
        $req->setProcessInstanceId($id);
        $resp = $c->execute($req, $this->getAccessToken());
        $resp = json_decode(json_encode($resp), true);
        return json($resp);
    }

    public function dd()
    {
        //注册回调
        $url  = 'https://oapi.dingtalk.com/call_back/register_call_back?access_token=' . $this->getAccessToken();
        $data = [
            'call_back_tag' => ['bpms_task_change', 'bpms_instance_change'],
            'token'         => 'shengpi',
            'aes_key'       => '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp',
            'url'           => 'http://yly4.ylyedu.com/api/test/ee',
        ];
        $res  = postHttpRequestJson($url, json_encode($data));
        return $res;
    }

    public function ee()
    {
        Loader::import('crypto/DingtalkCrypt');
        $con       = mdb()->test;
        $signature = $_GET["signature"];
        $timeStamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $postdata  = file_get_contents("php://input");
        $postList  = json_decode($postdata, true);
        $encrypt   = $postList['encrypt'];
        $crypt     = new \DingtalkCrypt('shengpi', '1234567890qwertyuiopasdfghjklzxcvbnmijnokmp', config('dingding.corpid'));

        //解密数据
        $msg     = "";
        $errCode = $crypt->DecryptMsg($signature, $timeStamp, $nonce, $encrypt, $msg);

        $msg = json_decode($msg, true);

        if ($msg['type'] === 'finish' && $msg['EventType'] === 'bpms_task_change') {
            $con->insert(['msg' => $msg, 'errCode' => $errCode]);
        }

        //业务处理



        //加密数据
        $res        = "success";
        $encryptMsg = "";
        $crypt->EncryptMsg($res, $timeStamp, $nonce, $encryptMsg);
        return $encryptMsg;
    }
}