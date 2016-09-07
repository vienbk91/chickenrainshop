<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Coupon'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="coupons index large-9 medium-8 columns content">
    <h3><?= __('Coupons') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_end') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coupons as $coupon): ?>
            <tr>
                <td><?= $this->Number->format($coupon->id) ?></td>
                <td><?= h($coupon->code) ?></td>
                <td><?= $this->Number->format($coupon->percent) ?></td>
                <td><?= h($coupon->time_start) ?></td>
                <td><?= h($coupon->time_end) ?></td>
                <td><?= h($coupon->created) ?></td>
                <td><?= h($coupon->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $coupon->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $coupon->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id)]) ?>
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
