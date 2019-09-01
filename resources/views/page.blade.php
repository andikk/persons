<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Persons</title>

    </head>
    <body>
        <div>
            <h1>Page</h1>
            
            <div>
                Добавить запись
                <form method="POST" action="{{route('personStore')}}" name="addPerson">
                    <label>
                        Имя
                        <input type="text" name="name" required>
                    </label>
                    <label>
                        Дата
                        <input type="date" name="date" required>
                    </label>
                    
                    <button type="submit">+</button>
                    {{ csrf_field() }}
                </form>
            </div>
            <hr>
            <div>
                Редактировать запись
                <form method="POST" action="" name="updatePerson">
                    <label>
                        Имя
                        <input type="text" name="nameUpdate" required>
                    </label>
                    <label>
                        Дата
                        <input type="date" name="dateUpdate" required>
                    </label>
                    
                    <button type="submit">+</button>
                    {{ csrf_field() }}
                </form>
            </div>
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
                        
                         <form method="POST" action="{{ route('personEdit',['person' => $person->id]) }}" name="EditPerson">
                           
                            <button type="submit">Edit</button>
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>
                @endforeach
               
            </table>
        </div>

        @if (count($errors) > 0)
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>
            </div>
        @else
            <div>
                <p>Информация добавлена</p>
            </div>
        @endif
      
    </body>
</html>
