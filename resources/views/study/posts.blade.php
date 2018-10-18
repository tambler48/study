<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Посты</title>
</head>
<body>
    <?php  foreach ($posts as $post){  ?>
        <h2> <?php echo $post['header'] ?>  </h2>
    <?php } ?>
</body>
</html>