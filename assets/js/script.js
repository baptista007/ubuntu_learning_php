var MAX_RECORD_COUNT = 20;

String.prototype.trimLeft = function (charlist) {
    if (charlist === undefined)
        charlist = "\s";

    return this.replace(new RegExp("^[" + charlist + "]+"), "");
};

String.prototype.trimRight = function (charlist) {
    if (charlist === undefined)
        charlist = "\s";

    return this.replace(new RegExp("[" + charlist + "]+$"), "");
};

function valToArray(val) {
    if (val) {
        if (Array.isArray(val)) {
            return val;
        } else {
            return val.split(",");
        }
    } else {
        return [];
    }
}
;

function debounce(fn, delay) {
    var timer = null;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            fn.apply(context, args);
        }, delay);
    };
}

function extend(obj, src) {
    for (var key in src) {
        if (src.hasOwnProperty(key))
            obj[key] = src[key];
    }
    return obj;
}

function setPathLink(path, queryObj) {
    var url;
    if (queryObj) {
        var str = [];
        for (var k in queryObj) {
            var v = queryObj[k]
            if (queryObj.hasOwnProperty(k) && v !== '') {
                str.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
            }
        }

        var qs = str.join("&");

        if (path.indexOf('?') > 0) {
            url = path + '&' + qs;
        } else {
            url = path + '?' + qs;
        }

    } else {
        url = siteAddr + path;
    }

    return url;
}

function randomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function hideFlashMsg() {
    var elem = $('#flashmsgholder');
    if (elem.length > 0) {
        var duration = elem.attr("data-show-duration");
        if (duration > 0) {
            window.setTimeout(function () {
                elem.fadeOut();
            }, duration)
        }
    }
}

function removeErf(id, id_field) {
    $('#erf-tr-' + id).remove();

    //Updating erf selection
    let ids = $('#' + id_field).val().split(",");
    ids = ids.filter(function (check_id) {
        return (parseInt(check_id) !== parseInt(id));
    });

    $('#' + id_field).val(ids.join(','));
}

$(window).on("load", function (e) {
    $(".se-pre-con").fadeOut("slow");
});

$(document).ajaxStart(function () {
    $(".se-pre-con").fadeIn("slow");
    ;
});

$(document).ajaxStop(function () {
    $(".se-pre-con").fadeOut("slow");
    ;
});

(function ($) {
    "use strict"; // Start of use strict

    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");

        if ($(".sidebar").hasClass("toggled")) {
            $('.sidebar .collapse').collapse('hide');
            $('.sm-screen-logo').show();
            $('.lg-screen-logo').hide();
        } else {
            $('.sm-screen-logo').hide();
            $('.lg-screen-logo').show();
        }
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
        ;

        // Toggle the side navigation when window is resized below 480px
        if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            $('.sidebar .collapse').collapse('hide');
        }
        ;
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    // Scroll to top button appear
    $(document).on('scroll', function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });
})(jQuery); // End of use strict

/**
 * Shows users a message.
 * Currently uses humane.js
 *
 * @param string message
 * @returns void
 */
function showMessage(message) {
    $('.flash-msg-container').html(message);

    setTimeout(function () {
        $('.flash-msg-container').html('');
    }, 4500);
}

function getSelectedErfTable(selected_elements, hidden_field) {
    let html = "";
    if (selected_elements.length > 0) {
        html = '<table class="table table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>Extension</th>' +
                '<th>ERF Number</th>' +
                '<th>ERF Size</th>' +
                '<th>Street Address</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="erf-selection-section">';

        selected_elements.each(function (i, erf) {
            html += '<tr id="erf-tr-' + $(erf).data('id') + '">';
            html += '<td>';
            html += $(erf).data('extension');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('no');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('size');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('street');
            html += '</td>';
            html += '<td>';
            html += '<button type="button" onclick="removeErf(' + $(erf).data('id') + ', \'' + hidden_field + '\')" class="btn btn-sm btn-danger">Remove</button>';
            html += '</td>';
            html += '</tr>';
        });

        html += '</tbody>' +
                '</table>';
    } else {
        html = "<div class='alert alert-warning'>Nothing selected</div>";
    }

    return html;
}

function getSelectedOwnersTableSms(selected_elements, hidden_field) {
    let html = "";
    if (selected_elements.length > 0) {
        html = '<table class="table table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>Extension</th>' +
                '<th>ERF Number</th>' +
                '<th>Street Address</th>' +
                '<th>Owner Name</th>' +
                '<th>Owner Contact</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="owner-selection-section">';

        selected_elements.each(function (i, erf) {
            html += '<tr id="erf-tr-' + $(erf).data('id') + '">';
            html += '<td>';
            html += $(erf).data('extension');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('no');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('street');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('name') + ' ' + $(erf).data('surname');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('numbers').replace(/,/g, "<br />");
            html += '</td>';
            html += '<td>';
            html += '<button type="button" onclick="removeErf(' + $(erf).data('id') + ', \'' + hidden_field + '\')" class="btn btn-sm btn-danger">Remove</button>';
            html += '</td>';
            html += '</tr>';
        });

        html += '</tbody>' +
                '</table>';
    } else {
        html = "<div class='alert alert-warning'>Nothing selected</div>";
    }

    return html;
}

function getSelectedOwnersTableEmail(selected_elements, hidden_field) {
    let html = "";
    if (selected_elements.length > 0) {
        html = '<table class="table table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>Extension</th>' +
                '<th>ERF Number</th>' +
                '<th>Street Address</th>' +
                '<th>Owner Name</th>' +
                '<th>Owner Contact</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="owner-selection-section">';

        selected_elements.each(function (i, erf) {
            html += '<tr id="erf-tr-' + $(erf).data('id') + '">';
            html += '<td>';
            html += $(erf).data('extension');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('no');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('street');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('name') + ' ' + $(erf).data('surname');
            html += '</td>';
            html += '<td>';
            html += $(erf).data('emails').replace(/,/g, "<br />");
            html += '</td>';
            html += '<td>';
            html += '<button type="button" onclick="removeErf(' + $(erf).data('id') + ', \'' + hidden_field + '\')" class="btn btn-sm btn-danger">Remove</button>';
            html += '</td>';
            html += '</tr>';
        });

        html += '</tbody>' +
                '</table>';
    } else {
        html = "<div class='alert alert-warning'>Nothing selected</div>";
    }

    return html;
}


$(document).ready(function () {
    hideFlashMsg();

    var pageLoadinStyle = $('#page-loading-indicator').html();

    $('body').on('click', '.toggle-check-all', function () {
        var p = $(this).closest('table').find('.optioncheck');
        p.prop("checked", $(this).prop("checked"));
    });

    $('.btn-delete-selected').click(function () {
        var recordDeleteMsg = $(this).data("prompt-msg");
        if (recordDeleteMsg == '') {
            recordDeleteMsg = "Are you sure you want to delete this record";
        }
        var sel_ids = $(this).closest('.page').find("input.optioncheck:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        if (sel_ids.length > 0) {
            if (confirm(recordDeleteMsg)) {
                var url = $(this).data('url');
                url = url.replace("{sel_ids}", sel_ids);
                window.location = url;
            }
        } else {
            alert('No Record Selected');
        }
    });

    $('.recordDeletePromptAction').click(function (e) {
        var recordDeleteMsg = $(this).attr("data-prompt-msg");
        if (isEmpty(recordDeleteMsg)) {
            recordDeleteMsg = "Are you sure you want to delete this record";
        }
        if (!confirm(recordDeleteMsg)) {
            e.preventDefault();
        }
    });

    $('.removeEditUploadFile').click(function (e) {
        if (confirm("Are you sure you want to delete this file?")) {
            // hidden input that contains all the file
            var holder = $(this).closest(".uploaded-file-holder");
            var inputid = $(this).attr("data-input");
            var inputControl = $(inputid);
            var filepath = $(this).attr('data-file');
            var filenum = $(this).attr('data-file-num');
            var srcTxt = inputControl.val();
            var arrSrc = srcTxt.split(",");
            arrSrc.forEach(function (src, index) {
                if (src == filepath) {
                    arrSrc.splice(index, 1);
                }
            });

            holder.find("#file-holder-" + filenum).remove();
            var ty = arrSrc.join(",");
            inputControl.val(ty);
        }
    });

    $('.open-page-modal').on('click', function (e) {
        e.preventDefault();

        var dataURL = $(this).attr('href');
        var modal = $(this).next('.modal');

        modal.modal({show: true});
        modal.find('.modal-body').html(pageLoadinStyle).load(dataURL);

    });

    $('a.page-modal').on('click', function (e) {
        e.preventDefault();

        var dataURL = $(this).attr('href');
        var modal = $('#main-page-modal');

        if (!isEmpty($(this).data('desc'))) {
            modal.find('.modal-title').text($(this).data('desc'));
        } else {
            modal.find('.modal-title').text('');
        }

        modal.modal({show: true});
        modal.find('.modal-body').html(pageLoadinStyle).load(dataURL);
    });

    $('.open-page-inline').on('click', function (e) {
        e.preventDefault();
        var dataURL = $(this).attr('href');

        var page = $(this).parent('.inline-page').find('.page-content');
        var loaded = page.attr('loaded');

        if (!loaded) {
            page.html(pageLoadinStyle).load(dataURL);
            page.attr('loaded', true)
        }
        page.toggleClass("d-none");
    });

    $('.export-btn').on('click', function (e) {
        var html = $(this).closest('.page').find('.page-records').html();
        var title = $(this).closest('.page').find('.record-title').html();
        $('#exportformdata').val(html);
        $('#exportformtitle').val(title);
        $('#exportform').submit();
    });

    $('form.multi-form').on('submit', function (e) {
        var isAllRowsValid = true;
        var form = $(this)[0];

        $(form).find('tr.input-row').each(function (e) {
            var validateRow = false;

            $(this).find('td').each(function (e) {
                var inp = $(this).find('input,select,textarea');

                if (inp.val() != '') {
                    validateRow = true;
                    return true;
                }
            });

            if (validateRow == true) {
                $(this).find('input,select,textarea').each(function (e) {
                    var elem = $(this)[0];
                    if (!elem.checkValidity()) {
                        isAllRowsValid = false;
                        return true;
                    }
                });
            }

        });

        if (isAllRowsValid == false) {
            e.preventDefault();
            form.reportValidity();
            e.preventDefault();
        }
    });

    $('[data-load-target]').on('change', function (e) {

        var val = $(this).val();
        var path = $(this).data('load-path');

        path = path + '/' + val;

        var targetName = $(this).data('load-target');

        var selectElem = "[name='" + targetName + "']";


        $(selectElem).html('<option value="">Loading...</option>');
        var placeholder = $(selectElem).attr('placeholder') || 'Select a value...';

        $.ajax({
            type: 'GET',
            url: path,
            dataType: 'json',
            success: function (data) {
                var options = '<option value="">' + placeholder + '</option>';
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].value + '">' + data[i].label + '</option>';
                }
                $(selectElem).html(options);
            },
            error: function (data) {

            },
        });

    });

//    $('.datepicker').flatpickr({
//        altInput: true,
//        allowInput: true,
//        onReady: function (dateObj, dateStr, instance) {
//            var $cal = $(instance.calendarContainer);
//            if ($cal.find('.flatpickr-clear').length < 1) {
//                $cal.append('<button class="btn btn-light my-2 flatpickr-clear">Clear</button>');
//                $cal.find('.flatpickr-clear').on('click', function () {
//                    instance.clear();
//                    instance.close();
//                });
//            }
//        }
//    });

    /*
     * --------------------
     * Ajaxify those forms
     * --------------------
     *
     * All forms with the 'ajax' class will automatically handle showing errors etc.
     *
     */
    $('form.ajax').ajaxForm({
        delegation: true,
        beforeSubmit: function (formData, jqForm, options) {
            $(jqForm[0])
                    .find('.error.help-block')
                    .remove();
            $(jqForm[0]).find('.has-error')
                    .removeClass('has-error');

            var $submitButton = $(jqForm[0]).find('input[type=submit]');
            toggleSubmitDisabled($submitButton);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $('.uploadProgress').show().html('Uploading Images - ' + percentComplete + '% Complete...    ');
        },
        error: function (data, statusText, xhr, $form) {
            // Form validation error.
            if (422 == data.status) {
                processFormErrors($form, $.parseJSON(data.responseText));
                return;
            }

            ('<div class="alert alert-dnager">Whoops!, it looks like something went wrong on our servers.\n\
         Please try again, or contact support if the problem persists.</div>');

            var $submitButton = $form.find('input[type=submit]');
            toggleSubmitDisabled($submitButton);

            $('.uploadProgress').hide();
        },
        success: function (data, statusText, xhr, $form) {
            if (data.success) {
                if ($form.hasClass('reset')) {
                    $form.resetForm();
                }

                if ($form.hasClass('closeModalAfter')) {
                    $('.modal, .modal-backdrop').fadeOut().remove();
                }

                var $submitButton = $form.find('input[type=submit]');
                //toggleSubmitDisabled($submitButton);

                if (typeof data.message !== 'undefined') {
                    if (!isEmpty($form.attr('data-feedback-div')) && $('#' + $form.attr('data-feedback-div')).length) {
                        $('#' + $form.attr('data-feedback-div')).html('<div class="alert alert-success">' + data.message + '</div>');
                    } else {
                        showMessage('<div class="alert alert-success">' + data.message + '</div>');
                    }
                }

                if (!isEmpty(data.runThis)) {
                    eval(data.runThis);
                }

                if (!isEmpty(data.redirectUrl)) {
                    setTimeout(function () {
                        window.location.href = data.redirectUrl;
                    }, 2000);
                }
            } else {
                if (!isEmpty($form.attr('data-feedback-div')) && $('#' + $form.attr('data-feedback-div')).length) {
                    $('#' + $form.attr('data-feedback-div')).html('<div class="alert alert-danger">' + data.message + '</div>');
                } else {
                    showMessage('<div class="alert alert-danger">' + data.message + '</div>');
                }

                var $submitButton = $form.find('input[type=submit]');
                toggleSubmitDisabled($submitButton);

                if (!isEmpty(data.fieldmessages)) {
                    processFormErrors($form, data.fieldmessages);
                }
            }

            $('.uploadProgress').hide();
            return false;
        },
        dataType: 'json'
    });

    $('table.datatable').each(function () {
        var buttons = [];
        if ($(this).hasClass('datatable-buttons')) {
            buttons = [
                {
                    extend: 'excel',
                    text: 'Export To Excel',
                    exportOptions: {
                        columns: 'th:not(.exclude)'
                    },
                    className: 'btn btn-sm btn-primary'
                },
                {
                    extend: 'pdf',
                    text: 'Export To Pdf',
                    exportOptions: {
                        columns: 'th:not(.exclude)'
                    },
                    className: 'btn btn-sm btn-primary ml-1'
                }
            ];
        }

        $(this).DataTable({
            fixedHeader: false,
            dom: 'Bfrtip',
            buttons: buttons,
            'pageLength': ($(this).data('max-record') ? $(this).data('max-record') : MAX_RECORD_COUNT),
            'searching': true
        });
    });

    $(document).on("blur", ".currency", function () {
        let value = unformatNumber($(this).val());
        value = formatNumber(value, 2);
        $(this).val(value);
    });
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


//$(window).bind('load', function () {
//    $('img').each(function () {
//        if ((typeof this.naturalWidth != "undefined" &&
//                this.naturalWidth == 0)
//                || this.readyState == 'uninitialized') {
//            $(this).attr('src', './assets/images/no-image-available.png');
//        }
//    });
//});


$(function () {
    $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});

$(function () {
    $(".switch-checkbox").bootstrapSwitch();
});

function fixBodyPadding() {
    var winHeight = $(window).height();
    var navTopHeight = $('#main-nav').outerHeight();
    document.body.style.paddingTop = navTopHeight + 'px';
}

$(function () {
    fixBodyPadding();
});

$(window).resize(fixBodyPadding);

function showTime() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
//    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if (h == 0) {
        h = 12;
    }

    if (h > 12) {
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
//    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + " " + session;
    document.getElementById("MyClockDisplay").innerText = date.toLocaleString();
    document.getElementById("MyClockDisplay").textContent = date.toLocaleString();

    setTimeout(showTime, 1000);
}