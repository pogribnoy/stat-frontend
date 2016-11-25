<?php
class NewsListController extends ControllerBase {
	
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$this->view->setVar("page_header", $this->t->_('text_'.$this->controllerName.'_title'));
		
		$date = new DateTime();
		$date->modify( '-1 year' );
		$fdate = $date->format( «Y-m-d» ); //2008-07-16

		$news_rows = News::find([
			'conditions' => 'active = 1 AND publication_date >= ' . $fdate,
			'order' => 'publication_date DESC',
		]);
		$news = array();
		foreach ($news_rows as $row) {
			// наполняем массив
			$news[$row->id] =  [
				'name' => $row->name,
				'description' => $row->description,
				'publication_date' => $row->publication_date,
			];
		}
		
		$this->view->setVar("news", $news);
	}
}
