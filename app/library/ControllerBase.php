<?php

namespace app\library;

class ControllerBase
{
    public $view;
    public function __construct(string $pathViewTheme)
    {
        $this->view = new View($pathViewTheme);
    }
}