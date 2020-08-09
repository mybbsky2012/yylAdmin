<?php
/*
 * @Description  : 实用工具
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-08-09
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\service\AdminToolService;

class AdminTool
{
    /**
     * 生成随机字符串密码
     *
     * @method POST
     * 
     * @return json
     */
    public function randomStr()
    {
        $random_len = Request::param('random_len/d', 1);
        $random_ids = Request::param('random_ids/a', []);

        if (empty($random_ids)) {
            error('请选择所用字符');
        }

        $data = AdminToolService::randomStr($random_ids, $random_len);

        return success($data);
    }

    /**
     * 时间戳转换
     *
     * @method POST
     * 
     * @return json
     */
    public function timestamp()
    {
        $param = Request::only(
            [
                'type'      => 'time',
                'datetime'  => '',
                'timestamp' => '',
            ]
        );

        if ($param['type'] == 'time' && !strtotime($param['datetime'])) {
            error('请选择有效的时间');
        }

        if ($param['type'] == 'date' && $param['timestamp'] && !is_numeric($param['timestamp'])) {
            error('请输入有效的时间戳');
        }

        $data = AdminToolService::timestamp($param);

        return success($data);
    }

    /**
     * MD5加密
     *
     * @method POST
     * 
     * @return json
     */
    public function md5Enc()
    {
        $str = Request::param('str/s', '');

        if (empty($str)) {
            error('请输入字符串');
        }

        $data = AdminToolService::md5Enc($str);

        return success($data);
    }

    /**
     * 生成二维码
     *
     * @method POST
     * 
     * @return json
     */
    public function qrcode()
    {
        $str = Request::param('str/s', '');

        if (empty($str)) {
            error('请输入文本内容');
        }

        $data = AdminToolService::qrcode($str);

        return success($data);
    }
}
