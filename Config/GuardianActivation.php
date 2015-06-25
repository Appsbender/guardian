<?php

class GuardianActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		$guardKey = Configure::read('Guardian.guardKey');
		if (empty($guardKey)) {
			$guardKey = sha1(uniqid());
			$Setting = ClassRegistry::init('Settings.Setting');
			$setting = $Setting->write('Guardian.guardKey', $guardKey, array(
				'title' => 'Guard Key',
				'description' => 'Append this value in the admin URL are at the start of each session',
				'editable' => true,
				'input_type' => 'text',
			));
			$controller->Session->write('Guardian.guardKey', $guardKey);
			$message = sprintf(
				'Admin area has been protected with URL: %s',
				Router::url(Hash::merge(
					Configure::read('Croogo.dashboardUrl'),
					array('?' => $guardKey)
				), true)
			);
			CakeLog::write(LOG_INFO, $message);
			$controller->Session->setFlash($message, 'flash', array('class' => 'success'));

			$controller->redirect(array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Guardian',
			));
		}
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$Setting->deleteKey('Guardian.guardKey');
		$controller->Session->delete('Guardian');
	}
}
