var ton = document.getElementById('confirm-color').value;

if (ton == "chaud") {
  var tabcolor = ["orange", "red", "yellow", "#FFCD9B"];
} else if (ton == "froid") {
  var tabcolor = ["blue", "purple", "#40E0D0", "#87CEEB"];
} else if (ton == "neutre") {
  var tabcolor = ["#BBBBBB", "#707070", "#946C6C", "plum"];
}

//remise du calendrier au mois courant
document.getElementById('now').addEventListener("click", 
function() {
  document.getElementById('calendar').innerHTML = '';
  month = date.getMonth() + 1;
  year = date.getFullYear();
  calendar(month, year, tabcolor);
});

//affiche le calendrier du mois précédent
document.getElementById('prev').addEventListener("click", 
function() {
  month = month - 1;
  if (month == 0) {
    --year;
    month = 12;
  }
  document.getElementById('calendar').innerHTML = '';
  calendar(month, year, tabcolor);
});

//affiche le calendrier du mois suivant
document.getElementById('next').addEventListener("click", 
function() {
  month++;
  if (month == 13) {
    ++year;
    month = 1;
  }
  document.getElementById('calendar').innerHTML = '';
  calendar(month, year, tabcolor);
});

//affiche le calendrier du mois et de l'année selectionnés
document.getElementById('confirm').addEventListener("click", 
function() {
  var select_month = document.getElementById('month-select');
  var choice_month = select_month.selectedIndex;
  var choice_year = document.getElementById('annee').value;
  document.getElementById('calendar').innerHTML = '';
  month = choice_month + 1;
  year = choice_year;
  calendar(month, choice_year, tabcolor);
});

//affiche, par défaut, le calendrier du mois courant
calendar(month, year, tabcolor);





