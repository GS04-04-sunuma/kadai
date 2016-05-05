<!-- File: /app/View/BookDatas/add.ctp -->

<h1>Get BookData</h1>
<?php
echo $this->Form->create('BookData');
echo $this->Form->input('title');
echo $this->Form->end('Save BookData');
?>