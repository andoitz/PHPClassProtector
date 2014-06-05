<?php
class nameOfMyClass{
	private $example;
	public function __construct($param1,$param2,$param3){
		$this->example = $param1.$param2.$param3;
	}
	public function myMethod1($param1,$param2){
		return "myMethod1 => ".$param1.$param2.": ".$this->example;
	}
	public function myMethod2($param1){
		return "myMethod2 => ".$param1.": ".$this->example;
	}
}