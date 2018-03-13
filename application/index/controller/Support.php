<?php
namespace app\index\controller;

use think\Controller;

class Support extends Controller
{
    // 首页
    public function index()
    {
        return view();
    }

    // 日志
    public function log()
    {
        return view();
    }

    // 知识分类页
    public function knowledge()
    {
        return view();
    }

    // 知识列表页
    public function knowledgeList()
    {
        return view('knowledgeList');
    }

    // 知识详情页
    public function knowledgeDetail()
    {
        return view('knowledgeDetail');
    }

    // 规章制度
    public function rules()
    {
        return view();
    }

    // 制度列表页
    public function rulesList()
    {
        return view('rulesList');
    }

    // 制度详情页
    public function rulesDetail()
    {
        return view('rulesDetail');
    }

    // 报销
    public function dispatch()
    {
        return view();
    }

    // 报销审核
    public function dispatchAudit()
    {
        return view('dispatchAudit');
    }

    // 反馈
    public function feedback()
    {
        return view();
    }

}
