<?php
class IndexController extends ControllerBase {
	
	public function initialize() {
		parent::initialize();
		// убираем указание на layout index, чтобы не задваивался вывод
		$this->view->cleanTemplateAfter();
		//$this->actionLifeTime = 3600;
	}

	public function indexAction() {
		// Проверяет, кэш с ключом на существование или истёкший срок
		if (!$this->view->getCache()->exists($this->viewCacheKey)) {
			$regions_rows = Region::find(['order' => 'name ASC']);
			$regions = array();
			foreach ($regions_rows as $row) {
				// наполняем массив
				$regions[$row->id] =  $row->name;
			}
			
			$organizations_rows = Organization::find(['order' => 'name ASC']);
			$organizations = array();
			foreach ($organizations_rows as $row) {
				// наполняем массив
				$organizations[] = [
					'id' => $row->id,
					'name' => $row->name,
					'regionID' => $row->region_id,
				];
			}
			
			//$this->view->setVar("page_header", $this->t->_("text_site_full_name"));
			$this->view->setVar("regions", $regions);
			$this->view->setVar("organizations", $organizations);
		}
		$this->view->cache([
			"lifetime" => 5,
			"key"      => $this->viewCacheKey,
		]);
	}
}
