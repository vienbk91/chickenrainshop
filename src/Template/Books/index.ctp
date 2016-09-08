<!-- 
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Book'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Writers'), ['controller' => 'Writers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Writer'), ['controller' => 'Writers', 'action' => 'add']) ?></li>
    </ul>
</nav>
 -->
<h2><?php echo __('Danh mục sách mới'); ?></h2>
<div class="books index large-9 medium-8 columns content">
    <?php 
    foreach ($books as $book) {
    	echo $book->title . "<br><br>";
    	echo $this->Html->image($book->image , array(
    			'width' => '120px' ,
    			'height' => '160px'
    	)) . "<br><br>";
    	echo "Giá bán: " . $this->Number->format($book->sale_price , array(
    			'places' => 0 ,
    			'after' => 'VND'
    	)) . "<br>";
    	echo "<hr>";
    }
    ?>
</div>
