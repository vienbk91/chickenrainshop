<h2><?php echo __('Danh mục 5 quyển sách mới nhất'); ?></h2>
<h4><?php echo $this->Html->link('Xem thêm sách' , '/sach-moi/') ?></h4>
<div class="books index large-9 medium-8 columns content">
   <?php echo $this->element('books' , array('books' => $books)); ?>
</div>
