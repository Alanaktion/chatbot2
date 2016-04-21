<?php

require_once __DIR__ . '/jaxl/jaxl.php';

/**
 * JAXL superclass with added functionality
 */
class SJAXL extends JAXL {

	/**
	 * Get the current JAXLSocketClient instance
	 * @return JAXLSocketClient
	 */
	public function getTransport() {
		return $this->trans;
	}

}
