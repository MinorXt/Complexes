<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск квартир</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <!-- Кнопка назад -->
    <a href="/" class="btn btn-outline-secondary mb-3">Назад</a>

    <h2 class="mb-4">Поиск квартир</h2>

    <div class="row">
        <!-- Фильтры -->
        <div class="col-md-3">
            <form method="get" action="/filter">
                <div class="mb-3">
                    <label>Жилой комплекс:</label>
                    <select class="form-select" name="complex">
                        <option value="">Все</option>
                        <?php foreach ($complexes as $complex): ?>
                            <option value="<?= $complex['id']; ?>"
                                <?php if (!empty($params['complex']) && $params['complex'] == $complex['id']) echo 'selected'; ?>>
                                <?=$complex['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Добавленный фильтр: Корпус -->
                <div class="mb-3">
                    <label>Корпус:</label>
                    <select class="form-select" name="section">
                        <option value="">Все</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?= $section['id']; ?>"
                                <?php if (!empty($params['section']) && $params['section'] == $section['id']) echo 'selected'; ?>>
                                <?=$section['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Добавленный фильтр: Срок сдачи -->
                <div class="mb-3">
                    <label>Срок сдачи:</label>
                    <select class="form-select" name="planning_date">
                        <option value="">Все</option>
                        <?php foreach ($planning_dates as $date): ?>
                            <?php if ($date): ?>
                                <option value="<?= $date; ?>"
                                    <?php if (!empty($params['planning_date']) && $params['planning_date'] == $date) echo 'selected'; ?>>
                                    <?= date('d.m.Y', strtotime($date)); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Количество комнат:</label>
                    <select class="form-select" name="rooms">
                        <option value="">Все</option>
                        <option value="1" <?php if (!empty($params['rooms']) && $params['rooms'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if (!empty($params['rooms']) && $params['rooms'] == '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if (!empty($params['rooms']) && $params['rooms'] == '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if (!empty($params['rooms']) && $params['rooms'] == '4') echo 'selected'; ?>>4</option>
                    </select>
                </div>

                <!-- Добавленный фильтр: Этаж -->
                <div class="mb-3">
                    <label>Этаж от:</label>
                    <input type="number" class="form-control" name="min_floor"
                           value="<?= $params['min_floor'] ?? ''; ?>">
                </div>

                <div class="mb-3">
                    <label>Этаж до:</label>
                    <input type="number" class="form-control" name="max_floor"
                           value="<?= $params['max_floor'] ?? ''; ?>">
                </div>

                <div class="mb-3">
                    <label>Цена от:</label>
                    <input type="number" class="form-control" name="min_price"
                           value="<?= $params['min_price'] ?? ''; ?>">
                </div>

                <div class="mb-3">
                    <label>Цена до:</label>
                    <input type="number" class="form-control" name="max_price"
                           value="<?= $params['max_price'] ?? ''; ?>">
                </div>

                <!-- Добавленная сортировка -->
                <div class="mb-3">
                    <label>Сортировка:</label>
                    <select class="form-select" name="sort">
                        <option value="price_asc" <?php if (($params['sort'] ?? 'price') == 'price_asc') echo 'selected'; ?>>Цена по возрастанию</option>
                        <option value="price_desc" <?php if (($params['sort'] ?? '') == 'price_desc') echo 'selected'; ?>>Цена по убыванию</option>
                        <option value="rooms" <?php if (($params['sort'] ?? '') == 'rooms') echo 'selected'; ?>>По количеству комнат</option>
                        <option value="floor" <?php if (($params['sort'] ?? '') == 'floor') echo 'selected'; ?>>По этажу</option>
                        <option value="section" <?php if (($params['sort'] ?? '') == 'section') echo 'selected'; ?>>По корпусу</option>
                        <option value="planning_date" <?php if (($params['sort'] ?? '') == 'planning_date') echo 'selected'; ?>>По сроку сдачи</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Найти</button>
                <a href="/filter" class="btn btn-secondary w-100 mt-2">Сбросить</a>
            </form>
        </div>

        <!-- Результаты -->
        <div class="col-md-9">
            <h4>Найдено: <?= count($apartments); ?> квартир</h4>

            <?php if (empty($apartments)): ?>
                <div class="alert alert-info mt-3">Квартиры не найдены</div>
            <?php else: ?>
                <table class="table table-hover mt-3">
                    <thead>
                    <tr>
                        <th>ЖК</th>
                        <th>Корпус</th>
                        <th>Комнат</th>
                        <th>Этаж</th>
                        <th>Срок сдачи</th>
                        <th>Цена</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($apartments as $apartment): ?>
                        <tr>
                            <td><?= $apartment['complex_name']; ?></td>
                            <td><?= $apartment['section_name']; ?></td>
                            <td><?= $apartment['rooms']; ?></td>
                            <td><?= $apartment['floor']; ?></td>
                            <td>
                                <?php if (!empty($apartment['section_planning_date'])): ?>
                                    <?= date('d.m.Y', strtotime($apartment['section_planning_date'])); ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td class="text-success">
                                <?= number_format($apartment['price'], 0, '', ' '); ?> ₽
                            </td>
                            <td>
                                <a href="/apartment/<?=$apartment['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    Подробнее
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>