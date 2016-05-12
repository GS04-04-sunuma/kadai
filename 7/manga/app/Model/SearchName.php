<?php

class SearchName extends AppModel {
    public $validate = array(
        'name' => array(
            'rule' => 'isUnique',
            'message' => '入力した漫画タイトルの情報はすでに存在します。'
        )
    );
}