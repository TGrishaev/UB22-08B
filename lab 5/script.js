// Задание 1: Грибы
function displayMushrooms() {
    const count = document.getElementById('mushroomCount').value;
    document.getElementById('result1').textContent = count + " " + getMushroomWord(count);
  }
  
  function getMushroomWord(number) {
    let lastDigit = number % 10;
    let lastTwoDigits = number % 100;
  
    if (lastDigit === 1 && lastTwoDigits !== 11) {
      return 'гриб';
    } else if ([2, 3, 4].includes(lastDigit) && ![12, 13, 14].includes(lastTwoDigits)) {
      return 'гриба';
    } else {
      return 'грибов';
    }
  }
  
  /// Задание 2: Обработка массива
let currentArray = [];

function generateRandomArray() {
  currentArray = Array.from({ length: 10 }, () => Math.floor(Math.random() * 20) - 10);
  document.getElementById('randomArray').textContent = '[' + currentArray.join(', ') + ']';
}

function processArray() {
  // Часть А: Вычисление суммы без методов Array
  let sum = 0;
  for (let i = 0; i < currentArray.length; i++) {
    if (Math.cos(currentArray[i]) < 0) break;
    sum += currentArray[i];
  }

  // Часть Б: Удаление элементов с помощью методов Array
  currentArray = currentArray.filter(num => sumDigits(Math.floor(Math.abs(num))) % 2 === 0);
  document.getElementById('result2').textContent = "Сумма: " + sum + ", Отфильтрованный массив: " + currentArray;
}

function sumDigits(number) {
  return number.toString().split('').reduce((sum, digit) => sum + parseInt(digit), 0);
}
  
  // Задание 4: Палиндром
  function checkPalindrome() {
    const word = document.getElementById('wordInput').value;
    const isPalindrome = word === word.split('').reverse().join('');
    document.getElementById('result4').textContent = isPalindrome ? "Слово является палиндромом" : "Слово не является палиндромом";
  }