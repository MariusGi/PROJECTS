<?php

declare(strict_types=1);

session_start();

class SessionHelper
{
    public static function flash(string $name = '', string $message = '', string $bootstrapClass = 'alert alert-success')
    {
        if (empty($name)) {
            return false;
        }

        if (!empty($message) && empty($_SESSION[$name])) {

            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $bootstrapClass;

        } elseif(empty($message) && !empty($_SESSION[$name])) {

            echo '<div class="'.$_SESSION[$name.'_class'].'" id="msg-flash">
                    '. $_SESSION[$name] .'
                  </div>';

            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);

        }
    }
}
