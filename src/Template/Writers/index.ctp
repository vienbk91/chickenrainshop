 <h1><?php echo 'Danh sách tác giả '; ?></h3>
 <h3><?php echo $this->Paginator->sort('name' , 'Sắp xếp theo thứ tự ngược lại'); ?></h3>
<div class="writers index large-9 medium-8 columns content">
<?php 
foreach($writers as $writer) {
    echo $this->Html->link($writer->name , '/tac-gia/' . $writer->slug , array('target' => 'self')) . "<br>";
}
?>
<br><br>
<?php echo $this->element('paginator' , array('object' => 'tác giả')); ?>
</div>
