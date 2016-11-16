<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Groups extends Acl_controller
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
        $this->set_insert_list(array('insert_group', 'form_insert'));
        $this->set_update_list(array('edit_group', 'form_edit'));
        $this->set_delete_list(array('delete_group'));

        $this->check_access();

        $this->load->model('groups_model');
        $this->load->library('form_validation');
    }

    /**
     * Default Action. Listing group collection
     *
     * @access public
     */
    function index()
    {
        $data['rows'] = $this->groups_model->get_all();

        $template['_B'] = 'groups/groups_view.php';

        $this->load->template_view($this->template_base, $data, $template);

    }

    /**
     * Insert a new group
     *
     * @access public
     * @param
     * @return
     */
    function insert_group()
    {

        $this->form_validation->set_rules('groupname', lang('label_name'), 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {

            $name = $this->input->post('groupname');
            $enable = ((bool)$this->input->post('enablegroup') == FALSE) ? FALSE : TRUE;

            $id = $this->groups_model->insert($name, $enable);

            set_flash_message(lang('msg_insert_group_success'));
            redirect('groups/');
        }

    }

    /**
     * Edit a group data
     *
     * @access public
     * @param
     * @return
     */
    function edit_group()
    {

        $this->form_validation->set_rules('groupname', lang('label_name'), 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $id = $this->input->post('groupid');

        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {

            $name = $this->input->post('groupname');
            $enable = ((bool)$this->input->post('enablegroup') == FALSE) ? FALSE : TRUE;

            $this->groups_model->update_all($id, $name, $enable);

            set_flash_message(lang('msg_update_group_success'));
            redirect('groups/');
        }

    }

    /**
     * delete group
     *
     * @access public
     * @param  int
     * @return
     */
    function delete_group($id = 0)
    {

        if ($this->groups_model->delete($id) == 0) {
            set_flash_message(lang('msg_delete_group_success'), FLASH_MSG_SUCCESS);
        } else
            set_flash_message(lang('msg_delete_group_failure'), FLASH_MSG_ERROR);

        redirect('groups/');
    }

    /**
     * Load insert group form
     *
     * @access public
     * @param
     * @return
     */
    function form_insert()
    {

        $tamplate['_B'] = 'groups/insert_group_view.php';

        $this->load->template_view($this->template_base, $tamplate);

    }

    /**
     * Load edit group form
     *
     * @access public
     * @param
     * @return
     */
    function form_edit($id = 0)
    {

        $data['data'] = $this->groups_model->get_group($id);


        if ($this->session->userdata('nombregrupo') == 'Administrador') {
            $tamplate['_B'] = 'groups/edit_group_view.php';
        } else {
            $tamplate['_B'] = 'groups/groups_view.php';
        }

        $this->load->template_view($this->template_base, $data, $tamplate);
    }
}


?>