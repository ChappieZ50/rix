<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class Pages
{
    public function setHeader($title = '')
    {
        echo "<li class='menu-header'>$title</li>";
    }

    public function setPage($title, $route, $options = [])
    {
        $defaults = [
            'icon'  => '',
            'size'  => 17,
            'class' => '',
            'id'    => ''
        ];
        $options = array_merge($defaults, $options);
        $active = Route::is($route) ? 'class="active"' : null;
        echo "<li $active><a class='nav-link $options[class]' id='$options[id]'' href=' " . route($route) . " '><i class=' $options[icon]' style='font-size: " . $options['size'] . "px;'></i> <span> $title </span></a></li>";
    }

    public function setSubPage($title, $icon, $submenu, $size = 17)
    {
        foreach ($submenu as $sub) {
            if (Route::is($sub[1])) {
                $route = $sub[1];
                break;
            }
        }
        $activeDropdown = isset($route) && Route::is($route) ? 'active' : null;
        $route = '';
        echo "<li class='nav-item dropdown $activeDropdown'>";
        echo "<a href='javascript:;' class='nav-link has-dropdown' data-toggle='dropdown'><i class='$icon' style='font-size: " . $size . "px;'></i> <span>$title</span></a>";
        echo "<ul class='dropdown-menu'>";
        foreach ($submenu as $sub) {
            $active = Route::is($sub[1]) ? "class='active'" : null;
            echo "<li $active><a class='nav-link' href='" . route($sub[1]) . "'>$sub[0]</a></li>";
        }
        echo "</ul>";
        echo "</li>";
    }
}
