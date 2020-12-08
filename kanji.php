<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Иероглифы</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/kanji-styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="scripts/kanjiScript.js" defer></script>
</head>
<body>
<?php
	include('config.php');
	
	$kanjiSelect = $mysqli->query("SELECT kanji_view FROM kanji");
	$radicalsSelect = $mysqli->query("SELECT * from kanji_keys");
	
	$radicalsList = [];
	while ($item = $radicalsSelect->fetch_array()) {
		array_push($radicalsList, $item);
	}	
?>
<header class="header">
	<div class="container header__container">
		<div class="header__inner">
			<div class="header__logo">
				<div class="logo__image-block">
					<img src="images/logo.png" alt="Kanagawa wave" class="logo__image">
				</div>
				<div class="logo__title-block">
					<span class="logo__title">Yume<br>Chizu</span>
				</div>
			</div>
			<nav class="header__nav">
				<a href="home.php" class="nav__item">Главная</a>
				<a href="#" class="nav__item">Иероглифы</a>
				<a href="words.php" class="nav__item">Слова</a>
			</nav>
		</div>
	</div>
</header>
<div class="main">
	<div class="main__inner">
		<div class="inner__title-block">
			<div class="container">
				<h1 class="inner__title">Изученные иероглифы</h1>
			</div>
		</div>
		<div class="inner__interactions-block">
			<div class="container">
				<div class="inner__interactions">
					<form action="search.php" class="interactions__search-block">
						<input type="search" name="search" class="interactions__search" placeholder="Найти иероглифы">
						<input type="image" src="images/search.png" class="interactions__search-image">
					</form>
					<div class="interactions__add-block">
						<a href="add-kanji.php" class="interactions__add">Добавить иероглиф</a>
					</div>
					<div class="interactions__add-block">
						<a href="radicals.php" class="interactions__add">Ключи</a>
					</div>
				</div>
			</div>
		</div>
		<div class="inner__content">
			<form class="content__form" action="kanji-item.php" method="get">
				<?php
					for ($i = 0; $i < count($radicalsList); $i++) {
						$radicalNumber = $radicalsList[$i]['key_number'];
						$radicalView = $radicalsList[$i]['key_view'];
						$radicalName = $radicalsList[$i]['key_name'];

						$selectKanjiOfRadical = $mysqli->query("SELECT kanji_view FROM kanji WHERE key_num = '$radicalNumber'");
						$kanjiOfRadicalList = [];
						while ($item = $selectKanjiOfRadical->fetch_array()) {
							array_push($kanjiOfRadicalList, $item);
						}
						if (count($kanjiOfRadicalList)) {
							print("<div class='content__item'>
											 <div class='container'>
												 <div class='item__radical-block'>	
													 <h2 class='item__radical'>Ключ $radicalNumber:  $radicalView ($radicalName)</h2>
												 </div>
												 <div class='item__kanji-list'>");
							for ($j = 0; $j < count($kanjiOfRadicalList); $j++) {
								$item = $kanjiOfRadicalList[$j]['kanji_view'];
								print("<button class='kanji-list__item' name='kanji' value='$item'>$item</button>");
							}
								print("</div>
										 </div>
									 </div>");
						}
					}

				?>
			</form>
		</div>
	</div>
</div>
</body>
</html>