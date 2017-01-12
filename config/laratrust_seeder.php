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
            'cat_status_raw' => 'u',
            'cat_status_cat' => 'u',
            'cat_status_qa' => 'u',
            'cat_status_lock' => 'u',
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
            'cat_status_raw' => 'u',
            'cat_status_cat' => 'u',
            'cat_status_qa' => 'u',
            'cat_status_lock' => 'u',
        ],
        'cataloguer' => [
            'profile' => 'r,u'
        ],
        'khoerodin' => [
            'profile' => 'r',
            'cat_status_raw' => 'u',
            'cat_status_cat' => 'u',
        ]
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];
