<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $writer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $writer->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Writers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="writers form large-9 medium-8 columns content">
    <?= $this->Form->create($writer) ?>
    <fieldset>
        <legend><?= __('Edit Writer') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('biography');
            echo $this->Form->input('books._ids', ['options' => $books]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
