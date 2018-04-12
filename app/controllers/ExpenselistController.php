<?php
class ExpenselistController extends ControllerList {
	public $entityName = 'Expense';
	public $controllerName = "Expenselist";
	public $notCollapsible = 1;
		
	public $defaultSort = [
		"column" => "settlement",
		"order" => "asc",
	];
	
	public function initColumns() {
		// описатель таблицы
		$this->columns = array(
			'expense_type' => array(
				'id' => 'expense_type',
				'name' => $this->controller->t->_("text_expenselist_expense_type"),
				'filter' => 'select',
				'filter_style' => 'id', //name
				'filterLinkEntityName' => 'ExpenseType',
				"sortable" => "DESC",
			),
			'organization' => array(
				'id' => 'organization',
				'name' => $this->controller->t->_("text_entity_property_name"),
				'filter' => 'select',
				'filter_style' => 'id', //name
				//"sortable" => "DESC",
				//'nullSubstitute' => '-',
				'hidden' => 1,
			),
			'settlement' => array(
				'id' => 'settlement',
				'name' => $this->controller->t->_("text_expenselist_settlement"),
				'filter' => 'text',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'name' => array(
				'id' => 'name',
				'name' => $this->controller->t->_("text_expenselist_expense_name"),
				'type' => 'text',
				'filter' => 'text',
				"sortable" => "DESC",
			),
			/*'street_type' => array(
				'id' => 'street_type',
				'name' => $this->controller->t->_("text_entity_property_street_type"),
				'filter' => 'select',
				'filter_style' => 'id', //name
				'filterLinkEntityName' => 'StreetType',
				"sortable" => "DESC",
				'nullSubstitute' => '-',
				//'hideble' => 1,
			),*/
			'street' => array(
				'id' => 'street',
				'name' => $this->controller->t->_("text_entity_property_street"),
				'filter' => 'text',
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
				"sortable" => "DESC",
				'nullSubstitute' => '-',
			),
			'amount' => array(
				'id' => 'amount',
				'name' => $this->controller->t->_("text_entity_property_amount"),
				'filter' => 'text',
				"sortable" => "DESC",
			),
			'target_date' => array(
				'id' => 'target_date',
				'name' => $this->controller->t->_("text_expenselist_target_date"),
				'filter' => 'period',
				//'hideble' => 1,
				'nullSubstitute' => '-',
			),
			'expense_status' => array(
				'id' => 'expense_status',
				'name' => $this->controller->t->_("text_entity_property_status"),
				'filter' => 'select',
				'filter_style' => 'id', //name
				'filterLinkEntityName' => 'ExpenseStatus',
				//'filterLinkEntityFieldID' => 'name',
				//'filterFillConditions' => function() { $conditions = ''; return $conditions; },
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
			if($org) {
				$this->view->page_header = $org->name; //$this->descriptor['page_header'] = $org->name;
				if($this->t->exists('text_' . $this->controllerNameLC . '_description')) $this->view->pageDescription = $this->t->_('text_' . $this->controllerNameLC . '_description', ['param1' => $org->name]);
			}
		}
		//$this->logger->log(json_encode($this->descriptor));
	}
	
	public function getPhqlSelect() {
		$userRoleID = $this->controller->userData['role_id'];
		
		// строим запрос к БД на выборку данных
		$phql = "SELECT <TableName>.*, ExpenseType.id AS expense_type_id, ExpenseType.name AS expense_type_name, ExpenseStatus.id AS expense_status_id, ExpenseStatus.name AS expense_status_name, Organization.id AS organization_id, Organization.name AS organization_name, Region.id AS organization_region_id, Region.name AS organization_region_name, StreetType.id AS street_type_id, StreetType.name AS street_type_name FROM <TableName> JOIN ExpenseType on ExpenseType.id=<TableName>.expense_type_id JOIN Organization ON Organization.id = <TableName>.organization_id JOIN Region ON Region.id = Organization.region_id LEFT JOIN StreetType ON StreetType.id = <TableName>.street_type_id LEFT JOIN ExpenseStatus ON ExpenseStatus.id = <TableName>.expense_status_id";
		
		$phql .= " WHERE <TableName>.deleted_at IS NULL";
		
		// уточняем выборку, если переданы доп. фильтры, которые могут навязывать внешние контроллеры
		if(isset($this->add_filter["organization_id"])) {
			$phql .= " AND <TableName>.organization_id = " . $this->add_filter["organization_id"];
		}
		
		return $phql;
	}
	
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
			if($val != '') {
				//$this->filter_values["organization"] =  $val;
				if(!isset($this->add_filter['organization_id'])) $this->add_filter['organization_id'] = $val;
			}
		}
	}
	
	protected function addSortToPhql($phql) {
		$phql = parent::addSortToPhql($phql);
		$phql .= ', Expense.street ' . $this->filter_values['order'];
		return $phql;
	}
	
	protected function addSpecificSortLimitToPhql($phql, $id) {
		$filter_values = $this->filter_values;
		if($id == 'expense_status') return $phql .= ' ORDER BY ExpenseStatus.name ' . $filter_values['order'];
		else if($id == 'expense_type') return $phql .= ' ORDER BY ExpenseType.name ' . $filter_values['order'];
		//else if ($id == 'street_type') return $phql .= ' ORDER BY StreetType.name ' . $filter_values['order'];
		return null;
	}
	
	public function fillFieldsFromRow($row) {
		$item = array(
			"fields" => array(
				"id" => array(
					'id' => 'id',
					'value' => $row->expense->id,
				),
				"organization" => array(
					'value_id' => $row->organization_id ? $row->organization_id : '',
					'value' => $this->getFieldValueFromModel($row->organization_id, $this->columns["organization"]),//$row->organization_name ? $row->organization_name : '',
				),
				"settlement" => array(
					'id' => 'settlement',
					'value' => $this->getFieldValueFromModel($row->expense->settlement, $this->columns["settlement"]),//$row->expense->settlement ? $row->expense->settlement : '',
				),
				"expense_type" => array(
					'value_id' => $row->expense_type_id ? $row->expense_type_id : '',
					'value' => $this->getFieldValueFromModel($row->expense_type_name, $this->columns["expense_type"]),//$row->expense_type_name ? $row->expense_type_name : '',
				),
				/*"street_type" => array(
					'value_id' => $row->street_type_id ? $row->street_type_id : '',
					'value' => $row->street_type_name ? $row->street_type_name : '',
				),*/
				"street" => array(
					'id' => 'street',
					'value' => $this->getFieldValueFromModel($row->expense->street, $this->columns["street"]),//($row->expense->street && !($this->columns["street"]["nullSubstitute"] && $row->expense->street == $this->columns["street"]["nullSubstitute"])) ? $row->expense->street : '',
					'values' => [
						'street_type' => [
							'value_id' => $row->street_type_id ? $row->street_type_id : '',
							'value' => $row->street_type_name ? $row->street_type_name : '',
						],
					],
				),
				"house" => array(
					'id' => 'house',
					'value' => $this->getFieldValueFromModel($row->expense->house, $this->columns["house"]),//$row->expense->house ? $row->expense->house: '',
				),
				"name" => array(
					'id' => 'name',
					'value' => $this->getFieldValueFromModel($row->expense->name, $this->columns["name"]),// $row->expense->name ? $row->expense->name: '',
				),
				"amount" => array(
					'id' => 'amount',
					//'value' => $row->expense->amount != null ? number_format($row->expense->amount / 100, 2, '.', ' ') : '',
					'value' => $this->getFieldValueFromModel($row->expense->amount, $this->columns["amount"]),//$row->expense->amount ? $row->expense->amount : '',
				),
				"target_date" => array(
					'id' => 'target_date',
					'value1' => $row->expense->target_date_from ? $row->expense->target_date_from : '',
					'value2' => $row->expense->target_date_to ? $row->expense->target_date_to : '',
				),
				"expense_status" => array(
					'value_id' => $row->expense_status_id ? $row->expense_status_id : '',
					'value' => $this->getFieldValueFromModel($row->expense_status_name, $this->columns["expense_status"]),//$row->expense_status_name ? $row->expense_status_name : '',
				),
				"executor" => array(
					'id' => 'executor',
					'value' => $this->getFieldValueFromModel($row->expense->executor, $this->columns["executor"]),// $row->expense->executor ? $row->expense->executor : '',
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
				'title' => $this->t->exists('button_question_title') ? $this->t->_('button_question_title') : null,
			];
		}
	}
}
