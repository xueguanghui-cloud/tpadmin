<?php

use think\migration\Seeder;

class AdminRole extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->table('admin_role')->insert([
            ['id' => 1, 'name' => '管理员'],
            ['id' => 2, 'name' => '测试角色']
        ])->save();
    }
}
