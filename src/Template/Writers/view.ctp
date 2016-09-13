<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Writer'), ['action' => 'edit', $writer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Writer'), ['action' => 'delete', $writer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $writer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Writers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Writer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="writers view large-9 medium-8 columns content">
    <h3><?= h($writer->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($writer->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($writer->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($writer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($writer->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Biography') ?></h4>
        <?= $this->Text->autoParagraph(h($writer->biography)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Books') ?></h4>
        <?php if (!empty($writer->books)): ?>
            <?php echo $this->element('books' , array('books' => $books)); ?>
            <?php echo $this->element('paginator' , array('object' => 'quyển sách')); ?>
        <?php endif; ?>
    </div>
</div>
