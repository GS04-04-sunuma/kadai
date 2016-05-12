<?php

class BookDatasController extends AppController {
    public $helpers = array('Html', 'Form', 'JS');

    public function index() {
        App::import("Model", "RankData");
        $rankDataModel = new RankData();
        // 総合値ランクを取得
        $conditions = array("RankData.type" => "total");
        $total_rank_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('total_rank_data', $total_rank_data);
        // ストーリーランクを取得
        $conditions = array("RankData.type" => "story");
        $story_rank_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('story_rank_data', $story_rank_data);
        // 画力ランクを取得
        $conditions = array("RankData.type" => "drawing_skill");
        $drawing_skill_rank_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('drawing_skill_rank_data', $drawing_skill_rank_data);
        // キャラクターランクを取得
        $conditions = array("RankData.type" => "chara_appeal");
        $chara_appeal_rank_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('chara_appeal_rank_data', $chara_appeal_rank_data);
        // 世界観ランクを取得
        $conditions = array("RankData.type" => "world_view");
        $world_view_rank_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('world_view_rank_data', $world_view_rank_data);
        // 評価数の多い順に取得
        $conditions = array("RankData.type" => "evaluationData_count");
        $evaluationData_count_data = $rankDataModel->find('all', array('conditions' => $conditions));
        $this->set('evaluationData_count_data', $evaluationData_count_data);
    }
    
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid id'));
        }

        $book = $this->BookData->findById($id);
        if (!$book) {
            throw new NotFoundException(__('Invalid book data'));
        }
        
        App::import("Model", "BookEvaluation");
        $bookEvaluation = new BookEvaluation();
        if ($this->request->is('post')) {
            print_r($this->request->data);
            // 評価データの保存
            $evaluation = $this->request->data['BookEvaluation'];
            $evaluationData = array(
                    'BookEvaluation' => array(
                        'book_id' => $id,
                        'story' => $evaluation['ストーリー'],
                        'drawing_skill' => $evaluation['画力'],
                        'chara_appeal' => $evaluation['キャラクター'],
                        'world_view' => $evaluation['世界観'],
                        'total' => intval ($evaluation['ストーリー']) + intval ($evaluation['画力'])
                                            + intval ($evaluation['キャラクター']) + intval ($evaluation['世界観']),
                        'body' => $evaluation['コメント'],
                        'created' => date('Y/m/d H:i:s')
                    )
                );
            $bookEvaluation->create($evaluationData);
            $bookEvaluation->save();
        }
        
        $this->set('book', $book);
        // 漫画データをIDで検索して評価を全て取得　
        $bookEvaluations = $bookEvaluation->findAllByBookId($id);
        $story = 0;
        $drawingSkill = 0;
        $charaAppeal = 0;
        $worldView = 0;
        // 平均値を取得
        foreach($bookEvaluations as $bookEvaluation) {
            $story += $bookEvaluation['BookEvaluation']['story'];
            $drawingSkill += $bookEvaluation['BookEvaluation']['drawing_skill'];
            $charaAppeal += $bookEvaluation['BookEvaluation']['chara_appeal'];
            $worldView += $bookEvaluation['BookEvaluation']['world_view'];
        }
        $count = count($bookEvaluations);
        $story_average = $story == 0 ? 0 : round($story/$count, 1, PHP_ROUND_HALF_DOWN);
        $drawingSkill_average = $drawingSkill == 0? 0 : round($drawingSkill/$count, 1, PHP_ROUND_HALF_DOWN);
        $charaAppeal_average = $charaAppeal == 0? 0 : round($charaAppeal/$count, 1, PHP_ROUND_HALF_DOWN);
        $worldView_average = $worldView == 0? 0 : round($worldView/$count, 1, PHP_ROUND_HALF_DOWN);
        
        $evaluationData = [$story_average, $drawingSkill_average, $charaAppeal_average, $worldView_average];
        $this->set('evaluationData', $evaluationData);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $titleName = $this->request->data('BookData.title');
            App::import ( "Vendor", "AmazonAPIHelper");
            $apiHelper = new AmazonAPIHelper();
            $apiHelper->saveBookDatasInfo($titleName, $this);
            
            App::import("Model", "SearchName");
            $searchNameModel = new SearchName();
            $data = array(
                'SearchName' => array(
                    'name' => $titleName
                )
            );
            $searchNameModel->create($data);
            $searchNameModel->save($data, true);
            return $this->redirect(array('controller' => 'bookdatas', 'action' => 'index'));
        }
        
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
    }

    
}