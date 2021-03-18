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

    public function categoryRecursive( int $selected_id = 0, int $id = 0, string $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                if ($selected_id != 0 &&  $value->id == $selected_id) {
                    $this->htmlSelect .= '<option selected value=' . $value->id . '>' . $text . $value['name'] . "</option>";
                } else {
                    $this->htmlSelect .= '<option value=' . $value->id . '>' . $text . $value['name'] . "</option>";

                }
                $this->categoryRecursive($selected_id, $value->id, $text . '--');
            }
        }

        return $this->htmlSelect;
    }

    public function categoryMultipleSelectRecursive($selected_id, int $id = 0, string $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                if (in_array($value->id, $selected_id )) {
                    $this->htmlSelect .= '<option selected value=' . $value->id . '>' . $text . $value['name'] . "</option>";
                } else {
                    $this->htmlSelect .= '<option value=' . $value->id . '>' . $text . $value['name'] . "</option>";

                }
                $this->categoryMultipleSelectRecursive($selected_id, $value->id, $text . '--');
            }
        }

        return $this->htmlSelect;
    }

}