<?php

namespace Src\Controllers;
use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiController extends Controller
{
    public function getApartments(RequestInterface $request, ResponseInterface $response)
    {
        $data = file_get_contents('http://localhost/q');
        $data = json_decode($data, true);

        $existsIds = [];

        foreach ($data as $item) {
            $record = ORM::forTable('apartments')
                ->where('external_id', $item['id'])
                ->findOne();

            if (!$record) {
                $record = ORM::forTable('apartments')->create();
            }

            $record->set([
                'section_id' => $section->id,
                'layout_id' => $layout->id,
                'rooms' => $item['rooms'],
                'floor' => $item['floor'],
                'price' => $item['price'],
                'external_id' => $item['id']
            ])->save();

            $existsIds[] = $record->id;
        }

        ORM::forTable('apartments')
            ->whereNotIn('id', $existsIds)
            ->delete_many();
    }
}