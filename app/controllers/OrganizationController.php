<?php
class OrganizationController extends ControllerBase {
	
	public function initialize() {
		parent::initialize();
	}
	
	public function indexAction() {
		$id = $this->request->get('id', ["trim", "int"]);
		if ($id != '') {
			$viewCacheKey = $this->controllerName . "_" . $this->actionName . "_" . $id . ".html";
			if (!$this->view->getCache()->exists($viewCacheKey)) {
				
				// данные организации
				$row = false;
				$row = Organization::findFirst([
					"conditions" => "id = ?1", 
					"bind" => [1 => $id]
				]);
				if($row) {
					$org = [
						"id" => [
							"value" => $row->id,
						],
						"name" => [
							"name" => $this->t->_("text_entity_property_name"),
							"value" => $row->name,
						],
						"contacts" => [
							"name" => $this->t->_("text_entity_property_contacts"),
							"value" => $row->contacts,
						],
						"email" => [
							"name" => $this->t->_("text_entity_property_email"),
							"value" => $row->email,
						],
						"region" => [
							"name" => $this->t->_("text_entity_property_region"),
							"value_id" => $row->region_id,
						],
						"img" => [
							"href" => '',
						],
					];
					
					// изображения
					$file_rows = false;
					$file_rows = $row->getFile();
					if($file_rows && count($file_rows)>0) {
						//$this->logger->log(json_encode($file_rows));
						$org["img"]["href"] = $this->config->application->commonHost . "/" . $file_rows[0]->directory . $file_rows[0]->name;			
					}
					
					// данные о регионе
					$row = false;
					$row = Region::findFirst([
						"conditions" => "id = ?1", 
						"bind" => [1 => $org["region"]["value_id"]]
					]);
					if($row) $org["region"]["value"] = $row->name;
					
					// расходы
					$expenses = $this->getExpenses($org["id"]["value"]);
					
					$this->view->page_header = $org["name"]["value"];
					$this->view->org = $org;
					$this->view->expenses = $expenses;
					if($this->t->exists('text_' . $this->controllerNameLC . '_description')) $this->view->pageDescription = $this->t->_('text_' . $this->controllerNameLC . '_description', ['param1' => $org["name"]["value"]]);
				}
				else {
					$this->dispatcher->forward([
						'controller' => 'errors',
						'action'     => 'show401',
					]);
					return;
				}
			}
			$this->view->cache([
				"lifetime" => $this->config->application->caching->viewCacheDedaultTime,
				"key"      => $viewCacheKey,
			]);
		}
		else {
			$this->dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show401',
			]);
		}
	}
	
	public function filterAction() {
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		$id = $this->request->get('id', ["trim", "int"]);
		if ($id != '') {
			if(isset($_REQUEST["filter_year"])) {
				$val = $this->filter->sanitize(urldecode($_REQUEST["filter_year"]), "int");
				if($val != '') $filter_year =  $val;
			}
			$cacheKey = $this->controllerName . "_" . $this->actionName . "_" . $id . "_" . $filter_year . ".json";
			$cachedData = $this->dataCache->get($cacheKey);
			if ($cachedData === null) {
				// данные организации
				$row = false;
				$row = Organization::findFirst([
					"conditions" => "id = ?1", 
					"bind" => [1 => $id]
				]);
				if($row) {
					$expenses = $this->getExpenses($row->id, $filter_year);
					// Сохраняем их в кэше
					
					$this->dataCache->save($cacheKey, $expenses);
					return json_encode($expenses);
				}
				else {
					$this->dispatcher->forward([
						'controller' => 'errors',
						'action'     => 'show401',
					]);
					return;
				}
			}
			else return json_encode($cachedData);
		}
		else {
			$this->dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show401',
			]);
		}
	}
	
	public function getExpenses($orgID, $filter_year=null) {
		$curD = new DateTime('now');
		$curYear = (int)$curD->format("Y");
		$year = $curYear;// - 1;
		if($filter_year != null) $year =  $filter_year;
		
		$curDate = $curD->format("Y-m-d");
		//$year = (int)$curD->format("Y") - 1;
		$periodS = DateTime::createFromFormat('Y-m-d', $year . '-01-01');
		$periodStart = $periodS->format("Y-m-d");
		$periodE = DateTime::createFromFormat('Y-m-d', ($year + 1) . '-01-01');
		$periodEnd = $periodE->format("Y-m-d");
		//$this->logger->log('periodStart = ' . $periodStart);
		//$this->logger->log('periodEnd = ' . $periodEnd);
		
		$years = [];
		$years2 = $year + 1;
		$years1 = $years2 - 10;
		if($years1 < 2016) $years1 = 2017;
		if($years2 > $curYear) $years2 = $curYear;
		for($i = $years1; $i <= $years2; $i++) $years[] = $i;
		
		$totalSum = Expense::sum([
			"column" => "amount", 
			"conditions" => "deleted_at IS NULL AND organization_id=?1 AND ((target_date_from >= ?3 AND target_date_from < ?4) OR (target_date_to >= ?3 AND target_date_to < ?4))", 
			"bind" => [
				1 => $orgID,
				3 => $periodStart, 
				4 => $periodEnd,
			],
		]);
		if($totalSum) {
			$expenseTypes = array();
			$expenseTypesRows = ExpenseType::find();
			foreach ($expenseTypesRows as $row) {
				// наполняем массив
				$sum = Expense::sum([
					"column" => "amount", 
					"conditions" => "deleted_at IS NULL AND expense_type_id = ?1 AND organization_id=?2 AND ((target_date_from >= ?3 AND target_date_from < ?4) OR (target_date_to >= ?3 AND target_date_to < ?4))", 
					"bind" => [
						1 => $row->id, 
						2 => $orgID, 
						3 => $periodStart, 
						4 => $periodEnd,
					],
				]);
				$prcnt = $totalSum == 0 ? 0 : $sum/$totalSum;
				$expenseTypes[$row->id] = [
					'name' => $row->name,
					'sum' => $sum,
					'prcnt' => $prcnt > 0 ? number_format($prcnt, 2, '.', '') : 0,
				];
			}
			return $expenses = [
				"year" => $year,
				"years" => $years,
				"expenseTypes" => $expenseTypes,
				"totalSum" => $totalSum,
			];
		}
		else {
			return $expenses = [
				"year" => $year,
				"years" => $years,
			];
		}
	}
}
