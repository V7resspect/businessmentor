<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Результат</title>
</head>
<body>
<h1>Результат анализа</h1>
<p><b>Количество лексически значимых слов:</b> <?php echo $data['words_count']; ?></p>
<p><b>Часто используемые слова:</b></p>
<ul>
    <?php foreach ($data['popular_words'] as $word => $count) { ?>
        <li><?php echo "$word ($count)"; ?></li>
    <?php } ?>
</ul>
<p><b>Исходный текст:</b></p>
<p><?php echo $data['text']; ?></p>
<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>