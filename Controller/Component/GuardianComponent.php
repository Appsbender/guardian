<?php

App::uses('Component', 'Controller');

class GuardianComponent extends Component {

	public function startup(Controller $controller) {
		$guardKey = Configure::read('Guardian.guardKey');
		$hasKey = isset($controller->request->query[$guardKey]);
		$guarded = $controller->Session->read('Guardian.guardKey');
		if ($controller->request->param('prefix') === 'admin') {
			if ($hasKey && !$guarded) {
				$guarded = $guardKey;
				$controller->Session->write('Guardian.guardKey', $guarded);
				return;
			}
			if (!$guarded) {
				throw new NotFoundException('Unguarded');
			}
		}
	}

}
