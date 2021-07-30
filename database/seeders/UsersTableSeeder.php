<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 生成数据集合
        User::factory()->count(10)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'linkun';
        $user->email = 'linkun@wufeng-network.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('a123456789');
        $user->save();
    }
}
