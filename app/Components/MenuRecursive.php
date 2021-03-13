<?php


namespace App\Components;


use App\Models\Menu;

class MenuRecursive
{
    private string $html;
    private $menus;

    public function __construct(Menu $menus)
    {
        $this->menus = $menus;
        $this->html = '';
    }

    public function menuRecursiveAdd(int $parent_id = 0, string $subMark = '')
    {
        $data = $this->menus->where('parent_id', $parent_id)->get(['id', 'name', 'parent_id']);
        foreach ($data as $value) {
            $this->html .= '<option value="' . $value->id . '"> ' . $subMark . $value->name . '</option>';
            $this->menuRecursiveAdd($value->id, $subMark . '--');
        }

        return $this->html;

    }

    public function menuRecursiveEdit($current_parent_id, $parent_id = 0, $subMark = '')
    {
        $data = $this->menus->where('parent_id', $parent_id)->get(['id', 'name', 'parent_id']);
        foreach ($data as $value) {
            if ($current_parent_id == $value->id) {
                $this->html .= '<option selected value="' . $value->id . '"> ' . $subMark . $value->name . '</option>';
            } else {
                $this->html .= '<option value="' . $value->id . '"> ' . $subMark . $value->name . '</option>';
            }

            $this->menuRecursiveAdd($value->id, $subMark . '--');
        }

        return $this->html;
    }

}