<?php


namespace App\Http\ViewComposers;
use App\Models\Menu;
use Illuminate\Contracts\View\View;


class MenuComposer
{
    protected $menus;
    public function __construct()
    {
        $this->menus=Menu::all();
    }

    public function compose(View $view){
        $view->with('menus',$this->menus);
    }
}