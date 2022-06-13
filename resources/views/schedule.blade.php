<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Раписание рейсов @if(isset($departure_date)) на {{$departure_date}} @endif</title>
</head>
<body>

<style>

</style>

<div class="container">

    @if(isset($departure_date))
        <h1>Расписание рейсов на {{$departure_date}}</h1>
    @endif

    <a style="margin-top: 20px;" class="btn btn-success" href="{{url('/')}}">На главную</a>

    @if(isset($error_types))
        <ul class="errors">
            @foreach($error_types as $error_type)
                @foreach($error_type as $error)
                    <li>{{$error}}</li>
                @endforeach
            @endforeach
        </ul>
    @endif

    @if(isset($items))
        <table class="schedule-table" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th>Номер рейса</th>
                <th>Наименование</th>
                <th>Дата отправления</th>
                <th>Время отправления</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$item->flight_number}}</td>
                    <td>{{$item->flight_name}}</td>
                    <td>{{$item->departure_date}}</td>
                    <td>{{$item->departure_time}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
