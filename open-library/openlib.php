<?php
	class OpenLibrary{
		public $isbn	= "";
		public $key		= "";
		public $result	= "";
		//OL returns JSON, decode JSON --> array with key = ISBNxxxxx 
		
		public function setIsbn($isbn){
			$this->isbn = $isbn;
		}
		
		public function getIsbn(){
			return $this->isbn;
		}
		
		public function getKey(){
			$key = "ISBN". $this->getIsbn();
			return $key;
		}
		
		public function curl($isbn){
			$url = "https://openlibrary.org/api/books?bibkeys=ISBN".$isbn."&jscmd=data&format=json";
			
			$client = curl_init($url);
			curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
			$response = curl_exec($client);
			
			$this->result = json_decode($response, true);
			
			return $this->result;
		}
		
		//Printing result 
		public function display($heading, $content){
			echo "<tr><td>{$heading}</td><td>";
			echo $content;
			echo "</td></tr>";
		}
		
		
		public function getAuthors(){
			$authors_list = array_column($this->result,'authors');
			foreach ($authors_list as $author){
				foreach ($author as $detail){
					$this->display("Author", $detail['name']);
				}
			} 
		}

		public function getCover($size){
			$image = "";
			if($size == "small"){
				$image = $this->result['ISBN'.$this->isbn]['cover']['small'];
			}else if($size == "medium"){
				$image = $this->result['ISBN'.$this->isbn]['cover']['medium'];	
			}else if($size == "large"){
				$image = $this->result['ISBN'.$this->isbn]['cover']['large'];	
			}
			
			$this->display("Picture", "<img src='{$image}' ");
		} 		
		
		public function getTitle(){
			$this->display("Title", $this->result['ISBN'.$this->isbn]['title']);
		}
		
		public function getIsbn10(){
			if($type = 'isbn10'){
				if (array_key_exists("isbn_10",$this->result['ISBN'.$this->isbn]['identifiers'])){
					$this->display(	"ISBN 10", $this->result['ISBN'.$this->isbn]['identifiers']['isbn_10'][0]);
				}else return false;
			}
		}
		
		public function getIsbn13(){
			if($type = 'isbn10'){
				if (array_key_exists("isbn_13",$this->result['ISBN'.$this->isbn]['identifiers'])){
					$this->display(	"ISBN 13", $this->result['ISBN'.$this->isbn]['identifiers']['isbn_13'][0]);
				}else return false;
			}
		}
	}
?>