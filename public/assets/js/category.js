$(document).ready(function() {

    
    $("#add_category").click(function() {
        var formData = new FormData();
        formData.append('action', 'insert');
        

        formData.append('categ_name', $("#categ_name").val());
        

        

        $.ajax({
            url: 'Category/index',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#addModal').modal('hide');  // Hide the modal on success
                location.reload(); 
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

   



    $(document).on('click', '.button-delete', function() {
        $('#deleteModal').modal('show');
        
        var $tr = $(this).closest('tr');
        
        var categ_id = $tr.find("td:eq(0)").text();
       
       
       
        $('#delete_id').val(categ_id);
       
    });

    $(document).on('click', '#delete_category', function() {
        var formData = new FormData();
        formData.append('action', 'delete');
    
        
    
        formData.append('categ_id', $("#delete_id").val());

        // Log FormData
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }
       
        $.ajax({
            url: 'Category/index',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#deleteModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
