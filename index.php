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
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Адрес электронной почты</label>
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
                    <a class='btn btn-primary' href='reg.php' role='button'>регистрация</a>
                    <?php
    use BD_KDD\BD;
    require 'base.php';
    $log = $_POST['email'];
    $pass = $_POST['password'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    //echo($log);
    $bd = new BD;
    $url_git = $bd->git_url();
    echo("<a class='btn btn-primary' href='$url_git' role='button'>GitHub</a>");
    $url_vk = $bd->URL();
    echo("<a class='btn btn-primary' href='$url_vk' role='button'>Вконтакте</a>");
    $yandex_url = $bd->yandex_url();
    echo("<a class='btn btn-primary' href='$yandex_url' role='button'>Яндекс</a>");
    if(isset ($log))
            {
                $bd = new BD;
                $foo = $bd->login($log, $pass);
                //$pass = password_hash($pass, PASSWORD_DEFAULT);
                var_dump($foo);
                    if($foo == 1){
                        header("Location:2048.php?name=$name");
                    }else{ echo('Не верный логин или пароль123');}
            }


    // if(isset ($id))
    // {

    //     $bd = new BD;
    //     $foo = $bd->URL();
    //     echo("<a class='btn btn-primary' href='$foo' role='button'>Ссылка</a>");

    // }
    ?>
                
            </div>
            <div class="col">
            </div>
        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>