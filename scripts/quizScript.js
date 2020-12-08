quizResults = quizResults.split(', ');
quizResults.splice(0, 1);
let ons = quizResults.filter(item => /[ア-ン]+/.test(item)),
	kuns = quizResults.filter(item => /[あ-ん]+/.test(item)),
	meanings = quizResults.filter(item => /[а-я]+/.test(item)),
	onsRomaji = quizResults.slice(ons.length + kuns.length, ons.length + kuns.length + ons.length),
	kunsRomaji = quizResults.slice(ons.length + kuns.length + ons.length, ons.length + kuns.length + ons.length + kuns.length);

let checkButton = document.querySelector('.buttons__check-answers'),
	showResultsButton = document.querySelector('.buttons__show-results');

function isAnswerCorrect(arrayValues, arrayCorrectValues) {
	for (let i = 0; i < arrayValues.length; i++) {
		if (!arrayCorrectValues.includes(arrayValues[i])) { return false; }
	}
	return true;
}

function howToSplit(input) {
	if (input.split('').includes(',')) { return input.split(', '); } 
	else if (input.split('').includes('、')) { return input.split('、'); }
	else if (input.split('').includes('　')) { return input.split('　'); }
	else { return input.split(' '); }
}

function checkAnswers() {
	let quizAnswerOns = howToSplit(document.getElementById('answer-field__item-ons').value),
		quizAnswerKuns = howToSplit(document.getElementById('answer-field__item-kuns').value),
		quizAnswerMeanings = howToSplit(document.getElementById('answer-field__item-meanings').value.toLowerCase());
	
	let onsCorrect = isAnswerCorrect(quizAnswerOns, ons), 
		kunsCorrect = isAnswerCorrect(quizAnswerKuns, kuns), 
		meaningsCorrect = isAnswerCorrect(quizAnswerMeanings, meanings);
	console.log(onsCorrect, kunsCorrect, meaningsCorrect);
}

function showResults() {
	let resultsOns = document.querySelector('.results__ons').innerHTML,
		resultsKuns = document.querySelector('.results__kuns').innerHTML,
		resultsMeanings = document.querySelector('.results__meanings').innerHTML,
		quizResultsBlock = document.querySelector('.quiz__results');
	
	resultsOns = 'Онные чтения: ' + ons.join('、');
	resultsKuns = 'Кунные чтения: ' + kuns.join('、');
	resultsMeanings = 'Значения: ' + meanings.join(', ');
	quizResultsBlock.style.display = 'block';
}
checkButton.addEventListener('click', checkAnswers);
showResultsButton.addEventListener('click', showResults);


