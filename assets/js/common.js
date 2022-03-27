/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var g_form = '',
        g_data = '',
        g_donot_ask = false;

var _MS_PER_DAY = 1000 * 60 * 60 * 24;

// a and b are javascript Date objects
function dateDiffInDays(a, b) {
    // Discard the time and time-zone information.
    var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
    var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

    return Math.floor((utc2 - utc1) / _MS_PER_DAY);
}

function openModalRemoteContent(url, title, close_btn_url, close_btn_modal_title) {
    var $modal = $('#ajax-modal');

    doGet(url, function (data) {
        if (data.indexOf('class="modal-content"') === -1) {
            var prep = '<div class="modal-dialog modal-lg" role="document">';
            prep += '<div class="modal-content">';

            if (title) {
                prep += '<div class="modal-header">';
                prep += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                prep += '<h4 class="modal-title">';
                prep += title;
                prep += '</h4>';
                prep += '</div>';
            }

            prep += '<div class="modal-body">';
            prep += data;
            prep += '</div>';

            if (close_btn_url) {
                prep += '<div class="modal-footer">';
                prep += '<button type="button" class="btn btn-default" onclick="openModalRemoteContent(\'' + close_btn_url + '\', \'' + close_btn_modal_title + '\')">Close</button>';
                prep += '</div>';
            }

            prep += '</div>';
            prep += '</div>';

            data = prep;
        }

        $modal.html(data).modal();
    });
}

function doGet(url, success_func, error_func) {
    var result = null;

    $.get(
            url,
            function (data) {
                result = data;
            }
    )
            .success(function () {
                if (typeof success_func === 'function') {
                    success_func.apply(this, [result]);
                }
            })
            .error(function () {
                if (typeof error_func === 'function') {
                    error_func.apply(this, [result]);
                }
            });
}

function simpleDoGet(url, field) {
    var result = null;

    $.get(
            url,
            function (data) {
                result = data;
            }
    )
            .success(function () {
                $("#" + field).val(result);
                return false;
            })
            .error(function () {
                alert("Something went wrong");
            });

    return false;
}

function validateCompField(check_fields) {
    var field_value = '',
            fields = check_fields.split(','),
            return_value = true,
            field_name = '',
            focus_field = '';

    for (var field in fields) {
        field_name = fields[field];

        if (field_name.indexOf(':') === -1) {
            field_value = document.getElementById(field_name).value;

            if (field_value === ''
                    || field_value === '0') {
                if (return_value) {
                    if (typeof changeTab === 'function') {
                        changeTab(field_name);
                    }
                }

                if (!document.getElementById(field_name).disabled
                        && focus_field === '') {
                    focus_field = field_name;
                }

                $('#' + field_name).addClass('input-error');
                $('#' + field_name).blur(function () {
                    if ($(this).val() !== ''
                            && $(this).val() !== '0') {
                        $(this).removeClass('input-error');
                    }
                });

                if (return_value) {
                    return_value = false;
                }
            } else {
                $('#' + field_name).removeClass('input-error');
            }
        }
    }

    if (focus_field !== '') {
        $('#' + focus_field).focus();
    }

    return return_value;
}

function isEmpty(value) {
    //Undefined or null
    if (typeof (value) === 'undefined'
            || value === null) {
        return true;
    }

    //Arrays && Strings
    if (typeof (value.length) !== 'undefined') {
        return value.length === 0;
    }

    //Numbers or boolean
    if (typeof (value) === 'number'
            || typeof (value) === 'boolean') {
        return false;
    }

    //Objects
    var count = 0;

    for (var i in value) {
        if (value.hasOwnProperty(i)) {
            count++;
        }
    }

    return count === 0;
}

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function goTo(id) {
    window.location = 'index.php?id=' + id;
}

function ajaxReload(url, container) {
    doGet(url, function (data) {
        $('#' + (container ? container : 'content')).html(data);
    });

    return false;
}

function updateCombo(url, type, id, value) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + 'type=' + type;
    url += '&filter=' + value;

    doGet(url, function (data) {
        $('#' + id).empty().append(data);

        setTimeout(function () {
            $('#' + id).focus();
        }, 250);
    });
}

function formatNumber(number, num_decimal) {
    var _return = new NumberFormat(number);
    _return.setPlaces((!isEmpty(num_decimal) ? num_decimal : 2));
    return _return.toFormatted();
}

function unformatNumber(number) {
    return (!isEmpty(number) ? number.replace(/,/g, '') : number)
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

/**
 *
 * @param elm $submitButton
 * @returns void
 */
function toggleSubmitDisabled($submitButton) {

    if ($submitButton.hasClass('disabled')) {
        $submitButton.attr('disabled', false)
                .removeClass('disabled')
                .val($submitButton.data('original-text'));
        return;
    }

    $submitButton.data('original-text', $submitButton.val())
            .attr('disabled', true)
            .addClass('disabled')
            .val('Working...');
}

/**
 * Replaces a parameter in a URL with a new parameter
 *
 * @param url
 * @param paramName
 * @param paramValue
 * @returns {*}
 */
function replaceUrlParam(url, paramName, paramValue) {
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }
    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
}

function myFloatParser(value) {
    if (!isEmpty(value) && !isNaN(value)) {
        return parseFloat(value);
    } else {
        return 0;
    }
}

function scrollToElement(element) {
    $('html, body').animate({
        scrollTop: ($('#' + element).offset().top - 50)
    },500);
}