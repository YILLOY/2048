<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">логин</label>
                        <input type="text" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                        <div id="emailHelp" class="form-text">Мы никогда никому не передадим вашу электронную почту.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Никнейм</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                    <a class='btn btn-primary' href='index.php' role='button'>Я передумал</a>
                </form>

            </div>
            <div class="col">
            </div>
        </div>
    </div>
    <?php
    use BD_KDD\BD;
    require 'base.php';
    $log = $_POST['email'];
    $pass = $_POST['password'];
    $name = $_POST['name'];
    if(isset($log, $pass, $name))
    {
        $bd = new BD;
        $foo = $bd->registration($log, $pass, $name);
        echo($foo);
        echo("<a class='btn btn-primary' href='index.php' role='button'>Назад</a>");
    }

    ?>


    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>