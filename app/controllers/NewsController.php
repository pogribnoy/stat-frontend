<?php
class NewsController extends ControllerBase {
	public function initialize() {
		parent::initialize();
	}
	
	public function indexAction() {
		$id = $this->request->get('id', ["trim", "int"]);
		if ($id != '') {
			$viewCacheKey = $this->controllerName . "_" . $this->actionName . "_" . $id . ".html";
			if (!$this->view->getCache()->exists($viewCacheKey)) {
				$id = $this->request->get('id');
				
				$news_row = false;
				$news_row = News::findFirst([
					"conditions" => "id = ?1", 
					"bind" => [1 => $id]
				]);
				if($news_row) {
					$news = [
						"id" => [
							"value" => $news_row->id,
						],
						"name" => [
							"value" => $news_row->name,
						],
						"description" => [
							"value" => $news_row->description,
						],
						"publication_date" => [
							"name" => $this->t->_("text_" . $this->controllerName . "_publication_date"),
							"value" => $news_row->publication_date,
						],
					];
				}
				else $this->dispatcher->forward([
					'controller' => 'errors',
					'action'     => 'show401',
				]);
				//$this->logger->log(json_encode($news_row));
				//$this->logger->log(json_encode($news));
				
				$this->view->setVar("page_header", $news["name"]["value"] . '<small> (' . $news["publication_date"]["value"]. ')</small>');
				$this->view->setVar("news", $news);
			}
			$this->view->cache([
				"lifetime" => 864000,
				"key"      => $viewCacheKey,
			]);
		}
		else {
			$this->dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show401',
			]);
		}
	}
}
