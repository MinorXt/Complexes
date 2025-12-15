<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Квартира #<?= $apartment['id'] ?? ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <a href="/filter" class="btn btn-outline-secondary mb-3">Назад к поиску</a>
    <a href="/" class="btn btn-outline-secondary mb-3">На главную</a>

    <?php if (empty($apartment)): ?>
        <div class="alert alert-danger">Квартира не найдена</div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><?= $apartment['rooms']; ?>-комнатная квартира #<?= $apartment['id']; ?></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Жилой комплекс:</th>
                                <td><?= $apartment['complex_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Строение:</th>
                                <td><?= $apartment['section_name'] ?? 'Не указано'; ?></td>
                            </tr>
                            <tr>
                                <th>Количество комнат:</th>
                                <td><?= $apartment['rooms']; ?></td>
                            </tr>
                            <tr>
                                <th>Этаж:</th>
                                <td><?= $apartment['floor']; ?></td>
                            </tr>
                            <tr>
                                <th>Планировка:</th>
                                <td>
                                    <?php if (!empty($apartment['layout_image'])): ?>
                                        <img src="<?= $apartment['layout_image']; ?>"
                                             alt="Планировка квартиры"
                                             style="max-width: 600px; max-height: 500px; border: 1px solid #ddd; border-radius: 4px;">
                                    <?php else: ?>
                                        <span class="text-muted">Изображение отсутствует</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Цена:</th>
                                <td class="h4 text-success">
                                    <?= number_format($apartment['price'], 0, '', ' '); ?> ₽
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок других квартир этой же планировки -->
        <?php if (!empty($sameLayoutApartments)): ?>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Другие квартиры с такой же планировкой</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Жилой комплекс</th>
                                <th>Комнат</th>
                                <th>Этаж</th>
                                <th>Цена</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sameLayoutApartments as $other): ?>
                                <tr>
                                    <td><?= $other['complex_name']; ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?= $other['rooms']; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $other['floor']; ?></span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        <?= number_format($other['price'], 0, '', ' '); ?> ₽
                                    </td>
                                    <td>
                                        <a href="/apartment/<?= $other['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            Подробнее
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Других квартир с такой же планировкой не найдено
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
</body>
</html>