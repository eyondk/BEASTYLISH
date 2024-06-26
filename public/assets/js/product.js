$(document).ready(function() {

    $("#addImageBtn").click(function() {
        var moreImages = $("#moreImages");
        var input = $('<input>').attr({
            type: 'file',
            accept: 'image/png, image/jpeg, image/jpg',
            name: 'product_image[]',
            class: 'form-control form-control-lg fs-6 mt-3',
            required: true
        });
        moreImages.append(input);
    });

    $('#search-btn').click(function() {
        var searchTerm = $('#searchInput').val().toLowerCase();
    
        $('#productTable tbody tr').each(function() {
            var row = $(this);
            var allText = row.text().toLowerCase(); // Get all text from the row and convert to lower case
    
            if (allText.indexOf(searchTerm) !== -1) {
                row.show(); // Show row if it contains the search term
            } else {
                row.hide(); // Hide row if it does not contain the search term
            }
        });
    });

    $("#add_product").click(function() {
        var formData = new FormData();
        formData.append('action', 'insert');
        $("input[name='product_image[]']").each(function() {
            var files = $(this)[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append('product_image[]', files[i]);
            }
        });

        formData.append('product_name', $("#product_name").val());
        formData.append('product_price', parseFloat($("#product_price").val()));
        formData.append('product_stocks', $("#product_stocks").val());
        formData.append('product_sizes', $("#product_sizes").val());
        formData.append('product_colors', $("#product_colors").val());
        formData.append('product_category', $("#product_category").val());
        formData.append('product_description', $("#product_description").val());
        formData.append('product_discount', $("#product_discount").val());  

        // Log FormData
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }

        $.ajax({
            url: 'Products/index',
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
    
    $(document).on('click', '.button-update', function() {
        $('#updateModal').modal('show');
        
        var $tr = $(this).closest('tr');
        
        var prod_id = $tr.find("td:eq(1)").text();
        var prod_name = $tr.find("td:eq(2)").text();
        var prod_price = $tr.find("td:eq(3)").text().replace('₱ ', '').replace(',', '');
        var discount_percent = $tr.find("td:eq(4)").text().replace('%', '');
        var prod_description = $tr.find("td:eq(6)").text();
        var prod_stock = $tr.find("td:eq(7)").text();
        var prod_color = $tr.find("td:eq(8)").text();
        var prod_sizes = $tr.find("td:eq(9)").text();
        var categ_id = $tr.find("td:eq(10)").data('categ-id');
        var image_path = $tr.find("td:eq(0)").find('img').attr('src');
        console.log(categ_id);
       
        $('#old_image').attr('src', image_path);
        $('#update_id').val(prod_id);
        $('#update_name').val(prod_name);
        $('#update_price').val(prod_price);
        $('#update_discount').val(discount_percent);
        $('#update_description').val(prod_description);
        $('#update_stocks').val(prod_stock);
        $('#current_stocks').val(prod_stock);
        $('#update_color').val(prod_color);
        $('#update_sizes').val(prod_sizes);
        $('#update_discount').val(discount_percent);
       
        $('#update_category').val(categ_id);

// Log the selected value to verify
        toggleFieldsForUpdateCategory();

    });

    $(document).on('click', '#update_product', function() {
        var formData = new FormData();
        var newStock = $("#update_stocks").val();
        var currentStock = parseInt($("#current_stocks").val());

        
   
        if (parseInt(newStock) < currentStock) {
            alert('New stock quantity must be greater than the current stock quantity.');
            return;
        }
        formData.append('action', 'update');
    
        var updateImage = $('#update_image')[0].files;
        if (updateImage.length > 0) {
            for (var i = 0; i < updateImage.length; i++) {
                formData.append('product_image[]', updateImage[i]);
            }
        } else {
            var oldImages = $('#old_image').attr('src');
            formData.append('old_images', oldImages);
        }
    
        formData.append('product_id', $("#update_id").val());
        formData.append('product_name', $("#update_name").val());
        formData.append('product_price', parseFloat($("#update_price").val().replace(/[^\d.-]/g, '')));
        formData.append('product_stocks', $("#update_stocks").val());
        formData.append('product_sizes', $("#update_sizes").val());
        formData.append('product_colors', $("#update_colors").val());
        formData.append('product_category', $("#update_category").val());
        formData.append('product_description', $("#update_description").val());
        formData.append('product_discount', $("#update_discount").val()); 
        
        
        // Log FormData
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }

        $.ajax({
            url: 'Products/index',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#updateModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function toggleFieldsBasedOnCategory() {
        var selectedCategory = $('#product_category').val(); 
        if (selectedCategory == 5 || selectedCategory == 6 || selectedCategory == 7 || selectedCategory == 8 || selectedCategory == 9 || selectedCategory == 10 || selectedCategory == 11)  { 
            $('#product_sizes').prop('disabled', true).parent().hide();
            $('#product_colors').prop('disabled', true).parent().hide(); 
        } else {
            $('#product_sizes').prop('disabled', false).parent().show();
            $('#product_colors').prop('disabled', false).parent().show();
        }
    }
    // Function to toggle fields in the update modal
function toggleFieldsForUpdateCategory() {
   
    
    var selectedCategory = $('#update_category').val(); // Get the selected category ID in the modal
    if (selectedCategory == 5 || selectedCategory == 6 || selectedCategory == 7 || selectedCategory == 8 || selectedCategory == 9 || selectedCategory == 10 || selectedCategory == 11) { // Assuming 3 is the ID for accessories
        $(' #update_sizes').prop('disabled', true).parent().hide(); // Disable and hide the sizes field
        $(' #update_colors').prop('disabled', true).parent().hide(); // Disable and hide the colors field
    } else {
        $(' #update_sizes').prop('disabled', false).parent().show(); // Enable and show the sizes field
        $(' #update_colors').prop('disabled', false).parent().show(); // Enable and show the colors field
    }
}

    // Initial state setup for the update modal
    $('#updateModal').on('show.bs.modal', function (event) {
        toggleFieldsForUpdateCategory('#updateModal');
    });
    toggleFieldsBasedOnCategory();

    // Event listener for category change
    $('#product_category').change(function() {
        toggleFieldsBasedOnCategory();
    });
    $('#update_category').change(function() {
        toggleFieldsForUpdateCategory();
    });
    $(document).on('click', '.button-delete', function() {
        $('#deleteModal').modal('show');
        
        var $tr = $(this).closest('tr');
        
        var prod_id = $tr.find("td:eq(1)").text();
        var prod_stock = $tr.find("td:eq(5)").text();
       
        $('#prod_stocks').val(prod_stock);
        $('#delete_id').val(prod_id);
       
    });

    $(document).on('click', '#delete_product', function() {
        var formData = new FormData();
        formData.append('action', 'delete');
        var Stock = parseInt($("#prod_stocks").val());
        if (parseInt(Stock) > 0) {
            alert('You cannot delete product when theres still stocks left');
            return;
        }
        
        formData.append('product_id', $("#delete_id").val());
       
        $.ajax({
            url: 'Products/index',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#updateModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
