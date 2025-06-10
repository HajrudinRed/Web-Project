let Utils = {
   datatable: function (table_id, columns, data, pageLength=15) {
       try {
           if ($.fn.dataTable.isDataTable("#" + table_id)) {
             $("#" + table_id)
               .DataTable()
               .destroy();
           }
           $("#" + table_id).DataTable({
             data: data,
             columns: columns,
             pageLength: pageLength,
             lengthMenu: [2, 5, 10, 15, 25, 50, 100, "All"],
             responsive: true,
             language: {
                 emptyTable: "No data available",
                 loadingRecords: "Loading...",
                 processing: "Processing..."
             }
           });
       } catch (error) {
           console.error('DataTable initialization error:', error);
       }
   },
   
   parseJwt: function(token) {
       if (!token) return null;
       try {
         const payload = token.split('.')[1];
         const decoded = atob(payload);
         return JSON.parse(decoded);
       } catch (e) {
         console.error("Invalid JWT token", e);
         return null;
       }
   },
   
   // ✅ Added: Helper function to get current user
   getCurrentUser: function() {
       const token = localStorage.getItem("jwt_token") || localStorage.getItem("user_token");
       if (token) {
           const parsed = this.parseJwt(token);
           return parsed?.user || null;
       }
       return null;
   },
   
   // ✅ Added: Helper function to check if user is authenticated
   isAuthenticated: function() {
       const token = localStorage.getItem("jwt_token") || localStorage.getItem("user_token");
       return token && token !== "undefined";
   },
   
   // ✅ Added: Helper function to format dates
   formatDate: function(dateString) {
       if (!dateString) return 'N/A';
       try {
           return new Date(dateString).toLocaleDateString();
       } catch (e) {
           return 'Invalid Date';
       }
   }
};
