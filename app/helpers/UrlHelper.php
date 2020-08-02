<?php

declare(strict_types = 1);

class UrlHelper
{
    public static function redirect(string $page)
    {
        header('location: ' .URLROOT.'/'.$page);
    }
}