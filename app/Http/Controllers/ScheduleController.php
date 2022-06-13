<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param $departure_date
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function getScheduleByDate($departure_date)
    {
        $validator = Validator::make(
            [
                'departure_date' => $departure_date
            ],
            [
                'departure_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal: ' . date('Y-m-d')]
            ],
            [
                'departure_date.required' => 'Необходимо указать дату!',
                'departure_date.date' => 'Тип данных должен быть «Дата»!',
                'departure_date.after_or_equal' => 'Невозможно получить расписание рейсов на старые даты!',
                'departure_date.date_format' => 'Несоответствие формату даты «год-месяц-день»!'
            ]);

        if ($validator->fails()) {
            return view('schedule', [
                'error_types' => $validator->errors()->messages(),
                'departure_date' => $departure_date
            ]);
        }

        $login = env('API_LOGIN', 'tC3vFKwj2U');
        $password = env('API_PASSWORD', '$2y$10$8trDuPFirzMs6heOagQT.uawloJ0jcLsbxwZ7ZM33l4UWjIdel/dq');
        $api_url = env('API_URL', 'http://server/api/') . 'schedule';

        $http_request = Http::post($api_url, [
            'login' => $login,
            'password' => $password,
            'departure_date' => $departure_date
        ]);

        if (!$http_request->ok()) {
            $messages = null;
            if (isset($http_request->object()->messages)) {
                $messages = $http_request->object()->messages;
            }
            return view('schedule', [
                'error_types' => $messages,
                'departure_date' => $departure_date
            ]);
        } else {
            $items = null;
            if (isset($http_request->object()->items)) {
                $items = $http_request->object()->items;
            }
            return view('schedule', [
                'items' => $items,
                'departure_date' => $departure_date
            ]);
        }
    }
}
