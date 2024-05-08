$().ready(function () {
  wrk = new Service();
  window.ctrl = new IndexCtrl();
  ctrl.init();
});

class IndexCtrl {
  constructor() {

  }
  init() {
    wrk.checkLogin(ctrl.loadAccueilCo, ctrl.loadAccueil);
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
      role.textContent = "Role: ";
      $(this).find("roles").each(function () {
        role.textContent += $(this).text() + " ";
      })
      if (role.textContent === "Role: ") {
        role.textContent += "None";
      }
      div.appendChild(role);


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
    wrk.registerUser(username, password, ctrl.registerSuccess)
  }

  registerSuccess(data) {
    var res = $(data).find("result").text()
    if (res == "true") {
      alert("register Success");
      ctrl.loadAccueil();
    } else {
      alert("register Failed")
    }
  }
  loadAccueil() {
    wrk.loadView("accueil");
    wrk.getChampions(ctrl.championSuccess);
  }
  loadAccueilCo() {
    wrk.loadView("accueilConnecte");
    wrk.getChampions(ctrl.championSuccess);

  }
  loadLogin() {
    wrk.loadView("login");
  }
  loadRegister() {
    wrk.loadView("register");
  }

  loadCreate(){
    wrk.loadView("create");
  }

  loginSuccess() {
    ctrl.loadAccueilCo();
  }
  error() {
    alert("Login or Password invalid");
  }

  loginUser() {
    wrk.login($("#Lusername").val(), $("#Lpassword").val(), ctrl.loginSuccess, ctrl.error);

  }
  disconnect() {
    wrk.disconnect(ctrl.successDisconnect);
  }
  successDisconnect() {
    ctrl.loadAccueil();
  }

  createChampion(){
    var name = $("#name").val();
    var image = $("#image").val();
    var description = $("#description").val();
    var mana = document.getElementById("mana").checked ? 1: 0;
    var i = document.getElementById("region");
    var region = i.options[i.selectedIndex].value;
    var j = document.getElementById("type");
    var type = j.options[j.selectedIndex].value;
    var roles = [];
    $("#roles input[type='checkbox']:checked").each(function () {
      roles.push($(this).attr("value"));
    })
    if (name && image && description && region != "default" && type != "default" && roles.length > 0) {
      wrk.createChampion(name, image,description, mana,roles,region,type,ctrl.createSuccess, ctrl.createError);
    }else{
      $("#Cresult").text("Required Field Not Full");
    }

  }
  createError(){
    alert("Error Creating champion");
  }
  createSuccess(){
    ctrl.loadAccueilCo();
  }
}