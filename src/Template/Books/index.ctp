<h2><?php echo __('Danh mục sách mới'); ?></h2>
<h4><?php echo $this->Html->link('Xem thêm' , '/sachmoi/') ?></h4>
<div class="books index large-9 medium-8 columns content">
   <?php echo $this->element('books' , array('books' => $books)); ?>
   <?= "<hr>" ?>
</div>
