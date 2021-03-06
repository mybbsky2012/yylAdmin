<?php
/*
 * @Description  : 用户管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-26
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\service\AdminUserService;
use app\admin\validate\AdminUserValidate;

class AdminUser
{
    /**
     * 用户列表
     *
     * @method GET
     * @return json
     */
    public function userList()
    {
        $page          = Request::param('page/d', 1);
        $limit         = Request::param('limit/d', 10);
        $order_field   = Request::param('order_field/s ', '');
        $order_type    = Request::param('order_type/s', '');
        $username      = Request::param('username/s', '');
        $nickname      = Request::param('nickname/s', '');
        $admin_rule_id = Request::param('admin_rule_id/s', '');

        $where = [];
        if ($username) {
            $where[] = ['username', 'like', '%' . $username . '%'];
        }
        if ($nickname) {
            $where[] = ['nickname', 'like', '%' . $nickname . '%'];
        }
        $whereOr = false;
        if ($admin_rule_id) {
            $whereOr = true;
            $where0 = [['admin_rule_ids', 'like', $admin_rule_id], ['is_delete', '=', 0]];
            $where1 = [['admin_rule_ids', 'like', $admin_rule_id . ',%'], ['is_delete', '=', 0]];
            $where2 = [['admin_rule_ids', 'like', '%,' . $admin_rule_id . ',%'], ['is_delete', '=', 0]];
            $where3 = [['admin_rule_ids', 'like', '%,' . $admin_rule_id], ['is_delete', '=', 0]];
            $where = [$where0, $where1, $where2, $where3];
        }

        $field = '';

        $order = [];
        if ($order_field && $order_type) {
            $order = [$order_field => $order_type];
        }

        $data = AdminUserService::list($where, $page, $limit, $field, $order, $whereOr);

        return success($data);
    }

    /**
     * 用户添加
     *
     * @method POST
     * @return json
     */
    public function userAdd()
    {
        $param = Request::only(
            [
                'username' => '',
                'nickname' => '',
                'password' => '',
                'email'    => '',
                'remark'   => '',
                'sort'     => 200,
            ]
        );

        validate(AdminUserValidate::class)->scene('user_add')->check($param);

        $data = AdminUserService::add($param);

        return success($data);
    }

    /**
     * 用户修改
     *
     * @method POST
     * @return json
     */
    public function userEdit()
    {
        $param = Request::only(
            [
                'admin_user_id' => '',
                'username'      => '',
                'nickname'      => '',
                'email'         => '',
                'remark'        => '',
                'sort'          => 200,
            ]
        );

        validate(AdminUserValidate::class)->scene('user_edit')->check($param);

        $data = AdminUserService::edit($param);

        return success($data);
    }

    /**
     * 用户删除
     *
     * @method POST
     * @return json
     */
    public function userDele()
    {
        $admin_user_id = Request::param('admin_user_id/d', '');

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $data = AdminUserService::dele($admin_user_id);

        return success($data);
    }

    /**
     * 用户信息
     *
     * @method GET
     * @return json
     */
    public function userInfo()
    {
        $admin_user_id = Request::param('admin_user_id/d', '');

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $admin_user = AdminUserService::info($admin_user_id);

        return success($admin_user);
    }

    /**
     * 用户密码重置
     *
     * @method POST
     * @return json
     */
    public function userPwd()
    {
        $param = Request::only(
            [
                'admin_user_id' => '',
                'password'      => '',
            ]
        );

        validate(AdminUserValidate::class)->scene('user_pwd')->check($param);

        $data = AdminUserService::pwd($param);

        return success($data);
    }

    /**
     * 用户权限分配
     *
     * @method POST
     * @return json
     */
    public function userRule()
    {
        $admin_user_id  = Request::param('admin_user_id/d', '');
        $admin_rule_ids = Request::param('admin_rule_ids/a', []);
        $admin_menu_id = Request::param('admin_menu_id/a', []);

        $param['admin_user_id']  = $admin_user_id;
        $param['admin_rule_ids'] = $admin_rule_ids;
        $param['admin_menu_id']  = $admin_menu_id;

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $data = AdminUserService::rule($param);

        return success($data);
    }

    /**
     * 用户权限明细
     *
     * @method POST
     * @return json
     */
    public function userRuleInfo()
    {
        $admin_user_id  = Request::param('admin_user_id/d', '');

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $data = AdminUserService::info($admin_user_id);

        return success($data);
    }

    /**
     * 用户是否禁用
     *
     * @method POST
     * @return json
     */
    public function userProhibit()
    {
        $admin_user_id = Request::param('admin_user_id/d', '');
        $is_prohibit   = Request::param('is_prohibit/s', 0);

        $param['admin_user_id'] = $admin_user_id;
        $param['is_prohibit']   = $is_prohibit;

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $data = AdminUserService::prohibit($param);

        return success($data);
    }

    /**
     * 用户是否超管
     *
     * @method POST
     * @return json
     */
    public function userSuperAdmin()
    {
        $admin_user_id  = Request::param('admin_user_id/d', '');
        $is_super_admin = Request::param('is_super_admin/s', 0);

        $param['admin_user_id']  = $admin_user_id;
        $param['is_super_admin'] = $is_super_admin;

        validate(AdminUserValidate::class)->scene('admin_user_id')->check(['admin_user_id' => $admin_user_id]);

        $data = AdminUserService::superAdmin($param);

        return success($data);
    }
}
