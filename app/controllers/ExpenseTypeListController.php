<?php
class ExpenseTypeListController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_('text_'.$this->controllerName.'_title'));
		//parent::indexAction();
		
		
		$expenseTypesRows = ExpenseType::find();
		$expenseTypes = array();
		foreach ($expenseTypesRows as $row) {
			// наполняем массив
			$expenseTypes[$row->id] = [
				'name' => $row->name,
				'sum' => Expense::sum([
					"column" => "amount", 
					"conditions" => "expense_type_id = ?1", 
					"bind" => [1 => $row->id],
				]),
			];
			$this->logger->log('sum: ' . json_encode($expenseTypes));
			$totalSum = Expense::sum(["column" => "amount"]);
			$expenseTypes[$row->id]['prcnt'] = number_format($expenseTypes[$row->id]['sum']/$totalSum, 2, '.', '');
			$expenseTypes[$row->id]['sum'] = number_format($expenseTypes[$row->id]['sum']/100, 2, '.', '');
		}
		
		$this->view->setVar("expenseTypes", $expenseTypes);
	}
}
