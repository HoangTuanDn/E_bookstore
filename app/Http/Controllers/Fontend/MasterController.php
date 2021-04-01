<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class MasterController extends Controller
{
    public function index(View $view){
        $menus = Menu::all();
        $categories = Category::get(['name', 'slug']);
        $collectionParentMenus = $menus->where('parent_id', 0);
        $parentMenus = [];
        $categoryMatchSlug = [];
        $menuGroups = [];
        $data = session('cart');
        $totalItemCart =  empty($data) ? 0 : count($data);


        foreach ($categories as $category){
            $categoryMatchSlug [$category->name] = $category->slug;
        }

        foreach ($menus as $menu){
            if ($menu->parent_id == 0){
                $menuGroups[$menu->id] = [];
            }
            if (isset($menuGroups[$menu->parent_id]) && array_key_exists($menu->name, $categoryMatchSlug)){
                $menuGroups[$menu->parent_id] [] = [
                    'name' => $menu->name,
                    'href' => route('home.shop',['category' => $categoryMatchSlug[$menu->name]])
                ];
            }
        }

        foreach ($collectionParentMenus as $collectionParentMenu){
            if (isset($menuGroups[$collectionParentMenu->id])){
                $parentMenus[$collectionParentMenu->name] = $menuGroups[$collectionParentMenu->id];
            }
        }

        $view->with(['parentMenus' => $parentMenus, 'totalItemCart' => $totalItemCart]);

    }
}
