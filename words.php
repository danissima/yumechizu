<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Слова</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="stylesheet" href="styles/words-styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="module" src="scripts/wordsScript.js" defer></script>
</head>
<body>
<?php
	include('config.php');
	
	$selectWords = $mysqli->query("SELECT * FROM words ORDER BY kana");
	$words = [];
	while($item = $selectWords->fetch_array()) {
		$item['from'] = 'words';
		array_push($words, $item);
	}
	$selectCombs = $mysqli->query("SELECT * FROM combinations ORDER BY kana");
	while($item = $selectCombs->fetch_array()) {
		$item['from'] = 'combs';
		array_push($words, $item);
	}
	$sortedByKana = [];
	$memory = null;
	foreach($words as &$word) {
		preg_match_all('/./u', $word['kana'], $letter);
		if ($letter[0][0] != $memory) {
			$memory = $letter[0][0];
			$sortedByKana[$memory] = array();
		}
		$sortedByKana[$memory][] = $word;
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
				<a href="kanji.php" class="nav__item">Иероглифы</a>
				<a href="#" class="nav__item">Слова</a>
			</nav>
		</div>
	</div>
</header>
<div class="main">
	<div class="container">
		<div class="main__inner">
			<div class="inner__title-block">
				<h1 class="inner__title">Изученные слова</h1>
			</div>
			<div class="inner__interactions-block">
				<div class="inner__interactions">
					<form action="" class="interactions__search-block">
						<input type="search" name="search" class="interactions__search" placeholder="Найти слова">
						<input type="image" src="images/search.png" class="interactions__search-image">
					</form>
				</div>
			</div>
			<div class="inner__content">
				<div class="content__form-block">
					<form action="add-words.php" class="content__form" method="get">
						<div class="form__item-block">
							<div class="form__item-title-block">
								<h3 class="form__item-title">Новые слова: </h3>
								<button form="" class="word__add button__add form__button">&#43;</button>
							</div>
							<div class="item__table-block">
								<table cellspacing='3' border='0' class="form__table">
									<thead>
										<tr class="table__row table__head-row">
											<th class="table__cell table__head-cell">Слово</th>
											<th class="table__cell table__head-cell">Азбука</th>
											<th class="table__cell table__head-cell">Перевод</th>
										</tr>
									</thead>
									<tbody class="words__table">
										<tr class="table__row">
											<td class="table__cell"><input placeholder="Введи слово" name="wordKanji[]" type="text" class="form__item form__item_no-margin"></td>
											<td class="table__cell"><input placeholder="Введи написание азбукой" name="wordKana[]" type="text" class="form__item form__item_no-margin"></td>
											<td class="table__cell"><input placeholder="Введи перевод" name="wordTranslation[]" type="text" class="form__item form__item_no-margin"></td>
											<td class='table__cell'><button type='button' class='word__remove manipulate__button'>&times;</button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="form__submit">
							<input type="submit" value="Добавить слова" class="form__button form__button-submit">
							<input type="hidden" value="add" name="action">
						</div>
					</form>
				</div>
				<div class="content__letters">
					<?php
						foreach($sortedByKana as &$letter) {
							$current = key($sortedByKana);
							print("<div class='letter__item'>");
							print("<span class='letter'>$current</span>");
							print("<table class='content__table' cellspacing='3' bordercolor='black' frame='void' border='1'>
											<tr class='table__row table__head-row'>
												<th class='table__cell table__head-cell'>Иероглифы</th>
												<th class='table__cell table__head-cell'>Азбука</th>
												<th class='table__cell table__head-cell'>Перевод</th>
												<th class='table__cell table__head-cell'>&#128563;</th>
											</tr>");
							foreach($letter as &$word) {
								$id = $word['ID'];
								$from = $word['from'];
								$wordKanji = $word[1];
								$kana = $word['kana'];
								$translation = $word['translation'];
								print("<tr class='table__row'>
												 <input type='hidden' value='$id' class='word-id'>
												 <td class='table__cell'>$wordKanji</td>
												 <td class='table__cell'>$kana</td>
												 <td class='table__cell'>$translation</td>
												 <td class='table__cell table__manipulate'><button class='word__change manipulate__button'><span class='manipulate__pen'>&#9999;</span></button></td>
												 <input type='hidden' value='$from' class='word-from'>
											 </tr>");
							}
							print("</table>");
							print("</div>");
							next($sortedByKana);
						}

					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal">
	<div class="container">
		<div class="modal__inner">
			<div class="modal__content">
				<div class="modal__title-block">
					<h1 class="modal__title">Изменить ключ</h1>
					<div class="modal__close-block">
						<button class="modal__close form__button">&times;</button>
					</div>
				</div>
				<form action="add-words.php" method="get" class="modal__form">
					<div class="form__table-block">
						<table class="modal__table">
							<thead>
								<tr class="table__row table__head-row">
									<th class="table__cell table__head-cell">Ключ</th>
									<th class="table__cell table__head-cell">Номер</th>
									<th class="table__cell table__head-cell">Название</th>
								</tr>
							</thead>
							<tbody class="modal__body">
								<tr class="table__row">
									<td class="table__cell"><input placeholder="Введи слово" class="form__item form__item_no-margin modal__word" type="text" name="wordKanji"></td>
									<td class="table__cell"><input placeholder="Введи написание азбукой" class="form__item form__item_no-margin modal__kana" type="text" name="wordKana"></td>
									<td class="table__cell"><input placeholder="Введи перевод" class="form__item form__item_no-margin modal__translation" type="text" name="wordTranslation"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal__submit">
						<input type="submit" value="Изменить слово" class="form__button form__button-submit">
						<input type="hidden" value="change" name="action">
						<input type="hidden" value="" name="changing" class="changing">
						<input type="hidden" value="" name="from" class="from">
					</div>
				</form>
				<form action="add-words.php" method="get" class="modal__form modal__delete">
					<div class="modal__submit">
						<input type="submit" value="Удалить слово" class="form__button form__button-submit">
						<input type="hidden" value="delete" name="action">
						<input type="hidden" value="" name="deleting" class="deleting">
						<input type="hidden" value="" name="from" class="from">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
