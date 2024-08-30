<?php namespace App\Support\Traits;
trait PermissionTrait {
    static public $SETTING = [
        'GENERAL'          => 'setting.general',
        'SOCIAL_NETWORK'   => 'setting.social.network',
        'CONTACT_SUPPORT'  => 'setting.contact.support',
        'PAYMENT_GATEWAY'  => 'setting.payment.gateway',
        'FRONTEND_SUPPORT' => 'setting.frontend.support',
        'HOSPITAL_SERVARY' => 'setting.hospital.servay',
        'CHANGE_PASSWORD'  => 'setting.change.password',
        'MEDIA_MANAGER'    => 'setting.media.manager',
    ];
    static public $ROLE = [
        'ADD'    => 'role.add',
        'UPDATE' => 'role.update',
        'DELETE' => 'role.delete',
        'LIST'   => 'role.list'
    ];
    static public $PAGE = [
        'ADD'    => 'page.add',
        'UPDATE' => 'page.update',
        'DELETE' => 'page.delete',
        'LIST'   => 'page.list',
        'ASSIGN' => 'menu.assign'
    ];
    static public $USER = [
        'ADD'        => 'user.add',
        'UPDATE'     => 'user.update',
        'DELETE'     => 'user.delete',
        'LIST'       => 'user.list',
        'VIEW'       => 'user.view',
        'PERMISSION' => 'user.permission',
    ];
    static public $CATEGORY = [
        'ADD'    => 'category.add',
        'UPDATE' => 'category.update',
        'DELETE' => 'category.delete',
        'LIST'   => 'category.list'
    ];
    static public $BLOG = [
        'ADD'    => 'blog.add',
        'UPDATE' => 'blog.update',
        'DELETE' => 'blog.delete',
        'LIST'   => 'blog.list'
    ];
    static public $CONTACT = [
        'LIST'   => 'contact.list',
        'DELETE' => 'contact.delete',
        'VIEW'   => 'contact.view'
    ];
    static public $NEWSLETTER = [
        'LIST'   => 'contact.list',
        'DELETE' => 'contact.delete',
    ];
    static public $PACKAGEPRICE = [
        'ADD'   => 'packageprice.list',
        'show'   => 'packageprice.show',
        'LIST' => 'packageprice.add',
    ];
}
