<?php

return [
    [
        'text' => 'menu.home',
        'icon' => 'fa fa-dashboard',
        'route' => 'home.index',
    ],
    [
        'text' => 'Users',
        'icon' => 'fa fa-users',
        'children' => [
            [
                'text' => 'List Users',
                'route' => 'user.index',
                'icon' => 'fa fa-users',
                //                'permissions' => ['list users'],
            ],
            [
                'text' => 'Create User',
                'route' => 'user.create',
                'icon' => 'fa fa-users',
                //                'permissions' => ['list users'],
            ],
            [
                'text' => 'RolePermission User',
                'route' => 'rolepermission.index',
                'icon' => 'fa fa-users',
                //                'permissions' => ['list users'],
            ],
        ],
    ],
    [
        'text' => 'Posts',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'List categorypost',
                'route' => 'categorypost.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
            [
                'text' => 'List Posts',
                'route' => 'post.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
            [
                'text' => 'List postcomment',
                'route' => 'postcomment.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Demo',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'List Demo',
                'route' => 'demo.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
            [
                'text' => 'Create Demo',
                'route' => 'demo.create',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Room',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'List Room',
                'route' => 'room.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
            [
                'text' => 'Create Room',
                'route' => 'room.create',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Menu',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'List menu',
                'route' => 'menu.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
            [
                'text' => 'Create menu',
                'route' => 'menu.create',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Seo',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'Seo',
                'route' => 'seo.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Contact',
        'icon' => 'fa fa-book',
        'children' => [
            [
                'text' => 'List contact',
                'route' => 'contact.index',
                'icon' => 'fa fa-book',
                //                'permissions' => ['list posts'],
            ],
        ],
    ],
    [
        'text' => 'Redirect link',
        'route' => 'redirect.index',
        'icon' => 'fa fa-circle-o text-blue',
    ],
    [
        'text' => 'Log',
        'route' => 'log.index',
        'icon' => 'fa fa-circle-o text-blue',
    ],
    [
        'text' => 'Configures',
        'route' => 'configure.index',
        'icon' => 'fa fa-circle-o text-green',
    ],
    [
        'text' => 'Translate language',
        'route' => 'langcustom.index',
        'icon' => 'fa fa-circle-o text-yellow',
    ]
    // Thêm các mục menu khác tương tự
];
