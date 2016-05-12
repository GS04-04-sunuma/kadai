<!-- File: /app/View/BookDatas/add.ctp -->

<h1>評価したい漫画のタイトルを入力してください</h1>
<?php
echo $this->Form->create('BookData', array('onsubmit'=>'return confirmBox();'));
echo $this->Form->input('漫画のタイトル');
echo $this->Form->end('入力した漫画のデータを取得');
?>
<?php echo $this->Flash->render() ?>

<script type="text/javascript">
    function confirmBox() {
        if (window.confirm('入力された漫画のタイトルで情報を取得します。')) {
            onClick = "loading()";
            location.href = "<?php echo $this->Html->url('/add'); ?>";
            $.blockUI();
        } else {
            window.alert('キャンセルしました');
            return false;
        }
    }
</script>


<h2 class="booktitle">これまで取得した漫画のデータ</h2>
<?php foreach ($search_name_datas as $search_name_data): ?>
<h3 class="booksubtitle"><?php echo $search_name_data['SearchName']['name'] ?></h3>
    <ul class="sample">
        <?php $searchName = $search_name_data['SearchName']['name']; ?>
        <?php if(isset($books[$searchName])): ?>
        <?php foreach ($books[$searchName] as $book): ?>
        <li>
           <?php echo $this->Html->image($book['book_data']['imgM'],array('url'=>array('action' => 'view', $book['book_data']['id'])));?>
        </li>
        <?php endforeach; ?>
        <?php unset($book); ?>
        <?php endif; ?>
    </ul>
<?php endforeach; ?>
<?php unset($search_name_data); ?>