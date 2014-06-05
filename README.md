SERVER INFORMATION
	Visit www.andoitz.com for more information and updates

	PHPPROTECTOR is used for protect your PHP classes code and use it in other place. For example:
	
	Create and use your own API for protect your code
	
	1. Create your PHP Classes (private classes)
	2. Share your PHP Classes via your own server, in a place that only phpProtector server class can access
	3. Use your phpProtector client class for call phpProtector server and get the result of your "private Classes"
	4. phpProtector class will interpreter your "private Classes" with the params that your are sending and will return a result to your phpProtector client
	5. Use your phpProtector client as a bridge to your private classes. Now you can access there and share your php program in a safe way.
	
	Your own function classes needs to have a return value and never print nothing or the result will not work.
	
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

CLIENT INFORMATION

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