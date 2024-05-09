<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php wp_head(); ?>
</head>

<body>
    <div style="padding: 40px;">
        <div style="margin-bottom: 30px;padding:5px 5px;background:lightgray;display:inline-block;border-radius:5px">[pr_tk_address id='<?php echo $id ?>']</div>
        <?php
        echo do_shortcode("[pr_tk_address id='$id']");
        ?>
    </div>
    <?php wp_footer(); ?>
</body>

</html>