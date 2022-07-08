<?php

class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_model');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
{
	$data['current_user'] = $this->auth_model->current_user();

	$this->load->library('pagination');

  $config['base_url'] = site_url('/admin/post');
	$config['page_query_string'] = TRUE;
	//$config['total_rows'] = $this->article_model->count();
	$config['per_page'] = 2; // <-kamu bisa ubah ini

	$this->pagination->initialize($config);
	$limit = $config['per_page'];
	$offset = html_escape($this->input->get('per_page'));

	$data['articles'] = $this->article_model->get($limit, $offset);
		
	$data['keyword'] = $this->input->get('keyword');

	if(!empty($this->input->get('keyword'))){
		$data['articles'] = $this->article_model->search($data['keyword']);
	}
		
	if(count($data['articles']) <= 0 && !$this->input->get('keyword')){
		$this->load->view('admin/post_empty.php', $data);
	} else {
		$this->load->view('admin/post_list.php', $data);
	}
}

	
	public function new()
	{
		$data['current_user'] = $this->auth_model->current_user();
		$this->load->library('form_validation');
		
		$this->load->model('profile_model');//uplod
			// the user id contain dot, so we must remove it
			$file_name1 = str_replace('.','',$data['current_user']->id);
			$file_name2 = str_replace('.','',$data['current_user']->id);
			$file_name3 = str_replace('.','',$data['current_user']->id);
			$config['upload_path']          = FCPATH.'/upload/gambar/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name1']            = $file_name1;
			$config['file_name2']            = $file_name2;
			$config['file_name3']            = $file_name3;
			$config['overwrite']            = true;
			$config['max_size']             = 1024; // 1MB
			$config['max_width']            = 1080;
			$config['max_height']           = 1080;
			$this->load->library('upload', $config); //library upload
			if (!$this->upload->do_upload('pic1','pic2','pic3')) { //do_upload(fieldname)
				$data['error'] = $this->upload->display_errors(); //eor upload
			} else {
				$uploaded_data = $this->upload->data();	 //data upload disimpan dalam array
				$new_data = [
					'foto1' => $uploaded_data['file_name1'],
					'foto2' => $uploaded_data['file_name2'],
					'foto3' => $uploaded_data['file_name3'],
				];
		
				if ($this->profile_model->update_lagi($new_data)) {

					$this->session->set_flashdata('message', 'Avatar updated!');
					redirect(site_url('admin/setting'));
				}
			}






		if ($this->input->method() === 'post') {
			// Lakukan validasi sebelum menyimpan ke model
			$rules = $this->article_model->rules();
			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() === FALSE){
				return $this->load->view('admin/post_new_form.php', $data);
			}

			// generate unique id and slug
			$id = uniqid('', true);
			$slug = url_title($this->input->post('title'), 'dash', TRUE) . '-' . $id;

			$article = [
				'id' => $id,
				'title' => $this->input->post('title'),
				'alamat' => $this->input->post('alamat'),
				'id_kecamatan' => $this->input->post('kec'),
				'latlong' => $this->input->post('latlong'),
				'skor_rating' => $this->input->post('rating'),	
				'harga_tiket' => $this->input->post('htiket'),
				'jenis_id' => $this->input->post('jnwisata'),
				'website' => $this->input->post('nmweb'),					
				'slug' => $slug,
				'content' => $this->input->post('content'),
				'draft' => $this->input->post('draft')
			];

			$saved = $this->article_model->insert($article);

			if ($saved) {
				$this->session->set_flashdata('message', 'Article was created');
				return redirect('admin/post');
			}
		}

		$this->load->view('admin/post_new_form.php', $data);
	}

	public function edit($id = null)
	{
		$data['current_user'] = $this->auth_model->current_user();
		$data['article'] = $this->article_model->find($id);
		$this->load->library('form_validation');

		if (!$data['article'] || !$id) {
			show_404();
		}
		
		if ($this->input->method() === 'post') {
			// lakukan validasi data seblum simpan ke model
			$rules = $this->article_model->rules();
			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() === FALSE){
				return $this->load->view('admin/post_edit_form.php', $data );
			}

			$article = [
				'id' => $id,
				'title' => $this->input->post('title'),
				'alamat' => $this->input->post('alamat'),
				'id_kecamatan' => $this->input->post('kec'),
				'latlong' => $this->input->post('latlong'),
				'skor_rating' => $this->input->post('rating'),	
				'harga_tiket' => $this->input->post('htiket'),
				'jenis_id' => $this->input->post('jnwisata'),
				'website' => $this->input->post('nmweb'),					
				'slug' => $slug,
				'content' => $this->input->post('content'),
				'draft' => $this->input->post('draft')
			];
			$updated = $this->article_model->update($article);
			if ($updated) {
				$this->session->set_flashdata('message', 'Article was updated');
				redirect('admin/post');
			}
		}

		$this->load->view('admin/post_edit_form.php', $data);
	}
	
	public function delete($id = null)
	{
		if (!$id) {
			show_404();
		}

		$deleted = $this->article_model->delete($id);
		if ($deleted) {
			$this->session->set_flashdata('message', 'Article was deleted');
			redirect('admin/post');
		}
	}
}