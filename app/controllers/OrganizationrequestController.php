<?php
class OrganizationrequestController extends ControllerEntity {
	public $entityName = 'OrganizationRequest';
	public $tableName = 'organization_request';
	
	public $access = [
		"edit" => [
			"id" => self::hiddenAccess,
			"status" => self::hiddenAccess,
			"response" => self::hiddenAccess,
			"created_at" => self::hiddenAccess,
		],
	];
	
	public function initialize() {
		parent::initialize();
	}
	
	/* 
	* Заполняет (инициализирует) свойство fields
	* Переопределяемый метод.
	*/
	public function initFields() {
		$this->fields = [
			'id' => array(
				'id' => 'id',
				'name' => $this->t->_("text_entity_property_id"),
				'type' => 'label',
				'newEntityValue' => '-1',
			), 
			'organization' => array(
				'id' => 'organization',
				'name' => $this->t->_("text_entity_property_recipient"),
				'type' => 'link',
				'style' => 'id', //name
				'linkEntityName' => 'Organization',
				'linkEntityField' => 'name',
				'required' => 2,
				'newEntityID' => true, // взять сущность по filter_organization_id
			),
			'expense' => array(
				'id' => 'expense',
				'name' => $this->t->_("text_organizationrequest_expense"),
				'type' => 'link',
				'style' => 'id', //name
				'linkEntityName' => 'Expense',
				'linkEntityField' => 'name',
				'required' => 2,
				'newEntityID' => true, // взять сущность по filter_expense_id
			), 
			/*'topic' => array(
				'id' => 'topic',
				'name' => $this->t->_("text_organizationrequest_topic"),
				'type' => 'select',
				'style' => 'id', //name
				'linkEntityName' => 'OrganizationRequestTopic',
				'required' => 2,
				//'newEntityValue' => null,
			), */
			'status' => array(
				'id' => 'status',
				'name' => $this->t->_("text_entity_property_status"),
				'type' => 'link',
				'style' => 'id', //name
				'linkEntityName' => 'RequestStatus',
				'linkEntityField' => 'name_code',
				'newEntityID' => "1",
				//'newEntityValue' => $this->t->_("status_new"),
			), 
			'request' => array(
				'id' => 'request',
				'name' => $this->t->_("text_organizationrequest_request"),
				'type' => 'textarea',
				'required' => 2,
				'newEntityValue' => null,
			), 
			'response' => array(
				'id' => 'response',
				'name' => $this->t->_("text_organizationrequest_response"),
				'type' => 'label',
				'newEntityValue' => "-",
			), 
			'response_email' => array(
				'id' => 'response_email',
				'name' => $this->t->_("text_organizationrequest_response_email"),
				'type' => 'text',
				'required' => 2,
				'newEntityValue' => null,
			), 
			'created_at' => array(
				'id' => 'created_at',
				'name' => $this->t->_("text_entity_property_created_at"),
				'type' => 'label',
				'required' => 0,
				'newEntityValue' => null,
			),
			'recaptcha' => array(
				'id' => 'recaptcha',
				'name' => $this->t->_("text_entity_property_recaptcha"),
				'type' => 'recaptcha',
				'required' => 2,
				'newEntityValue' => $this->config['application']['reCaptchaPublicKey'],
			), 
		];
		// наполняем поля данными
		parent::initFields();
	}
	
	/* 
	* Наполняет модель сущности из запроса при сохранении
	* Переопределяемый метод.
	*/
	protected function fillModelFieldsFromSaveRq() {
		//$this->entity->id получен ранее при select из БД или будет присвоен при создании записи в БД
		$this->entity->organization_id = $this->fields['organization']['value_id'];
		$this->entity->expense_id = $this->fields['expense']['value_id'];
		$this->logger->log(__METHOD__ . ". organization_id = " . $this->fields['organization']['value_id']);
		
		$this->entity->status_id = $this->fields['status']['value_id'];
		//$this->entity->topic_id = $this->fields['topic']['value_id'];
		$this->entity->request = $this->fields['request']['value'];
		$this->entity->response_email = $this->fields['response_email']['value'];
		
		if($this->isFieldAccessibleForUser($this->fields['created_at'])) $this->entity->created_at = (new DateTime($this->fields['request']['value']))->format("Y-m-d H:i:s");
		else $this->entity->created_at = (new DateTime('now'))->format("Y-m-d H:i:s");
	}
	
	/* 
	* Предоставляет текст запроса к БД
	* Переопределяемый метод.
	*/
	public function getPhql() {
		// строим запрос к БД на выборку данных
		return "SELECT OrganizationRequest.*, Organization.id AS organization_id, Organization.name AS organization_name, Expense.id AS expense_id, Expense.name AS expense_name FROM OrganizationRequest JOIN Organization on Organization.id=OrganizationRequest.organization_id JOIN Expense on Expense.id=OrganizationRequest.expense_id WHERE OrganizationRequest.id = '" . $this->filter_values["id"] . "' LIMIT 1";
	}
	
	/* 
	* Заполняет свойство fields данными, полученными после выборки из БД
	* Переопределяемый метод.
	*/
	public function fillFieldsFromRow($row) {
		//$this->logger->log(json_encode($row));
		$this->fields["id"]["value"] = $row->id;
		$this->fields["organization"]["value"] = $row->organization_name;
		$this->fields["organization"]["value_id"] = $row->organization_id;
		$this->fields["expense"]["value"] = $row->expense_name;
		$this->fields["expense"]["value_id"] = $row->expense_id;
		//$this->fields["topic"]["value"] = $row->topic_name;
		//$this->fields["topic"]["value_id"] = $row->topic_id;
		$this->fields["request"]["value"] = $row->request;
		$this->fields["response"]["value"] = $row->response;
		$this->fields["response_email"]["value"] = $row->response_email;
		$this->fields["status"]["value"] = $row->status;
		$this->fields["created_at"]["value"] = $row->created_at;
	}
	
	protected function sanitizeRqFilters() {
		parent::sanitizeRqFilters();
		
		if(isset($_REQUEST["filter_organization_id"])) $this->filter_values["organization_id"] = $this->filter->sanitize(urldecode($_REQUEST["filter_organization_id"]), ["trim", "int"]); 
		if(isset($_REQUEST["filter_expense_id"])) $this->filter_values["expense_id"] = $this->filter->sanitize(urldecode($_REQUEST["filter_expense_id"]), ["trim", "int"]); 
	}
		
	/* 
	* Обновляет данные сущности после сохранения в БД (например, проставляется дата создания записи)
	* Переопределяемый метод.
	*/
	protected function updateEntityFieldsFromModelAfterSave() {
		$this->fields["id"]["value"] = $this->entity->id;
		$this->fields["created_at"]["value"] = $this->entity->created_at;
	}
	
	public function customizeFields() {
		if(count($this->operations) > 0) {
			foreach ($this->operations as $id => $operation) {
				if($operation['id'] == 'save') $this->operations[$id]['name'] = $this->t->_('button_send');
				elseif($operation['id'] == 'check') unset($this->operations[$id]);
			}
			$this->operations = array_values($this->operations);
		}
		//$this->logger->log(__METHOD__ . ". values2 = " . json_encode($this->fields['status']['values']));
	}
}
