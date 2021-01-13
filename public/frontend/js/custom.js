$(document).ready(function() {
    var base_url = $('#base_url').val();
    $('.sub-submit').click(function() {
        var token = $(this).data('token');
        var email = document.getElementById("kk").value;
        $.ajax({
            url: base_url + '/email',
            type: 'post',
            data: '_token=' + token + '&email=' + email,
            dataType: 'json',
            success: function(result) {
                swal({
                    type: 'success',
                    title: result.status,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function (xhr) {
                swal({
                    type: 'error',
                    title: JSON.parse(xhr.responseText).error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
        document.getElementById("kk").value = '';
    });
});
$(document).ready(function() {
    var base_url = $('#base_url').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('a#add').click( function() {
        var product_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: base_url + '/ajaxadd',
            data: { product_id: product_id },
            success: function(result) {
                swal({
                    type: 'success',
                    title: result.status,
                    showConfirmButton: false,
                    timer: 2000
                });
                $( ".cart-count" ).load(window.location.href + " #step1Content" );
            },
            error: function (xhr) {
                swal({
                    type: 'error',
                    title: JSON.parse(xhr.responseText).error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
});
$(document).ready(function() {
    var base_url = $('#base_url').val();
    $('.clear_cart').on('click', function () {
        $.ajax({
            type: 'get',
            url: base_url + '/clear_cart',
            success: function(result) {
                swal({
                    type: 'success',
                    title: result.status,
                    showConfirmButton: false,
                    timer: 2000
                });
                $( ".car-col" ).load(window.location.href + " .carto" );
                $( ".price-title" ).load(window.location.href + " .price-title>span" );
                $( ".cart-count" ).load(window.location.href + " #step1Content" );
            },
            error: function (xhr) {
                swal({
                    type: 'error',
                    title: JSON.parse(xhr.responseText).error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
});
$(document).ready(function() {
    var base_url = $('#base_url').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.delete-btn').click( function() {
        var row_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: base_url + '/remove',
            data: { row_id: row_id },
            success: function(result) {
                swal({
                    type: 'success',
                    title: result.status,
                    showConfirmButton: false,
                    timer: 2000
                });
                $( ".item_" + row_id ).fadeOut();
                $( ".price-title" ).load(window.location.href + " .price-title>span" );
                $( ".cart-count" ).load(window.location.href + " #step1Content" );
            },
            error: function (xhr) {
                swal({
                    type: 'error',
                    title: JSON.parse(xhr.responseText).error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
});
$(document).ready(function() {
    var base_url = $('#base_url').val();
    $('.favourite_add').click(function() {
        var token = $(this).data('token');
        var id = $(this).attr('product');
        $.ajax({
            url: base_url + '/wishlist_add',
            type: 'post',
            data: '_token=' + token + '&productID=' + id,
            dataType: 'json',
            success:function(result) {
                swal({
                    type: 'success',
                    title: result.status,
                    showConfirmButton: false,
                    timer: 2000
                });
                var wishCount = document.getElementById('wishesCount').value;
                wishCount++;
                document.getElementById('wishesCount').value = wishCount;
            },
            error: function(xhr) {
                swal({
                    type: 'error',
                    title: JSON.parse(xhr.responseText).error,
                    showConfirmButton: false,
                    timer: 2000
                });
                var wishCount = document.getElementById('wishesCount').value;
                wishCount--;
                document.getElementById('wishesCount').value = wishCount;
            }

        });
        $( ".wish-count" ).load(window.location.href + " #step2Content" );
    });
    $('.favourite_add').click(function() {
        $(this).toggleClass('color55');
    });
});

$(document).ready(function cart(e) {
    var base_url = $('#base_url').val();
    $(".qty").change(function() {
        var id = $(this).attr('ad');
        var qty = $(this).val();
        $.ajax({
            url: base_url + '/update_cart',
            type: 'get',
            data: 'rowId=' + id + '&qty=' + qty ,
            dataType: 'json',
            success : function(data){
                $( ".price-title" ).load(window.location.href + " .price-title>span" );
                $( ".countoo" ).load(window.location.href + " .countoo>span" );
                $( ".pricoo" ).load(window.location.href + " .pricoo>span" );
                $( ".cart-count" ).load(window.location.href + " #step1Content" );
            },
        });
    });
});
