<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class Pages
{
    /* public function setPage($title, $route, $icon = '')
     {
         $this->single[] = [
             'title'  => $title,
             'route'  => $route,
             'icon'   => $icon,
             'href'   => route($route),
             'active' => Route::is($route) ? 'class="active"' : null
         ];
         return $this;
     }

     public function setSubPage($title, $icon, $submenu)
     {
         $this->multiple[] = [
             'title'   => $title,
             'icon'    => $icon,
             'submenu' => $submenu,
         ];
         return $this;
     }

     public function renderPages()
     {
         if (!empty($this->single)) {
             $single = $this->single;
             foreach ($single as $value) {
                 echo "<li $value[active]><a class='nav-link' href=' $value[href] '><i class=' $value[icon]'></i> <span> $value[title] </span></a></li>";
             }
         }
         if (!empty($this->multiple)) {
             $multiple = $this->multiple;
             foreach ($multiple as $value) {
                 foreach($value['submenu'] as $submenu){
                     if(Route::is($submenu[1])){
                         $route = $submenu[1];
                         break;
                     }
                 }
                 $activeDropdown =  isset($route) && Route::is($route) ? 'active' : null;
                 $route = '';
                 echo "<li class='nav-item dropdown $activeDropdown'>";
                 echo "<a href='javascript:;' class='nav-link has-dropdown' data-toggle='dropdown'><i class='$value[icon]' style='font-size: 17px;'></i> <span>$value[title]</span></a>";
                 echo "<ul class='dropdown-menu'>";
                 foreach ($value['submenu'] as $sub) {
                     $active = Route::is($sub[1]) ? "class='active'" : null;
                     echo "<li $active><a class='nav-link' href='" . route($sub[1]) . "'>$sub[0]</a></li>";
                 }
                 echo "</ul>";
                 echo "</li>";
             }
         }
         return null;
     }*/
    public function setHeader($title = '')
    {
        echo "<li class='menu-header'>$title</li>";
    }

    public function setPage($title, $route, $icon = '')
    {
        $active = Route::is($route) ? 'class="active"' : null;
        echo "<li $active><a class='nav-link' href=' " . route($route) . " '><i class=' $icon'></i> <span> $title </span></a></li>";
    }

    public function setSubPage($title, $icon, $submenu)
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
        echo "<a href='javascript:;' class='nav-link has-dropdown' data-toggle='dropdown'><i class='$icon' style='font-size: 17px;'></i> <span>$title</span></a>";
        echo "<ul class='dropdown-menu'>";
        foreach ($submenu as $sub) {
            $active = Route::is($sub[1]) ? "class='active'" : null;
            echo "<li $active><a class='nav-link' href='" . route($sub[1]) . "'>$sub[0]</a></li>";
        }
        echo "</ul>";
        echo "</li>";
    }
}
