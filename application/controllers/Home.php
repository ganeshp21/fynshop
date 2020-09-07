<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	function __construct(){  
			parent::__construct(); 
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation'); 
			$this->load->library('session');
			$this->load->library('pagination');
	}
	 
	public function index()
	{
		$search = $this->input->get('search');
		$where = [];  
		if($search){
			$where['title LIKE'] = '%'.$search.'%'; 
		}

		//echo current_url(); die();
			$per_page =6; 
			$config['base_url'] = current_url().($search?'?search='.$search:''); 
			$config['total_rows'] = $this->db->where($where)->count_all_results('products');
			$config['enable_query_strings'] = true;  
			$config['per_page']             = $per_page;  
			$config['full_tag_open']        = '<ul class="pagination justify-content-center">';
			$config['num_tag_open']         = '<li class="page-item"><span class="page-link">';
			$config['num_tag_close']        = '</span></li>';
			$config['cur_tag_open']         = '<li class="page-item active"><a class="page-link" href="#">';
			$config['cur_tag_close']        = '</a></li>';
			$config['prev_tag_open']        = '<li class="page-item"><span class="page-link">';
			$config['prev_tag_close']       = '</span></li>';
			$config['next_tag_open']        = '<li class="page-item"><span class="page-link">';
			$config['next_tag_close']       = '</span></li>';
			$config['last_tag_open']        = '<li class="page-item"><span class="page-link">';
			$config['last_tag_close']       = '</span></li>';
			$config['first_tag_open']       = '<li class="page-item"><span class="page-link">';
			$config['first_tag_close']      = '</span></li>';
			$config['full_tag_close']       = '</ul>'; 

			$this->pagination->initialize($config);
		
			//echo $limit = $this->config->item('per_page'); die();
		$data = [];  
	


		$start = !empty((int)$this->input->get('per_page'))?(int)$this->input->get('per_page'):0;
		$limit = $per_page;
		$data['products'] = $this->db->where($where)->limit($limit,$start)->get('products')->result();  
		//echo $this->db->last_query();  die();
		$data['pagination'] = $this->pagination->create_links(); 
		$data['title'] = 'All products';  
        $this->load->view('inc/header',$data);  
        $this->load->view('home',$data);
        $this->load->view('inc/footer');  
	}
}
