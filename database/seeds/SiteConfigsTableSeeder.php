<?php

use Illuminate\Database\Seeder;

class SiteConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_configs')->insert([
            ['name' => 'logo', 'value' => 'logo 图片'],
            ['name' => 'site_name', 'value' => '站点名称'],
            ['name' => 'site_title', 'value' => '站点标题'],
            ['name' => 'site_desc', 'value' => '站点介绍'],
            ['name' => 'copyright', 'value' => '版权信息'],
            ['name' => 'about_us', 'value'=>'关于我们'],
            ['name' => 'contact_us', 'value'=>'联系我们'],
            ['name' => 'close', 'value'=>'0'],
            ['name' => 'close_reason', 'value'=>'关闭原因'],
            ['name' => 'close_register', 'value'=>'0'],

        ]);
    }
}
