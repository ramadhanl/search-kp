<?php
class Kelola_data extends CI_Controller {
	public function index()
	{
		$this->load->view('home');
	}
	public function tokenizer()
	{
		require_once  __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$tokens = $tokenizer->tokenize('Saya membeli barang seharga Rp 5.000 di Jl. Prof. Soepomo no. 67.');
		var_dump($tokens);
		echo strtolower($tokens[0]);
	}
	public function stopword($kalimat)
	{
		$liststopword = array(
		"adanya ",
		"adalah ",
		"adapun ",
		"agak ",
		"agaknya ",
		"agar ",
		"akan ",
		"akankah ",
		"akhirnya ",
		"akulah ",
		"amat ",
		"amatlah ",
		"anda ",
		"andalah ",
		"antar ",
		"diantaranya ",
		"antara ",
		"antaranya ",
		"diantara ",
		"apaan ",
		"mengapa ",
		"apabila ",
		"apakah ",
		"apalagi ",
		"apatah ",
		"atau ",
		"ataukah ",
		"ataupun ",
		"bagai ",
		"bagaikan ",
		"sebagai ",
		"sebagainya ",
		"bagaimana ",
		"bagaimanapun ",
		"sebagaimana ",
		"bagaimanakah ",
		"bagi ",
		"bahkan ",
		"bahwa ",
		"bahwasanya ",
		"sebaliknya ",
		"banyak ",
		"sebanyak ",
		"beberapa ",
		"seberapa ",
		"begini ",
		"beginian ",
		"beginikah ",
		"beginilah ",
		"sebegini ",
		"begitu ",
		"begitukah ",
		"begitulah ",
		"begitupun ",
		"sebegitu ",
		"belum ",
		"belumlah ",
		"sebelum ",
		"sebelumnya ",
		"sebenarnya ",
		"berapa ",
		"berapakah ",
		"berapalah ",
		"berapapun ",
		"betulkah ",
		"sebetulnya ",
		"biasa ",
		"biasanya ",
		"bila ",
		"bilakah ",
		"bisa ",
		"bisakah ",
		"sebisanya ",
		"boleh ",
		"bolehkah ",
		"bolehlah ",
		"buat ",
		"bukan ",
		"bukankah ",
		"bukanlah ",
		"bukannya ",
		"cuma ",
		"percuma ",
		"dahulu ",
		"dalam ",
		"dan ",
		"dapat ",
		"dari ",
		"daripada ",
		"dekat ",
		"demi ",
		"demikian ",
		"demikianlah ",
		"sedemikian ",
		"dengan ",
		"depan ",
		"di ",
		"dia ",
		"dialah ",
		"dini ",
		"diri ",
		"dirinya ",
		"terdiri ",
		"dong ",
		"dulu ",
		"enggak ",
		"enggaknya ",
		"entah ",
		"entahlah ",
		"terhadap ",
		"terhadapnya ",
		"hal ",
		"hampir ",
		"hanya ",
		"hanyalah ",
		"harus ",
		"haruslah ",
		"harusnya ",
		"seharusnya ",
		"hendak ",
		"hendaklah ",
		"hendaknya ",
		"hingga ",
		"sehingga ",
		"ialah ",
		"ibarat ",
		"ingin ",
		"inginkah ",
		"inginkan ",
		"ini ",
		"inikah ",
		"inilah ",
		"itu ",
		"itukah ",
		"itulah ",
		"jangan ",
		"jangankan ",
		"janganlah ",
		"jika ",
		"jikalau ",
		"juga ",
		"justru ",
		"kala ",
		"kalau ",
		"kalaulah ",
		"kalaupun ",
		"kalian ",
		"kami ",
		"kamilah ",
		"kamu ",
		"kamulah ",
		"kapan ",
		"kapankah ",
		"kapanpun ",
		"dikarenakan ",
		"karena ",
		"karenanya ",
		"kecil ",
		"kemudian ",
		"kenapa ",
		"kepada ",
		"kepadanya ",
		"ketika ",
		"seketika ",
		"khususnya ",
		"kinilah ",
		"kiranya ",
		"sekiranya ",
		"kita ",
		"kitalah ",
		"lagi ",
		"lagian ",
		"selagi ",
		"lain ",
		"lainnya ",
		"melainkan ",
		"selaku ",
		"lalu ",
		"melalui ",
		"terlalu ",
		"lama ",
		"lamanya ",
		"selama ",
		"selama ",
		"selamanya ",
		"lebih ",
		"terlebih ",
		"bermacam ",
		"macam ",
		"semacam ",
		"maka ",
		"makanya ",
		"makin ",
		"malah ",
		"malahan ",
		"mampu ",
		"mampukah ",
		"mana ",
		"manakala ",
		"manalagi ",
		"masih ",
		"masihkah ",
		"semasih ",
		"masing ",
		"maupun ",
		"semaunya ",
		"memang ",
		"mereka ",
		"merekalah ",
		"meski ",
		"meskipun ",
		"semula ",
		"mungkin ",
		"mungkinkah ",
		"namun ",
		"nanti ",
		"nantinya ",
		"nyaris ",
		"oleh ",
		"olehnya ",
		"seorang ",
		"seseorang ",
		"pada ",
		"padanya ",
		"padahal ",
		"paling ",
		"sepanjang ",
		"pantas ",
		"sepantasnya ",
		"sepantasnyalah ",
		"pasti ",
		"pastilah ",
		"pernah ",
		"pula ",
		"merupakan ",
		"rupanya ",
		"serupa ",
		"saat ",
		"saatnya ",
		"sesaat ",
		"saja ",
		"sajalah ",
		"saling ",
		"bersama ",
		"sama ",
		"sesama ",
		"sambil ",
		"sampai ",
		"sana ",
		"sangat ",
		"sangatlah ",
		"saya ",
		"sayalah ",
		"sebab ",
		"sebabnya ",
		"sebuah ",
		"tersebut ",
		"tersebutlah ",
		"sedang ",
		"sedangkan ",
		"sedikit ",
		"sedikitnya ",
		"segala ",
		"segalanya ",
		"segera ",
		"sesegera ",
		"sejak ",
		"sejenak ",
		"sekali ",
		"sekalian ",
		"sekalipun ",
		"sesekali ",
		"sekaligus ",
		"sekarang ",
		"sekarang ",
		"sekitar ",
		"sekitarnya ",
		"sela ",
		"selain ",
		"selalu ",
		"seluruh ",
		"seluruhnya ",
		"semakin ",
		"sementara ",
		"sempat ",
		"semua ",
		"semuanya ",
		"sendiri ",
		"sendirinya ",
		"seolah ",
		"seperti ",
		"sepertinya ",
		"sering ",
		"seringnya ",
		"serta ",
		"siapa ",
		"siapakah ",
		"siapapun ",
		"disini ",
		"disinilah ",
		"sini ",
		"sinilah ",
		"sesuatu ",
		"sesuatunya ",
		"suatu ",
		"sesudah ",
		"sesudahnya ",
		"sudah ",
		"sudahkah ",
		"sudahlah ",
		"supaya ",
		"tadi ",
		"tadinya ",
		"tanpa ",
		"setelah ",
		"telah ",
		"tentang ",
		"tentu ",
		"tentulah ",
		"tentunya ",
		"tertentu ",
		"seterusnya ",
		"tapi ",
		"tetapi ",
		"setiap ",
		"tiap ",
		"setidaknya ",
		"tidak ",
		"tidakkah ",
		"tidaklah ",
		"waduh ",
		"wahai ",
		"sewaktu ",
		"walau ",
		"walaupun ",
		"yaitu ",
		"yakni ",
		"yang ",
		". ",
		 ","
		);
		$hasil = str_ireplace($liststopword, "", $kalimat);

		return $hasil;
	}
	public function stemmer(){
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		// create stemmer
		// cukup dijalankan sekali saja, biasanya didaftarkan di service container
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		
		// stem
		$sentence = 'Sumatera selatan Perekonomian Indonesia sedang dalam pertumbuhan yang membanggakan belajar bermain sepak bola';
		echo $sentence . "\n";
		$output   = $stemmer->stem($sentence);
		$tokens = $tokenizer->tokenize($output);
		var_dump($output);
		var_dump($tokens);
		echo $output . "\n";
		// ekonomi indonesia sedang dalam tumbuh yang bangga
		echo $stemmer->stem('Mereka meniru-nirukannya') . "\n";
		// mereka tiru
	}
	public function tfidf(){
		ini_set('max_execution_time', 3600);
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		echo "Mulai...mengosongkan table<br>";
		//$query = $this->db->get_where('data_kp', array('status' => 1));
		$this->db->empty_table('stki_tf'); 
		$this->db->empty_table('stki_terms'); 
		$query = $this->db->get('stki_data_kp');
		foreach ($query->result() as $row)
		{	
			$id_doc = $row->id_doc;
		    $judul = $row->judul;
		    $judul_baru = $stemmer->stem($judul);
		    $judul_baru = $this->stopword($judul_baru);
		    $tokens = $tokenizer->tokenize($judul_baru);
		    //Mencari term frequency
		    foreach ($tokens as $token) {
		    	if(strlen($token)!==0){
		    		$query2=$this->db->get_where('stki_terms', array('term' => $token));
		    		$banyak=$query2->num_rows();
		    		if($banyak==0){
		    			$data = array('term' => $token);
		    			$this->db->insert('stki_terms', $data);
		    			$query2=$this->db->get_where('stki_terms', array('term' => $token));
			    		foreach ($query2->result() as $row2){
			    			$id_term=$row2->id_term;
			    		}
		    			$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => 1);
		    			$this->db->insert('stki_tf', $data);
		    		}    
		    		else{
		    			$query2=$this->db->get_where('stki_terms', array('term' => $token));
			    		foreach ($query2->result() as $row2){
			    			$id_term=$row2->id_term;
			    		}
		    			$query3 = $this->db->get_where('stki_tf', array('id_term' => $id_term,'id_doc'=>$id_doc));
						$banyak=$query3->num_rows();
						if($banyak==0){
		    				$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => 1);
		    				$this->db->insert('stki_tf', $data);
		    				// echo "<p>Insert ".$id_term." and ".$id_doc." to tf table.</p>";
		    			}
		    			else{
		    				$query4 = $this->db->get_where('stki_tf', array('id_term' => $id_term,'id_doc'=>$id_doc));
		    				foreach ($query4->result() as $row4){
								$frequency = $row4->tf;
								$id = $row4->id;}
							$frequency=$frequency+1;
							$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => $frequency);
							$this->db->where('id', $id);
							$this->db->update('stki_tf', $data); 
							// echo "<p>Update frequency row with id =  ".$id." and frequency = ".$frequency." to tf table.</p>";
		    			}
		    		}
		    	}
		    }
		    echo 'Selesai mengolah : "'.$judul.'"(id_doc : '.$id_doc.')<br>';
		}
		//Menghitung df dan idf
		$query=$this->db->get('stki_terms');
	    foreach ($query->result() as $row){
			$id_term=$row->id_term;
			$query2 = $this->db->get_where('stki_tf', array('id_term' => $id_term));
			echo "id_term : ".$id_term."<br>";
			$df=$query2->num_rows();
			$n = $this->db->get('stki_data_kp')->num_rows();
			$idf = log($n/$df);
			$data = array('df' => $df,'idf' => $idf);
			$this->db->where('id_term', $id_term);
			$this->db->update('stki_terms', $data); 
		}
		$query=$this->db->get('stki_data_kp');
		foreach ($query->result() as $row) {
			echo "<h1>update normalized_tf for id_doc : ".$row->id_doc."</h1><br>";
			$query2=$this->db->get_where('stki_tf', array('id_doc' => $row->id_doc));
			$n_terms=$query2->num_rows();
			foreach ($query2->result() as $row2) {
				$normalized_tf=$row2->tf/$n_terms;
				$data = array('normalized_tf' => $normalized_tf);
				$this->db->where('id', $row2->id);
				$this->db->update('stki_tf', $data);
				echo "id_term : ".$row2->id_term."<br>";
			}
		}
	}
}