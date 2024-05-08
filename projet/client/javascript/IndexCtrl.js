$().ready(function () {
  wrk = new Service();
  window.ctrl = new IndexCtrl();
  ctrl.init();
});

class IndexCtrl {
  constructor() {

  }
  init() {
    wrk.checkLogin(() => ctrl.loadAccueilCo(), () => ctrl.loadAccueil())
  }

  championSuccess(data) {
    $("#Acccontent").empty();
    $(data).find("champion").each(function () {

      var div = document.createElement("div");
      div.className = "champion";

      var name = document.createElement("h3");
      name.textContent = $(this).find("nom").text();
      div.appendChild(name);

      var img = document.createElement("img");
      img.src = $(this).find("image").text();
      img.width = 280; // Ajustez la taille selon vos besoins
      div.appendChild(img);

      var description = document.createElement("p");
      description.textContent = $(this).find("description").text();
      div.appendChild(description);

      var mana = document.createElement("p");
      mana.textContent = "Mana: " + $(this).find("mana").text();
      div.appendChild(mana);

      var type = document.createElement("p");
      type.textContent = "Type: " + $(this).find("type").text();
      div.appendChild(type);

      var region = document.createElement("p");
      region.textContent = "Region: " + $(this).find("region").text();
      div.appendChild(region);

      var role = document.createElement("p");
      type.textContent = "Role: " + $(this).find("role").text();
      div.appendChild(type);

      var user = document.createElement("p");
      user.textContent = "Created by: " + $(this).find("user").text();
      div.appendChild(user);

      $("#Acccontent").append(div);
    });
  }
  //récupérer les valeurs entrées par l'utilisateur dans les champs
  registerUser() {
    var username = $("#username").val()
    var password = $("#password").val()
    //verification si c'est vide
    if (username == "" || password == "") {
      //fail
    }
    //Si les champs ne sont pas vides, une requête AJAX est envoyée au serveur pour enregistrer le nouvel utilisateur
    wrk.registerUser(username, password, this.registerSuccess)
  }

  registerSuccess(data) {
    var res = $(data).find("result").text()
    if (res == "true") {
      alert("register Sucess");
      ctrl.loadAccueil();
    } else {
      alert("register Failed")
    }
  }
  loadAccueil() {
    wrk.loadView("accueil");
    wrk.getChampions(this.championSuccess);
  }
  loadAccueilCo() {
    wrk.loadView("accueilConnecte");
    wrk.getChampions(this.championSuccess);

  }
  loadLogin() {
    wrk.loadView("login");
  }
  loadRegister() {
    wrk.loadView("register");
  }

  loginSuccess() {
    alert("BIEN JOUE");
    ctrl.loadAccueilCo();
  }
  error() {
    alert("pas correcte");
  }


  loginUser() {
    wrk.login($("#Lusername").val(), $("#Lpassword").val(), this.loginSuccess, this.error);

  }
  disconnect() {
    wrk.disconnect(this.successDisconnect);
  }
  successDisconnect() {
    ctrl.loadAccueil();
  }


}