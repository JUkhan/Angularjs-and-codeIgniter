<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public $table = 'Users';

	public function get_Roles_list(){
		return $this->db->select('RoleId, RoleName')->get('Roles')->result();
	}public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('Users.UserId,Users.UserName,Users.Password,Users.FirstName,Users.LastName,Users.Email,Roles.RoleName as Roles_RoleName,Users.Role,Navigations.NavName as Navigations_NavName,Users.NavigationId,Users.IsActive')
			
->join('Roles', 'Users.Role = Roles.RoleId', 'left outer')
->join('Navigations', 'Users.NavigationId = Navigations.NavigationId', 'left outer');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('Users.UserId,Users.UserName,Users.Password,Users.FirstName,Users.LastName,Users.Email,Roles.RoleName as Roles_RoleName,Users.Role,Navigations.NavName as Navigations_NavName,Users.NavigationId,Users.IsActive')
		
->join('Roles', 'Users.Role = Roles.RoleId', 'left outer')
->join('Navigations', 'Users.NavigationId = Navigations.NavigationId', 'left outer');

		if(isset($params->UserName) && !empty($params->UserName)){
				$this->db->like("Users.UserName",$params->UserName);
			}	
if(isset($params->FirstName) && !empty($params->FirstName)){
				$this->db->like("Users.FirstName",$params->FirstName);
			}	
if(isset($params->LastName) && !empty($params->LastName)){
				$this->db->like("Users.LastName",$params->LastName);
			}	
if(isset($params->Email) && !empty($params->Email)){
				$this->db->like("Users.Email",$params->Email);
			}	
if(isset($params->Role) && !empty($params->Role)){
				$this->db->where("Users.Role",$params->Role);
			}	
if(isset($params->NavigationId) && !empty($params->NavigationId)){
				$this->db->where("Users.NavigationId",$params->NavigationId);
			}	
if(isset($params->IsActive) && !empty($params->IsActive)){
				$this->db->where("Users.IsActive",$params->IsActive);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
->join('Roles', 'Users.Role = Roles.RoleId', 'left outer')
->join('Navigations', 'Users.NavigationId = Navigations.NavigationId', 'left outer');

		if(isset($params->UserName) && !empty($params->UserName)){
				$this->db->like("Users.UserName",$params->UserName);
			}	
if(isset($params->FirstName) && !empty($params->FirstName)){
				$this->db->like("Users.FirstName",$params->FirstName);
			}	
if(isset($params->LastName) && !empty($params->LastName)){
				$this->db->like("Users.LastName",$params->LastName);
			}	
if(isset($params->Email) && !empty($params->Email)){
				$this->db->like("Users.Email",$params->Email);
			}	
if(isset($params->Role) && !empty($params->Role)){
				$this->db->where("Users.Role",$params->Role);
			}	
if(isset($params->NavigationId) && !empty($params->NavigationId)){
				$this->db->where("Users.NavigationId",$params->NavigationId);
			}	
if(isset($params->IsActive) && !empty($params->IsActive)){
				$this->db->where("Users.IsActive",$params->IsActive);
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
        return $this->db->where('UserId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('UserId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('UserId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
	
}

?>