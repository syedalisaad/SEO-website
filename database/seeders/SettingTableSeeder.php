<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = array(
            'sites' => array(
                'site_name'      => 'Good Hospital Bad Hospital',
                'site_logo'      => '',
                'site_favicon'   => '',
                'email_info'     => 'info@goodhospitalbadhospital.com',
                'email_support'  => 'support@goodhospitalbadhospital.com',
                'email_no_reply' => 'no-reply@goodhospitalbadhospital.com',
                'footer_about'   => 'Lorem ipsum lorem ipsum lorem ipsum lorem ipsum',
                'footer_text'    => 'Copyright 2021 Good Hospital Bad Hospital all right reserved',
            ),
            'contact_support' => array(
                'address'           => '',
                'contact_number'    => '',
                'fax_number'        => '',
                'contact_email'     => '',
            ),
            'frontend_support' => array(
                'frontend_video_box_1' => '',
                'frontend_video_box_2' => '',
            ),
            'payment_gateway' => array(
                'stripe' => ['client_id' => '', 'client_secret' => '', 'sandbox_mode' => 'sandbox'],
            ),
            'social_links' => array(
                'facebook'  => '//www.facebook.com',
                'twitter'   => '//www.twitter.com',
                'instagram' => '//www.instagram.com',
                'youtube'   => '//www.youtube.com',
            ),
            'seo_metadata' => array(
                'meta_title'        => '',
                'meta_keywords'     => '',
                'meta_desc'         => '',
                'schema_breadcrumb' => '',
                'schema_faq'        => '',
                'schema_sitelinks'  => '',
           ),
            'developers' => array(
                'version' => '1.0.0', //Major, Minor, Bugs
           ),
        );

        \DB::table('settings')->truncate();

        foreach ( $settings as $key => $value )
        {
            \DB::table('settings')->insert([
                'key' 		=> $key,
                'value' 	=> json_encode( $value )
            ]);
        }
    }
}
