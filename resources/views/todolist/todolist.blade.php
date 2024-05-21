<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">

    @if(isset($error))
        <div class="row">
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        </div>
    @endif

    <div class="row">
        <form method="post" action="/logout">
            @csrf
            <button class="w-15 btn btn-lg btn-danger" type="submit">Sign Out</button>
        </form>
    </div>

    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Todolist</h1>
        </div>
    </div>

    <a href="/openAddTodo" class="btn btn-lg btn-primary">Add Todo</a>

    <div class="row align-items-right g-lg-5 py-5">
        <div class="mx-auto">
            <form id="deleteForm" method="post" style="display: none">

            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">To Do Aktivitas</th>
                    <th scope="col">Tanggal Mulai</th>
                    <th scope="col">Tanggal Selesai</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Aksi</th>

                </tr>
                </thead>
                <tbody>
                @foreach($todolist as $key => $todo)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$todo['todo']}}</td>
                        <td>{{$todo['tanggal']}}</td>
                        <td>{{$todo['deadline']}}</td>
                        <td>{{$todo['catatan']}}</td>
                        <td></td>
                        <td>
                            <form action="/todolist/{{$todo['id']}}/delete" method="post">
                                @csrf
                                <button class="w-100 btn btn-lg btn-danger" type="submit">Tandai Selesai</button>
                            </form>
                            <a href="/todolist/{{$todo['id']}}/edit" class="btn btn-lg btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
