<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tokens extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_x_apps/tokens_model');
    }

    public function index()
    {
        if (!has_permission('api_x_apps_tokens', '', 'view')) {
            access_denied('api_x_apps_tokens');
        }

        $data['title'] = _l('api_x_apps_tokens');
        $this->load->view('tokens/manage', $data);
    }

    public function table()
    {
        if (!has_permission('api_x_apps_tokens', '', 'view')) {
            ajax_access_denied();
        }
        $this->app->get_table_data(module_views_path('api_x_apps', 'tables/tokens_table'));
    }

    public function manage()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($data['id'] == '') {
                if (!has_permission('api_x_apps_tokens', '', 'create')) {
                    access_denied('api_x_apps_tokens');
                }
                $id      = $this->tokens_model->add($data);
                $message = $id ? _l('added_successfully', _l('api_x_apps_token')) : '';
                echo json_encode(['success' => $id ? true : false, 'message' => $message]);
            } else {
                if (!has_permission('api_x_apps_tokens', '', 'edit')) {
                    access_denied('api_x_apps_tokens');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->tokens_model->update($data, $id);
                $message = $success ? _l('updated_successfully', _l('api_x_apps_token')) : '';
                echo json_encode(['success' => $success, 'message' => $message]);
            }
        }
    }

    public function delete($id)
    {
        if (!has_permission('api_x_apps_tokens', '', 'delete')) {
            access_denied('api_x_apps_tokens');
        }
        if (!$id) {
            redirect(admin_url('api_x_apps/tokens'));
        }
        $response = $this->tokens_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('api_x_apps_token')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('api_x_apps_token')));
        }
        redirect(admin_url('api_x_apps/tokens'));
    }
}
