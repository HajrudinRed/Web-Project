$(document).ready(function() {

 

  var app = $.spapp({pageNotFound : 'error_404'}); // initialize

  // define routes
  
  app.route({view: 'about', load: 'about.html' });
  app.route({view: 'contact', load: 'contact.html' });
  app.route({view: '404', load: '404.html' });
  app.route({view: 'courses', load: 'courses.html' });
  app.route({view: 'team', load: 'team.html' });
  app.route({view: 'testimonial', load: 'testimonial.html' });
  // run app
  app.run();

});
// Check for JWT token in localStorage
function getUserFromToken() {
    const token = localStorage.getItem('jwt_token');
    if (!token) return null;
    try {
        // Decode JWT payload
        const payload = JSON.parse(atob(token.split('.')[1]));
        return payload.user || payload; // adjust if your payload structure is different
    } catch (e) {
        return null;
    }
}

function updateNavbarForUser() {
    const user = getUserFromToken();
    let html = '';
    if (user) {
        html += `<a href="#dashboard" class="nav-item nav-link">Dashboard</a>`;
        if (user.role === 'admin') {
            html += `<a href="#admin" class="nav-item nav-link">Admin Panel</a>`;
        }
        html += `<a href="#" class="nav-item nav-link" id="logout-link">Logout (${user.name})</a>`;
    } else {
        html += `<a href="../login/login.html" class="nav-item nav-link">Login</a>`;
    }
    $('#navbar-user-links').html(html);
}

// Handle logout
$(document).on('click', '#logout-link', function(e) {
    e.preventDefault();
    localStorage.removeItem('jwt_token');
    updateNavbarForUser();
    window.location.hash = "#home";
});

// Run on page load
$(function() {
    updateNavbarForUser();
});