//affiche un entier sur 2 chiffres
function twoInt(n) {
  if (n >= 0 && n <= 9) {
    return '0' + n;
  }
  return n;
}
  
//récupère la date courante
function todayDate(){
  g = new Date();
  return twoInt(g.getDate()) + ' / ' + twoInt(g.getMonth() + 1) + ' / ' + g.getFullYear();
}
  
//affiche l'heure courante puis la supprime toutes les 1000 millisecondes
function heure() {
  var d = new Date ();
  var annee = d.getFullYear();
  var ete = (31-(33+Math.trunc(497/400) * annee) % 7);
  var hiver = (31-(51+Math.trunc(497/400) * annee) % 7);
  if (d.getMonth() == 2 && d.getDate() == ete) {
    if(d.getHours() < 2) {
      document.getElementById("heure").innerHTML =
      ("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) + ":" 
      + twoInt(d.getSeconds()) + (" (heure d'hiver)"));
    } else {
      document.getElementById("heure").innerHTML 
      =("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) 
      + ":" + twoInt(d.getSeconds()) + (" (heure d'été)"));
    }
  } else if (d.getMonth() == 9 && d.getDate() == hiver && d.getHours() < 3) {
    document.getElementById("heure").innerHTML 
    =("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) 
    + ":" + twoInt(d.getSeconds()) + (" (heure d'été)"));
  } else if (d.getMonth() == 9 && d.getDate() == hiver && d.getHours() >= 3) {
    document.getElementById("heure").innerHTML =("Il est " + 
    twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) + ":" + 
    twoInt(d.getSeconds()) + (" (heure d'hiver)"));
  } else if (d.getMonth() == 2 && d.getDate() == ete && d.getHours >= 2) {
    document.getElementById("heure").innerHTML 
    =("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) 
    + ":" + twoInt(d.getSeconds()) + (" (heure d'été)"));
  } else if (d.getMonth() >= 2 && d.getDate() >= ete && d.getMonth() <= 9 
  && d.getDate() <= hiver) {
    document.getElementById("heure").innerHTML 
    =("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) 
    + ":" + twoInt(d.getSeconds()) + (" (heure d'été)"));
  } else {
    document.getElementById("heure").innerHTML 
    =("Il est " + twoInt(d.getHours()) + ":" + twoInt(d.getMinutes()) 
    + ":" + twoInt(d.getSeconds()) + (" (heure d'hiver)"));
  }
  setTimeout("heure()", 1000);
}
