<?php
namespace app\index\controller;

use think\Controller;

class Sale extends Controller
{
    // 首页
    public function index()
    {
        return view();
    }

    // 提交技术申请-客户信息页
    public function customer()
    {
        return view();
    }
    // 提交技术申请-服务内容
    public function service()
    {
        return view();
    }
    // 提交技术申请-预收费用
    public function charge()
    {
        return view();
    }

    // 项目管理页面
    public function manager()
    {
        return view();
    }

    // 项目管理详情页面
    public function managerDetail()
    {
        return view('managerDetail');
    }

}
