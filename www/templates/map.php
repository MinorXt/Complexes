<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Квартира #<?= $apartment['id'] ?? ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/v3/?apikey=46b5bf40-9a4c-4256-9483-b5eef6ac5b7d&lang=ru_RU"></script>
</head>
<body>
<div class="container mt-4">
    <a href="/" class="btn btn-outline-secondary mb-3">На главную</a>

    <h1><?= $complex['name'] ?></h1>
    <div id="map" style="width: 1300px; height: 600px"></div>
    <script>
        async function initMap() {
            await ymaps3.ready;
            const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer} = ymaps3;

            ymaps3.import.registerCdn('https://cdn.jsdelivr.net/npm/{package}', [
                '@yandex/ymaps3-default-ui-theme@0.0.22'
            ]);

            const map = new YMap(
                document.getElementById('map'),

                {
                    location: {
                        center: [<?= $complex['latitude'] ?>, <?= $complex['longitude'] ?>],
                        zoom: 10
                    }
                },
                [
                    new YMapDefaultSchemeLayer({}),
                    new YMapDefaultFeaturesLayer({})
                ]
            );

            const {YMapDefaultMarker} = await ymaps3.import('@yandex/ymaps3-default-ui-theme');
            map.addChild(
                new YMapDefaultMarker({
                    coordinates: [<?= $complex['latitude'] ?>, <?= $complex['longitude'] ?>],
                    title: 'Hello World!',
                    subtitle: 'kind and bright'
                })
            );

        }
        initMap();
    </script>

</div>
</body>
</html>