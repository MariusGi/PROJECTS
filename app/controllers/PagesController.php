<?php

declare(strict_types = 1);

class PagesController extends Controller
{
    public function index()
    {
        $data = [
            'title' => SITENAME,
        ];

        $this->view('pages/index', $data);
    }

    public function scoreboard()
    {
        $data = [
            'title' => 'scoreboard',
        ];

        $this->view('pages/scoreboard', $data);
    }
}
