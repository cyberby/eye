<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $domains = ['test.com' => 1, 'jbc.com' => 2, 'hd01.net' => 1, 'globo.net'=>2];
        foreach ($domains as $domain => $user_id) {
            DB::table('sites')->insert([
                'domain' => $domain,
                'user_id' => $user_id
            ]);
        }
    }
}
