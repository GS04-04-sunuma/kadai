<!-- File: /app/View/Posts/view.ctp -->

<div class="bookdata">

    <h1><?php echo h($book['BookData']['title']); ?></h1>
    <br>

    <div class="bookInfo">
        <p><small>作者:<?php echo $book['BookData']['author']; ?></small></p>
        <p><small>出版社:<?php echo $book['BookData']['manufacturer']; ?></small></p>
        <?php echo $this->Html->image($book['BookData']['imgL']);?>

        <div class="box">
            <canvas id="radarChart" height="450" width="450"></canvas>
            <div id="legend"></div>
        </div>
    </div>
    <div class="evaluation">
    <?php
        $options = array('5' => 'すごくいい!', '4' => 'いい', '3' => 'ふつう', '2' => 'あんまり', '1' => 'うーん..');
        $attributes = array('value' => 3);
        echo $this->Form->create('BookEvaluation', array('url' => array('action' => 'add', $book['BookData']['id'])));
        echo $this->Form->radio('ストーリー', $options, $attributes);
        echo $this->Form->radio('画力', $options, $attributes);
        echo $this->Form->radio('キャラクター', $options, $attributes);
        echo $this->Form->radio('世界観', $options, $attributes);
        echo $this->Form->input('コメント', array('rows' => '3'));
        echo $this->Form->end('評価する');
    ?>
    </div>
</div>

