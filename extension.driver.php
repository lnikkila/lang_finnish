<?php

	Class extension_lang_finnish extends Extension {

		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => '__toggleFinnish'
				)
			);
		}

		/**
		 * Toggle between Finnish and default date and time settings
		 */
		public function __toggleFinnish($context) {

			// Set Finnish date and time settings
			if($context['settings']['symphony']['lang'] == 'fi') {
				$this->__setFinnish();
			}

			// Restore default date and time settings
			else {
				$this->__unsetFinnish();
			}
		}

		public function install() {

			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'region');
			$time = Symphony::Configuration()->get('time_format', 'region');
			$separator = Symphony::Configuration()->get('datetime_separator', 'region');

			// Store current date and time settings
			Symphony::Configuration()->set('date_format', $date, 'lang-Finnish-storage');
			Symphony::Configuration()->set('time_format', $time, 'lang-Finnish-storage');
			Symphony::Configuration()->set('datetime_separator', $separator, 'lang-Finnish-storage');
			Symphony::Configuration()->write();
		}

		public function enable(){
			if(Symphony::Configuration()->get('lang', 'symphony') == 'fi') {
				$this->__setFinnish();
			}
		}

		public function disable(){
			$this->__unsetFinnish();
		}

		public function uninstall() {
			$this->__unsetFinnish();

			// Remove storage
			Symphony::Configuration()->remove('lang-Finnish-storage');
			Symphony::Configuration()->write();
		}

		/**
		 * Set Finnish date and time format
		 */
		private function __setFinnish() {

			// Set Finnish date and time settings
			Symphony::Configuration()->set('date_format', 'd. F Y', 'region');
			Symphony::Configuration()->set('time_format', 'H:i', 'region');
			Symphony::Configuration()->set('datetime_separator', ', ', 'region');     
			Symphony::Configuration()->write();
		}

		/**
		 * Reset default date and time format
		 */
		private function __unsetFinnish() {

			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'lang-Finnish-storage');
			$time = Symphony::Configuration()->get('time_format', 'lang-Finnish-storage');
			$separator = Symphony::Configuration()->get('datetime_separator', 'lang-Finnish-storage');  

			// Store new date and time settings
			Symphony::Configuration()->set('date_format', $date, 'region');
			Symphony::Configuration()->set('time_format', $time, 'region');
			Symphony::Configuration()->set('datetime_separator', $separator, 'region');
			Symphony::Configuration()->write();
		}

	}

