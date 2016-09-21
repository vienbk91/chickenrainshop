<div class="related">
	<h4><?= __('Tìm kiếm sách') ?></h4>
	<form action="<?php echo Cake\Routing\Router::url('/sach-moi/tim-kiem/'); ?>" method="post" name="searchBook" id="searchBook">
		<input type="text" name="keyword" id="keyword" value="<?php if (isset($searchKey)){ echo $searchKey; } else { echo ""; } ?>">
		<input type="submit" name="searchBtn" id="searchBtn" value="Tìm kiếm" style="background: #966600;float: left;text-transform: uppercase;box-shadow: none;border-width: 0; height: 40px;border: 0px;width: 140px;" />
	</form>
</div>
<br><br>
<div class="books index large-9 medium-8 columns content">
   <?php echo $this->element('books' , array('books' => $books)); ?>
   <?php echo $this->element('paginator' , array('object' => 'quyển sách')); ?>
</div>