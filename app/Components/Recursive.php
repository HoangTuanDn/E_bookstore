<?php

namespace App\Components;

use App\Models\Category;

class Recursive
{
    private $data;
    private $htmlSelect;
    public function __construct()
    {
        $this->htmlSelect = '';
    }

    public function setData($data)
    {
        $this->data = $data;

    }

    public function categoryRecursive( int $parent_id = 0, int $id = 0, string $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                if ($parent_id != 0 &&  $value->id == $parent_id) {
                    $this->htmlSelect .= '<option selected value=' . $value->id . '>' . $text . $value['name'] . "</option>";
                } else {
                    $this->htmlSelect .= '<option value=' . $value->id . '>' . $text . $value['name'] . "</option>";

                }
                $this->categoryRecursive($value->parent_id, $value->id, $text . '--');
            }
        }

        return $this->htmlSelect;
    }

}