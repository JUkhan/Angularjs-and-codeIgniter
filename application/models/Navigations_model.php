<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigations_model extends CI_Model
{
    public $table = 'Navigations';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('Navigations.NavigationId,Navigations.NavName,Navigations.NavOrder,Navigations.ActionPath,x.NavName as Navigations_NavName,Navigations.ParentNavId')
			
->join('Navigations as x', 'Navigations.ParentNavId = x.NavigationId', 'left outer');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('Navigations.NavigationId,Navigations.NavName,Navigations.NavOrder,Navigations.ActionPath,x.NavName as Navigations_NavName,Navigations.ParentNavId')
		
->join('Navigations as x', 'Navigations.ParentNavId = x.NavigationId', 'left outer');

		if(isset($params->NavName) && !empty($params->NavName)){
				$this->db->like("Navigations.NavName",$params->NavName);
			}	
if(isset($params->ParentNavId) && !empty($params->ParentNavId)){
				$this->db->where("Navigations.ParentNavId",$params->ParentNavId);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
->join('Navigations as x', 'Navigations.ParentNavId = x.NavigationId', 'left outer');

		if(isset($params->NavName) && !empty($params->NavName)){
				$this->db->like("Navigations.NavName",$params->NavName);
			}	
if(isset($params->ParentNavId) && !empty($params->ParentNavId)){
				$this->db->where("Navigations.ParentNavId",$params->ParentNavId);
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
        return $this->db->where('NavigationId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('NavigationId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('NavigationId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
	
}

?>