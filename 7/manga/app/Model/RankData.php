<?php

class RankData extends AppModel {
    
    // type : total, story, drawing_skill, chara_appeal, world_view
    public $validate = array(
        'book_id' => array(
            'rule' => 'isUnique'
        ),
        'isbn' => array(
            'rule' => 'isUnique'
        )
    );

}