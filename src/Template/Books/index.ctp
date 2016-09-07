<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Book'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Writers'), ['controller' => 'Writers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Writer'), ['controller' => 'Writers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="books index large-9 medium-8 columns content">
    <h3><?= __('Books') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pages') ?></th>
                <th scope="col"><?= $this->Paginator->sort('publisher') ?></th>
                <th scope="col"><?= $this->Paginator->sort('publish_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('link_download') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= $this->Number->format($book->id) ?></td>
                <td><?= $book->has('category') ? $this->Html->link($book->category->name, ['controller' => 'Categories', 'action' => 'view', $book->category->id]) : '' ?></td>
                <td><?= h($book->title) ?></td>
                <td><?= h($book->slug) ?></td>
                <td><?= h($book->image) ?></td>
                <td><?= $this->Number->format($book->price) ?></td>
                <td><?= $this->Number->format($book->sale_price) ?></td>
                <td><?= $this->Number->format($book->pages) ?></td>
                <td><?= h($book->publisher) ?></td>
                <td><?= h($book->publish_date) ?></td>
                <td><?= h($book->link_download) ?></td>
                <td><?= h($book->published) ?></td>
                <td><?= h($book->created) ?></td>
                <td><?= h($book->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
