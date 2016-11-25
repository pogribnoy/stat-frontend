<?php
class AboutController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}
	
	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_('text_' . $this->controllerName . '_title'));
	}
}
