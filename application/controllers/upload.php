<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index(){
		$val = $this->input->get('val');
        $type = $this->input->get('type');
		$this->load->view('upload_view', array('error' => ' ', 'val' => $val ,  'type' => $type));
	}
    
   function do_upload()
	{
        $type = $this->input->post('type');
        if ( $type == "photo") {
			$path = "/upload/photo";
		}
        else {
			$path = "/upload/";
   		}

		$config['upload_path'] = ".$path";
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000';
		$config['max_width']  = '1000';
		$config['max_height']  = '2000';
		$val = $this->input->post('val');
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('upload_view', $error);
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->data();
			$file_name = $file['file_name'];
			echo "<script>
			window.opener.document.getElementById('$val').value = '$file_name';
			window.close();
			</script>  
			";
		}
	}	

}
