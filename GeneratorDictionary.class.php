<?php 

/**
 * Maintans a set of words for a sentences generator
 * @author etessore
 * @version 1.0.0
 * @todo maintain an ordinate array so that 
 * insertion and deletion will be more efficent
 */
class GeneratorDictionary{
	private $words;
	private $count;

	public function __construct(){
		$this->count = 0;
		$this
			->add_word('lorem')
			->add_word('ipsum');
	}
	
	/**
	 * Adds the given $word to the current set 
	 * @param string $word the word
	 * @return GeneratorDictionary $this for chainability
	 */
	public function add_word($word){
		$this->words[] = $word;
		$this->count++;
		return $this;
	}
	
	/**
	 * Removes the given words from the current set
	 * @param string $word the word
	 * @return GeneratorDictionary $this for chainability
	 */
	public function remove_word($word){
		foreach($this->words as $k => $v){
			if($v==$word){
				unset($this->words[$k]);
				$this->count--;
			}
		}
		return $this;
	}

	/**
	 * @return the full set of words
	 */
	public function get_all_words(){
		return $this->words;
	}
	
	/**
	 * @return the number of words in the current dictionary
	 */
	public function number_of_words(){
		return $this->count;
	}
}