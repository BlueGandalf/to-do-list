@php
    use Illuminate\Support\Facades\Vite;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MLP To-Do</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <img src="{{ Vite::asset('assets/logo.png') }}" class="logo img-fluid">
        </div>
        <div class="row">
            <div class="col-sm-4">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Insert task name" required />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add</button>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="index-column">#</th>
                                    <th class="task-column">Task</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <th>
                                            {{ $loop->index + 1 }}
                                        </th>
                                        <td class="task">
                                            <span class="task-name @if ($task->isComplete) complete @endif">
                                                {{ $task->name }}
                                            </span>
                                            @unless ($task->isComplete)
                                                <form method="POST", action="{{ route('tasks.destroy', $task) }}" class="button">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                                </form>
                                                <form method="POST", action="{{ route('tasks.update', $task) }}" class="button">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="isComplete" value="1" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
                                                </form>
                                            @endunless
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="text-muted text-center">
                Copyright &#xa9; 2020 All Rights Reserved.
            </p>
        </div>
    </footer>
</body>
</html>
