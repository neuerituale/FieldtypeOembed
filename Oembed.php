<?php

/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2023 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;

class Oembed extends WireData {

	/**
	 * @var Field|null
	 */
	protected $field = null;

	/**
	 * @var null|Page
	 */
	protected $page = null;

	/**
	 * Construct a new Event
	 */
	public function __construct(Page $page, Field $field) {
		parent::__construct();

		$page->wire($this);
		$this->page = $page;
		$this->field = $field;

		$this->set('empty', true);
		$this->set('url', '');
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
		if($key !== 'empty' && $key !== 'url') $this->set('empty', false);

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

