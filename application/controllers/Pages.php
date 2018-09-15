<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index($page = "home")
	{
    if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
    {
      show_404();
    }
    $data['title'] = ucfirst($page);
    $this->load->view('pages/template/header',$data);
    $this->load->view('pages/'.$page);   
    $this->load->view('pages/template/footer');
  }
  public function view()
  {
    # code...
  }
  public function show($id = "")
  {
    # code...
  }
  public function create()
  {
    # code...
  }
  public function store()
  {
    # code...
  }
  public function edit($id)
  {
    # code...
  }
  public function update()
  {
    # code...
  }
  public function delete($id)
  {
    # code...
  }
}
