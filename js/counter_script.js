let counter = document.getElementById('count').innerHTML;
let maxCount = 10;

// Проверка на правильное отображение кнопок после загрузки страницы (начало)
if(counter == "") {
  counter = 1;
  document.getElementById('count').innerHTML = counter;
}

if(counter >= maxCount) {
  counter = maxCount;
  document.getElementById('count').innerHTML = counter;
  document.getElementById('plus').disabled = true;
  document.getElementById('plus').style.cursor = "auto";
}
else if(counter < maxCount && counter > maxCount) {
  document.getElementById('plus').disabled = false;
  document.getElementById('minus').disabled = false;
  document.getElementById('plus').style.cursor = "pointer";
  document.getElementById('minus').style.cursor = "pointer";
}
else if(counter <= 1) {
  counter = 1;
  document.getElementById('count').innerHTML = counter;
  document.getElementById('minus').disabled = true;
  document.getElementById('minus').style.cursor = "auto";
}
// Проверка на правильное отображение кнопок после загрузки страницы (конец)


// Слушатели нажатия кнопок
document.getElementById('plus').onclick = onClickPlus;
document.getElementById('minus').onclick = onClickMinus;

// Нажатие на "+"
function onClickPlus() {
  counter++;

  if(counter > 1) {
    document.getElementById('minus').disabled = false;
    document.getElementById('minus').style.cursor = "pointer";
  }

  document.getElementById('count').innerHTML = counter;

  if((counter + 1) > maxCount) {
    document.getElementById('plus').disabled = true;
    document.getElementById('plus').style.cursor = "auto";
  }
}

// Нажатие на "-"
function onClickMinus() {
  counter--;

  if(counter < maxCount) {
    document.getElementById('plus').disabled = false;
    document.getElementById('plus').style.cursor = "pointer";
  }

  document.getElementById('count').innerHTML = counter;

  if(counter == 1) {
    document.getElementById('minus').disabled = true;
    document.getElementById('minus').style.cursor = "auto";
  }
}
