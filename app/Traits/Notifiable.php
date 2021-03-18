<?php

namespace  App\Traits;

use App\Components\Message;

trait Notifiable {

    public function getMessage($type, $action = '', $name = '', $text = '')
    {
        $message = new Message($type, $text);
        return $message->getText($action, $name);
    }
}