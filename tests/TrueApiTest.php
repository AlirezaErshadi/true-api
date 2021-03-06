<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(__FILE__)) .'/TrueApi.php';

/**
 * Test class for TrueApi.
 * Generated by PHPUnit on 2009-11-20 at 10:22:43.
 */
class TrueApiTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    TrueApi
	 * @access protected
	 */
	protected $TrueApi;
	protected $CurlResponseJson;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->TrueApi = new TrueApi(array(
			'log-print-level' => 'emerg',
		));

		$this->CurlResponseJson = new MockCurlResponse('json');

		$this->TrueApi->RestClient = new MockRestClient;
	}

	public function test__setup()
	{
		// Remove the following lines when you implement this test.
		foreach ($this->TrueApi->controllers as $controller) {
			$model = $this->TrueApi->classify($controller);
			$this->assertTrue(is_object($this->TrueApi->{$model}));
			$this->assertTrue(method_exists($this->TrueApi->{$model}, 'index'));
		}
	}

	public function testAuth()
	{
		// Remove the following lines when you implement this test.
		$auth = $this->TrueApi->auth('kevin', 'password1', 'I052983ee7dd36eb268b63f9e49b99f1772e839ba', 'Customer');
		$this->assertSame('TRUEREST username=kevin&password=password1&apikey=I052983ee7dd36eb268b63f9e49b99f1772e839ba&class=Customer', $auth);

		$auth = $this->TrueApi->auth('kevin', 'password1', 'I052983ee7dd36eb268b63f9e49b99f1772e839ba');
		$this->assertSame('TRUEREST username=kevin&password=password1&apikey=I052983ee7dd36eb268b63f9e49b99f1772e839ba&class=Customer', $auth);
	}

	public function testParseJson() {
		$parsed = $this->TrueApi->parseJson($this->CurlResponseJson);

		$this->assertArrayNotHasKey('response', $parsed);
		$this->assertArrayNotHasKey('bogus', $parsed);
		$this->assertArrayHasKey('data', $parsed);
		$this->assertArrayHasKey('meta', $parsed);
	}

	public function testResponse() {
		$parsed = array(
			'meta' => array(
				'status' => 'ok',
				'feedback' => array(

				),
				'request' => array(

				),
			),
			'data' => array(

			),
		);

		$response = $this->TrueApi->response($parsed);
		$this->assertArrayNotHasKey('response', $response);
		$this->assertArrayNotHasKey('bogus', $response);
		$this->assertArrayHasKey('data', $response);
		$this->assertArrayHasKey('meta', $response);

		$this->TrueApi->opt('returnData', true);
		$response = $this->TrueApi->response($parsed);
		$this->assertArrayNotHasKey('response', $response);
		$this->assertArrayNotHasKey('bogus', $response);
		$this->assertArrayNotHasKey('data', $response);
		$this->assertArrayNotHasKey('meta', $response);

	}

	public function testRest()
	{
		$resNoAuth = $this->TrueApi->rest('put', 'servers/edit/1', array('color' => 'black'));
		$this->assertFalse($resNoAuth);

		$auth  = $this->TrueApi->auth('testuser', 'testpassword', 'I052983ee7dd36eb268b63f9e49b99f1772e839ba', 'Customer');

		$resMeth = $this->TrueApi->rest('do', 'servers/edit/1', array('color' => 'black'));
		$this->assertFalse($resMeth);

		$resOK = $this->TrueApi->rest('put', 'servers/edit/1', array('color' => 'black'));
		$this->assertTrue($resOK !== false);
	}
}

Class MockCurlResponse {
	public $headers;
	public $body;
	public function  __construct($format = 'json') {
		switch($format) {
			case 'json':
				$this->body = '{
				  "meta":{
					"status":"ok",
					"feedback":[
					  {
						"message":"The Server has been saved",
						"level":"info"
					  }
					],
					"request":{
					  "request_method":"put",
					  "request_uri":"\\/cakephp\\/servers\\/edit\\/2313.json",
					  "server_protocol":"HTTP\\/1.1",
					  "remote_addr":"212.182.167.154",
					  "server_addr":"87.233.11.186",
					  "http_user_agent":"True Api v0.1",
					  "http_host":"admin.true.dev",
					  "request_time":1258721321
					}
				  },
				  "data":{
					"Server":{
					  "color":"black"
					}
				  }
				}';

				$this->headers = array (
					'Http-Version' => '1.1',
					'Status-Code' => '200',
					'Status' => '200 OK',
					'Server' => 'nginx/0.7.62',
					'Date' => 'Fri, 20 Nov 2009 12:50:02 GMT',
					'Content-Type' => 'text/javascript',
					'Transfer-Encoding' => 'chunked',
					'Connection' => 'keep-alive',
					'X-Powered-By' => 'PHP/5.2.10-2ubuntu6',
					'Set-Cookie' => 'PHPSESSID=eb9d1573f0f5ee2aac9a8f132dc6688b; path=/',
					'Expires' => 'Thu, 19 Nov 1981 08:52:00 GMT',
					'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
					'Pragma' => 'no-cache',
				);

				break;
		}
	}

}

Class MockRestClient {
	public function  put() {
		return array (
		  'meta' =>
		  array (
			'status' => 'ok',
			'feedback' =>
			array (
			  0 =>
			  array (
				'message' => 'The Server has been saved',
				'level' => 'info',
			  ),
			),
			'request' =>
			array (
			  'request_method' => 'put',
			  'request_uri' => '/cakephp/servers/edit/2313.json',
			  'server_protocol' => 'HTTP/1.1',
			  'remote_addr' => '212.182.167.154',
			  'server_addr' => '87.233.11.186',
			  'http_user_agent' => 'True Api v0.1',
			  'http_host' => 'admin.true.dev',
			  'request_time' => 1258721691,
			),
		  ),
		  'data' =>
		  array (
			'Server' =>
			array (
			  'color' => 'black',
			),
		  ),
		);
	}
	public function  __call($name,  $arguments) {
		return true;
	}

	public function add_response_type($type, $callback, $request_suffix = '') {
		if (is_array($callback)) {
			$object = $callback[0];
			$method = $callback[1];
		} else {
			$object = $this;
			$method = $callback;
		}

		if (!method_exists($object, $method)) {
			throw new Exception('Callback method "'.get_class($object).'::'.$method.'" does not exist');
		}
		return true;
	}
}
