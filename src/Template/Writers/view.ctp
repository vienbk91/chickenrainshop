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
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Slug') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Info') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Sale Price') ?></th>
                <th scope="col"><?= __('Pages') ?></th>
                <th scope="col"><?= __('Publisher') ?></th>
                <th scope="col"><?= __('Publish Date') ?></th>
                <th scope="col"><?= __('Link Download') ?></th>
                <th scope="col"><?= __('Published') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($writer->books as $books): ?>
            <tr>
                <td><?= h($books->id) ?></td>
                <td><?= h($books->category_id) ?></td>
                <td><?= h($books->title) ?></td>
                <td><?= h($books->slug) ?></td>
                <td><?= h($books->image) ?></td>
                <td><?= h($books->info) ?></td>
                <td><?= h($books->price) ?></td>
                <td><?= h($books->sale_price) ?></td>
                <td><?= h($books->pages) ?></td>
                <td><?= h($books->publisher) ?></td>
                <td><?= h($books->publish_date) ?></td>
                <td><?= h($books->link_download) ?></td>
                <td><?= h($books->published) ?></td>
                <td><?= h($books->created) ?></td>
                <td><?= h($books->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Books', 'action' => 'view', $books->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Books', 'action' => 'edit', $books->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Books', 'action' => 'delete', $books->id], ['confirm' => __('Are you sure you want to delete # {0}?', $books->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
