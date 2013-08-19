<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NavigViewRight_model extends CI_Model
{
    public $table = 'NavigViewRight';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}public function get_Roles_list(){
		return $this->db->select('RoleId, RoleName')->get('Roles')->result();
	}public function get_Users_list(){
		return $this->db->select('UserId, UserName')->get('Users')->result();
	}
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('NavigViewRight.NavgViewId,Navigations.NavName as Navigations_NavName,NavigViewRight.Navigations,Roles.RoleName as Roles_RoleName,NavigViewRight.Roles,Users.UserName as Users_UserName,NavigViewRight.Users')
			
->join('Navigations', 'NavigViewRight.Navigations = Navigations.NavigationId', 'left outer')
->join('Roles', 'NavigViewRight.Roles = Roles.RoleId', 'left outer')
->join('Users', 'NavigViewRight.Users = Users.UserId', 'left outer');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('NavigViewRight.NavgViewId,Navigations.NavName as Navigations_NavName,NavigViewRight.Navigations,Roles.RoleName as Roles_RoleName,NavigViewRight.Roles,Users.UserName as Users_UserName,NavigViewRight.Users')
		
->join('Navigations', 'NavigViewRight.Navigations = Navigations.NavigationId', 'left outer')
->join('Roles', 'NavigViewRight.Roles = Roles.RoleId', 'left outer')
->join('Users', 'NavigViewRight.Users = Users.UserId', 'left outer');

		if(isset($params->Navigations) && !empty($params->Navigations)){
				$this->db->where("NavigViewRight.Navigations",$params->Navigations);
			}	
if(isset($params->Roles) && !empty($params->Roles)){
				$this->db->where("NavigViewRight.Roles",$params->Roles);
			}	
if(isset($params->Users) && !empty($params->Users)){
				$this->db->where("NavigViewRight.Users",$params->Users);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
->join('Navigations', 'NavigViewRight.Navigations = Navigations.NavigationId', 'left outer')
->join('Roles', 'NavigViewRight.Roles = Roles.RoleId', 'left outer')
->join('Users', 'NavigViewRight.Users = Users.UserId', 'left outer');

		if(isset($params->Navigations) && !empty($params->Navigations)){
				$this->db->where("NavigViewRight.Navigations",$params->Navigations);
			}	
if(isset($params->Roles) && !empty($params->Roles)){
				$this->db->where("NavigViewRight.Roles",$params->Roles);
			}	
if(isset($params->Users) && !empty($params->Users)){
				$this->db->where("NavigViewRight.Users",$params->Users);
			}	

		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where('NavgViewId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('NavgViewId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('NavgViewId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
	
}

?>