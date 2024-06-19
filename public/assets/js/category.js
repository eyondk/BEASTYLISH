$(document).ready(function() {
    // Insert category
    $("#add_category").click(function(event) {
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
                alert('Failed to add category. Please try again.');
            }
        });
    });

    // Show delete confirmation and handle product check
    $(document).on('click', '.button-delete', function(event) {
        var $tr = $(this).closest('tr');
        var categ_id = $tr.find("td:eq(0)").text();
        $('#delete_id').val(categ_id);
        
        $.ajax({
            url: 'Category/index',
            method: 'POST',
            data: { categ_id: categ_id, action: 'checkForProducts' },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.hasProducts) {
                    alert('This category cannot be deleted because there are associated products.');
                    $('#delete_id').val('');
                } else {
                    $('#deleteModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to check for associated products. Please try again.');
            }
        });
    });

    // Delete category
    $(document).on('click', '#delete_category', function(event) {
        var categ_id = $("#delete_id").val();
        if (!categ_id) {
            alert('No category selected for deletion.');
            return;
        }

        var formData = new FormData();
        formData.append('action', 'delete');
        formData.append('categ_id', categ_id);

        $.ajax({
            url: 'Category/index',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#deleteModal').modal('hide');
                location.reload(); // Ensure this is commented out if you do not want the page to reload
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to delete category. Please try again.');
            }
        });
    });
});
