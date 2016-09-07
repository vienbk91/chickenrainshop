<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $coupon->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Coupons'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="coupons form large-9 medium-8 columns content">
    <?= $this->Form->create($coupon) ?>
    <fieldset>
        <legend><?= __('Edit Coupon') ?></legend>
        <?php
            echo $this->Form->input('code');
            echo $this->Form->input('percent');
            echo $this->Form->input('description');
            echo $this->Form->input('time_start');
            echo $this->Form->input('time_end');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
