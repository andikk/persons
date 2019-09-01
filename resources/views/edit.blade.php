<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
            <div>
                <p>{{ $person }}</p>

                <h2>Редактировать запись</h2>
                <form method="POST" action="">
                    <label>
                        Имя
                        <input type="text" name="name" value="" required>
                    </label>
                    <label>
                        Дата
                        <input type="date" name="date" value="" required>
                    </label>
                    
                    <button type="submit">+</button>
                    {{ csrf_field() }}
                </form>
            </div>
    </body>
</html>
