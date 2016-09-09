<h2><?php echo __('Sách mới'); ?></h2>
<p>
<?php echo $this->Paginator->sort('title' , 'Sắp xếp theo tên sách'); ?> |
<?php echo $this->Paginator->sort('created' , 'Sắp xếp mới nhất/cũ nhất'); ?>
</p>
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
    	echo "Tác giả: ";
    	foreach ($book->writers as $writer) { 
    		echo $writer->name . "   ";
    	}
    	echo "<hr>";
    }
    ?>
    <p>
    <?php echo $this->element('paginator'); ?>
</div>