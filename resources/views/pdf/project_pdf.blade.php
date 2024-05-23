
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        h2, h4 {
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
<table class="w-full">
    <tr>
        <td class="w-half">
            logo ryadh
        </td>
        <td class="w-half">
            <h2>رقم التسعيرة : {{ $projects->price_number }}</h2>
        </td>
    </tr>
</table>

<div class="margin-top">
    <table class="w-full">
        <tr>
            <td class="w-half">
                <div><h4>اسم المشروع :</h4></div>
                <div>{{ $projects->project_name }}</div>
            </td>
            <td class="w-half">
                <div><h4>القسم :</h4></div>
                <div>{{ $projects->section_name }}</div>
            </td>
        </tr>
    </table>
</div>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>بند الصرف</th>
        <th>قيمة البند</th>
    </tr>
    </thead>
    <tbody>
    @foreach($multi_project as $key => $item)
        <tr>
            <td>
                {{ $key+1 }}
            </td>
            <td>
                {{ $item->item_name }}
            </td>
            <td>
                {{ $item->item_value }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total">
    المجموع : {{ $projects->total }} SR
</div>

<div class="footer margin-top">
    <div>ملاحظات</div>
    <div>{{ $projects->description }}</div>
</div>
</body>
</html>
