<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tên thư mục') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Tóm lược') ?></h4>
        <?= $this->Text->autoParagraph(h($category->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Sách cùng thư mục') ?></h4>
        <?php if (!empty($books)): ?>
            <?php echo $this->element('books' , array('books' => $books)); ?>
            <?php echo $this->element('paginator' , array('object' => 'quyển sách')); ?>
        <?php endif; ?>
    </div>
</div>
