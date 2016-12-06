<?php
class AboutController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}
	
	public function indexAction() {
		$this->view->cache([
			"lifetime" => 86400,
			"key"      => $this->viewCacheKey,
		]);
	}
}
