<?php

/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2023 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;

class Oembed extends WireData {

	/**
	 * Construct a new Event
	 */
	public function __construct() {
		$this->set('empty', true);
		parent::__construct();
	}

	/**
	 * Set a value to the event: date, location or notes
	 *
	 * @param string $key
	 * @param string $value
	 * @return WireData|self
	 *
	 */
	public function set($key, $value) {

		// declare as valid
		if($key !== 'empty') $this->set('empty', false);

		// date
		if($key === 'date') $value = $value ? wireDate('c', $value) : '';
		return parent::set($key, $value);
	}

	/**
	 * @return string
	 */
	public function render() {
		return $this->get('empty') ? '' : (string) $this->get('html');
	}

	/**
	 * Return the rendered output
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}
}

