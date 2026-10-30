<?php

return [

    [
        'label' => 'Dashboard',
        'route' => 'home',
        'permission' => 'dashboard.view',
    ],

    [
        'label' => 'Master Data',
        'children' => [
            [
                'label' => 'Users',
                'route' => 'users.index',
                'permission' => 'users.view',
            ],
            [
                'label' => 'Branches',
                'route' => 'branches.index',
                'permission' => 'branches.view',
            ],
        ],
    ],

    [
        'label' => 'Pengaturan',
        'children' => [
            [
                'label' => 'Roles',
                'route' => 'roles.index',
                'permission' => 'roles.view',
            ],
            [
                'label' => 'Permissions',
                'route' => 'permissions.index',
                'permission' => 'permissions.view',
            ],
        ],
    ],

];