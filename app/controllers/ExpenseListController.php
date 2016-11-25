<?php
class ExpenseListController extends ControllerList {
	public $entityName = 'expense';
	public $controllerName = "expenselist";
	
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		parent::indexAction();
		// переопределяем название
		//$this->view->setVar("page_header", $this->t->_('text_'.$this->controllerName.'_title'));
		//str_replace("$expenseType", isset($this->filter_values['expense_type_id']) ? $this->filter_value['expense_type_id'] : '', $phql);
		
		$totalSum = Expense::sum(["column" => "amount"]);
		$expenseTypesRows = ExpenseType::find();
		$expenseTypes = array();
		foreach ($expenseTypesRows as $row) {
			// наполняем массив
			$expenseTypes[$row->id] = [
				'name' => $row->name,
				'sum' => Expense::sum([
					"column" => "amount", 
					"conditions" => "expense_type_id = ?1", 
					"bind" => [1 => $row->id]
				]),
			];
			$this->logger->log('sum: ' . json_encode($expenseTypes));
			$expenseTypes[$row->id]['prcnt'] = $expenseTypes[$row->id]['sum']/$totalSum*100;
		}
		
		$this->view->setVar("expenseTypes", $expenseTypes);
	}
	
	/* 
	* Заполняет (инициализирует) свойство colmns
	* Переопределяемый метод.
	*/
	public function initColumns() {
		// описатель таблицы
		$this->columns = array(
			/*'id' => array(
				'id' => 'id',
				'name' => $this->controller->t->_("text_entity_property_id"),
				'type' => 'number',
				'filter' => 'number',
				'filter_value' => isset($this->filter_values['id']) ? $this->filter_values['id'] : '',
				"sortable" => "DESC"
			),*/
			'organization_region' => array(
				'id' => 'organization_region',
				'name' => $this->controller->t->_("text_expenselist_organization_region"),
				'filter' => 'select',
				'filter_value' => isset($this->filter_values['organization_region']) ? $this->filter_values['organization_region'] : '',
				'style' => 'id',
				"sortable" => "DESC",
				"hideble" => 'true',
			),
			'name' => array(
				'id' => 'name',
				'name' => $this->controller->t->_("text_expenselist_expense_name"),
				'type' => 'text',
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['name']) ? $this->filter_values['name'] : '',
				"sortable" => "DESC",
			),
			'organization_name' => array(
				'id' => 'organization_name',
				'name' => $this->controller->t->_("text_expenselist_organization_name"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['organization_name']) ? $this->filter_values['organization_name'] : '',
				"sortable" => "DESC",
			),
			'amount' => array(
				'id' => 'amount',
				'name' => $this->controller->t->_("text_entity_property_amount"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['amount']) ? $this->filter_values['amount'] : '',
				"sortable" => "DESC",
			),
			'date' => array(
				'id' => 'date',
				'name' => $this->controller->t->_("text_entity_property_date"),
				'filter' => 'text',
				'filter_value' => isset($this->filter_values['date']) ? $this->filter_values['date'] : '',
				"sortable" => "DESC",
			),
			'expense_type' => array(
				'id' => 'expense_type',
				'name' => $this->controller->t->_("text_expenselist_expensetype"),
				'filter' => 'select',
				'filter_value' => isset($this->filter_values['expense_type_id']) ? $this->filter_values['expense_type_id'] : '',
				'filter_id' => 'expense_type_id', // задается, если отличается от id
				'style' => 'id',
				"sortable" => "DESC",
			),
			'operations' => array(
				'id' => 'operations',
				'name' => $this->controller->t->_("text_entity_property_actions"),
			)
		);
	}
	
	/* 
	* Заполняет свойство columns данными списков из связанных таблиц
	* Переопределяемый метод.
	*/
	public function fillColumnsWithLists() {
		// регионы для фильтрации
		$regions_rows = Region::find();
		$regions = array();
		foreach ($regions_rows as $row) {
			// наполняем массив
			$regions[] = array(
				'id' => $row->id,
				"name" => $row->name
			);
		}
		$this->columns['organization_region']['filter_values'] = $regions;
		
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
	}
	
	/* 
	* Предоставляет базовый текст запроса к БД
	* Переопределяемый метод.
	*/
	public function getPhqlSelect() {
		$userRoleID = $this->controller->userData['role_id'];
		
		// строим запрос к БД на выборку данных
		$phql = "SELECT <TableName>.*, ExpenseType.id AS expense_type_id, ExpenseType.name AS expense_type_name, Organization.id AS organization_id, Organization.name AS organization_name, Region.id AS organization_region_id, Region.name AS organization_region_name FROM <TableName> JOIN ExpenseType on ExpenseType.id=<TableName>.expense_type_id JOIN Organization ON Organization.id = <TableName>.organization_id JOIN Region ON Region.id = Organization.region_id";
		
		$phql .= " WHERE 1=1";
		
		return $phql;
	}
	
	/* 
	* Добавляет текст запроса к БД параметры фильтрации
	* Расширяемый метод
	*/
	public function addFilterValuesToPhql($phql) {
		$phql = parent::addFilterValuesToPhql($phql);
		
		//if(isset($this->filter_values["expense_type_id"]) && isset($this->columns['expense_type_id'])) $phql .= " AND ExpenseType.id = '" . $this->filter_values["expense_type_id"] . "'";
		
		return $phql;
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
				"organization_region" => array(
					'value_id' => $row->organization_region_id ? $row->organization_region_id : '',
					'value' => $row->organization_region_name ? $row->organization_region_name : '',
				),
				"name" => array(
					'id' => 'name',
					'value' =>  $row->expense->name,
				),
				"organization_name" => array(
					'value_id' => $row->organization_id ? $row->organization_id : '',
					'value' => $row->organization_name ? $row->organization_name : '',
				),
				"amount" => array(
					'id' => 'amount',
					'value' => $row->expense->amount ? number_format($row->expense->amount / 100, 2, '.', ' ') : '',
				),
				"date" => array(
					'id' => 'date',
					'value' => $row->expense->date ? $row->expense->date : '',
				),
				"expense_type" => array(
					'value_id' => $row->expense_type_id ? $row->expense_type_id : '',
					'value' => $row->expense_type_name ? $row->expense_type_name : '',
				)
			)
		);
		if($row->organization_id) $item['fields']['organization_name']['url'] = '/organization?id=' . $row->organization_id;
		$this->items[] = $item;
	}
}