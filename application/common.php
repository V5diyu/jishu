<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function mdb()
{
    $config   = \think\Config::get('mongodb');
    $host     = $config['host'];
    $port     = $config['prot'];
    $dbname   = $config['dbname'];
    $username = $config['username'];
    $password = $config['password'];
    //$mongo    = new MongoClient('mongodb://' . $username . ':' . $password . '@' . $host . ':' . $port . '/admin');
    $mongo = new MongoClient();
    return $mongo->selectDB($dbname);
}


function ok($data = [], $msg = '成功')
{
    return [
        'ret'  => true,
        'data' => $data,
        'msg'  => $msg
    ];
}

function error($msg = 'error', $code = '')
{
    $res = [
        'ret'  => false,
        'data' => '',
        'msg'  => $msg
    ];
    if (!empty($code)) {
        $res['code'] = $code;
    }
    return $res;
}

function uniqueID()
{
    list($s1, $s2) = explode(' ', microtime());
    $mic  = (float)floatval($s1);
    $iii  = ($s2 + $mic) * 10000;
    $iioo = strval($iii);
    $ID   = $iioo . rand(0, 1000);

    return strval($ID);
}

function getUuid()
{
    mt_srand(( double )microtime() * 10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid   = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    return $uuid;
}

function getHttpRequest($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0');

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;

}

function postHttpRequest($url, $postDataArray)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postDataArray));
    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

function postHttpRequestJson($url, $data)
{

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ));
    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

function strEmptyChange($str)
{
    if (empty($str)) {
        return '';
    }
    return $str;
}

function strEmptyFloat($str)
{
    if (empty($str)) {
        return 0;
    }
    return floatval($str);
}


function randstr($length = 32, $mode = 0)
{
    switch ($mode) {
        case 1: {
            $str = '1234567890';
            break;
        }
        case 2: {
            $str = 'abcdefghijklmnopqrstuvwxyz';
            break;
        }
        case 3: {
            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        }
        case 4: {
            $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        }
        case 5: {
            $str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        }
        default : {
            $str = '1234567890';
            break;
        }
    }

    $rslt = '';
    $len  = strlen($str) - 1;
    $num  = 0;
    for ($i = 0; $i < $length; $i++) {
        srand();
        $num  = rand(0, $len);
        $a    = $str[$num];
        $rslt = $rslt . $a;
    }
    return $rslt;
}

function setExcelTitleStyle(&$obj, $count)
{
    $arr = array_slice(range('A', 'Z'), 0, $count);
    $obj->getRowDimension(1)->setRowHeight(25);
    $i = 1;
    foreach ($arr as $item) {
        $obj->getColumnDimension($item)->setWidth(20);
        $obj->getStyle($item . $i)->getFont()->setBold(true)->setSize(14)->setName('雅痞-简')->getColor()->setARGB('27408B');
        $obj->getStyle($item . $i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $obj->getStyle($item . $i)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F0FFFF');
        $obj->getStyle($item . $i)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
    }
    return $obj;
}
