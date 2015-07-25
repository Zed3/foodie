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

  function manage_favorite(rest_id, dish_id) {
    $.ajax({
        url: "/favorite/" + rest_id + "/" + dish_id,
        complete: function(data) {
            // $("#div_loading_area").addClass("add_new_form_loading_hide");
            // $("#url_youtube").val('');
            // $("#search_results").html('');
            console.log(data);
            // var result = data.responseJSON;
            // if (result.error) {
            //     Message.addAlert(result.error, "error");
            // }

            // if (result.result == false) {
            //     Message.addAlert("Could not add song", "warning");
            // } else if (result.result == true) {
            //     Message.addAlert("Added song", "success");
            // }

        },
        timeout: 60000
    });
}