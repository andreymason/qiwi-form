<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
	<title>Выпуск карт</title>
</head>
<body>
	<div class="wrapper">
		<div class="view_cards_block">
			<form method="POST"> 
				<h2>Просмотреть карты</h2>
				<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
				<p>Токен: <input type="text" name="token"></p>
				 
				<p><input type="checkbox" id="only_cards" name="only_cards" class="custom-checkbox">
			    <label for="only_cards">Показать только карты через запятую</label></p>
			    <div class="button_submit_block">
					<input type="submit" name="show" value="Посмотреть карты" style="background:#61c5ff"><br>
				</div>
				<div class="view_cards_block_result">

				</div>
			</form>
		</div>
		<br/>

<form method="POST"> 
	<h2>Выпустить карты за 99 руб (Для оплаты рекламы в сервисах Яндекс.Директ и myTarget, QIWI Мастер Prepaid)</h2>
	Номер телефона: <input type="text" name="phonenumber" placeholder="380.....">
	Токен: <input type="text" name="token">
	Кол-во карт: <input type="number" name="number" value='1' min="1">
	<br>
	<br>
	<input type="submit" name="create" value="Выпустить карты">
</form>

<form method="POST"> 
	<h2>Выпустить карты за 99 руб (Для оплаты рекламы в сервисах Facebook и Google, QIWI Мастер Debit)</h2>
	<div class="view_cards_block">
		<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
		<p>Токен: <input type="text" name="token"></p>
		<p>Кол-во карт: <input type="number" name="number" value='1' min="1"></p>
		<div class="button_submit_block">
			<input type="submit" name="create2" value="Выпустить карты" style="background:#61c5ff">
		</div>	
	</div>
</form>
<div class="del_or_add_card_wrapper">
	<div class="del">
		<form method="POST"> 
			<h2>Заблочить карты</h2>
			<div class="input_del_add_wrapper">
				<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
				<p>Токен: <input type="text" name="token"></p>
			</div>
			<p class="number_card">Номера карт (через запятую):</p><br>
			<div class="textarea_wrapper">
				<textarea name="numbers" cols="60" rows="5"></textarea>
			</div>
			<input type="submit" name="block" value="Заблокировать карты" style="background: #ff1430;">
		</form>
		<div class="all_cards">
			<form method="POST" onSubmit='return confirm("Вы действительно хотите заблокировать все карты?")'>
				<div class="input_del_add_wrapper">
					<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
					<p>Токен: <input type="text" name="token"></p>
				</div>
				<input type="submit" name="block_all" value="Заблокировать все карты!" style="background: #ff1430;">
			</form>
		</div>
	</div>	
	<div class="add">	
		<form method="POST"> 
			<h2>Разблочить карты</h2>
			<div class="input_del_add_wrapper">
				<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
				<p>Токен: <input type="text" name="token"></p>
			</div>
			<p class="number_card">Номера карт (через запятую):</p><br>
			<div class="textarea_wrapper">
				<textarea name="numbers" cols="60" rows="5"></textarea>
			</div>
			<input type="submit" name="unblock" value="Разблокировать карты">
		</form>
		<div class="all_cards">
			<form method="POST" onSubmit='return confirm("Вы действительно хотите разблокировать все карты?")'>
				<div class="input_del_add_wrapper">
					<p>Номер телефона: <input type="text" name="phonenumber" placeholder="380....."></p>
					<p>Токен: <input type="text" name="token"></p>
				</div>
				<input type="submit" name="unblock_all" value="Разблокировать все карты!">
			</form>
		</div>
	</div>
</div>		
</div>
<?php 

function responseChecker($error) {
    if($error == 401) {
        echo "Неверный токен или истек срок действия токена API<br/>";
    }
    else if($error == 400) {
        echo "Ошибка синтаксиса запроса (неправильный формат данных)<br/>";
    }
    else if($error == 403) {
        echo "Нет прав на данный запрос (недостаточно разрешений у токена API)<br/>";
    }
    else if($error == 404) {
        echo "Не найдена транзакция или отсутствуют платежи с указанными признаками, либо не найден кошелек<br/>";
    }
    else if($error == 423) {
        echo "Слишком много запросов, сервис временно недоступен<br/>";
    } 
    else if($error == 500) {
        echo "Внутренняя ошибка сервиса (превышена длина URL веб-хука, проблемы с инфраструктурой, недоступность каких-либо ресурсов и т.д.)<br/>";
    }
    
}

if(isset($_POST["show"])) {

	$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";
	
	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer '.$_POST["token"]
	]);
	
	$result = curl_exec($ch);
	$result_array = json_decode($result);
	
	
	if (empty($result)) {
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	responseChecker($http_code);
	curl_close($ch); 
	} 
	else {
	foreach($result_array as $cards) {
		
		if($cards->qvx->status == "ACTIVE") {
			
			$url = "https://edge.qiwi.com/cards/v1/cards/".$cards->qvx->id."/details";
	
			$ch = curl_init($url);
	
			$data = json_encode(["operationId" => gen_uuid()]);
	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Accept: application/json',
				'Authorization: Bearer '.$_POST["token"],
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data)
			]);
	
			$res = curl_exec($ch);
			$res = json_decode($res);
			$checkcard = 0;
			curl_close($ch);
			
			if($res->errorCode == "auth.forbidden") {
			echo "Неверный токен. Попробуйте другой или смените его<br/>";
		    }
			else if (empty($res)) {
			    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			    responseChecker($http_code);
			}
			else {
			    
			    if(isset($_POST["only_cards"]) && $_POST["only_cards"] == "on") {
				echo $res->pan.", ";
			    }
			    else {
				$checkcard = 1;
				echo '<div class="result_line_block">';
					echo '<div class="result_line">';
						echo $res->pan.";".$cards->qvx->cardExpireMonth."/".$cards->qvx->cardExpireYear.";".$res->cvv;
						echo "<br/>".$cards->qvx->activated;
					echo "</div>";
				echo "</div>";
			    }
			    
			}	
		}
	}
	}
	}


if(isset($_POST["block_all"])) {
    
	$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer '.$_POST["token"] 
	]);

	$result = curl_exec($ch);
	$result_array = json_decode($result);
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if (empty($result)) {
	    
        responseChecker($http_code);
        curl_close($ch); 
    }
    else {
        foreach($result_array as $res) {
    		if($res->qvx->status == "ACTIVE") {
    			$url = "https://edge.qiwi.com/cards/v2/persons/".$_POST["phonenumber"]."/cards/".$res->qvx->id."/block";
    
    			$ch = curl_init($url);
    
    			curl_setopt($ch, CURLOPT_URL, $url);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    			curl_setopt($ch, CURLOPT_PUT, true);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, [
    				'Accept: application/json',
    				'Content-Type: application/json',
    				'Authorization: Bearer '.$_POST["token"]
    			]);
    			
    			$res = curl_exec($ch);
    			
    			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    			
    			if (empty($res)) {
    			    responseChecker($http_code);
    			}
    			
    		}
    	}
    	
    	echo "<p>Все карты заблокированы</p>";
    }

	
}

if(isset($_POST["unblock_all"])) {
	
	$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer '.$_POST["token"] 
	]);

	$result = curl_exec($ch);
	$result_array = json_decode($result);
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if (empty($result)) {
	    
        responseChecker($http_code);
        curl_close($ch); 
    }
    else {
        foreach($result_array as $res) {
    		$url = "https://edge.qiwi.com/cards/v2/persons/".$_POST["phonenumber"]."/cards/".$res->qvx->id."/unblock";
    
    		$ch = curl_init($url);
    
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_PUT, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    			'Accept: application/json',
    			'Content-Type: application/json',
    			'Authorization: Bearer '.$_POST["token"]
    		]);
    
    		$res = curl_exec($ch);
    		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    		
    		if (empty($res)) {
			    responseChecker($http_code);
			}
    		
    	}
    	
    	echo "<p>Все карты разблокированы</p>";
    }
}


if(isset($_POST["block"])) {

	$cards = explode(",", $_POST["numbers"]);
	foreach($cards as $card) {
		$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer '.$_POST["token"]
		]);

		$result = curl_exec($ch);
		$result_array = json_decode($result);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
    	if (empty($result)) {
    	    
            responseChecker($http_code);
            curl_close($ch); 
        }
        else {
            foreach($result_array as $res) {
    			if(substr($res->qvx->maskedPan, -4) == substr($card, -4)) {
    				$url = "https://edge.qiwi.com/cards/v2/persons/".$_POST["phonenumber"]."/cards/".$res->qvx->id."/block";
    
    				$ch = curl_init($url);
    
    				curl_setopt($ch, CURLOPT_URL, $url);
    				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    				curl_setopt($ch, CURLOPT_HTTPHEADER, [
    					'Accept: application/json',
    					'Authorization: Bearer '.$_POST["token"],
    					'Content-Type: application/json'
    				]);
    
    				$res = curl_exec($ch);
    				$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    				
    				if (empty($res)) {
        			    responseChecker($http_code);
        			}
        			else {
        			    echo "Блокнул карту ".$card."<br/>";
        			}
    			}
    		}
        }
	}
}

if(isset($_POST["unblock"])) {
    
	$cards = explode(",", $_POST["numbers"]);
	foreach($cards as $card) {
		$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer '.$_POST["token"]
		]);

		$result = curl_exec($ch);
		$result_array = json_decode($result);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
    	if (empty($result)) {
    	    
            responseChecker($http_code);
            curl_close($ch); 
        }
        else {
            foreach($result_array as $res) {
    			if(substr($res->qvx->maskedPan, -4) == substr($card, -4)) {
    				$url = "https://edge.qiwi.com/cards/v2/persons/".$_POST["phonenumber"]."/cards/".$res->qvx->id."/unblock";
    
    				$ch = curl_init($url);
    
    				curl_setopt($ch, CURLOPT_URL, $url);
    				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    				curl_setopt($ch, CURLOPT_HTTPHEADER, [
    					'Accept: application/json',
    					'Authorization: Bearer '.$_POST["token"],
    					'Content-Type: application/json'
    				]);
    
    				$res = curl_exec($ch);
    				$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    				
    				if (empty($res)) {
        			    responseChecker($http_code);
        			}
        			else {
        			    echo "Разблокировал карту ".$card."<br/>";
        			}
    			}
    		}
        }
	}
}

function gen_uuid() {
	 $uuid = array(
	  'time_low'  => 0,
	  'time_mid'  => 0,
	  'time_hi'  => 0,
	  'clock_seq_hi' => 0,
	  'clock_seq_low' => 0,
	  'node'   => array()
	 );

	 $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
	 $uuid['time_mid'] = mt_rand(0, 0xffff);
	 $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
	 $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
	 $uuid['clock_seq_low'] = mt_rand(0, 255);

	 for ($i = 0; $i < 6; $i++) {
	  $uuid['node'][$i] = mt_rand(0, 255);
	 }

	 $uuid = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
	  $uuid['time_low'],
	  $uuid['time_mid'],
	  $uuid['time_hi'],
	  $uuid['clock_seq_hi'],
	  $uuid['clock_seq_low'],
	  $uuid['node'][0],
	  $uuid['node'][1],
	  $uuid['node'][2],
	  $uuid['node'][3],
	  $uuid['node'][4],
	  $uuid['node'][5]
	 );

	 return $uuid;
}

function createCards($number, $token, $numCards, $alias, $price) {
    
    for($i = 0; $i < $numCards; $i++) {
        $url = "https://edge.qiwi.com/cards/v2/persons/".$number."/orders";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["cardAlias" => $alias]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ]);

        $result = curl_exec($ch);

        $result_array = json_decode($result);
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        $idd = $result_array->id;
        
	    if($result_array->errorCode == "auth.forbidden") {
	        echo "Неверный токен. Попробуйте другой или смените его";
	    }
    	else if (empty($result)) {
    	    
            responseChecker($http_code);
            curl_close($ch); 
        }
        else {

            $url = "https://edge.qiwi.com/cards/v2/persons/".$number."/orders/".$idd."/submit";
    
            $ch = curl_init($url);
    
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer '.$token
            ]);
    
            $result = curl_exec($ch);
            
            $result_array = json_decode($result);
    
            curl_close($ch);
            
            if (empty($result)) {
    	        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                responseChecker($http_code);
                curl_close($ch); 
            }
            else {
                $url = "https://edge.qiwi.com/sinap/api/v2/terms/32064/payments";
    
                $postfields = json_encode(["id" => strval(time() * 1000), "sum" => ["amount" => $price, "currency" => "643"], "paymentMethod" => ["type" => "Account", "accountId" => "643"], "fields" => ["account" => $number, "order_id" => $idd]]);
        
                $ch = curl_init($url);
        
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token
                ]);
        
                $res = curl_exec($ch);
                
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                curl_close($ch);
    				
				if (empty($res)) {
    			    responseChecker($http_code);
    			}
    			
        		sleep(1);
            }
        }
    }
	
	sleep(5);
	
	$url = "https://edge.qiwi.com/cards/v1/cards?vas-alias=qvc-master";

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer '.$token
	]);

	$result = curl_exec($ch);
	$result_array = json_decode($result);
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
    if (empty($result)) {
    
        responseChecker($http_code);
        curl_close($ch); 
    }
    else {
        foreach($result_array as $cards) {
    		
    		$now = strtotime("now");
    		
    		if((($now + 300) > strtotime($cards->qvx->activated)) && (($now - 300) < strtotime($cards->qvx->activated))) {
    			
    			$url = "https://edge.qiwi.com/cards/v1/cards/".$cards->qvx->id."/details";
    
    			$ch = curl_init($url);
    
    			$data = json_encode(["operationId" => gen_uuid()]);
    
    			curl_setopt($ch, CURLOPT_URL, $url);
    			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, [
    				'Accept: application/json',
    				'Authorization: Bearer '.$token,
    				'Content-Type: application/json',
    				'Content-Length: ' . strlen($data)
    			]);
    
    
    			$res = curl_exec($ch);
    			$res = json_decode($res);
    
    			curl_close($ch);
    			
    			if (empty($res)) {
    			    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    			    responseChecker($http_code);
    			}
    			else {
    			    echo $res->pan.";".$cards->qvx->cardExpireMonth."/".$cards->qvx->cardExpireYear.";".$res->cvv;
    			
        			echo "<br/>";
        			echo "<br/>";
    			}
    		}
    	}
    	echo "<br/>Карты создались";
    }
}
if(isset($_POST["create"])) {
	createCards($_POST["phonenumber"], $_POST["token"], $_POST["number"], "qvc-cpa", 99);
}

if(isset($_POST["create2"])) {
	createCards($_POST["phonenumber"], $_POST["token"], $_POST["number"], "qvc-cpa-debit", 99);
}

?>
</body>
</html>
