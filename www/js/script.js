// Когда странциа готова, выполняется скрипт
$(document).ready(function() {
  // Инициализируем запуск сортировщика таблиц
  $("#table").tablesorter({
    theme: "bootstrap",
    headers: {
      '.noneSort': {
        sorter: false
      }
    }
  });

  // Собираем nodeList для провекрки значения поля salary
  var matches = document.querySelectorAll("td.salary");
  for (var i = 0; i < matches.length; i++) {
    var dom = matches[i].innerHTML;
    if (dom > 1500) {
      matches[i].innerHTML = 1500;
    }
  }
})

// Счетчик обратного отсчета для редиректа после удаления ведомости
function countdown() {
  var i = document.getElementById("counter");
  if (parseInt(i.innerHTML) != 0) {
    i.innerHTML = parseInt(i.innerHTML) - 1;
  }
}
setInterval(function() {
  countdown();
}, 1000);
