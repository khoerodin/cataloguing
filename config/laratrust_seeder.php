<?php

return [
    'role_structure' => [
        'superadmin' => [
            'accounts_page' => 'r',
            'users' => 'c,r,u,d',
            'role_user' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permission_role' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
        ],
        'admin' => [
            'accounts_page' => 'r',
            'users' => 'c,r,u,d',
            'role_user' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permission_role' => 'c,r,u,d',
            'permissions' => 'r',
        ],
        'seniorcataloguer' => [
            'profile' => 'r,u',
        ],
        'cataloguer' => [
            'profile' => 'r,u'
        ],
        'khoerodin' => [
            'profile' => 'r',
        ]
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
