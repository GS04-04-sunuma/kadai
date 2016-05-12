<?php

class BookEvaluation extends AppModel {
    
    public $validate = array(
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
}