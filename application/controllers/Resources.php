<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Resources extends Acl_controller
{

    private $template_base = 'index';

    /**
     * Constructor
     *
     * @access public
     */
    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insert_resource', 'form_insert'));
        $this->set_update_list(array('edit_resource', 'form_edit'));
        $this->set_delete_list(array('delete_resource'));

        $this->check_access();

        $this->load->model('resources_model');
        $this->load->library('form_validation');
    }

    /**
     * Default Action. Listing group collection
     *
     * @access public
     */
    function index()
    {
        $data['rows'] = $this->resources_model->get_all();

        $template['_B'] = 'resources/resources_view.php';

        $this->load->template_view($this->template_base, $data, $template);

    }

    /**
     * Insert a new resource
     *
     * @access public
     * @param
     * @return
     */
    function insert_resource()
    {

        $this->form_validation->set_rules('resourcename', lang('label_name'), 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {

            $name = $this->input->post('resourcename');
            $id = $this->resources_model->insert($name);

            set_flash_message(lang('msg_insert_resource_success'));
            redirect('resources/');
        }

    }

    /**
     * Edit a resource data
     *
     * @access public
     * @param
     * @return
     */
    function edit_resource()
    {

        $this->form_validation->set_rules('resourcename', lang('label_name'), 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $id = $this->input->post('resourceid');

        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {

            $name = $this->input->post('resourcename');

            $this->resources_model->update($id, $name);

            set_flash_message(lang('msg_update_resource_success'));
            redirect('resources/');
        }

    }

    /**
     * delete resource
     *
     * @access public
     * @param  int
     * @return
     */
    function delete_resource($id = 0)
    {

        $this->resources_model->delete($id);

        set_flash_message(lang('msg_delete_resource_success'));
        redirect('resources/');
    }

    /**
     * Load insert resource form
     *
     * @access public
     * @param
     * @return
     */
    function form_insert()
    {
        $tamplate['_B'] = 'resources/insert_resource_view.php';

        $this->load->template_view($this->template_base, $tamplate);
    }

    /**
     * Load edit resource form
     *
     * @access public
     * @param
     * @return
     */
    function form_edit($id = 0)
    {

        $data['data'] = $this->resources_model->get_resource($id);
        $tamplate['_B'] = 'resources/edit_resource_view.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }
}


?>