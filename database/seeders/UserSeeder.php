<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'first_name' => 'Administrator',
                'last_name'  => 'Account',
                'email'      => 'admin@mailinator.com',
                'password'   => 'system@786',
                'user_type'  => 0,
            ],
            [
                'first_name' => 'Koderlabs',
                'last_name'  => 'Account',
                'email'      => 'admin@koderlabs.com',
                'password'   => 'welcome@123',
                'user_type'  => 0,
            ],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            \DB::table('user_details')->truncate();
            \DB::table('users')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach( $data as $row)
        {
            \DB::table('users')->insert(
                [
                    'first_name'    => $row['first_name'],
                    'last_name'     => $row['last_name'],
                    'email'         => $row['email'],
                    'password'      => bcrypt($row['password']),
                    'phone'         => '000-000-000',
                    'user_type'     => 0,
                    'is_active'     => 1,
                    'email_verified_at' => now(),
                    'remember_token'    => \Str::random(10),
                    'created_at'        => now()
                ]
            );
        }
    }
}
