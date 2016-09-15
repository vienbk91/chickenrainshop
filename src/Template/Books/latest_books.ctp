<h2><?php echo __('Sách mới'); ?></h2>
<p>
<?php echo $this->Paginator->sort('title' , 'Sắp xếp theo tên sách'); ?> |
<?php echo $this->Paginator->sort('created' , 'Sắp xếp mới nhất/cũ nhất'); ?>
</p>
<div class="books index large-9 medium-8 columns content">
	<?php 
		$this->Paginator->options(['url' => ['controller' => 'sach-moi']]); 
	?>
    <?php echo $this->element('books' , array('books' => $books)); ?>
    <p>
    <?php echo $this->element('paginator' , array('object' => 'quyển sách')); ?>
</div>