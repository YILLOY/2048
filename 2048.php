<!DOCTYPE html>
<html>
<head>
	<title>2048</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<style>
		#canvas { display: block; border: 1px solid #000; margin: 10px auto; width: 612px; height: 612px }
	</style>
</head>
<body>
	<?php
	use BD_KDD\BD;
    require 'base.php';
	$name = $_GET['payload'];
	if(isset($name))
	{
	$name = explode(",",$name);
	$id_bd = $name[2];
	$id_bd = explode(":",$id_bd);
	$id_bd = $id_bd[2];
	$name = $name[3];
	$name = explode(":",$name);
	//$first_name = explode('"',$first_name);
	$name = $name[1];
	//var_dump($name);
	//echo("$id_bd");
	//var_dump($first_name);
	echo("<h1>Привет и удачной игры $name</h1>");
	$BD = new BD;
	$BD->new_user_VK($id_bd, $name);
	if(isset($_POST['result']))
	{
		$result = $_POST['result'];
		$BD = new BD;
		$check = gettype($result);
		//echo("$check");
			$result = $BD->result($result);
			//$check = gettype($result);
			//$check = str_contains($result, "невозможно");
			//var_dump("$check");

			if(str_contains($result, "невозможно"))
			{
				
				echo("$result");
			}else
			{
				$BD->write_result($result, $name);
			}	
		
	}
	}
	if(isset($_GET['name']))
	{
		$name = $_GET['name'];
		echo("<h1>Привет и удачной игры $name</h1>");
		if(isset($_POST['result']))
		{
			$result = $_POST['result'];
			$BD = new BD;
			$check = gettype($result);
			//echo("$check");
				$result = $BD->result($result);
				//$check = gettype($result);
				//$check = str_contains($result, "невозможно");
				//var_dump("$check");
	
				if(str_contains($result, "невозможно"))
				{
					
					echo("$result");
				}else
				{
					$BD->write_result($result, $name);
				}	
			
		}
	}
	if(isset($_GET['code']))
	{
		$check = $_GET['state'];
		if(str_contains($check, "Git"))
		{
		$BD = new BD;
		$code = $_GET['code'];
		$result1 = $BD->name_github($code);
		$name = $result1["login"];
		echo("<h1>Привет и удачной игры $name</h1>");
		//var_dump($result);
		if(isset($_POST['result']))
		{
			$result = $_POST['result'];
			$BD = new BD;
			$check = gettype($result);
			//echo("$check");
				$result = $BD->result($result);
				//$check = gettype($result);
				//$check = str_contains($result, "невозможно");
				//var_dump("$check");
	
				if(str_contains($result, "невозможно"))
				{
					
					echo("$result");
				}else
				{
					$BD->write_result($result, $name);
				}	
			
		}
		}else
		{
			$code = $_GET['code'];
			$BD = new BD;
			$result2 = $BD->yandex_name($code);
			//echo($result2);
			//var_dump($result2);
			$name = $result2['display_name'];
			echo("<h1>Привет и удачной игры $name</h1>");
			if(isset($_POST['result']))
		{
			$result = $_POST['result'];
			$BD = new BD;
			$check = gettype($result);
			//echo("$check");
				$result = $BD->result($result);
				//$check = gettype($result);
				//$check = str_contains($result, "невозможно");
				//var_dump("$check");
	
				if(str_contains($result, "невозможно"))
				{
					
					echo("$result");
				}else
				{
					$BD->write_result($result, $name);
				}	
			
		}
		}
	}
	?>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  	Рекорды
	</button>
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Главные позеры</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
		<?php
		$foo = new BD;
		$foo = $foo->record();
		$check = count($foo);
		for($row = 0; $row <= $check; $row++)
		{
			echo" <div class='card' style='width: 15rem;'>
			<div class='card-body'>
				<h5 class='card-title'>Место:$row</h5>
				<h5 class='card-title'>Имя:{$foo[$row]['name']}</h5>
				<h5 class='card-title'>Результат:{$foo[$row]['weight']}</h5>
			</div>
			</div>";
		}
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
	<canvas id="canvas"></canvas>
	<script type="text/javascript" src="field.js"></script>
	<script>
		const padding = 50
		const fieldSize = 612 
		const cellSize = (fieldSize - padding * 2) / 4

		const canvas = document.getElementById("canvas")
		var ctx = canvas.getContext("2d")

		const left = "left"
		const right = "right"
		const down = "down"
		const up = "up"

		canvas.width = fieldSize
		canvas.height = fieldSize

		var field = new Field(4)
		field.Draw(ctx)
	</script>
	<script>
		function clear() {
			ctx.fillStyle = "#fff"
			ctx.fillRect(0, 0, fieldSize, fieldSize)
		}

		document.addEventListener("keydown", (event) => {
			let wasSlide = false

			if (event.key == "ArrowLeft") 
				wasSlide = field.Slide(left)
			else if (event.key == "ArrowRight")
				wasSlide = field.Slide(right)
			else if (event.key == "ArrowUp")
				wasSlide = field.Slide(up)
			else if (event.key == "ArrowDown")
				wasSlide = field.Slide(down)

			if (wasSlide)
				field.AddTile()
			
			clear()
			field.Draw(ctx)

		}, false)
		
	</script>
	<form method="POST">
    <div class="mb-3">
    <label for="result" class="form-label">ваш результат</label>
    <input type="number" class="form-control" id="result" name="result" required>
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
	<h2><a class='btn btn-primary' href='index.php' role='button'>выйти</a></h2>
	
	<script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>