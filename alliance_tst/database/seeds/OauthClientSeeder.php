<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')
            ->insert([
                'name' => 'tst_client',
                'secret' => 'CQ1WXdq6lDx4pqhMnEWN7zvmyszFJsTXEKSlf3X4',
                'redirect' => '',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2020-04-13 15:39:23',
                'updated_at' => '2020-04-13 15:39:23'
            ]);
        DB::table('oauth_access_tokens')
            ->insert([
                'id' => 'c89d44b6ffb6c69a46e78e4fe89cda334cff29962a85ff318e10c76edc7ba4324dcdd703223a25a0',
                'client_id' => 1,
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => '2020-04-13 15:41:20',
                'updated_at' => '2020-04-13 15:41:20',
                'expires_at' => '2020-04-28 15:41:19'
            ]);
    }
}
