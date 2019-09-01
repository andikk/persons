<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
            <div>


                <h2>Редактировать запись</h2>
                <form method="POST" action="{{route('personUpdate',['id' => $id])}}">
                    <label>
                        Имя
                        <input type="text" name="name" value="{{ $name }}" required>
                    </label>
                    <label>
                        Дата
                        <input type="date" name="date" value="{{ $date }}" required>
                    </label>
                    
                    <button type="submit">+</button>
                    {{ csrf_field() }}
                </form>
            </div>
    </body>
</html>
