<?php
$_prefixTable = \TestImgApi\TestImgApiServiceProvider::PREFIX_PACKAGE;
return[
    'tables' => [
        'users' => 'users',
        'users_info' => $_prefixTable.'_users_info',
        'positions' => $_prefixTable.'_positions',
        'tokens' => $_prefixTable.'_tokens',
    ],

    'defaultPerPage' => 5,
    'defaultFrontPerPage' => 5,
];
