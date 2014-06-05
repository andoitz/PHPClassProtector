<?php
/*
	Create your own phpProtectorClient for call the phpProtector classes
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
class phpProtectorClient{
	private $host = "127.0.0.1";
	private $scriptServer = "phpProtectorServer.php";
	public $result;
	
	public function __construct(){
	
	}
	public function callExample(){
		$myCall = array( 0 => array("class" => "nameOfMyClass",
									"params" => array("param1","param2","param3"),
									"methods" => array(	"myMethod1" => array("param1","param2"),
														"myMethod2" => array("param1"))),
						1 => array(	"class" => "nameOfMyClass2",
									"params" => array("param1","param2"),
									"methods" => array("myMethod1" => array("param1"))));
		$myCall = json_encode($myCall);
		$this->result = $this->sendCurl($myCall);
	}
	private function sendCurl($myCall){
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "http://".$this->host."/".$this->scriptServer,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array("data" =>$myCall)
		));
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		
		return $result;
	}
}
$example = new phpProtectorClient();
$example->callExample();
echo var_export($example->result,true);
?>