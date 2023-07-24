<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class Translate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('langs')->insert([
            ['key' => 'menu.home','en' => 'Home','vi' => 'Trang chủ',],
            ['key' => 'Users','en' => 'Users','vi' => 'Tài khoản',],
            ['key' => 'List Users','en' => 'List Users','vi' => 'Danh sách tài khoản',],
            ['key' => 'Create User','en' => 'Create User','vi' => 'Tạo mới tài khoản',],
            ['key' => 'RolePermission User','en' => 'RolePermission User','vi' => 'Phân quyền tài khoản',],
            ['key' => 'Posts','en' => 'Posts','vi' => 'Bài viết',],
            ['key' => 'List categorypost','en' => 'List category post','vi' => 'Danh sách danh mục bài viết',],
            ['key' => 'List Posts','en' => 'List Posts','vi' => 'Danh sách bài viết',],
            ['key' => 'List postcomment','en' => 'List postcomment','vi' => 'Danh sách bình luận',],
            ['key' => 'Demo','en' => 'Demo','vi' => 'Ví dụ',],
            ['key' => 'List Demo','en' => 'List Demo','vi' => 'Danh sách ví dụ',],
            ['key' => 'Create Demo','en' => 'Create Demo','vi' => 'Tạo mới ví dụ',],
            ['key' => 'Menu','en' => 'Menu','vi' => 'Bảng kê',],
            ['key' => 'List menu','en' => 'List menu','vi' => 'Danh sách bảng kê',],
            ['key' => 'Create menu','en' => 'Create menu','vi' => 'Tạo mới bảng kê',],
            ['key' => 'Seo','en' => 'Seo','vi' => 'Seo',],
            ['key' => 'Contact','en' => 'Contact','vi' => 'Liên hệ',],
            ['key' => 'List contact','en' => 'List contact','vi' => 'Danh sách liên hệ',],
            ['key' => 'Redirect link','en' => 'Redirect link','vi' => 'Chuyển hướng link',],
            ['key' => 'Log','en' => 'Log','vi' => 'Nhật kí hoạt động',],
            ['key' => 'Configures','en' => 'Configures','vi' => 'Cấu hình chung',],
            ['key' => 'Translate language','en' => 'Translate language','vi' => 'Dịch ngôn ngữ',],
        ]);
    }
}  