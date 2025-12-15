<?php

namespace Src\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController extends Controller
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $complexes = \ORM::forTable('complexes')->findArray();
        $sections = \ORM::forTable('sections')
            ->select('sections.*')
            ->select('complexes.name', 'complex_name')
            ->leftOuterJoin('complexes', 'sections.complex_id = complexes.id')
            ->findArray();
        $apartments = \ORM::forTable('apartments')
            ->select('apartments.*')
            ->select('complexes.name', 'complex_name')
            ->select('sections.name', 'section_name')
            ->leftOuterJoin('sections', 'apartments.section_id = sections.id')
            ->leftOuterJoin('complexes', 'sections.complex_id = complexes.id')
            ->findArray();

        return $this->renderer->render($response, 'index.php', [
            'complexes' => $complexes,
            'sections' => $sections,
            'apartments' => $apartments
        ]);
    }

    public function showMap(RequestInterface $request, ResponseInterface $response, array $args)
    {

        $complex = \ORM::forTable('complexes')->where('slug', $args['complex_slug'])->findOne();

        return $this->renderer->render($response, 'map.php', ['complex' => $complex]);

    }

    public function filter(RequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();
        $query = \ORM::forTable('apartments')
            ->select('apartments.*')
            ->select('complexes.name', 'complex_name')
            ->select('sections.name', 'section_name')
            ->leftOuterJoin('sections', 'apartments.section_id = sections.id')
            ->leftOuterJoin('complexes', 'sections.complex_id = complexes.id');

        if (!empty($params['complex'])) $query->where('complexes.id', $params['complex']);
        if (!empty($params['rooms'])) $query->where('apartments.rooms', $params['rooms']);
        if (!empty($params['min_price'])) $query->whereGte('apartments.price', $params['min_price']);
        if (!empty($params['max_price'])) $query->whereLte('apartments.price', $params['max_price']);
        if (!empty($params['section'])) $query->where('sections.id', $params['section']);
        if (!empty($params['planning_date'])) $query->where('sections.planning_date', $params['planning_date']);
        if (!empty($params['min_floor'])) $query->whereGte('apartments.floor', $params['min_floor']);
        if (!empty($params['max_floor'])) $query->whereLte('apartments.floor', $params['max_floor']);

        $sort = $params['sort'] ?? 'price';
        if ($sort == 'price_desc') {
            $query->orderByDesc('price');
        } elseif ($sort == 'price_asc') {
            $query->orderByAsc('price');
        } elseif ($sort == 'rooms') {
            $query->orderByAsc('rooms');
        } elseif ($sort == 'floor') {
            $query->orderByAsc('floor');
        } elseif ($sort == 'section') {
            $query->orderByAsc('sections.name');
        } elseif ($sort == 'planning_date') {
            $query->orderByAsc('sections.planning_date');
        } else {
            $query->orderByAsc('price');
        }

        $apartments = $query->findArray();

        $complexes = \ORM::forTable('complexes')->findArray();
        $sections = \ORM::forTable('sections')->findArray();
        $rooms = \ORM::forTable('apartments')->select('rooms')->distinct()->findArray();
        $planning_dates = \ORM::forTable('sections')->select('planning_date')->distinct()->findArray();

        return $this->renderer->render($response, 'filter.php', [
            'complexes' => $complexes,
            'sections' => $sections,
            'apartments' => $apartments,
            'rooms' => array_column($rooms, 'rooms'),
            'planning_dates' => array_column($planning_dates, 'planning_date'),
            'params' => $params
        ]);
    }

    public function apartment(RequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];

        $apartment = \ORM::forTable('apartments')
            ->select('apartments.*')
            ->select('complexes.name', 'complex_name')
            ->select('sections.name', 'section_name')
            ->select('layouts.image', 'layout_image')
            ->leftOuterJoin('sections', 'apartments.section_id = sections.id')
            ->leftOuterJoin('complexes', 'sections.complex_id = complexes.id')
            ->leftOuterJoin('layouts', 'apartments.layout_id = layouts.id')
            ->where('apartments.id', $id)
            ->findOne();

        if (!$apartment) {
            return $this->renderer->render($response, 'apartment.php', [
                'apartment' => null,
                'sameLayoutApartments' => []
            ]);
        }

        $apartmentData = $apartment->asArray();

        $sameLayoutApartments = \ORM::forTable('apartments')
            ->select('apartments.*')
            ->select('complexes.name', 'complex_name')
            ->select('sections.name', 'section_name')
            ->select('layouts.image', 'layout_image')
            ->leftOuterJoin('sections', 'apartments.section_id = sections.id')
            ->leftOuterJoin('complexes', 'sections.complex_id = complexes.id')
            ->leftOuterJoin('layouts', 'apartments.layout_id = layouts.id')
            ->where('apartments.layout_id', $apartmentData['layout_id'])
            ->whereNotEqual('apartments.id', $id)
            ->findArray();

        return $this->renderer->render($response, 'apartment.php', [
            'apartment' => $apartmentData,
            'sameLayoutApartments' => $sameLayoutApartments
        ]);
    }
}