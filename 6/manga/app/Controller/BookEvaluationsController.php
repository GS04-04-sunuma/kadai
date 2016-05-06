<?php

class BookEvaluationsController extends AppController {
    public $helpers = array('Html', 'Form');
    
    public function add($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        
        if ($this->request->is('post')) {
            print_r($this->request->data);
            $evaluation = $this->request->data['BookEvaluation'];
            $data = array(
                    'BookEvaluation' => array(
                        'book_id' => $id,
                        'story' => $evaluation['ストーリー'],
                        'drawing_skill' => $evaluation['画力'],
                        'chara_appeal' => $evaluation['キャラクター'],
                        'world_view' => $evaluation['世界観'],
                        'body' => $evaluation['コメント'],
                        'created' => date('Y/m/d H:i:s')
                    )
                );
            $this->BookEvaluation->create($data);
            $this->BookEvaluation->save();
            $this->redirect(array('controller' => 'bookdatas', 'action' => 'index'));
            //$this->Flash->success(__('Your post has been updated.'));
        }
    }
}