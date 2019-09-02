<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/style.css">

        <title>Persons</title>

    </head>
    <body>
        <div class="container">
            <h1 class="h1">Page</h1>
            <a href="{{ route('personAdd') }}">Добавить</a>
            <button class="modal-btn">Добавить</button>
            
            <hr>
            <div>
                <form method="POST" action="">
                    <p>Сортировка</p>
                    <select name="sort">
                      <option value="name" selected>Имя</option>
                      <option value="date">Датарождения</option>
                    </select>
                    <button type="submit">Установить</button>    
                </form>
                
            </div>
            <hr>
            <table>
                <tr>
                    <td>Имя</td>
                    <td>Дата</td>
                    <td>Действие</td>
                </tr>
                @foreach ($persons as $person)
                <tr>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->date }}</td>

                    <td> 
                        <form method="POST" action="{{ route('personDelete',['person' => $person->id]) }}" name="DeletePerson">
                            {{ method_field('DELETE') }}
                            <button type="submit">Del</button>
                            {{ csrf_field() }}
                        </form>
                        
                        <form method="POST" action="{{ route('personEdit',['name' => $person->name,'date' => $person->date, 'id' => $person->id]) }}" name="EditPerson">
                           
                            <button type="submit">Edit</button>
                            {{ csrf_field() }}
                        </form>

                        <button class="edit-btn" data-id="{{ $person->id }}" data-name="{{ $person->name }}" data-date="{{ $person->date }}">Редактировать</button>
                    </td>
                </tr>
                @endforeach
               
            </table>
        </div>

        <div class="modal">
            <form method="POST" action="">
                <label>
                    Имя
                    <input class="name" type="text" name="name" required>
                </label>
                <label>
                    Дата
                    <input class="date" type="date" name="date" required>
                </label>
                
                <button class="submit" type="submit">+</button>
                <button class="close">x</button>
                {{ csrf_field() }}
            </form>
            
        </div>

     <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
     <script src="/js/main.js"></script> 
    </body>
</html>
