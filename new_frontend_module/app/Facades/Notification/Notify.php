<?php

namespace App\Facades\Notification;

class Notify
{
    public function info(string $message, string $title = 'Info')
    {

        session()->flash('notify',[
            'type' => 'info',
            'message' => $message,
            'title' => $title
        ]);

    }

    public function success(string $message, string $title = 'Success')
    {

        session()->flash('notify',[
            'type' => 'success',
            'message' => $message,
            'title' => __($title)
        ]);
    }

    public function error(string $message, string $title = 'Error')
    {

        session()->flash('notify',[
            'type' => 'error',
            'message' => $message,
            'title' => __($title)
        ]);
    }

    public function warning(string $message, string $title = 'Warning')
    {

        session()->flash('notify',[
            'type' => 'warning',
            'message' => $message,
            'title' => __($title)
        ]);
    }


}
