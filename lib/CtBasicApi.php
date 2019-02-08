<?php

class CtBasicApi {

	private $merchantId;
	private $apiKey;
	private $data = [];
	private $hashAlgorithm = "sha256";
	private $prodUrl = "https://api.certitrade.net/ctpsp/basic";
	private $testUrl = "https://apitest.certitrade.net/ctpsp/basic";
    private $apiFields = ["merchantid", "amount", "currency", "orderid", "cust_phone", "cust_email", "return_url", "callback_url", "payment_method", "language", "hash", "client_info"];

	public function __construct($merchantId, $apiKey) {
		$this->merchantId = $merchantId;
		$this->data['merchantid'] = $merchantId;
		$this->data['client_info'] = "CT Basic Library Code";
		$this->apiKey = $apiKey;
	}

	/**
	 * Sets the parameters to be used in the call to the API
	 * @param array $data
	 */
	public function setData($data) {
        if (is_array($data)) {
            foreach ($data as $field => $value) {
                if (in_array($field, $this->apiFields)) {
                    $this->data[$field] = $data[$field];
                }
            }

        }
	}

	/**
	 * Set a single parameter
	 * @param string $parameter
	 * @param $value
	 */
	public function setParameter($parameter, $value) {
	    if (!in_array($parameter, $this->apiFields)) {
            return 0;
	    }

	    $this->data[$parameter] = $value;
	    return 1;
	}

	/**
	 * Returns the value of a parameter if previously set
	 * @param string $parameter
	 */
	public function getParameter($parameter) {
	    if (!isset($this->data[$parameter])) {
            return null;
	    }

	    return $this->data[$parameter];
	}

	/**
	 * Calculates the hash using current values and hash algorithm
	 */
	public function calculateHash() {
		$fields = ["merchantid", "orderid", "amount", "currency", "return_url", "callback_url"];

		$hashString = $this->apiKey;

		foreach ($fields as $field) {
			if (array_key_exists($field, $this->data)) {
				$hashString .= $this->data[$field];
			}
		}

		$hash = hash($this->hashAlgorithm, $hashString);
		$this->data['hash'] = $this->hashAlgorithm.":".$hash;
	}

	/**
	 * Creates and returns an html form and javascript that automatically submits it
	 * Note: This function does not automatically output the form to the browser
	 * @param string $mode Set to 'test' for testmode
	 */
	public function getRedirection($mode = 'prod') {
		if (!$this->data['hash']) {
			$this->calculateHash();
		}

		if ($mode == 'prod') {
			$url = $this->prodUrl;
		}
		elseif ($mode == 'test') {
			$url = $this->testUrl;
		}
		else {
			die("Unknown mode");
		}

		$form = "<form name=\"CtBasicForm\" action=\"$url\" method=\"post\" >\n";
		foreach ($this->data as $name => $value) {
			$form .= "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
		}
		$form .= "</form>\n";
		$form .= "<script>document.CtBasicForm.submit();</script>\n";

		return $form;
	}

	/**
	 * Validates the hash field in a callback and return
	 * @param array $data If no data is specified, POST variables are used
	 */
	public function validateHash($data = null) {
		if (!$data) {
			$data = $_POST;
		}

		$this->data = $data;

		list($hashAlgorithm, $hash) = explode(":", $data['hash']);

		$fields = ["paymentid", "merchantid", "orderid", "function", "description", "timestamp"];

		$hashString = $this->apiKey;
		foreach ($fields as $field) {
			$hashString .= $data[$field];
		}

		$ourHash = hash($hashAlgorithm, $hashString);

		return $ourHash == $hash;
	}

	/**
	 * Helper function to check the result in callback or return.
	 */
	public function paymentOk() {
	    return ($this->data['function'] == "APPROVE");
	}


}