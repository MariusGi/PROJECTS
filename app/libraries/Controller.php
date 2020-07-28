<?php

declare(strict_types = 1);

/*
 * Base Controller
 * Loads models and views
 */

class Controller
{
    // Load model
    public function model(string $model)
    {
        // Require model file
        require_once '../app/models/'.$model.'.php';

        // Instantiate model
        return new $model();
    }

    // Load view
    public function view(string $view, array $data = [])
    {
        // Check for the view file
        if (file_exists('../app/views/'.$view.'.php')) {
            require_once '../app/views/'.$view.'.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
}
