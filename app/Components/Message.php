<?php


namespace App\Components;


class Message
{
    private string $type ;
    private string $text;

    public  function __construct(string $type, string $text)
    {
        $this->type = $type;
        $this->text = $text;
    }

    public function setType(string $type){
        $this->type = $type;
    }

    public function setText(string $text){
        $this->text = $text;
    }


    public function getText(string $action ,string $name){
        switch ($this->type){
            case __('type_success'):

                if ($action == 'create'){
                    return __('success_create_message', ['name'=>$name]);
                }

                if ($action == 'update'){
                    return __('success_update_message', ['name'=>$name]);
                }

                if ($action == 'delete'){
                    return __('success_delete_message', ['name'=>$name]);
                }

            case __('type_warning'):

                if($action == 'update'){
                    return __('warning_update_message', ['name'=>$name]);
                }

            case __('type_error'):
                return __('error_message');

            default:
                return $this->text;
        }
    }
}