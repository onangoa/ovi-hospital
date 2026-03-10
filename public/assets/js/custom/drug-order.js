function calculateTotals() {
    var totalQuantity = 0;
    var totalAmount = 0;
    
    $('#items_table tbody tr').each(function() {
        var quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
        var amount = parseFloat($(this).find('.item-amount').val()) || 0;
        totalQuantity += quantity;
        // Calculate total amount as sum of (quantity * amount) for each drug
        totalAmount += quantity * amount;
    });
    
    $('#total_quantity').val(totalQuantity.toFixed(2));
    $('#total_amount').val(totalAmount.toFixed(2));
}

function getNextIndex() {
    var maxIndex = -1;
    $('#items_table tbody tr').each(function() {
        var input = $(this).find('input[name^="items"]').first();
        if (input.length > 0) {
            var name = input.attr('name');
            var match = name.match(/items\[(\d+)\]/);
            if (match) {
                var index = parseInt(match[1]);
                if (index > maxIndex) {
                    maxIndex = index;
                }
            }
        }
    });
    return maxIndex + 1;
}

function addNewRow() {
    var newIndex = getNextIndex();
    var newRowHtml = '<tr>' +
        '<td><input type="text" name="items[' + newIndex + '][name]" class="form-control" required /></td>' +
        '<td><input type="text" name="items[' + newIndex + '][dosage]" class="form-control" /></td>' +
        '<td><input type="number" name="items[' + newIndex + '][quantity]" class="form-control item-quantity" min="1" step="0.01" required /></td>' +
        '<td><input type="number" name="items[' + newIndex + '][amount]" class="form-control item-amount" min="0" step="0.01" required /></td>' +
        '<td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="fa fa-minus"></i></button></td>' +
        '</tr>';
    
    $('#items_table tbody').append(newRowHtml);
    
    // Focus on the first input of the new row
    $('#items_table tbody tr:last-child input:first').focus();
    
    // Recalculate totals
    calculateTotals();
}

function removeRow(button) {
    var rowCount = $('#items_table tbody tr').length;
    if (rowCount > 1) {
        $(button).closest('tr').remove();
        calculateTotals();
    } else {
        alert('At least one item is required.');
    }
}

// Initialize drug order functionality
$(document).ready(function() {
    // Add row button click
    $("#add_row").click(function(e) {
        e.preventDefault();
        addNewRow();
    });

    // Remove row button click (using event delegation)
    $(document).on('click', '.remove-tr', function(e) {
        e.preventDefault();
        removeRow(this);
    });

    // Input change events (using event delegation for dynamic rows)
    $(document).on('input change', '.item-quantity, .item-amount', function() {
        calculateTotals();
    });

    // Prevent form submission on Enter key in input fields
    $(document).on('keypress', 'input', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            var inputs = $('input:visible');
            var nextIndex = inputs.index(this) + 1;
            if (nextIndex < inputs.length) {
                inputs.eq(nextIndex).focus();
            }
        }
    });

    // Initial calculation
    calculateTotals();
});
