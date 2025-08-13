<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu = [
            [
                'title' => 'Dashboard',
                'route' => 'admin.dashboard',
            ],
            [
                'title' => 'Users',
                'route' => 'admin.users.index',
            ],
            [
                'title' => 'دریافت تحلیل',
                'route' => 'admin.get-analysis',
            ]
        ];

        foreach ($menu as &$menu_item) {
            $menu_item['title'] = __($menu_item['title']);
            $menu_item['highlight'] = Route::currentRouteName() == $menu_item['route'];
            $menu_item['route'] = route($menu_item['route']);
        }
        return view('components.admin-layout', compact('menu'));
    }
}
