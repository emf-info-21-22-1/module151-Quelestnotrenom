var BASE_URL = "../../server/server.php";

class Service {
  constructor() {

  }

  getChampions(successCallback, errorCallBack) {
    $.ajax({
      type: "GET",
      dataType: "XML",
      data: "action=champion",
      url: BASE_URL,
      success: successCallback,
      error: errorCallBack,

    })
  }


  registerUser(username, password, callback) {
    $.ajax({
      type: "POST",
      dataType: "XML",
      data: "action=register&username=" + username + "&password=" + password,
      url: BASE_URL,
      success: callback
    });
  }

  loadView(vue,) {
    $("#content").load("views/" + vue + ".html", function () {
      if (typeof callback !== "undefined") {
        callback();
      }
    })
  }
  login(username, password, successCallback, errorCallBack) {
    $.ajax({
      type: "POST",      
      dataType: "XML",
      data: "action=login&username=" + username + "&password=" + password,
      url: BASE_URL,
      success: successCallback,
      error: errorCallBack,
    });
  }
  checkLogin(successCallback, errorCallBack) {
    $.ajax({
      type: "POST",      
      url: BASE_URL,
      data: "action=checkLogin",
      success: successCallback,
      error: errorCallBack,
    });
  }
  disconnect(successCallback) {
    $.ajax({
      type: "POST",
      dataType: "XML",
      data: "action=deconnexion",
      url: BASE_URL,
      success: successCallback
    });
  }

}