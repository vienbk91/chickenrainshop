<?php echo $this->Paginator->counter("Trang {{page}}/{{pages}}, hiển thị {{current}} quyển sách trong tổng số {{count}} quyển."); ?>
</p>
	<ul class="pagination">
		<?= $this->Paginator->prev('<i class="fa fa-fw fa-chevron-left">Quay lại</i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa fa-fw fa-chevron-right">Kế tiếp</i>', ['escape' => false]) ?>
</ul>