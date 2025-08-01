<?php

namespace App\Helpers;

class SectionHelper
{
    public static function name()
    {
        if (in_array(\Illuminate\Support\Facades\Request::host(), ['admin.portalogy.test', 'admin.portalogy.me'])) return 'admin';
        return 'site';
    }

    public static function is($name)
    {
        return self::name() == $name;
    }
}
