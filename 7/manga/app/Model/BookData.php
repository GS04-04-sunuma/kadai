<?php

class BookData extends AppModel {
    public $validate = array(
        'isbn' => array(
            'rule' => 'isUnique'
        )   
    );
}