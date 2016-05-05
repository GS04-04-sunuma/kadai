<?php

class BookDatasController extends AppController {
    public $helpers = array('Html', 'Form');

    public function index() {
        App::import("Model", "SearchName");
        $searchNameModel = new SearchName();
        $search_name_datas = $searchNameModel->find('all');
        $this->set('search_name_datas', $search_name_datas);
        $array = array();
        foreach ($search_name_datas as $search_name_data) {
            $search_name = $search_name_data['SearchName']['name'];
            $bookData = $this->BookData->query('select * from book_data where searchName="'.$search_name.'";');
            if($bookData!=null && count($bookData)) $array[$search_name] = $bookData;
        }
        $this->set('books', $array);
        //$this->set('books', $this->BookData->find('all'));
    }
    
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $book = $this->BookData->findById($id);
        if (!$book) {
            throw new NotFoundException(__('Invalid book data'));
        }
        $this->set('book', $book);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $titleName = $this->request->data('BookData.title');
            App::import ( "Vendor", "AmazonAPIHelper");
            $apiHelper = new AmazonAPIHelper();
            echo "titleName: \"".$titleName."\"";
            $apiHelper->saveBookDatasInfo($titleName, $this);
            
            App::import("Model", "SearchName");
            $searchNameModel = new SearchName();
            $data = array(
                'SearchName' => array(
                    'name' => $titleName
                )
            );
            $searchNameModel->create($data);
            $searchNameModel->save($data);
        }
    }
    
}