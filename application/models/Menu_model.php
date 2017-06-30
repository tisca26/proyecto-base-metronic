<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ultimo_id()
    {
        return $this->db->insert_id();
    }

    public function error_consulta()
    {
        return $this->db->error();
    }

    public function generateTree(&$tree, $parentid = 0)
    {
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr, icon');
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 'active');
        $this->db->order_by('orderr asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                // push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateTree($tree[$r['id']]['children'], $r['id']);
            }
        }
    }

    /*
     * Uso en Menu Controller
     */
    public function generateallTree(&$tree, $parentid = 0)
    {
        $this->db->where('parent_id', $parentid);
        $this->db->order_by('orden asc, parent_id asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {
                // push found result onto existing tree
                $tree[$r['menu_id']] = $r;
                // create placeholder for children
                $tree[$r['menu_id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['menu_id']]['children'], $r['menu_id']);
            }
        }
    }

    public function generateallActiveTreeArray()
    {
        $tree = array();
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr, icon');
        $this->db->where('status', 'active');
        $this->db->order_by('parentid asc, orderr asc');
        $query = $this->db->get('menu');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $index = (isset($tree[$row->parentid])) ? count($tree[$row->parentid]) : 0;
                $tree[$row->parentid][$index] = $row;
            }
        }

        return $tree;
    }

    /*
    * Get all active tree to generate menu using recursive method
    */
    public function generateallActiveTree(&$tree, $parentid = 0)
    {
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr, icon');
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 'active');
        $this->db->order_by('orderr asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                // push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallActiveTree($tree[$r['id']]['children'], $r['id']);
            }
        }
    }

    public function generateallActiveTreeByUser(&$tree, $userid, $parentid = 0)
    {
        $sql = "select id,name,shortdesc,status,parentid,page_uri,orderr, menu.resourceid, acluser.RESOURCEID, icon from menu left join (SELECT acl.RESOURCEID FROM usersgroups ug inner join accesscontrollist acl on ug.GROUPID = acl.TARGETID and acl.TYPEID = 1 inner join resources r on r.ID = acl.RESOURCEID inner join groups g on g.ID = ug.GROUPID where ug.USERID = ? and g.ENABLE = 1 UNION SELECT acl.RESOURCEID from accesscontrollist acl inner join resources r on r.ID = acl.RESOURCEID inner join users u on u.ID = acl.TARGETID where acl.TARGETID = ? and acl.TYPEID = 2 and u.ENABLE = 1 ) acluser on acluser.RESOURCEID = menu.resourceid where parentid = ? and status = 'active' and (acluser.resourceid is not null or menu.resourceid is null) orderr by `orderr`, parentid asc";
        $res = $this->db->query($sql, array($userid, $userid, $parentid));
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                // push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallActiveTreeByUser($tree[$r['id']]['children'], $userid, $r['id']);
            }
        }
    }

    public function generateTree1(&$tree, $parentid = 0)
    {
        $this->db->join('omc_page', 'menu.id = omc_page.menu_id');
        $this->db->where('parentid', $parentid);
        $this->db->order_by('orderr asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {
                $tree[$r['id']] = $r;
                $tree[$r['id']]['children'] = array();
                $this->generateTree($tree[$r['id']]['children'], $r['id']);
            }
        }
    }

    /*
     * Uso en Menu Controller
     */
    public function menu_por_id($id = 0)
    {
        $data = null;
        $Q = $this->db->where('menu_id', $id)->get('menu');
        if ($Q->num_rows() > 0) {
            $data = $Q->row();
        }
        $Q->free_result();
        return $data;
    }

    public function getAllMenus()
    {
        $data = array();
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            $data = $Q->result();
        }
        $Q->free_result();
        return $data;
    }

    /*
     * Uso en Menu Controller
     */
    public function getAllMenusDisplay()
    {
        $data[0] = 'root';
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['nombre'];
            }
        }
        $Q->free_result();
        return $data;
    }

    public function getMenusNav()
    {
        $data = array();
        $this->db->select('id,name,parentid');
        $this->db->where('status', 'active');
        $this->db->orderby('parentid', 'asc');
        $this->db->orderby('name', 'asc');
        $this->db->groupby('parentid,id');
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                if ($row->parentid > 0) {
                    $data[0][$row->parentid]['children'][$row->id] = $row->name;
                } else {
                    $data[0][$row->id]['name'] = $row->name;
                }
            }
        }
        $Q->free_result();
        return $data;
    }

    public function getMenusDropDown()
    {
        $data = array();
        $this->db->select('id,name');
        $this->db->where('parentid !=', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    public function getTopMenus()
    {
        $data[0] = 'root';
        $this->db->where('parentid', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    public function getrootMenus()
    {
        $this->db->where('parentid', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    /*
     * Uso en Menu Controller
     */
    public function insertar($menu = array())
    {
        return $this->db->insert('menu', $menu);
    }

    /*
     * Uso en Menu Controller
     */
    public function editar($menu = array())
    {
        return $this->db->update('menu', $menu, array('menu_id' => $menu['menu_id']));
    }

    /*
     * Uso en Menu Controller
     */
    public function borrar($menu = array())
    {
        return $this->db->delete('menu', $menu);
    }

    /*
     * Uso en Menu Controller
     */
    public function changeMenuStatus($id = 0)
    {
        $menuinfo = $this->menu_por_id($id);
        if ($menuinfo->estatus == '1') {
            return $this->db->update('menu', array('estatus' => '0'), array('menu_id' => $id));
        } else {
            return $this->db->update('menu', array('estatus' => '1'), array('menu_id' => $id));
        }
    }

    /*
     * Uso en Menu Controller
     */
    public function changeMenuOrphansStatus($id = 0)
    {
        $menuinfo = $this->menu_por_id($id);
        if ($menuinfo->estatus == '1') {
            return $this->db->update('menu', array('estatus' => '0'), array('parent_id' => $id));
        }
        return true;
    }

    /*
     * Uso en Menu Controller
     */
    public function checkMenuOrphans($id = 0)
    {
        $data = array();
        $this->db->select('menu_id, nombre');
        $this->db->where('parent_id', $id);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            $data = $Q->result();
        }
        return $data;
    }

    /*
     * Uso en Menu Controller
     */
    public function changeMenuOrphansParent($id = 0)
    {
        $data = array('parent_id' => '-1');
        $this->db->where('parent_id', $id);
        return $this->db->update('menu', $data);
    }

    /*
     * Uso en Menu Controller
     */
    public function revertChangeMenuOrphansParent($id = 0, $orphans = array())
    {
        $last = '';
        foreach ($orphans as $orphan) {
            $data = array('parent_id' => $id);
            $this->db->where('menu_id', $orphan->id);
            $last = $this->db->update('menu', $data);
        }
        return $last;
    }

    /*
     * Uso en Menu manager
     */
    public function generateallActiveTreeArrayByUser($userid)
    {
        $tree = array();
        $sql = 'select menu.*, acluser.RESOURCEID
                from menu left join
                (SELECT acl.RESOURCEID FROM usersgroups ug
                inner join accesscontrollist acl on ug.groups_id = acl.TARGETID and acl.TYPEID = 1
                inner join resources r on r.resources_id = acl.RESOURCEID
                inner join groups g on g.groups_id = ug.groups_id
                where ug.usuarios_id = ? and g.estatus = 1
                UNION SELECT acl.RESOURCEID
                from accesscontrollist acl
                inner join resources r on r.resources_id = acl.RESOURCEID
                inner join usuarios u on u.usuarios_id = acl.TARGETID
                where acl.TARGETID = ? and acl.TYPEID = 2 and u.estatus = 1 ) acluser on acluser.RESOURCEID = menu.resource_id
                where (menu.estatus = ? and acluser.RESOURCEID is not null or menu.resource_id is null)
                order by menu.parent_id asc, menu.orden asc';
        $query = $this->db->query($sql, array($userid, $userid, 1));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $index = (isset($tree[$row->parent_id])) ? count($tree[$row->parent_id]) : 0;
                $tree[$row->parent_id][$index] = $row;
            }
        }
        return $tree;
    }
}