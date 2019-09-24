<?php
	class Googlebook{
		public $isbn	= "";
		public $key		= "";
		public $result	= "";
		
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
			$url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn;
			
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
		

		public function getCover(){
			$image = "";	
			$image = $this->result['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
			$this->display("Picture", "<img src='{$image}' ");
		} 		
		
		
/*--------------This part for Open library
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
----------------------*/
?>