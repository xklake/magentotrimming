/**
 * @copyright    Copyright (C) 2015 KtmVelo. All Rights Reserved.
 */
$ktm(function ($) {
    themeResize();
    $(window).resize(function () {
       themeResize();
    });
    $(document).on('click', '.ktm-maincart a', function(event) {
        var checkUrl = ($(this).attr('href').indexOf('checkout/cart/delete') > -1);
        if (checkUrl && $(this).attr('class') != 'deletecart' && $(this).attr('class').indexOf('btn-remove2') == -1) {
            deletecart($(this).attr('href'));
            return false;
        }
    });
    $(document).on('click', '.success button.close', function(event) {
        event.preventDefault();
        $(this).parent().fadeOut('slow', function () {
            $(this).remove();
        });
    });
    $(document).on('click', '.options-cart', function(event) {
        event.preventDefault();
        $.colorbox({
            iframe: true,
            href: this.href,
            opacity: 0.8,
            speed: 300,
            current: '{current} / {total}',
            close: '<i class="fa fa-times-circle-o"></i>',
            width: '100%',
            height: '100%',
            maxWidth: '930px',
            maxHeight: '95%',
            onOpen: function () {
                $('#cboxLoadingGraphic').addClass('box-loading');
            },
            onComplete: function () {
                setTimeout(function () {
                    $('#cboxLoadingGraphic').removeClass('box-loading');
                }, 3000);
            }
        });
    });
    $(document).on('click', '.show-options', function(event) {
        event.preventDefault();
        if ($('.btn-cart-mobile').length == 0) {
            $(this).next().trigger('click');
        } else {
            return window.location.href = $(this).attr('data-submit');
        }
    });

    if ($('.product-view').length > 0 && $('.option-file').length == 0 && $('.btn-cart-mobile').length == 0) {
        productAddToCartForm.submit = function (button, url) {
            if (this.validator.validate()) {
                var form = this.form;
                var oldUrl = form.action;
                if (url) {
                    form.action = url;
                }
                var e = null;
                if (!url) {
                    url = $('#product_addtocart_form').attr('action');
                }
                var checkWishlistUrl = (url.indexOf('wishlist/index/cart') > -1);

                url = url.replace("checkout/cart", "ajaxcart/index");

                var data = $('#product_addtocart_form').serialize();
                data += '&isAjax=1';
                try {
                    if (checkWishlistUrl) {
                        this.form.submit();
                    } else {
                        if ($('#qty').val() == 0) {
                            if ($('.error_qty').length == 0) {
                                $('<span/>').html('The quantity not zero!')
                                    .addClass('error_qty')
                                    .appendTo($('.add-to-cart'));
                            }
                        } else {
                            $('.error_qty').remove();
                            $("span.textrepuired").html('');
                            if (!$('.ajaxcart-index-options').length > 0) {
                                showCartBox(datatext.load, true);
                            }
                            $.ajax({
                                url: url,
                                dataType: 'json',
                                type: 'post',
                                data: data,
                                success: function (data) {
                                    parent.setAjaxData(data, true);
                                    $.colorbox.close();
                                    if (button && button != 'undefined') {
                                        button.disabled = false;
                                    }
                                }
                            });
                        }
                    }
                } catch (e) {
                }
                this.form.action = oldUrl;
                if (e) {
                    throw e;
                }

            }
            return false;
        }.bind(productAddToCartForm);
    }
});
function themeResize() {
    var width = $ktm(window).width();
    if (width <= 767) {
        $ktm('body').find('.btn-cart').addClass('btn-cart-mobile');
        if ($ktm('.product-quick-view').length > 0) {
            $ktm('body').find('.btn-cart').removeClass('btn-cart-mobile');
        }
    } else {
        $ktm('body').find('.btn-cart').removeClass('btn-cart-mobile');
    }
}
function setAjaxData(data, iframe) {
    if (data.status == 'ERROR') {
        showCartBox(data.message);
    } else {
        $ktm('.ktm-maincart').html('');
        if ($ktm('.ktm-maincart')) {
            $ktm('.ktm-maincart').append(data.output);
        }
        if ($ktm('.header .links')) {
            $ktm('.header .links').replaceWith(data.toplink);
        }
        $ktm.colorbox.close();
        showCartBox(data.message, false);
    }
}
function showCartBox(message, wait) {
    $ktm('#notification').html('<div class="success" style="display: none;">' + message +
    '<button class="close"><i class="fa fa-times"></i></button></div>');
    if (wait) {
        $ktm('.success').addClass('wait-loading');
        $ktm('.success .fa-check').hide();
        $ktm('.success .close').hide();
    } else {
        $ktm('.success').removeClass('wait-loading');
        $ktm('.success .fa-check').show();
        $ktm('.success .close').show();
    }
    $ktm('.success').fadeIn('slow');
    if (!wait) {
        setTimeout(function () {
            $ktm('.success').delay(500).fadeOut(1000);
        }, 5000);
    }
}
function setLocation(url) {
    var checkUrl = (url.indexOf('checkout/cart') > -1);
    var pass = true;
    if ($ktm('body').find('.btn-cart-mobile').length > 0) {
        pass = false;
    }
    if (checkUrl && pass) {
        var data = '&isAjax=1&qty=1';
        url = url.replace("checkout/cart", "ajaxcart/index");
        showCartBox(datatext.load, true);
        try {
            $ktm.ajax({
                url: url,
                dataType: 'json',
                data: data,
                type: 'post',
                success: function (data) {
                    setAjaxData(data);
                }
            });
        } catch (e) {
        }
        return false;
    }
    return window.location.href = url;
}
function deletecart(url) {
    var checkUrl = (url.indexOf('checkout/cart') > -1);
    if (checkUrl) {
        if (confirm("Are you sure you would like to remove this item from the shopping cart?")) {
            var data = '&isAjax=1&qty=1';
            var url = url.replace("checkout/cart", "ajaxcart/index");
            showCartBox(datatext.load, true);
            $ktm.ajax({
                url: url,
                dataType: 'json',
                data: data,
                type: 'post',
                success: function (data) {
                    setAjaxData(data, false);
                }
            });
        }
    }
    return false;
}