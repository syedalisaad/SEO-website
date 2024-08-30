<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class PageSeeder extends Seeder
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
                'name' => 'About Us',
                'slug' => 'about-us',
                'description' => '',
                'extras' => [
                    'source_header' => null
                ]
            ],
            [
                'name' => 'FAQ\'s',
                'slug' => 'faqs',
                'description' => '',
                'extras' => [
                    'source_header' => null
                ]
            ],
            [
                'name' => 'Refunds Policy',
                'slug' => 'refunds-policy',
                'description' => '',
                'extras' => [
                    'source_header' => null
                ]
            ],
        
            [
                'name' => 'Terms Of Service',
                'slug' => 'terms-of-service',
                'description' => '',
                'extras' => [
                    'source_header' => null
                ]
            ],
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'description' => 'Lorem ipsum',
                'extras' => [
                    'source_header' => null
                ]
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('pages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach( $data as $row)
        {
            DB::table('pages')->insert(
                [
                    'name'        => $row['name'],
                    'slug'        => $row['slug'],
                    'description' => $row['description'],
                    'extras'      => json_encode( $row['extras'] ),
                    'is_lock'     => 1,
                    'is_active'   => 1,
                    'created_at'  => now()
                ]
            );
        }
    }
}
