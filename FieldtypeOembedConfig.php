<?php
/**
 * COPYRIGHT NOTICE
 * Copyright (c) 2021 Neue Rituale GbR
 * @author NR <code@neuerituale.com>
 */

namespace ProcessWire;


class FieldtypeOembedConfig extends ModuleConfig
{
	/**
	 * @return array
	 * @throws WireException
	 */
	public function getDefaults() {

		// get schedules from Lazy Cron
		$lazyCronInstance = $this->modules->get('LazyCron');
		$getTimeFuncsFunction = function(){ return $this->timeFuncs; };

		return [
			'cronSchedule' => 86400,
			'timeFuncs' => $getTimeFuncsFunction->call($lazyCronInstance),
		];
	}

	/**
	 * @return InputfieldWrapper
	 */
	public function getInputfields() {

		$inputfields = parent::getInputfields();

		/** @var InputfieldSelect */
		$inputfields->add([
			'type' => 'Select',
			'name' => 'cronSchedule',
			'label' => 'Cron Schedule',
			'description' => __('If selected, the cron will refresh the expires oembed data in all oembed fields.'),
			'options' => $this->get('timeFuncs')
		]);

		// validate Custom Providers (JSON)
		if(!empty($this->customProviders)) {
			$customProviders = json_decode($this->customProviders,JSON_OBJECT_AS_ARRAY);
			if(!is_array($customProviders)) {
				// TODO remove notice
				wire()->error('Invalid JSON in field Custom Providers (JSON)');
			}
		}

		/** @var InputfieldTextarea */
		$inputfields->add([
			'type' => 'Textarea',
			'name' => 'customProviders',
			'label' => 'Custom Providers (JSON)',
			'rows' => 20,
			'description' => __('Add custom Providers here. For information on how to add custom providers please refer to the documentation.'),
		]);

		return $inputfields;
	}
}