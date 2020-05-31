<?php
/*
    wp_register_style('timeline_css', mvc_css_url('atoutcom-events', 'timeline'));
    wp_enqueue_style('timeline_css');
*/
?>
<ul class="atoutcom-users">
    <?php foreach ($objects as $object): ?>
        <li>
            <?php $this->render_view('_item', ['locals' => ['object' => $object]]); ?>
        </li>
    <?php endforeach; ?>
</ul>
