<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keys extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_x_apps/keys_model');
    }

    public function index()
    {
        if (!has_permission('api_x_apps_keys', '', 'view')) {
            access_denied('api_x_apps_keys');
        }

        $data['title'] = _l('api_x_apps_keys');
        $this->load->view('keys/manage', $data);
    }

    public function table()
    {
        if (!has_permission('api_x_apps_keys', '', 'view')) {
            ajax_access_denied();
        }
        $this->app->get_table_data(module_views_path('api_x_apps', 'tables/keys_table'));
    }

    public function manage()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($data['id'] == '') {
                if (!has_permission('api_x_apps_keys', '', 'create')) {
                    access_denied('api_x_apps_keys');
                }
                $id      = $this->keys_model->add($data);
                $message = $id ? _l('added_successfully', _l('api_x_apps_key')) : '';
                echo json_encode(['success' => $id ? true : false, 'message' => $message]);
            } else {
                if (!has_permission('api_x_apps_keys', '', 'edit')) {
                    access_denied('api_x_apps_keys');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->keys_model->update($data, $id);
                $message = $success ? _l('updated_successfully', _l('api_x_apps_key')) : '';
                echo json_encode(['success' => $success, 'message' => $message]);
            }
        }
    }

    public function delete($id)
    {
        if (!has_permission('api_x_apps_keys', '', 'delete')) {
            access_denied('api_x_apps_keys');
        }
        if (!$id) {
            redirect(admin_url('api_x_apps/keys'));
        }
        $response = $this->keys_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('api_x_apps_key')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('api_x_apps_key')));
        }
        redirect(admin_url('api_x_apps/keys'));
    }
}
