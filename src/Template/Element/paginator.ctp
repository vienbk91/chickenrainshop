<?php echo $this->Paginator->counter("Trang {{page}}/{{pages}}, hiển thị {{current}} " . $object . " trong tổng số {{count}} ". $object ."."); ?>
</p>
	<ul class="pagination">
		<?= $this->Paginator->prev('<i class="fa fa-fw fa-chevron-left">Quay lại</i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa fa-fw fa-chevron-right">Kế tiếp</i>', ['escape' => false]) ?>
	</ul>
</p>