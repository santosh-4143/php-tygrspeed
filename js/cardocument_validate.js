$(document).ready(function() {
   $("#form").validate({
       rules: {
           driver: "required",
           car:  "required"
         },
         messages: {
           driver: "Please select an option",
           car: "Please select an option"
         },
          submitHandler: function(form) {
           form.submit();
       }
     });
 });