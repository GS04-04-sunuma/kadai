<!-- File: /app/View/BookDatas/index.ctp -->
<h2 class="booktitle">漫画評価ランキング</h2>
<h3 class="booksubtitle">総合ランキング</h3>
<ul class="sample">
    <?php foreach ($total_rank_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>
<h3 class="booksubtitle">ストーリーがいいランキング</h3>
<ul class="sample">
    <?php foreach ($story_rank_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>
<h3 class="booksubtitle">作画がすごいランキング</h3>
<ul class="sample">
    <?php foreach ($drawing_skill_rank_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>
<h3 class="booksubtitle">キャラクターがいいランキング</h3>
<ul class="sample">
    <?php foreach ($chara_appeal_rank_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>
<h3 class="booksubtitle">世界観がすごいランキング</h3>
<ul class="sample">
    <?php foreach ($world_view_rank_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>
<h3 class="booksubtitle">評価数ランキング</h3>
<ul class="sample">
    <?php foreach ($evaluationData_count_data as $rank_data): ?>
    <li>
       <?php echo $this->Html->image($rank_data['RankData']['imgM'],array('url'=>array('action' => 'view', $rank_data['RankData']['book_id'])));?>
    </li>
    <?php endforeach; ?>
    <?php unset($book); ?>
</ul>

<h3 class="booksubtitle">今評価された漫画</h3>

<h3 class="booksubtitle">オススメタグランキング</h3>

