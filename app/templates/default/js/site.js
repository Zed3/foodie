  $(document).ready(function() {
    $('#dishes-table').DataTable();
    $( "#navbar-search" ).autocomplete({
      source: "/json/search",
      minLength: 2
    });


    $('#example').dataTable( {
        "ajax": '/json/all_dishes/'
    } );

  });