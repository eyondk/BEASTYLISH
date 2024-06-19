$(document).ready(function() {
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
});

