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
				$curD = new DateTime('now');
				$curDate = $curD->format("Y-m-d");
				$year = $curD->format("Y");
				$periodS = DateTime::createFromFormat('Y-m-d', $year . '-01-01');
				$periodStart = $periodS->format("Y-m-d");
				$periodE = DateTime::createFromFormat('Y-m-d', ((int)$year + 1) . '-01-01');
				$periodEnd = $periodE->format("Y-m-d");
				//$this->logger->log('periodStart = ' . $periodStart);
				//$this->logger->log('periodEnd = ' . $periodEnd);
				
				
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
				}
				else {
					$this->dispatcher->forward([
						'controller' => 'errors',
						'action'     => 'show401',
					]);
					return;
				}
				// изображения
				$file_rows = false;
				$file_rows = $row->getFile();
				if($file_rows && count($file_rows)>0) {
					//$this->logger->log(json_encode($file_rows));
					$org["img"]["href"] = $this->config->application->commonUpploadURL . $file_rows[0]->directory . $file_rows[0]->name;			
				}
				
				// данные о регионе
				$row = false;
				$row = Region::findFirst([
					"conditions" => "id = ?1", 
					"bind" => [1 => $org["region"]["value_id"]]
				]);
				if($row) $org["region"]["value"] = $row->name;
				
				
				//$this->logger->log(json_encode($org));
				
				$expenseTypesRows = ExpenseType::find();
				$expenseTypes = array();
				foreach ($expenseTypesRows as $row) {
					// наполняем массив
					$expenseTypes[$row->id] = [
						'name' => $row->name,
						'sum' => Expense::sum([
							"column" => "amount", 
							"conditions" => "expense_type_id = ?1 AND organization_id=?2 AND date >= ?3 AND date < ?4", 
							"bind" => [
								1 => $row->id, 
								2 => $org["id"]["value"], 
								3 => $periodStart, 
								4 => $periodEnd,
							],
						]),
					];
					$totalSum = Expense::sum([
						"column" => "amount", 
						"conditions" => "organization_id=?1", 
						"bind" => [1 => $org["id"]["value"]]
					]);
					$expenseTypes[$row->id]['prcnt'] = number_format($expenseTypes[$row->id]['sum']/$totalSum, 2, '.', '');
					//$expenseTypes[$row->id]['sum'] = number_format($expenseTypes[$row->id]['sum']/100, 2, '.', '');
					//$expenseTypes[$row->id]['sum'] = $expenseTypes[$row->id]['sum'];
				}
				//$this->logger->log('expenseTypes: ' . json_encode($expenseTypes));
				
				$this->view->setVar("page_header", $org["name"]["value"]);
				$this->view->setVar("org", $org);
				$this->view->setVar("year", $year);
				$this->view->setVar("expenseTypes", $expenseTypes);
			}
			$this->view->cache([
				//"lifetime" => 60,
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
}
