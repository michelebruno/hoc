<?php
    if (!defined('ABSPATH')) exit();
?>
</main>
<footer class="container">
    <?php $post = get_post(1188); echo apply_filters( 'the_content', $post->post_content )  ?>
</footer>
<?php

    wp_footer(); ?>
</body>
</html>
