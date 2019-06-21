<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index()
	{

    $data['title'] = "Home";
    $this->load->view('pages/template/header',$data);
    $this->load->view('pages/home');
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
