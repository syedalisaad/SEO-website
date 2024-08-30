<?php
# config/module.php
return [
    'modules' => [
        'General', //Default
        'Dashboard',
        'User',
        'HospitalSurvey',
        'Page',
        'Newsletter',
        'Contact',
        'Order',
        'Setting',
        'Post',
        'ApiJob',
        'PackagePrice',
        'Blog',
    ],
    'default' => [
        'General/resources/views/admin/master.blade.php',
        'General/resources/views/frontend/master.blade.php'
    ]
];
