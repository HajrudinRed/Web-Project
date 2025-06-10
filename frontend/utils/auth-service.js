var AuthService = {
  init: function () {
    // ✅ Check both token names for consistency
    var token = localStorage.getItem("jwt_token") || localStorage.getItem("user_token");
    if (token && token !== "undefined") {
      window.location.replace("index.html");
    }
    $("#login-form").validate({
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        AuthService.login(entity);
      },
    });
  },
  
  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        console.log(result);
        // ✅ Store token in both locations for consistency
        localStorage.setItem("jwt_token", result.data.token);
        localStorage.setItem("user_token", result.data.token);
        // ✅ Store user data separately
        if (result.data.user) {
            localStorage.setItem("user_data", JSON.stringify(result.data.user));
        }
        window.location.replace("index.html");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        if (typeof toastr !== 'undefined') {
            toastr.error(XMLHttpRequest?.responseText || 'Login failed');
        }
      },
    });
  },

  logout: function () {
    localStorage.clear();
    window.location.replace("login.html");
  },

  generateMenuItems: function(){
    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token).user;

    if (user && user.role){
      let nav = "";
      let main = "";
      switch(user.role) {
        case Constants.STUDENT_ROLE: // Updated to match your constants
          nav = '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#courses">Courses</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#reviews">My Reviews</a>'+
              '</li>'+
              '<li>'+
                  '<button class="btn btn-primary" onclick="AuthService.logout()">Logout</button>'+
              '</li>';
          $("#tabs").html(nav);

          main = '<section id="courses" data-load="courses.html"></section>'+
                 '<section id="reviews" data-load="reviews.html"></section>';
          $("#spapp").html(main);
          break;
          
        case Constants.INSTRUCTOR_ROLE:
          nav = '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#my-courses">My Courses</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#categories">Categories</a>'+
              '</li>'+
              '<li>'+
                  '<button class="btn btn-primary" onclick="AuthService.logout()">Logout</button>'+
              '</li>';
          $("#tabs").html(nav);

          main = '<section id="my-courses" data-load="instructor-courses.html"></section>'+
                 '<section id="categories" data-load="categories.html"></section>';
          $("#spapp").html(main);
          break;
          
        case Constants.ADMIN_ROLE:
          nav = '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#users">Users</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#courses">Courses</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#instructors">Instructors</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#categories">Categories</a>'+
              '</li>'+
              '<li class="nav-item mx-0 mx-lg-1">'+
                  '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#reviews">Reviews</a>'+
              '</li>'+
              '<li>'+
                  '<button class="btn btn-primary" onclick="AuthService.logout()">Logout</button>'+
              '</li>';
          $("#tabs").html(nav);

          main = '<section id="users" data-load="users.html"></section>'+
                 '<section id="courses" data-load="courses.html"></section>'+
                 '<section id="instructors" data-load="instructors.html"></section>'+
                 '<section id="categories" data-load="categories.html"></section>'+
                 '<section id="reviews" data-load="reviews.html"></section>';
          $("#spapp").html(main);
          break;
          
        default:
          window.location.replace("login.html");
      }
    } else {
        window.location.replace("login.html");
    }
  }
};