
$(document).ready(function(){
    cartQtyTotal();
});
// for handling common error 

function commonRequest(url, method, data, successCallBack, errorCallBack) {
    $('.web-loader').show();
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function (response) {
            $('.web-loader').hide();
            if (typeof successCallBack === 'function') {
                successCallBack(response);
            }
        },
        error: function (xhr, status, error) {
            $('.web-loader').hide();
            var response = JSON.parse(xhr.responseText);
            $('.toast-body').text(response.message);
            $('.toast').toast('show');
            $('.error').show();
        }
    });
}

function successMessage(message) {
    $('.toast-body').text(message);
    $('.toast').toast('show');
    $('.error').hide();
    $('.success').show();
}

// cart


function cartQtyTotal(){
    commonRequest('get-qty-total', 'get', '', function (response) {
        $('.cart-item').text(response);
    });
}

function loadCart() {
    commonRequest('get-cart', 'get', '', function (response) {
        $('#cart-content').html(response);
    });
}

$("#open-cart-modal").click(function ()
{
    $("#cartModal").modal('show');
    loadCart();
});





function addCart(proId)
{
    commonRequest('add-cart?id='+proId, 'get', '', function (response) {
        $('.cart-item').text(response.data.totalQty);
        successMessage(response.message);
    });
}

function removeItem(id){
    commonRequest('delete-cart-item?id='+id, 'get', '', function (response) {
        loadCart();
        $('.cart-item').text(response.data.totalQty);
        successMessage(response.message);
    });
}

function updateItem(id,qty){
    commonRequest('update-cart-item?id='+id+'&qty='+qty, 'get', '', function (response) {
        loadCart();
        $('.cart-item').text(response.data.totalQty);
        successMessage(response.message);
    });
}
