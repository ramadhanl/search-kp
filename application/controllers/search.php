<?php

class Search extends CI_Controller {
	public function index()
	{
		$this->load->view('home');
	}
	public function search()
	{
		$query = $this->input->post('searchbox');
		echo $query;
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		$tokens = $tokenizer->tokenize($query);
		//Mencari term frequency
	    foreach ($tokens as $token) {
	    	$token = $stemmer->stem($token);
	    	if(strlen($token)!==0){
	    		$query2=$this->db->get_where('terms', array('term' => $token));
	    		$banyak=$query2->num_rows();
	    		if($banyak!=0){
	    			$id_term=$row2->id_term;
	    		}
	    	$query=$this->db->get_where('tf', array('id_term' => $id_term));
            foreach ($query->result() as $row) {
            	echo $row->id_doc."<br>";
            }
	    }
	}}
	public function tokenizer(){
		require_once  __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$tokens = $tokenizer->tokenize('Saya membeli barang seharga Rp 5.000 di Jl. Prof. Soepomo no. 67.');
		var_dump($tokens);
	}
	public function stemmer(){
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		
		// create stemmer
		// cukup dijalankan sekali saja, biasanya didaftarkan di service container
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		// stem
		$sentence = 'Perekonomian Indonesia sedang dalam pertumbuhan yang membanggakan';
		$output   = $stemmer->stem($sentence);

		echo $output . "\n";
		// ekonomi indonesia sedang dalam tumbuh yang bangga

		echo $stemmer->stem('Mereka meniru-nirukannya') . "\n";
		// mereka tiru
	}
}
