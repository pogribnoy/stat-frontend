<?php
class OrganizationController extends ControllerBase {
	
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$id = $this->request->get('id');
		
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
		else $this->dispatcher->forward([
			'controller' => 'errors',
			'action'     => 'show401',
		]);
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
		
		$this->view->setVar("page_header", $org["name"]["value"]);
		$this->view->setVar("org", $org);
	}
}
