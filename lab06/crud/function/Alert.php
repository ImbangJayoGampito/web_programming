<?php function alert($message, $sts)
{
    if ($sts == 1) {
        $sts = 'success';
    } else {
        $sts = 'danger';
    }
    echo '<div class="alert alert-' . $sts . ' alert-dismissible fade show" role="alert">
            <strong>' . $message . '</strong>

        </div>';
}
