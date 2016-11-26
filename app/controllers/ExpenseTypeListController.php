<?php
class ExpenseTypeListController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_('text_'.$this->controllerName.'_title'));
		//parent::indexAction();
		
		$curD = new DateTime('now');
		$curDate = $curD->format("Y-m-d");
		$year = $curD->format("Y");
		$periodS = DateTime::createFromFormat('Y-m-d', $year . '-01-01');
		$periodStart = $periodS->format("Y-m-d");
		$periodE = DateTime::createFromFormat('Y-m-d', ((int)$year + 1) . '-01-01');
		$periodEnd = $periodE->format("Y-m-d");
		
		
		$expenseTypesRows = ExpenseType::find();
		$expenseTypes = array();
		foreach ($expenseTypesRows as $row) {
			// наполняем массив
			$expenseTypes[$row->id] = [
				'name' => $row->name,
				'sum' => Expense::sum([
					"column" => "amount", 
					"conditions" => "expense_type_id = ?1 AND date >= ?2 AND date < ?3", 
					"bind" => [
						1 => $row->id,
						2 => $periodStart, 
						3 => $periodEnd,
					],
				]),
			];
			$this->logger->log('sum: ' . json_encode($expenseTypes));
			$totalSum = Expense::sum(["column" => "amount"]);
			$expenseTypes[$row->id]['prcnt'] = number_format($expenseTypes[$row->id]['sum']/$totalSum, 2, '.', '');
			$expenseTypes[$row->id]['sum'] = number_format($expenseTypes[$row->id]['sum']/100, 2, '.', '');
		}
		
		$this->view->setVar("expenseTypes", $expenseTypes);
		$this->view->setVar("year", $year);
	}
}
