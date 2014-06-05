<?php
class nameOfMyClass2{
	private $example;
	public function __construct($param1,$param2){
		$this->example = $param1.$param2;
	}
	public function myMethod1($param1){
		return "myMethod2 => ".$param1.": ".$this->example;
	}
}