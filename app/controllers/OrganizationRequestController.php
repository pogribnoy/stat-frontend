<?php
class OrganizationRequestController extends ControllerEntity {
	public $entityName  = 'organizationrequest';
	public $tableName  = 'organization_request';
	
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
				'type' => 'label',
				'style' => 'id', //name
				'linkEntityName' => 'organization',
				'linkEntityField' => 'name',
				'newEntityValue' => null,
				'newEntityID' => 'true',
			),
			'topic' => array(
				'id' => 'topic',
				'name' => $this->t->_("text_organizationrequest_topic"),
				'type' => 'select',
				'style' => 'id', //name
				'linkEntityName' => 'OrganizationRequestTopic',
				'required' => 1,
				'newEntityValue' => null,
			), 
			'status' => array(
				'id' => 'status',
				'name' => $this->t->_("text_entity_property_status"),
				'type' => 'label',
				'newEntityID' => 1,
				'newEntityValue' => $this->t->_("status_new"),
			), 
			'request' => array(
				'id' => 'request',
				'name' => $this->t->_("text_organizationrequest_request"),
				'type' => 'textarea',
				'required' => 1,
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
				'required' => 1,
				'newEntityValue' => null,
			), 
			'created_at' => array(
				'id' => 'created_at',
				'name' => $this->t->_("text_entity_property_created_at"),
				'type' => 'label',
				'required' => 1,
				'newEntityValue' => null,
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
		$this->entity->organization_id = $this->filter_values['organization_id'];
		$this->entity->user_id = $this->session->get('auth')['id'];
		$this->entity->status_id = $this->filter_values['status_id'];
		$this->entity->topic_id = $this->fields['topic']['value_id'];
		$this->entity->request = $this->fields['request']['value'];
		$this->entity->response_email = $this->fields['response_email']['value'];
		$this->entity->created_at = (new DateTime('now'))->format("Y-m-d H-M");
	}
	
	/* 
	* Предоставляет текст запроса к БД
	* Переопределяемый метод.
	*/
	public function getPhql() {
		// строим запрос к БД на выборку данных
		return "SELECT OrganizationRequest.*, User.id AS user_id, User.name AS user_name, Organization.id AS organization_id, Organization.name AS rganization_name, OrganizationRequestTopic.id AS organization_request_topic_id, OrganizationRequestTopic.name AS organization_request_topic_name FROM OrganizationRequest JOIN Organization on Organization.id=OrganizationRequest.organization_id JOIN OrganizationRequestTopic on OrganizationRequestTopic.id=OrganizationRequest.topic_id JOIN User on User.id=OrganizationRequest.user_id WHERE Expense.id = '" . $this->filter_values["id"] . "' LIMIT 1";
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
		$this->fields["user"]["value"] = $row->user_name;
		$this->fields["user"]["value_id"] = $row->user_id;
		$this->fields["topic"]["value"] = $row->topic_name;
		$this->fields["topic"]["value_id"] = $row->topic_id;
		$this->fields["request"]["value"] = $row->request;
		$this->fields["response"]["value"] = $row->response;
		$this->fields["response_email"]["value"] = $row->response_email;
		$this->fields["status"]["value"] = $row->status;
		$this->fields["created_at"]["value"] = $row->created_at;
	}
		
	/* 
	* Обновляет данные сущности после сохранения в БД (например, проставляется дата создвания записи)
	* Переопределяемый метод.
	*/
	protected function updateEntityFieldsFromModelAfterSave() {
		$this->fields["id"]["value"] = $row->expense->id;
		$this->fields["created_at"]["value"] = $row->created_at;
	}
	
	/* 
	* Очищает параметры запроса
	* Расширяемый метод.
	*/
	protected function sanitizeSaveRqData($rq) {
		// id, select, link
		if(!parent::sanitizeSaveRqData($rq)) return false;
		// request
		if(isset($rq->fields->request) && isset($rq->fields->request->value)) {
			$val = $this->filter->sanitize(urldecode($rq->fields->request->value), ["trim", "string"]);
			if($val != '') $this->fields['request']['value'] = $val;
			else {
				$this->error['messages'][] = [
					'title' => "Ошибка",
					'msg' => 'Поле "'. $this->fields['request']['name'] .'" обязательно для указания'
				];
				return false;
			}
		}
		else return false;
		// response_email
		if(isset($rq->fields->response_email) && isset($rq->fields->response_email->value)) {
			$val = $this->filter->sanitize(urldecode($rq->fields->response_email->value), ["trim", "email"]);
			if($val != '') $this->fields['response_email']['value'] = $val;
			else {
				$this->error['messages'][] = [
					'title' => "Ошибка",
					'msg' => 'Поле "'. $this->fields['response_email']['name'] .'" обязательно для указания'
				];
				return false;
			}
			//$this->logger->log('val = ' . $val);
		}
		else return false;
		
		return true;
	}
}