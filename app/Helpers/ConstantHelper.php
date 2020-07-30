<?php
namespace App\Helper;
class ConstantHelper{
    /************ ROLES ************/
    const LEAD_ROLE = 1;
    const DEVELOPER_ROLE = 2;
    const ADMIN_ROLE = 3;


    public static $roles=[
        self::LEAD_ROLE => "Lead",
        self::DEVELOPER_ROLE => "Developer",
        self::ADMIN_ROLE => "Admin",

    ];

}
