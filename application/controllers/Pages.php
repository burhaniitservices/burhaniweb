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

  }
  public function show($id = "")
  {

  }
  public function create()
  {

  }
  public function store()
  {

  }
  public function edit($id)
  {

  }
  public function update()
  {

  }
  public function delete($id)
  {

  }
}
