<?php
namespace app\admin\validate;

use app\admin\model\AdminMenu as MenuModel;
use think\Validate;

class AdminMenu extends Validate
{
    protected $rule = [
        'name' => 'require|max:32',
        'icon' => 'require|max:32',
        'controller' => 'require|max:32',
        'sort' => 'number',
        'pid' => 'number',
    ];

    protected $message = [
        'name.require' => '名称不能为空',
        'name.max' => '名称不能超过32个字符',
        'icon.require' => '图标不能为空',
        'icon.max' => '图标不能超过32个字符',
        'controller.require' => '控制器不能为空',
        'controller.max' => '控制器不能超过32个字符',
        'sort.number' => '排序值必须是数字',
        'pid.different' => '不能选择自己作为上级菜单'
    ];

    public function sceneInsert()
    {
        return $this->append('pid', 'checkPidIsTop');
    }

    public function sceneUpdate()
    {
        return $this->append('pid', 'checkPidIsTop')->append('pid', 'different:id');
    }

    public function checkPidIsTop($value, $rule)
    {
        if ($value !== 0) {
            if (!$data = MenuModel::field('pid')->get($value)) {
                return '上级菜单不存在';
            }
            if ($data->pid) {
                return '上级菜单不能使用子项';
            }
        }
        return true;
    }
    
    public function sceneDelete()
    {
        return $this->only(['id'])->append('id', 'checkIdIsLeaf');
    }

    public function checkIdIsLeaf($value, $rule)
    {
        $data = MenuModel::field('id')->where('pid', $value)->find();
        return $data ? '存在子项' : true;
    }
}
