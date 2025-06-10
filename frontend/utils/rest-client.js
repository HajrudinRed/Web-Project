let RestClient = {
   get: function (url, callback, error_callback) {
     $.ajax({
       url: Constants.PROJECT_BASE_URL + url,
       type: "GET",
       beforeSend: function (xhr) {
         // ✅ Fixed: Use "Authorization" instead of "Authentication"
         const token = localStorage.getItem("jwt_token") || localStorage.getItem("user_token");
         if (token) {
           xhr.setRequestHeader("Authorization", "Bearer " + token);
         }
       },
       success: function (response) {
         if (callback) callback(response);
       },
       error: function (jqXHR, textStatus, errorThrown) {
         if (error_callback) error_callback(jqXHR);
       },
     });
   },
   
   request: function (url, method, data, callback, error_callback) {
     $.ajax({
       url: Constants.PROJECT_BASE_URL + url,
       type: method,
       beforeSend: function (xhr) {
         // ✅ Fixed: Use "Authorization" and proper Bearer format
         const token = localStorage.getItem("jwt_token") || localStorage.getItem("user_token");
         if (token) {
           xhr.setRequestHeader("Authorization", "Bearer " + token);
         }
         // ✅ Added: Set content type for JSON data
         if (data && typeof data === 'object') {
           xhr.setRequestHeader("Content-Type", "application/json");
         }
       },
       data: typeof data === 'object' ? JSON.stringify(data) : data,
     })
       .done(function (response, status, jqXHR) {
         if (callback) callback(response);
       })
       .fail(function (jqXHR, textStatus, errorThrown) {
         if (error_callback) {
           error_callback(jqXHR);
         } else {
           if (typeof toastr !== 'undefined') {
             toastr.error(jqXHR.responseJSON?.message || 'An error occurred');
           }
         }
       });
   },
   
   post: function (url, data, callback, error_callback) {
     RestClient.request(url, "POST", data, callback, error_callback);
   },
   delete: function (url, data, callback, error_callback) {
     RestClient.request(url, "DELETE", data, callback, error_callback);
   },
   patch: function (url, data, callback, error_callback) {
     RestClient.request(url, "PATCH", data, callback, error_callback);
   },
   put: function (url, data, callback, error_callback) {
     RestClient.request(url, "PUT", data, callback, error_callback);
   },
};