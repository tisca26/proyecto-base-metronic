<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function generateTree(&$tree, $parentid = 0)
    {
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr');
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

    function generateallTree(&$tree, $parentid = 0)
    {
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr');
        $this->db->where('parentid', $parentid);
        $this->db->order_by('orderr asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                // push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['id']]['children'], $r['id']);
            }
        }
    }

    /*
        * Get all active tree to generate menu as array
        */
    function generateallActiveTreeArray()
    {
        $tree = array();
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr');
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
    function generateallActiveTree(&$tree, $parentid = 0)
    {
        $this->db->select('id,name,shortdesc,status,parentid,page_uri,orderr');
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


    function generateallActiveTreeByUser(&$tree, $userid, $parentid = 0)
    {
        $sql = "select id,name,shortdesc,status,parentid,page_uri,`orderr`, menu.resourceid, acluser.RESOURCEID from menu left join (SELECT acl.RESOURCEID FROM usersgroups ug inner join accesscontrollist acl on ug.GROUPID = acl.TARGETID and acl.TYPEID = 1 inner join resources r on r.ID = acl.RESOURCEID inner join groups g on g.ID = ug.GROUPID where ug.USERID = ? and g.ENABLE = 1 UNION SELECT acl.RESOURCEID from accesscontrollist acl inner join resources r on r.ID = acl.RESOURCEID inner join users u on u.ID = acl.TARGETID where acl.TARGETID = ? and acl.TYPEID = 2 and u.ENABLE = 1 ) acluser on acluser.RESOURCEID = menu.resourceid where parentid = ? and status = 'active' and (acluser.resourceid is not null or menu.resourceid is null) orderr by `orderr`, parentid asc";
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

    function generateTree1(&$tree, $parentid = 0)
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

    function getMenu($id)
    {
        $data = array();
        $options = array('id' => id_clean($id));

        $Q = $this->db->where($options, 1)->get('menu');
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }

        $Q->free_result();
        return $data;
    }

    function getAllMenus()
    {
        // This is used to show menus in home tables
        $data = array();
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllMenusDisplay()
    {
        $data[0] = 'root';
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getMenusNav()
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

    function getMenusDropDown()
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

    function getTopMenus()
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

    function getrootMenus()
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

    function addMenu($name, $shortdesc, $status, $parentid, $order, $page_uri, $resourceId = null)
    {
        $data = array(
            'name' => ($name),
            'shortdesc' => ($shortdesc),
            'status' => ($status),
            'parentid' => ($parentid),
            'orderr' => ($order),
            'page_uri' => ($page_uri)
        );

        if ($resourceId != null) {
            $data['resourceid'] = $resourceId;
        }

        $this->db->insert('menu', $data);
        return $this->identity();
    }

    function updateMenu($id, $name, $shortdesc, $status, $parentid, $order, $page_uri, $resourceId = null, $icon)
    {
        $data = array(
            'name' => db_clean($name),
            'shortdesc' => db_clean($shortdesc),
            'status' => db_clean($status, 8),
            'orderr' => id_clean($order, 10),
            'parentid' => id_clean($parentid),
            'page_uri' => db_clean($page_uri),
            'resourceid' => $resourceId,
            'icon' => $icon,
        );

        $this->db->where('id', id_clean($id));
        $this->db->update('menu', $data);

    }

    function deleteMenu($id)
    {
        // $data = array('status' => 'inactive');
        $this->db->where('id', id_clean($id));
        $this->db->delete('menu');
    }

    function changeMenuStatus($id)
    {
        // getting status of page
        $menuinfo = array();
        $menuinfo = $this->getMenu($id);
        $status = $menuinfo['status'];
        if ($status == 'active') {

            $data = array('status' => 'inactive');
            $this->db->where('id', id_clean($id));
            $this->db->update('menu', $data);

        } else {

            $data = array('status' => 'active');
            $this->db->where('id', id_clean($id));
            $this->db->update('menu', $data);
        }

    }


    function changeMenuOrphansStatus($id)
    {
        $menuinfo = array();
        $menuinfo = $this->getMenu($id);
        $status = $menuinfo['status'];
        if ($status == 'active') {

            $data = array('status' => 'inactive');
            $this->db->where('parentid', id_clean($id));
            $this->db->update('menu', $data);
        }
    }


    function exportCsv()
    {
        $this->load->dbutil();
        $Q = $this->db->query("select * from menu");
        return $this->dbutil->csv_from_result($Q, ",", "\n");
    }

    function checkMenuOrphans($id)
    {
        $data = array();
        $this->db->select('id,name');
        $this->db->where('parentid', id_clean($id));
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;

    }


    function changeMenuOrphansParent($id)
    {
        $data = array('parentid' => '-1');
        $this->db->where('parentid', id_clean($id));
        $this->db->update('menu', $data);
    }

    /**
     * Return last id inserted
     *
     * @access public
     * @return int
     */
    function identity()
    {
        return $this->db->insert_id();
    }

    function generateallActiveTreeArrayByUser($userid)
    {
        $tree = array();

        $sql = 'select id,name,shortdesc,status,parentid,page_uri, menu.orderr, menu.resourceid, acluser.RESOURCEID, icon
                from menu left join
                (SELECT acl.RESOURCEID FROM usersgroups ug
                inner join accesscontrollist acl on ug.GROUPID = acl.TARGETID and acl.TYPEID = 1
                inner join resources r on r.ID = acl.RESOURCEID
                inner join groups g on g.ID = ug.GROUPID
                where ug.USERID = ? and g.ENABLE = 1
                UNION SELECT acl.RESOURCEID
                from accesscontrollist acl
                inner join resources r on r.ID = acl.RESOURCEID
                inner join users u on u.ID = acl.TARGETID
                where acl.TARGETID = ? and acl.TYPEID = 2 and u.ENABLE = 1 ) acluser on acluser.RESOURCEID = menu.resourceid
                where (menu.status = ? and acluser.RESOURCEID is not null or menu.resourceid is null)
                order by parentid asc, menu.orderr asc';
        $query = $this->db->query($sql, array($userid, $userid, 'active'));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $index = (isset($tree[$row->parentid])) ? count($tree[$row->parentid]) : 0;
                $tree[$row->parentid][$index] = $row;
            }
        }

        return $tree;
    }

}
