<div class="books view large-9 medium-8 columns content">
    <h3><?= h($book->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Thư mục') ?></th>
            <td><?= $book->has('category') ? $this->Html->link($book->category->name, ['controller' => 'Categories', 'action' => 'view', $book->category->slug]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tiêu đề') ?></th>
            <td><?= h($book->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ảnh bìa') ?></th>
            <td><?php echo $this->Html->image($book->image , array('width' => '120px' ,'height' => '160px')); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Download') ?></th>
            <td><?= $this->Html->link('Link download' , $book->link_download , ['target' => '_blank']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Giá gốc') ?></th>
            <td><?= $this->Number->format($book->price , array('places' => 0 ,'after' => 'VND')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Giá sale') ?></th>
            <td><?= $this->Number->format($book->sale_price , array('places' => 0 ,'after' => 'VND')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Số trang') ?></th>
            <td><?= $this->Number->format($book->pages) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tác giả') ?></th>
            <td>
            <?php 
            $countWriter = 0;
            foreach ($book->writers as $writer) {
            	$url = $this->Html->link($writer->name , '/tac-gia/' . $writer->slug , ['target' => '_self']);
            	if ($countWriter < count($book->writers) -1 ) {
            		echo $url . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            	} else {
            		echo $url;
            	}
            	
            	$countWriter++;
            }
            ?>
            </td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Thông tin sách') ?></h4>
        <?= $this->Text->autoParagraph(h($book->info)); ?>
    </div>
    <div class="related">
        <h4><?= __('Bình luận') ?></h4>
        <?php if (!empty($book->comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Người bình luận') ?></th>
                <th scope="col"><?= __('Nội dung bình luận') ?></th>
                <th scope="col"><?= __('Ngày đăng') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($book->comments as $comments): ?>
            <tr>
                <td><?php echo $comments['user']['username']; ?></td>
                <td><?php echo $comments->content; ?></td>
                <td><?php echo date('Y-m-d H:i:s' , strtotime($comments->created)); ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Thông tin tác giả') ?></h4>
        <?php if (!empty($book->writers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col" width="15%"><?= __('Name') ?></th>
                <th scope="col" width="60%"><?= __('Biography') ?></th>
                <th scope="col" width="25%" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($book->writers as $writers): ?>
            <tr>
                <td><?= h($writers->name) ?></td>
                <td><?= h($writers->biography) ?></td>
                <td class="actions" align="center">
                    <?= $this->Html->link(__('View'), ['controller' => 'Writers', 'action' => 'view', $writers->slug]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Writers', 'action' => 'edit', $writers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Writers', 'action' => 'delete', $writers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $writers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    
    <div class="related">
    	<h4><?= __('Các cuốn sách liên quan') ?></h4>
    </div>
    
</div>
