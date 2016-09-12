<?php 
    foreach ($books as $book) {
    	echo $book->title . "<br>";
        echo $this->Html->link('Xem thêm nội dung sách' , '/books/view/' . $book->slug , array('target' => '_self')) . "<br><br>";
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