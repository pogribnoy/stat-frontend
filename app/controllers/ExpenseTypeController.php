<?php
class ExpenseTypeController extends ControllerBase {
	
	public function initialize() {
		parent::initialize();
		// убираем указание на layout index, чтобы не задваивался вывод
		//$this->view->cleanTemplateAfter();
	}

	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_('text_'.$this->controllerName.'_title'));
		
		$id = $this->request->get('id');
		$expenseType = false;
		$expenseType = ExpenseType::findFirst([
			"conditions" => "id = ?1", 
			"bind" => [1 => $id]
		]);
		if($expenseType) {
			
		}
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
}
