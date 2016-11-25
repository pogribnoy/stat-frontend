<?php
class IndexController extends ControllerBase {
	//public $regions = [];
	//public $organizations = [];
	
	public function initialize() {
		parent::initialize();
		// убираем указание на layout index, чтобы не задваивался вывод
		$this->view->cleanTemplateAfter();
	}

	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_("text_site_full_name"));
		
		$regions_rows = Region::find();
		$regions = array();
		foreach ($regions_rows as $row) {
			// наполняем массив
			$regions[$row->id] =  $row->name;
		}
		
		$organizations_rows = Organization::find();
		$organizations = array();
		foreach ($organizations_rows as $row) {
			// наполняем массив
			$organizations[$row->id] =  [
				'name' => $row->name,
				'regionID' => $row->region_id,
			];
		}
		
		$this->view->setVar("regions", $regions);
		$this->view->setVar("organizations", $organizations);
	}
}
