<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $source = '/home/michael/projetos/arqaparecida_homologa/uploads/';

    public function index(): string
    {
        return view('welcome_message');
    }
}
