<!-- File: /app/View/BookDatas/index.ctp -->

<?php foreach ($search_name_datas as $search_name_data): ?>
<h1 class="booktitle"><?php echo $search_name_data['SearchName']['name'] ?></h1>
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
