<?php
session_start();
$_SESSION['name'];//имя пользователя	
$_SESSION['role'];//его роль
$connect = mysql_connect("localhost","root","") or die(mysql_error());
mysql_select_db("shop");
?>
<html>
<head>
	<title>Shoper</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="main.css">
</head>

<body>
	<?php
		$products = array(
		    '0' => array('id'=>1,'name'=> 'пластелин детский', 'price'=>60),
			'1'=>array('id'=>2,'name'=>'ножик "ежик"', 'price'=>20),
			'2'=>array('id'=>3,'name'=>'жвачка для рук', 'price' =>200),
			'3'=>array('id'=>4,'name'=>'гипсовая фигурка', 'price'=>150),
			'4'=>array('id'=>5,'name'=>'краски "ариель"','price'=>140),
			'5'=>array('id'=>6,'name'=>'формочка для пластелина', 'price'=>100));
		
	?>

<div class="wrapper">
	<header><h1>Shoper</h1></header>
    <?php
    	if($_SESSION['role']=='admin')
    		echo '<a href = "show.php">Посмотреть заказы</a>';
    ?>
	<div class="form">
	<form method="post" action="index.php">
		<div class="form-block">
		<div class="field"><label for="fio">ФИО</label>
			<input type="text" name="fio" id="fio" required /></div>
		<div class="field"><label for="products">Выберите продукт</label>
			<select name="prod" id="products">
		 		<?php    
		 			foreach ($products as $value) {
	                    echo '<option value="'.$value['id'].'">'.$value['name'].' '.$value['price'].' руб.</option>';
		 			}
		 		?>
			</select></div>
		<div class="field"><label for="num">Кол-во</label>
				<input type="text" name="num" id="num" required></div>
		<div class="field"><label for="com">Ваш комментарий</label>
			<input type="text" name="com" id="com" required></div>
		<button type="submit">Отправить данные</button>
	</div>
	</form>
	</div>
	<a class="right" href = "signin.php">SIGN IN</a>
<?php
	if(isset($_POST['fio']))
	{
		foreach ($products as $value) {
			if($_POST['prod']==$value['id'])
			{
				$price = $value['price'];
				$pro = $value['name'];
			}
		}
		$price = $price*$_POST['num'];
		$fio = $_POST['fio'];
		$com = $_POST['com'];
		echo <<<HERE
		<p>Привет, <b>$fio</b></p>
		<p>Сумма вашей покупки товара "$pro": <b>$price</b> рублей</p>
		<p>Мы обязательно примем к сведению ваш отзыв: <b>$com</b></p>
		<p>Спасибо за покупку! Приходите ещё!</p>
HERE;
		$num = $_POST['num'];
		$query = "INSERT INTO orders VALUES ('','$fio','$pro','$num','$com')";
		$result = mysql_query($query) or die(mysql_error());
	}
?>
</div>

</body>
</html>
