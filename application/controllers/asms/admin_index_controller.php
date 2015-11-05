<?php


class admin_index_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('/asms/admin_crud_retailer_model');
	}

	function admin_login()
	{
		$this->load->view('/asms/admin/admin_index',$this->load->view('asms/admin/admin_home_header'));
	}

	function admin_home()
	{
		$this->load->view('asms/admin/admin_home',$this->load->view('asms/admin/admin_home_header'));
	}

	function products_gallery()
	{
		$this->load->view('asms/admin/product_gallery',$this->load->view('asms/admin/admin_home_header'));
	}

	function admin_notifications()
	{
		$this->data['posts'] = $this->admin_crud_retailer_model->display_retailer_request(); // calling Post model method getPosts()   		
   		$this->load->view('/asms/admin/admin_notifications',$this->data,$this->load->view('asms/admin/admin_home_header'));
	}

	function disapprove_request()
	{
		if($this->input->post('disapprove'))
		{
			$disapprove=$this->input->post('disapprove');

			$disapprove_change_status=array(
				'status'=>'0'
				);

			$this->admin_crud_retailer_model->disapprove_retailer_request($disapprove,$disapprove_change_status);

			redirect('index.php/asms/admin_index_controller/admin_notifications');
		}

		else if($this->input->post('approve'))
		{
			$approve=$this->input->post('approve');

			$approve_change_status=array(
				'status'=>'1'
				);

			$shop_name=$this->input->post('shop_name');
			$r_username=$this->input->post('rname');

			$r_password=$r_username.'@123';

			$retailer_data=array(
			'rid'=>$this->input->post('approve'),
			'r_username'=>$shop_name.$r_username,
			'r_password'=>$shop_name.'@123',
			'rname'=>$this->input->post('rname'),
			'shop_name'=>$this->input->post('shop_name'),
			'shop_address'=>$this->input->post('shop_address'),
			'contact_number'=>$this->input->post('contact_number'),
			'other_number'=>$this->input->post('other_number'),
			'email_id'=>$this->input->post('email_id'),
			'vat'=>$this->input->post('vat'),
			'vat_date'=>$this->input->post('vat_date'),
			'cst'=>$this->input->post('cst'),
			'cst_date'=>$this->input->post('cst_date')
			);
			//print_r($retailer_data);

			$this->admin_crud_retailer_model->approve_retailer_request($approve,$approve_change_status,$retailer_data);
			redirect('index.php/asms/admin_index_controller/admin_notifications');
		}

		else
		{

		}
	}

	function add_retailer()
	{
		$this->load->view('/asms/admin/add_retailer',$this->load->view('asms/admin/admin_home_header'));
	}

	function admin_add_retailer()
	{
		$retailer_data=array(
			'rname'=>$this->input->post('rname'),
			'shop_name'=>$this->input->post('shop_name'),
			'shop_address'=>$this->input->post('shop_address'),
			'contact_number'=>$this->input->post('contact_number'),
			'other_number'=>$this->input->post('other_number'),
			'email_id'=>$this->input->post('email_id'),
			'vat'=>$this->input->post('vat'),
			'vat_date'=>$this->input->post('vat_date'),
			'cst'=>$this->input->post('cst'),
			'cst_date'=>$this->input->post('cst_date')
			);

	

		$this->admin_crud_retailer_model->admin_crud_retailer_f($retailer_data);
		//redirect("index.php/asms/home/index");

		echo "<script>
		     alert('Succesfully Added New Retailer ..!! ');
		     window.location.href='add_retailer';  
			 </script>";
	}

	function update_retailer()
	{
		$update_retailer_data=array(
			'rid'=>$this->input->post('rid'),
			'rname'=>$this->input->post('rname'),
			'shop_name'=>$this->input->post('shop_name'),
			'shop_address'=>$this->input->post('shop_address'),
			'contact_number'=>$this->input->post('contact_number'),
			'other_number'=>$this->input->post('other_number'),
			'email_id'=>$this->input->post('email_id'),
			'vat'=>$this->input->post('vat'),
			'vat_date'=>$this->input->post('vat_date'),
			'cst'=>$this->input->post('cst'),
			'cst_date'=>$this->input->post('cst_date')
			);

		$this->admin_crud_retailer_model->update_retailer($update_retailer_data);

		//print_r($update_retailer_data);
		echo "<script>
		     alert('Succesfully Updated Retailer Information..!! ');
		     window.location.href='display_retailer';  
			 </script>";
	}

	function admin_update_retailer($id)
	{
		$rid=$id;
		//echo $rid;
		$temp['posts']  = $this->admin_crud_retailer_model->update_retailer_s($rid);	
		
		$this->load->view('/asms/admin/update_retailer', $temp,$this->load->view('asms/admin/admin_home_header'));

	}

	function display_retailer()
	{
		//$this->load->model->('admin_add_retailer');
		$this->data['posts'] = $this->admin_crud_retailer_model->display_approved_retailer(); // calling Post model method getPosts()
   		$this->load->view('/asms/admin/display_retailer', $this->data,$this->load->view('asms/admin/admin_home_header'));
	}

	function delete_retailer()
	{

		$data=$this->input->post('msg');
		
		$this->admin_crud_retailer_model->delete_retailer($data);
				
		echo 
		"<script>
		alert('Succesfully Deleted Retailer..!! ');
		window.location.href='display_retailer';  
		</script>";

	}

	function products()
	{
		$this->load->view('asms/admin/add_products.php',$this->load->view('asms/admin/admin_home_header'));
	}

	function add_products()
	{
		$img_file =$this->input->post('image_url');

		// Read image path, convert to base64 encoding
		$imgData = base64_encode(file_get_contents($img_file));
        
		$add_products_data=array(
			'product_name'=>$this->input->post('pname'),
			'manufacture_name'=>$this->input->post('mname'),
			'car_type'=>$this->input->post('car_type'),
			'product_type'=>$this->input->post('ptype'),
			'description'=>$this->input->post('description'),
			'image_url'=>$imgData,
			'price'=>$this->input->post('price'),
			'quantity'=>$this->input->post('quantity')
						);
		$this->admin_crud_retailer_model->add_products($add_products_data);
		
		echo "<script>
		     alert('Value inserted Successfully!! '); 
			 </script>";
	
		redirect('index.php/asms/admin_index_controller/admin_home');

	}

	function display_products()
	{
		$this->data['posts'] = $this->admin_crud_retailer_model->display_products();
   	
   		$this->load->view('/asms/admin/display_products', $this->data);
	}

	function search_by_date_report()
	{
		$this->load->model('asms/admin_search_by_date_model');

		$search_by_date_data=array(
			'shop_name'=>$this->input->post('shop_name'),
			'from'=>$this->input->post('from'),
			'to'=>$this->input->post('to')
		);

		$this->admin_search_by_date_model->admin_search_by_date_model_f($search_by_date_data);
		$search_by_date_data['products']=$this->admin_search_by_date_model->admin_search_by_date_model_f($search_by_date_data);
		$this->load->view('/asms/admin/admin_search_by_date',$search_by_date_data,$this->load->view('asms/admin/admin_home_header'));
	}
	function subscriber_message()
	{
		$this->load->view('asms/admin/subscriber_message',$this->load->view('asms/admin/admin_home_header'));
	}

	function subscriber_message1()
	{
		$this->load->model('asms/asms_admin_model');

		$subject=$this->input->post('subject_sub');
		$message=$this->input->post('message_sub');

		$this->data[$result]=$this->asms_admin_model->send_message_subscriber();
		echo $this->data[$result];
		/*
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 

		$this->email->from('shivanisurat09@gmail.com','Shivani Enterprise');
		$this->email->to($data);
		$this->email->subject($subject);
		//$emailbody='<h3> Respected Admin , <br> New Retaier Request is Arrived </h3>';
		$this->email->message($message);

		if($this->email->send())
			echo "Successfully Sent An Email To <b> Admin (shivanisurat09@gmail.com) !! </b> <br>";
		else
			show_error($this->email->print_debugger())."\n";
		*/
	}
}
?>