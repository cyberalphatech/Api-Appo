<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_menu_item extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = _l('api_x_apps_menu_my_menu_item');
        $this->load->view('my_menu_item/manage', $data);
    }
}
