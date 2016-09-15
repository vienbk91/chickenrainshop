<div class="writers view large-9 medium-8 columns content">
    <h3><?= h($writer->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tên tác giả') ?></th>
            <td><?= h($writer->name) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Tiểu sử') ?></h4>
        <?= $this->Text->autoParagraph(h($writer->biography)); ?>
    </div>
    <div class="related">
        <h4><?= __('Sách đã xuất bản') ?></h4>
            <?php 
			    foreach ($books as $book) {
			        echo $this->Html->link($book->title , '/sach-moi/' . $book->slug , array('target' => '_self')) . "<br>";
			    	echo $this->Html->image($book->image , array(
			    			'width' => '120px' ,
			    			'height' => '160px'
			    	)) . "<br><br>";
			    	echo "Giá bán: " . $this->Number->format($book->sale_price , array(
			    			'places' => 0 ,
			    			'after' => 'VND'
			    	)) . "<br>";
			    	echo "Tác giả: ";
			    	//foreach ($book->_machingData['Writers'] as $writer) { 
			    		echo $book->_matchingData['Writers']['name'] . "   ";
			    	//}
			    	echo "<hr>";
			    }
			?>
            <?php echo $this->element('paginator' , array('object' => 'quyển sách')); ?>
    </div>
</div>
