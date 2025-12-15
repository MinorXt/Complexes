<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Недвижимость - Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/v3/?apikey=46b5bf40-9a4c-4256-9483-b5eef6ac5b7d&lang=ru_RU"></script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4 text-primary">Недвижимость</h1>

    <!-- Жилые комплексы -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Жилой комплекс (<?= count($complexes); ?>)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($complexes as $complex): ?>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <strong><?= $complex['name']; ?></strong><br>
                            <small class="text-muted"><?= $complex['address']; ?></small><br>
                            <a href="/filter?complex=<?= $complex['id']; ?>" class="btn btn-sm btn-outline-primary mt-2">
                                Показать квартиры
                            </a>
                            <a href="/complex/map/<?= $complex['slug']; ?>" class="btn btn-sm btn-outline-primary mt-2">
                                Посмотреть на карте
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Строения -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Строения (<?= count($sections); ?>)</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>ЖК</th>
                    <th class="text-center">Срок сдачи</th>
                    <th class="text-center">Этажей</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= $section['name']; ?></td>
                        <td><small><?= $section['complex_name']; ?></small></td>
                        <td class="text-center">
                            <?php if ($section['planning_date']): ?>
                                <?= date('d.m.Y', strtotime($section['planning_date'])); ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?= $section['floors']; ?></td>
                        <td class="text-end">
                            <a href="/filter?section=<?= $section['id']; ?>" class="btn btn-sm btn-outline-success">
                                Квартиры
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Квартиры -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Квартиры в продаже (<?= count($apartments); ?>)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th>ЖК</th>
                        <th>Строение</th>
                        <th class="text-center">Комнат</th>
                        <th class="text-center">Этаж</th>
                        <th class="text-end">Цена</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($apartments as $apartment): ?>
                        <tr>
                            <td><?= $apartment['complex_name']; ?></td>
                            <td><small><?= $apartment['section_name']; ?></small></td>
                            <td class="text-center"><?= $apartment['rooms']; ?></td>
                            <td class="text-center"><?= $apartment['floor']; ?></td>
                            <td class="text-end text-success fw-bold">
                                <?= number_format($apartment['price'], 0, '', ' '); ?> ₽
                            </td>
                            <td class="text-end">
                                <a href="/apartment/<?= $apartment['id']; ?>" class="btn btn-sm btn-outline-info">
                                    Подробно
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <!-- Кнопка поиска -->
    <div class="text-center mt-4">
        <a href="/filter" class="btn btn-primary btn-lg">Поиск квартир по фильтрам</a>
    </div>
</div>
</body>
</html>