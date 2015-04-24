<?php
session_start();
$_SESSION['name'];
$_SESSION['role'];

?>
<html>
<head>
	<title>Детский Магазин "Фан-Чулан" </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body style="padding-top:10px;">
	<?php
		$products = array(
			'0' => array('id'=>1,'name'=> 'пластелин детский', 'price'=>60),
			'1'=>array('id'=>2,'name'=>'ножик "ежик"', 'price'=>20),
			'2'=>array('id'=>3,'name'=>'жвачка для рук', 'price' =>200),
			'3'=>array('id'=>4,'name'=>'гипсовая фигурка', 'price'=>150),
			'4'=>array('id'=>5,'name'=>'краски "ариель"','price'=>140),
			'5'=>array('id'=>6,'name'=>'формочка для пластелина', 'price'=>100));
		
	?>

<div class="container" >
	<a href = "signin.php">Авторизоваться</a>
    <?php
    	if($_SESSION['role']=='admin')
    		echo '<a href = "show.php">Посмотреть заказы</a>';
    ?>
	<div class="row">
		
	<form method="post" action="index.php" class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-2 control-label">ФИО</label>
		<div class="col-sm-10">
			<input type="text" name="fio" class="form-control" required >
		</div>
    </div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Выберите продукт</label>
		<div class="col-sm-10">
			<select name="prod" class="form-control">
		 		<?php
		 		    
		 			foreach ($products as $value) {
	                    echo '<option value="'.$value['id'].'">'.$value['name'].' '.$value['price'].'Р</option>';
		 			}
		 		?>
		 		
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Кол-во</label>
			<div class="col-sm-10">
				<input type="text" name="num" class="form-control" required>
			</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Ваш комментарий</label>
		<div class="col-sm-10">
			<input type="text" name="com" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button class="btn btn-primary" type="submit" style="width:200px;">Отправить данные</button>
			</div>
		
	</div>
</form>
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
		<p>Уважаемый(ая), <b>$fio</b></p>
		<p>Сумма вашей покупки товара "$pro": <b>$price</b> Рублей</p>
		<p>Ваш комментарий мы обязательно учтем: <b>$com</b></p>
		<p>Спасибо за покупку!</p>
HERE;
		$fp = fopen('file.csv','a');
		$list = array($fio, $pro, $_POST['num'], $com);
		fputcsv($fp, $list);
		fclose($fp);
	}
?>
</div>
</div>
</body>
</html>
