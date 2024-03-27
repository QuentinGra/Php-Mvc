<?php foreach (isset($_SESSION['messages']) ? $_SESSION['messages'] : [] as $type => $message) : ?>
    <div class="alert alert<?= $type; ?>">
        <?php
        echo $message;
        unset($_SESSION['messages'][$type]);
        ?>
    </div>
<?php endforeach; ?>