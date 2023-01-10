//affiche un entier sur 2 chiffres
function twoInt(n) {
  if (n >= 0 && n <= 9) {
    return '0' + n;
  }
  return n;
}

//renvoie true si l'année est bissextile, false sinon
function is_bi(year) {
  return (year % 4 == 0) &&(year % 400 == 0 || year % 100 != 0);
}

//renvoie le nombre de jours par rapport au mois et à l'année
function nbJours(month, year) {
  var n = 0;
  if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
    n = 31;
  } else if (month == 4 || month == 6 || month == 9 || month == 11) {
    n = 30;
  } else {
    if (is_bi(year)) {
      n = 29;
    } else {
      n = 28;
    }
  }
  return n;
}

//renvoie le premier jour du mois
function firstDay(month, year) {
  var first = new Date(year, month - 1, 1);
  var start = first.getDay();
  if (start == 0) {
    start = 7;
  }
  return start;
}

//renvoie le numéro du énième number du jour day du mois de l'année
function nthDayofMonth(month, year, number, day) {
  var date = new Date(year, month - 1, 1);
  var days = new Array;
  var k = 1;
  var j = 0;
  while (k <= 31) {
    if (date.getDay() == day) {
      days[j] = date.getDate();
      ++j;
      if (j == number) {
        return days[j - 1];
      }
    }
    ++k;
    date = new Date(year, month - 1, k);
  }
  return days[j - 1];
}

//applique style et color aux jours fériés

function ferie(tdd, style, color) {
  tdd.style.backgroundColor = color;
  tdd.style.textDecoration = style;
}

//applique color aux ponts   
function pont(tdd, color) {
  tdd.style.backgroundColor = color;
}
    
//affiche le calendrier du mois courant
function calendar(month, year, tabcolor) {

  //création d'un tableau contenant les initiales des jours de la semaine
  var Jours = new Array();
  Jours[1] = "Lun";
  Jours[2] = "Mar";
  Jours[3] = "Mer";
  Jours[4] = "Jeu";
  Jours[5] = "Ven";
  Jours[6] = "Sam";
  Jours[7] = "Dim";

  //création d'un tableau contenant les mois de l'année
  var Mois = new Array();
  Mois[1] = "Janvier";
  Mois[2] = "Février";
  Mois[3] = "Mars";
  Mois[4] = "Avril";
  Mois[5] = "Mai";
  Mois[6] = "Juin";
  Mois[7] = "Juillet";
  Mois[8] = "Août";
  Mois[9] = "Septembre";
  Mois[10] = "Octobre";
  Mois[11] = "Novembre";
  Mois[12] = "Décembre";

  //récupération du style choisi par l'utilisateur
  var underline = document.getElementById('underline').value;
  var style = document.getElementById('style').value;
  if (style == "wavy") {
    var style_choice = underline + " " + style;
  } else if (style == "underline") {
    var style_choice = style + " 2px";
  } else {
    var style_choice = style + " " + underline + " 2px";
  }
        
  //récupération du pays de l'utilisateur
  var pays = document.getElementById('pays');
  if (pays) {
    pays = pays.value;
  } else {
    pays = "fr";
  }
        
  //création de variables contenant le nombres de jours ainsi que le premier jour du mois courant
  var number = nbJours(month, year);
  var first = firstDay(month, year);

  //création d'un tableau
  var table = document.createElement('table');
  var tbh = table.insertRow();

  //on remplit la première ligne par les initiales des jours
  for (var i = 1 ; i < Jours.length ; ++i) {
    var tdh = tbh.insertCell();
    tdh.appendChild(document.createTextNode(Jours[i]));
    tdh.style.border="1px solid black";
    tdh.style.backgroundColor = "brown";
    tdh.style.color = "white";
  }

  var tbr = document.createElement("tr");
  var column = 0;		

  //on positionne le 1 au premier jour du mois
  for (var i = 1; i < first; i++) {
    var tdd = tbr.insertCell();
    tdd.style.border="1px solid black";
    tdd.style.backgroundColor = "hsl(207, 20%, 91%)";
    column++;
  }

  //on remplit le tableau avec le nombre de jours dans le mois
  for (let i = 1; i <= number; i++) {
    const k = document.createElement("k");
    i = twoInt(i);
    k.innerText = i;
    var tdd= tbr.insertCell();
    var q = document.getElementById('nb-event');
    if (q) {
      var p = q.value;

    }

    while (p > 0) {
      var style = document.getElementById('style-event-d'+p);
      var style_d = "";
      if(style) {
        style_d = style.value;
        var style_m = document.getElementById('style-event-m'+p).value;
        var style_y = document.getElementById('style-event-y'+p).value;
        (style_d == i || twoInt(style_d) == i) 
        && (style_m == twoInt(month) || style_m == month) && style_y == year ? 
        tdd.style.textDecoration = style_choice : null;
      }

      --p;
    }
    tdd.appendChild(document.createTextNode(i));
    tdd.style.border="1px solid black";
    
    tdd.style.height = "23.5px";
    //fonction affichant les évenements liés au jour sur lequel on clique
      tdd.onclick=function(){
        window.location.href = "accueil.php?jour="+
        (k.innerText)+"&mois="+twoInt(month)+"&annee="+year;
      };
      
      column++;
      if (column == 6) {
        tdd.style.backgroundColor=tabcolor[0];
      }

      //retour au lundi si l'on dépasse dimanche
        if (column == 7) {
          tdd.style.backgroundColor=tabcolor[1];
          table.appendChild(tbr);
          var tbr = document.createElement("tr");
          column = 0;
        }
          
       
        //gestion des jours fériés
          
          i == 1 && month == 1 ? ferie (tdd, style_choice, tabcolor[2]) : null;
          if (i == 2 && month == 1 && column == 5) {
            pont(tdd, tabcolor[3]);
          }
          
          i == 25 && month == 12 ? ferie(tdd, style_choice, tabcolor[2]) : null;
          
          //calcul de Pâques et des jours fériés qui en dépendent

            var G = year % 19;

            var C = Math.floor(year / 100);

            var H = (C - Math.floor(C / 4) - Math.floor((8 * C + 13) / 25) + 
            19 * G + 15) % 30;

            var I = H - Math.floor(H / 28) * (1 - Math.floor(H / 28) *
             Math.floor(29 / (H + 1)) * Math.floor((21 - G) / 11));

            var J = (year * 1 + Math.floor(year / 4) + I + 2 - C + 
            Math.floor(C / 4)) % 7;

            var L = I - J;

            var MoisPaques = 3 + Math.floor((L + 40) / 44);

            var JourPaques = L + 28 - 31 * Math.floor(MoisPaques / 4);
            
            i == JourPaques && month == MoisPaques ? 
            ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == JourPaques + 1 && month == MoisPaques && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            // lundi de Pâques
            if (JourPaques == 31) {
              i == 1 && month == MoisPaques + 1 ? 
              ferie (tdd, style_choice, tabcolor[2]) : null;
              if (i == 2 && month == MoisPaques + 1 && column == 5) {
                pont(tdd, tabcolor[3]);
              }
            }

            if (JourPaques == 2) {
              i == 31 && month == MoisPaques - 1 ? 
              ferie (tdd, style_choice, tabcolor[2]) : null;
              if (i == 1 && month == MoisPaques && column == 5) {
                pont(tdd, tabcolor[3]);
              }
            }

            if (JourPaques == 1) {
              i == 30 && month == MoisPaques - 1 ? 
              ferie (tdd, style_choice, tabcolor[2]) : null;
              if (i == 31 && month == MoisPaques && column == 5) {
                pont(tdd, tabcolor[3]);
              }
            }


            i == JourPaques + 1 && month == MoisPaques ? 
            ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == JourPaques + 2 && month == MoisPaques && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            // vendredi saint
            i == JourPaques - 2 && month == MoisPaques ? 
            ferie (tdd, style_choice, tabcolor[2]) : null;

            if (i == JourPaques - 1 && month == MoisPaques && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            // Ascension
            var JourAscension = JourPaques + 40;
            var MoisAscension = MoisPaques;
            if (JourAscension > nbJours(MoisPaques, year)) {
                JourAscension = JourAscension - nbJours(month, year);
                ++MoisAscension;
            }

            if (JourAscension > nbJours(MoisPaques + 1, year)) {
              JourAscension = JourAscension - nbJours(MoisPaques + 1, year) - 1;
              ++MoisAscension;
            }
            
            i == JourAscension && month == MoisAscension ? 
            ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == JourAscension + 1 && month == MoisAscension 
            && column == 5) {
              pont(tdd, tabcolor[3]);
            }

              
          if (i == 26 && month == 12 && column == 5) {
            pont(tdd, tabcolor[3]);
          }
          // en France
          
          
          if (pays === "fr") {
            
            //Pentecôte

            var JourPentecote = JourPaques + 50;
            var MoisPentecote = MoisPaques;
            if (JourPentecote > number) {
                JourPentecote = JourPentecote - number;
                ++MoisPentecote;
            }
          
            if (JourPentecote > nbJours(MoisPaques + 1, year)) {
              JourPentecote = JourPentecote - nbJours(MoisPaques + 1, year) - 1;
              ++MoisPentecote;
            }
            
            i == JourPentecote && month == MoisPentecote ? 
            ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == JourPentecote + 1 && month == MoisPentecote 
            && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            //lundi de Pentecôte


            i == JourPentecote + 1 && month == MoisPentecote 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == JourPentecote + 2 && month == MoisPentecote 
            && column == 5) {
              pont(tdd, tabcolor[3]);
            }
          
          
        
            
            
            
            i == 1 && month == 11 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 2 && month == 11 && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            i == 11 && month == 11 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 12 && month == 11 && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            i == 1 && month == 5 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 2 && month == 5 && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            i == 8 && month == 5 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 9 && month == 5 && column == 5) {
              pont(tdd, tabcolor[3]);
            }


            i == 14 && month == 7 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 15 && month == 7 && column == 5) {
              pont(tdd, tabcolor[3]);
            }


            i == 15 && month == 8 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 16 && month == 8 && column == 5) {
              pont(tdd, tabcolor[3]);
            }


            i == 26 && month == 12 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 27 && month == 12 && column == 5) {
              pont(tdd, tabcolor[3]);
            }

            
          }
          
          // au Royaume Uni
          
          if (pays === "uk") {
            
            i == 2 && month == 1 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 3 && month == 1 && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            
            i == 17 && month == 3 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 18 && month == 3 && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            
            month == 5 && i == nthDayofMonth(month, year, 1, 1)
             ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            month == 5 && i == nthDayofMonth(month, year, 5, 1) 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == 12 && month == 7 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 13 && month == 7 && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            
            i == nthDayofMonth(month, year, 1, 1) && month == 8 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
           
            i == nthDayofMonth(month, year, 5, 1) && month == 8 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == 30 && month == 11 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 1 && month == 12 && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            
            i == 26 && month == 12 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            if (i == 27 && month == 12 && column == 5) {
              pont(tdd, tabcolor[3]);
            }
            
          } else if (pays === "us") {
            
            i == nthDayofMonth(month, year, 3, 1) && month == 1 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == nthDayofMonth(month, year, 3, 1) && month == 2 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == nthDayofMonth(month, year, 5, 1) && month == 5 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == 19 && month == 6 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            i == 20 && month == 6 && column == 5 
            ? pont(tdd, tabcolor[3]) : null;
            
            
            i == 4 && month == 7 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            i == 5 && month == 7 && column == 5 
            ? pont(tdd, tabcolor[3]) : null;
            
            i == nthDayofMonth(month, year, 1, 1) && month == 9 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == nthDayofMonth(month, year, 2, 1) && month == 10 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            
            i == 11 && month == 11 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            i == 12 && month == 11 && column == 5
             ? pont(tdd, tabcolor[3]) : null;
            
            i == nthDayofMonth(month, year, 4, 4) && month == 11 
            ? ferie (tdd, style_choice, tabcolor[2]) : null;
            i == nthDayofMonth(month, year, 4, 5) && month == 11 
            ? pont(tdd, tabcolor[3]) : null;
          }
          
          
          
          //gestion du jour courant

          i == date.getDate() && date.getMonth() + 1 == month 
          && date.getFullYear() == year 
          ? tdd.style.border = "3px solid black" : null;
        
          i == number ? table.appendChild(tbr) : null;
          
           while (i == number && column != 7) {
          var tdd = tbr.insertCell();
          tdd.style.border="1px solid black";
          tdd.style.backgroundColor = "hsl(207, 20%, 91%)";
          column++;
        }
          
        }
        
        document.getElementById('month-select').value = (Mois[month]);
        document.getElementById('annee').value = year;
        document.getElementById('calendar').appendChild(table);
      }
