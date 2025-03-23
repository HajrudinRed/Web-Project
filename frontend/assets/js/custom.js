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