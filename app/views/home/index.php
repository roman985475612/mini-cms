<h1><?= $title ?></h1>
<ul>
    <?php foreach ($categores as $category): ?>
        <li>
            ID: <?= $category->id ?><br>
            Title: <?= $category->title ?><br>
            Created at: <?= $category->created_at ?><br>
            Updated at: <?= $category->updated_at ?><br>
        </li>
    <?php endforeach ?>
</ul>