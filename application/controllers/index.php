<?php

class Index extends CI_Controller {
	public function index()
	{
		//$this->load->view('home');
	}
	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
