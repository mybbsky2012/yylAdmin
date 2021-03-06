<?php
/*
 * @Description  : 日志验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-06
 * @LastEditTime : 2020-08-15
 */

namespace app\admin\validate;

use think\Validate;

class AdminLogValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_log_id' => ['require'],
    ];

    // 错误信息
    protected $message  =   [
        'admin_log_id.require' => '缺少参数admin_log_id',
    ];

    // 验证场景
    protected $scene = [
        'admin_log_id' => ['admin_log_id'],
    ];
}
