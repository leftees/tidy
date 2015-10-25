<?php

namespace Tidy\Http\Controllers;

use Illuminate\Http\Request;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;

class MenuController extends Controller
{
    
    public function menuItems()
    {
//        $user = $this->getUser();
//        
        // Check against user permissions to see what menu items should be loaded
        $menu = [
            [
                'divider' => false,
                'subheader' => 'Profile',
                'items' => [
                    ['icon' => 'settings','title' => 'First link'],
                    ['icon' => 'settings','title' => 'Second link'],
                ]
            ],
            [
                'divider' => true,
                'subheader' => 'Admin',
                'items' => [
                    ['icon' => 'settings','title' => 'First link'],
                    ['icon' => 'settings','title' => 'Second link'],
                ]
            ]
        ];
        
        
        return response()->json(compact('menu'));
    }
    
}
