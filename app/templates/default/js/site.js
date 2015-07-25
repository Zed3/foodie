  $(document).ready(function() {
    $('#dishes-table').DataTable();
    $( "#navbar-search" ).autocomplete({
      source: "/json/search",
      minLength: 2
    });

    $('#rest-dishes').DataTable({
    	"bPaginate": false
    });
  });