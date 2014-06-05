<?php
/*
	Visit www.andoitz.com for more information and updates

	PHPPROTECTOR is used for protect your PHP classes code and use it in other place. For example:
	
	Create and use your own API for protect your code
	
	1. Create your PHP Classes (private classes)
	2. Share your PHP Classes via your own server, in a place that only phpProtector server class can access
	3. Use your phpProtector client class for call phpProtector server and get the result of your "private Classes"
	4. phpProtector class will interpreter your "private Classes" with the params that your are sending and will return a result to your phpProtector client
	5. Use your phpProtector client as a bridge to your private classes. Now you can access there and share your php program in a safe way.
	
	Your own function classes needs to have a return value and never print nothing or the result will not work.
	
*/
class phpProtectorServer{
	public $result = array();
	public $data;
	public $myClassesFolder = './myPrivateClasses/';
	public $myClasses = array();
	
	public function __construct(){
		/*
			USAGE:
				phpProtectorServer needs to receive all variables in json var with the name "data"
				- $myClass = array( 0 => array(	"class" => "nameOfMyClass",
									"params" => array("param1","param2","param3"),
									"methods" => array("myMethod1" => array("param1","param2"),
														"myMethod2" => array("param1"))),
									1 => array(	"class" => "nameOfMyClass2",
												"params" => array("param1","param2"),
												"methods" => array("myMethod1" => array("param1"))));
												
					This example will return 3 results:
						$nameOfMyClass = new nameOfMyClass("param1","param2","param3");
						$nameOfMyClass2 = new nameOfMyClass("param1","param2");
						
						- $result = array(	0 => $nameOfMyClass->myMethod1("param1","param2"),
											1 => $nameOfMyClass->myMethod2("param1"),
											2 => $nameOfMyClass2->myMethod1("param1"));
		*/
		$this->getData();
	}
	//RECEIVE POST VAR AND INTERPRETE IT AS A PHPPROTECTORCLASS CALL
	private function getData(){
		if(isset($_POST["data"])){
			if($this->data = json_decode($_POST["data"])){
				if(!count($this->data)>0){
					$this->result = array( 0 => "ERROR: 'DATA' POST var needs to have data" );
				}
				else{
					$this->processData();
				}
			}
			else{
				$this->result = array( 0 => "ERROR: 'DATA' POST var needs to be send in json encoding" );
			}
		}
		else{
			$this->result = array( 0 => "ERROR: 'DATA' POST var needs to be especified" );
		}
		$this->returnData();
	}
	//FUNCTION USED TO PROCESS POST DATA
	private function processData(){
		foreach($this->data as $key => $class){
			$this->loadClass($class);
		}
	}
	//FUNCTION THAT LOADS A CLASS
	private function loadClass($class){
		$nameClass=$class->class;
		if(!isset($class->class) || !isset($class->params) || !isset($class->methods)){
			$this->result = array( 0 => "ERROR: You have a Syntax ERROR, please read the documentation" );
			$this->returnData();
		}
		else{
			if(!count($class->params)>0 || !count($class->methods)>0){
				$this->result = array( 0 => "ERROR: Params and METHODS needs to be especified.");
				$this->returnData();
			}
			else{
				if(!file_exists($this->myClassesFolder.$nameClass.'.php')){
					$this->result = array( 0 => "ERROR: ".$nameClass.".php file not found in the server.");
					$this->returnData();
				}
				else{
					//ALL SEEMS CORRECT
					//WE ARE LOADING A CLASS
					include($this->myClassesFolder.$nameClass.'.php');			
					$rc = new ReflectionClass($nameClass);
					$this->$nameClass = $rc->newInstanceArgs($class->params);
					//CALL METHODS
					foreach($class->methods as $method => $params ){
						$this->result[] = call_user_func_array(array($this->$nameClass,$method),$params);
					}
				}
			}
		}
	}
	//RETURN DATA AND CLOSE
	private function returnData(){
		echo json_encode($this->result);
		die();
	}
}
//TEST
/*
$_POST["data"] = array( 0 => array(	"class" => "nameOfMyClass",
									"params" => array("param1","param2","param3"),
									"methods" => array("myMethod1" => array("param1","param2"),
														"myMethod2" => array("param1"))),
						1 => array(	"class" => "nameOfMyClass2",
									"params" => array("param1","param2"),
									"methods" => array("myMethod1" => array("param1"))));
									
$_POST["data"] = json_encode($_POST["data"]);
*/
$myPHPPS = new phpProtectorServer();
?>