<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->helper('form');
    }
    
	public function index()
	{
		$this->load->view('home');
	}
    
    public function consulta()
    {
        $cliente = new Client(['base_uri' => 'http://premium-valor-94418.appspot.com/']);
        $data = explode("/", $_POST['data']);
        $response = $cliente->get('/relatoriobd/' . $data[1] . "/" . $data[0] . "/" . $data[2]);
        
        $array = explode("Data", $response->getBody());
        for($i = 0; $i < count($array); $i++){
          $medidas[$i] = explode("/", $array[$i]);
        }
        $data['medidas'] = $medidas;
        $this->load->view('home', $data);
    }
    
    public function registrar()
    {   
        $cliente = new Client(['base_uri' => 'http://premium-valor-94418.appspot.com/']);
        $response = $cliente->post('/subscribe', [
            'form_params' => [
                'email' => $_POST['email']
            ]
        ]);
        if (!strpos($response->getBody(), "ja")) {
            $this->session->set_flashdata('error', false);
            $this->session->set_flashdata('message', "Email cadastrado!");
        }
        else {
            $this->session->set_flashdata('error', true);
            $this->session->set_flashdata('message', "Email já cadastrado!");
        }
        redirect('home');
    }
}
