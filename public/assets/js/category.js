$(document).ready(function() {
    // Insert category
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

    // Show delete confirmation and handle product check
    $(document).on('click', '.button-delete', function() {
        $('#deleteModal').modal('show');
        
        var $tr = $(this).closest('tr');
        var categ_id = $tr.find("td:eq(0)").text();
        $('#delete_id').val(categ_id);
        
        alert(categ_id);
        $.ajax({
            url: 'Category/index',
            method: 'POST',
            data: { categ_id: categ_id, action: 'checkForProducts' },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.hasProducts) {
                    alert('This category cannot be deleted because there are associated products.');
                    $('#delete_id').val('');
                    return
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to check for associated products. Please try again.');
            }
        });
    });

    // Delete category
    $(document).on('click', '#delete_category', function() {
        var formData = new FormData();
        formData.append('action', 'delete');
        formData.append('categ_id', $("#delete_id").val());

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
