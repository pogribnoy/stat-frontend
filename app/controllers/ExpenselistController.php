<?php
class ExpenselistController extends ControllerList {
	public $entityName = 'Expense';
	public $controllerName = "Expenselist";
	public $notCollapsible = 1;
	
	public function initialize() {
		parent::initialize();
	}
	
	
	/* 
	* Заполняет (инициализирует) свойство colmns
	* Переопределяемый метод.
	*/
	public function initColumns() {
		// описатель таблицы
		$this->columns = array(
			'expense_type' => array(
				'id' => 'expense_type',
				'name' => $this->controller->t->_("text_expenselist_expense_type"),
				'filter' => 'select',
				//'filter_value' => isset($this->filter_values['expense_type']) ? $this->filter_values['expense_type'] : '',
				'filter_style' => 'id', //name
				//'filter_id' => 'expense_type_id', // задается, если отличается от id
				//'style' => 'id',
				"sortable" => "DESC",
			),
			'organization' => array(
				'id' => 'organization',
				'name' => $this->controller->t->_("text_entity_property_name"),
				'filter' => 'select',
				//'filter_value' => isset($this->filter_values['street_type']) ? $this->filter_values['street_type'] : '',
				'filter_style' => 'id', //name
				//'filter_id' => 'street_type_id', // задается, если отличается от id
				//'style' => 'id',
				//"sortable" => "DESC",
				//'nullSubstitute' => '-',
				'hidden' => 1,
			),
			'settlement' => array(
				'id' => 'settlement',
				'name' => $this->controller->t->_("text_expenselist_settlement"),
				'filter' => 'text',
				//'filter_value' => isset($this->filter_values['settlement']) ? $this->filter_values['settlement'] : '',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'name' => array(
				'id' => 'name',
				'name' => $this->controller->t->_("text_expenselist_expense_name"),
				'type' => 'text',
				'filter' => 'text',
				//'filter_value' => isset($this->filter_values['name']) ? $this->filter_values['name'] : '',
				"sortable" => "DESC",
			),
			'street_type' => array(
				'id' => 'street_type',
				'name' => $this->controller->t->_("text_entity_property_street_type"),
				'filter' => 'select',
				//'filter_value' => isset($this->filter_values['street_type']) ? $this->filter_values['street_type'] : '',
				'filter_style' => 'id', //name
				//'filter_id' => 'street_type_id', // задается, если отличается от id
				//'style' => 'id',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
				'hideble' => 1,
			),
			'street' => array(
				'id' => 'street',
				'name' => $this->controller->t->_("text_entity_property_street"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['street']) ? $this->filter_values['street'] : '',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'house' => array(
				'id' => 'house',
				'name' => $this->controller->t->_("text_entity_property_house_building"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['house']) ? $this->filter_values['house'] : '',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'executor' => array(
				'id' => 'executor',
				'name' => $this->controller->t->_("text_entity_property_executor"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['executor']) ? $this->filter_values['executor'] : '',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'amount' => array(
				'id' => 'amount',
				'name' => $this->controller->t->_("text_entity_property_amount"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['amount']) ? $this->filter_values['amount'] : '',
				"sortable" => "DESC",
			),
			'target_date' => array(
				'id' => 'target_date',
				'name' => $this->controller->t->_("text_expenselist_target_date"),
				'filter' => 'period',
				'filter_value' => isset($this->filter_values['target_date']) ? $this->filter_values['target_date'] : '',
				'hideble' => 1,
				'nullSubstitute' => '-',
			),
			'expense_status' => array(
				'id' => 'expense_status',
				'name' => $this->controller->t->_("text_entity_property_status"),
				'filter' => 'select',
				'filter_value' => isset($this->filter_values['expense_status']) ? $this->filter_values['expense_status'] : '',
				'filter_style' => 'id', //name
				//'filter_id' => 'expense_status_id', // задается, если отличается от id
				//'style' => 'id',
				"sortable" => "DESC",
			),
			'operations' => array(
				'id' => 'operations',
				'name' => $this->controller->t->_("text_entity_property_actions"),
			)
		);
	}
	
	public function createDescriptorObject() {
		parent::createDescriptorObject();
		
		if(isset($this->filter_values["organization"])) {
			$org = false;
			$org = Organization::findFirst(['conditions' => 'id=?1', 'bind' => [1 => $this->filter_values["organization"]]]);
			if($org) $this->view->setVar('page_header', $org->name); //$this->descriptor['page_header'] = $org->name;
		}
		//$this->logger->log(json_encode($this->descriptor));
	}
	
	/* 
	* Заполняет свойство columns данными списков из связанных таблиц
	* Переопределяемый метод.
	*/
	public function fillColumnsWithLists() {
		
		// типы расходов для фильтрации
		$expense_type_rows = ExpenseType::find();
		$expense_types = array();
		foreach ($expense_type_rows as $row) {
			// наполняем массив
			$expense_types[] = array(
				'id' => $row->id,
				"name" => $row->name
			);
		}
		$this->columns['expense_type']['filter_values'] = $expense_types;
		
		// статусы расходов для фильтрации
		$expense_status_rows = ExpenseStatus::find();
		$expense_statuses = array();
		foreach ($expense_status_rows as $row) {
			// наполняем массив
			$expense_statuses[] = array(
				'id' => $row->id,
				"name" => $row->name
			);
		}
		$this->columns['expense_status']['filter_values'] = $expense_statuses;
		
		// типы улиц для фильтрации
		$street_type_rows = StreetType::find();
		$street_types = array();
		foreach ($street_type_rows as $row) {
			// наполняем массив
			$street_types[] = array(
				'id' => $row->id,
				"name" => $row->name
			);
		}
		$this->columns['street_type']['filter_values'] = $street_types;
	}
	
	/* 
	* Предоставляет базовый текст запроса к БД
	* Переопределяемый метод.
	*/
	public function getPhqlSelect() {
		$userRoleID = $this->controller->userData['role_id'];
		
		// строим запрос к БД на выборку данных
		$phql = "SELECT <TableName>.*, ExpenseType.id AS expense_type_id, ExpenseType.name AS expense_type_name, ExpenseStatus.id AS expense_status_id, ExpenseStatus.name AS expense_status_name, Organization.id AS organization_id, Organization.name AS organization_name, Region.id AS organization_region_id, Region.name AS organization_region_name, StreetType.id AS street_type_id, StreetType.name AS street_type_name FROM <TableName> JOIN ExpenseType on ExpenseType.id=<TableName>.expense_type_id JOIN Organization ON Organization.id = <TableName>.organization_id JOIN Region ON Region.id = Organization.region_id LEFT JOIN StreetType ON StreetType.id = <TableName>.street_type_id LEFT JOIN ExpenseStatus ON ExpenseStatus.id = <TableName>.expense_status_id";
		$phql .= " WHERE 1=1";
		
		return $phql;
	}
	
	/* 
	* Добавляет текст запроса к БД параметры фильтрации
	* Расширяемый метод
	*/
	/*public function addFilterValuesToPhql($phql) {
		$phql = parent::addFilterValuesToPhql($phql);
		
		//if(isset($this->filter_values["expense_type_id"]) && isset($this->columns['expense_type_id'])) $phql .= " AND ExpenseType.id = '" . $this->filter_values["expense_type_id"] . "'";
		
		return $phql;
	}*/
	
	protected function addSpecificFilterValuesToPhql($phql, $id) { 
		$filter_values = $this->filter_values;
		$column =  $this->columns[$id];
		if ($id == 'target_date') {
			if(isset($column["nullSubstitute"]) && $filter_values[$id] == $column["nullSubstitute"]) return $phql .= " AND (<TableName>." . $id . "_from IS NULL OR <TableName>." . $id . "_from = '' OR <TableName>." . $id . "_from = '" . $column["nullSubstitute"] . "' OR (<TableName>." . $id . "_to IS NULL OR <TableName>." . $id . "_to = '' OR <TableName>." . $id . "_to = '" . $column["nullSubstitute"] . "'))";
			else return $phql .= " AND (<TableName>." . $id . "_from LIKE '%" . $filter_values[$id] . "%' OR <TableName>." . $id . "_to LIKE '%" . $filter_values[$id] . "%')";
		}
		return null; 
	}
	
	protected function addNonColumnsFilters() {
		if(isset($_REQUEST["filter_organization"])) {
			$val = $this->filter->sanitize(urldecode($_REQUEST["filter_organization"]), ['trim',"int"]);
			if($val != '') $this->filter_values["organization"] =  $val;
		}
	}
	
	protected function addSpecificSortLimitToPhql($phql, $id) {
		$filter_values = $this->filter_values;
		if ($id == 'street_type') return $phql .= ' ORDER BY StreetType.name ' . $filter_values['order'];
		else if($id == 'expense_type') return $phql .= ' ORDER BY ExpenseType.name ' . $filter_values['order'];
		else if($id == 'expense_status') return $phql .= ' ORDER BY ExpenseStatus.name ' . $filter_values['order'];
		return null;
	}
	
	/* 
	* Заполняет свойство items['fields'] данными, полученными после выборки из БД
	* Переопределяемый метод.
	*/
	public function fillFieldsFromRow($row) {
		$item = array(
			"fields" => array(
				"id" => array(
					'id' => 'id',
					'value' => $row->expense->id,
				),
				"organization" => array(
					'value_id' => $row->organization_id ? $row->organization_id : '',
					'value' => $row->organization_name ? $row->organization_name : '',
				),
				"settlement" => array(
					'id' => 'settlement',
					//'value_id' => $row->expense->organization_id ? $row->expense->organization_id : '',
					'value' => $row->expense->settlement ? $row->expense->settlement : '',
				),
				"expense_type" => array(
					'value_id' => $row->expense_type_id ? $row->expense_type_id : '',
					'value' => $row->expense_type_name ? $row->expense_type_name : '',
				),
				"street_type" => array(
					'value_id' => $row->street_type_id ? $row->street_type_id : '',
					'value' => $row->street_type_name ? $row->street_type_name : '',
				),
				"street" => array(
					'id' => 'street',
					'value' => $row->expense->street ? $row->expense->street : '',
				),
				"house" => array(
					'id' => 'house',
					'value' => $row->expense->house ? $row->expense->house: '',
				),
				"name" => array(
					'id' => 'name',
					'value' =>  $row->expense->name ? $row->expense->name: '',
				),
				"amount" => array(
					'id' => 'amount',
					//'value' => $row->expense->amount != null ? number_format($row->expense->amount / 100, 2, '.', ' ') : '',
					'value' => $row->expense->amount ? $row->expense->amount : '',
				),
				"target_date" => array(
					'id' => 'target_date',
					'value1' => $row->expense->target_date_from ? $row->expense->target_date_from : '',
					'value2' => $row->expense->target_date_to ? $row->expense->target_date_to : '',
				),
				"expense_status" => array(
					'value_id' => $row->expense_status_id ? $row->expense_status_id : '',
					'value' => $row->expense_status_name ? $row->expense_status_name : '',
				),
				"executor" => array(
					'id' => 'executor',
					'value' =>  $row->expense->executor ? $row->expense->executor : '',
				),
			)
		);
		
		//if($filter_values["organization_id"]) $item['fields']['organization_name']['url'] = '/organization?id=' . $row->organization_id;
		$this->items[] = $item;
	}

	public function fillOperations() {
		parent::fillOperations();
		if($this->acl->isAllowed($this->userData['role_id'], 'organizationrequest', 'question')) {
			if(!isset($this->operations["item_operations"])) $this->operations["item_operations"] = [];
			$this->operations["item_operations"][] = [
				'id' => 'question',
				'name' => $this->t->_('button_question'),
			];
		}
	}
}
