<?php
class Home extends CI_Controller {
	public function index()
	{
		$data = array('query' => 4869 );
		$this->load->view('home',$data);
	}
	public function result($query,$totaltime)
	{
		$data = array('query' => $query,
					  'totaltime'=>$totaltime);
		$this->load->view('home',$data);
	}
	public function display_top_tags($tahun)
	{
		$data = array('tahun' => $tahun );
		$this->load->view('top_tags',$data);
	}
	public function list_documents_tag($id_tag)
	{
		$data = array('id_tag' => $id_tag );
		$this->load->view('list_documents_tag',$data);
	}
	public function top_tags()
	{
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		//10 top_tags all the time
		$this->db->empty_table('stki_top_tags');
		$this->db->empty_table('stki_tags_reference');
		//ALTER TABLE stki_top_tags AUTO_INCREMENT = 1
		$year_start = date("Y")-7;
		echo $year_start."<br>";
		$year_finish = date("Y");
		for ($tahun=$year_start; $tahun<=$year_finish ; $tahun++) { 
			$this->db->empty_table('stki_terms_temp');
			$this->db->empty_table('stki_tf_temp');
			if ($tahun==$year_start)
				$sql=$this->db->get('stki_data_kp');
			else
				$sql=$this->db->get_where('stki_data_kp', array('tahun' => $tahun));
			foreach ($sql->result() as $row){	
				$id_doc = $row->id_doc;
			    $judul = $row->judul;
			    $judul_baru = $stemmer->stem($judul);
			    $judul_baru = $this->stopword($judul_baru);
			    $tokens = $tokenizer->tokenize($judul_baru);
			    //Mencari term frequency
			    foreach ($tokens as $token) {
			    	if(strlen($token)!==0){
			    		$query2=$this->db->get_where('stki_terms_temp', array('term' => $token));
			    		$banyak=$query2->num_rows();
			    		if($banyak==0){
			    			$data = array('term' => $token);
			    			$this->db->insert('stki_terms_temp', $data);
			    			$query2=$this->db->get_where('stki_terms_temp', array('term' => $token));
				    		foreach ($query2->result() as $row2){
				    			$id_term=$row2->id_term;
				    		}
			    			$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => 1);
			    			$this->db->insert('stki_tf_temp', $data);
			    		}    
			    		else{
			    			$query2=$this->db->get_where('stki_terms_temp', array('term' => $token));
				    		foreach ($query2->result() as $row2){
				    			$id_term=$row2->id_term;
				    		}
			    			$query3 = $this->db->get_where('stki_tf_temp', array('id_term' => $id_term,'id_doc'=>$id_doc));
							$banyak=$query3->num_rows();
							if($banyak==0){
			    				$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => 1);
			    				$this->db->insert('stki_tf_temp', $data);
			    				// echo "<p>Insert ".$id_term." and ".$id_doc." to tf table.</p>";
			    			}
			    			else{
			    				$query4 = $this->db->get_where('stki_tf_temp', array('id_term' => $id_term,'id_doc'=>$id_doc));
			    				foreach ($query4->result() as $row4){
									$frequency = $row4->tf;
									$id = $row4->id;}
								$frequency=$frequency+1;
								$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'tf' => $frequency);
								$this->db->where('id', $id);
								$this->db->update('stki_tf_temp', $data); 
								// echo "<p>Update frequency row with id =  ".$id." and frequency = ".$frequency." to tf table.</p>";
			    			}
			    		}
			    	}
			    }
			    echo 'Selesai mengolah : "'.$judul.'"(id_doc : '.$id_doc.')<br>';
			}
			$query=$this->db->get('stki_terms_temp');
		    foreach ($query->result() as $row){
				$id_term=$row->id_term;
				$query2 = $this->db->get_where('stki_tf_temp', array('id_term' => $id_term));
				echo "id_term : ".$id_term."<br>";
				$df=$query2->num_rows();
				$data = array('df' => $df);
				$this->db->where('id_term', $id_term);
				$this->db->update('stki_terms_temp', $data); 
			}
			$this->db->order_by("df", "desc");
			$this->db->limit(10);
			$sql=$this->db->get('stki_terms_temp');
			if ($tahun==$year_start)
				$year=9999;
			else
				$year=$tahun;
			foreach ($sql->result() as $row) {
				$data = array('tags' => $row->term,
				 			   'df' => $row->df,
				 			   'tahun' => $year);
				$this->db->insert('stki_top_tags', $data);
				$sql2 = $this->db->get_where('stki_top_tags', array('tags' => $row->term,'df' => $row->df,'tahun' => $year));
				foreach ($sql2->result() as $row2) {
					$id_tag = $row2->id;
				}
				$sql3 = $this->db->get_where('stki_tf_temp', array('id_term' => $row->id_term));
				foreach ($sql3->result() as $row3) {
					$data = array('id_tag' => $id_tag,
				 			   'id_doc' => $row3->id_doc);
					$this->db->insert('stki_tags_reference', $data);
				}
			}
		}

	}
	public function clean_data()
	{
		$this->db->empty_table('stki_data_kp');
		$sql=$this->db->get_where('biblio', array('gmd_id' => 45));
		foreach ($sql->result() as $row){
			$judul = $row->title;
			$id_doc = $row->biblio_id;
			$tahun = $row->publish_year;
			$penulis = '';
			$sql2=$this->db->get_where('biblio_author', array('biblio_id' => $id_doc));
			foreach ($sql2->result() as $row2){
				$author_id = $row2->author_id;
				$sql3=$this->db->get_where('mst_author', array('author_id' => $author_id));
				foreach ($sql3->result() as $row3){
					if ($penulis=='')
						$penulis=$row3->author_name;
					else
						$penulis=$penulis." , ".$row3->author_name;
				}
			}
			$data = array('id_doc' => $id_doc,
						  'judul' => $judul,
						  'tahun' => $tahun,
						  'penulis' => $penulis);
			$this->db->insert('stki_data_kp', $data);
		}
	}

	public function search()
	{
		$mtime = microtime(); 
		$mtime = explode(" ",$mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$starttime = $mtime; 
		$query=$this->input->post('searchbox');
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$query = $stemmer->stem(	$query);
		$query = $this->stopword($query);
		$tokens = $tokenizer->tokenize($query);
		$this->db->empty_table('stki_search_results');
		//Mencari term frequency
		$i=1;$count=0;
		foreach ($tokens as $token) {
			$double=0;
			for ($x=$i-1; $x>0 ; $x--) { 
				if($token==$qterm[$x]){
					$qtf[$x]++;
					$double=1;
				}
			}
			if($double==0){
				$qterm[$i]=$token;
				$qtf[$i]=1;
				$i++;
			}
			$sql=$this->db->get_where('stki_terms', array('term' => $token));
			foreach ($sql->result() as $row){
				$count++;
			}
		}
		$total_term=$i;
		//Scoring Document
		$sql=$this->db->get('stki_data_kp');
		$y=1;
		if($count!=0){
		foreach ($sql->result() as $row){
			$total_qtfidf=0;$total_dtfidf=0;$dot_product=0;
			for ($x=1; $x<$total_term; $x++) { 
				//Query Vector
				$normalized_qtf[$x]=$qtf[$x]/$total_term;
				//echo "<h3>".$qterm[$x]."</h3>tf : ".$qtf[$x]."<br>ntf : ".$normalized_qtf[$x]."<br>idf : ";
				$sql1=$this->db->get_where('stki_terms', array('term' => $qterm[$x]));
				$count=0;
				foreach ($sql1->result() as $row1){
	    			$idf[$x]=$row1->idf;$count++;$id_term=$row1->id_term;}
	    		if ($count==0)
	    			$idf[$x]=0;
	    		$qtfidf[$x]=$normalized_qtf[$x]*$idf[$x];
	    		//echo $idf[$x]."<br>tf*idf : ".$qtfidf[$x];
	    		$total_qtfidf=$total_qtfidf+($qtfidf[$x]*$qtfidf[$x]);

	    		//Document Vector
	    		$sql2=$this->db->get_where('stki_tf', array('id_doc' => $row->id_doc,'id_term' => $id_term));
		    	$count=0;
		    	foreach ($sql2->result() as $row2){
		    		$normalized_dtf[$x]=$row2->normalized_tf;$count++;
		    	}
		    	if ($count==0)
	    			$normalized_dtf[$x]=0;
		    	$dtfidf[$x]=$normalized_dtf[$x]*$idf[$x];
		    	$total_dtfidf+=($dtfidf[$x]*$dtfidf[$x]);
		    	$dot_product+=$dtfidf[$x]*$qtfidf[$x];
			}
			$dquery = sqrt($total_qtfidf);
			$ddocument = sqrt($total_dtfidf);
			if($dquery==0 || $ddocument==0){
				$score[$y]=$dot_product/0.001;
			}
			else
				$score[$y]=$dot_product/($dquery * $ddocument);
			//echo "<h4>".$row->judul."</h4>";
			//echo "Dot Product : ".$dot_product."<br>";
			//echo "Dquery : ".$dquery."<br>";
			//echo "Ddocument : ".$ddocument."<br>";
			//echo "Score : ".$score[$y]."<br>";
			$data = array('id_doc' => $row->id_doc,
						  'judul' => $row->judul,
						  'penulis' => $row->penulis,
						  'tahun' => $row->tahun,
						  'tags' => $row->tags,
						  'score'=> $score[$y]);
			$this->db->insert('stki_search_results', $data);
			$y++;
		}}
		$mtime = microtime(); 
	    $mtime = explode(" ",$mtime); 
	    $mtime = $mtime[1] + $mtime[0]; 
	    $endtime = $mtime; 
	    $totaltime = ($endtime - $starttime);
		redirect(base_url("home/result/".$this->input->post('searchbox')."/".$totaltime));
		//$this->load->view('home');
	}
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
		 ",",
		 "untuk ",
		 "guna ",
		 "pt ",
		 "l ",
		);
		$hasil = str_ireplace($liststopword, "", $kalimat);

		return $hasil;
	}
}
