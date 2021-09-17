var dropdownAjax = function (targetObj, send_data, url) {
    targetObj.html("<option value='' >Loading...</option>");
    targetObj.select2("val", "");
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: send_data,
        beforeSend: function (e) {
            targetObj.prop("disabled", true);
        }
    }).done(function (response) {
        console.log("success");
        if (response) {
            if (response.length > 0) {
                targetObj.html("<option value='' >Pilih</option>");
                for (i = 0; i < response.length; i++) {
                    var option = "<option value='" + response[i]['id'] + "' ";
                    option += " >" + response[i]['nama'] + "</option>";
                    targetObj.append(option);
                }
                targetObj.prop("disabled", false);
            } else {
                targetObj.html("<option value='' >Tidak ada data</option>");
            }
            targetObj.select2("val", "");
        }
    }).fail(function (response) {
        console.log('error');
        // main.alertMessage('Oops!', response.message, 'warning');
    }).always(function () {
        // console.log("complete");
    });
}

var submitAjax = function (formObj, options = {}) {
    var btnObj = formObj.find('button[type=submit]');

    if (formObj.attr('enctype') == "multipart/form-data") {
        var formData = new FormData(formObj[0]);
        options['cache'] = false;
        options['contentType'] = false;
        options['processData'] = false;
    } else {
        var formData = formObj.serialize();
    }
    // console.log(formData);

    $("span.error", formObj).remove();
    $(".form-control", formObj).removeClass('error');
    // default settings
    options = $.extend(true, {
        url: formObj.attr('action'),
        dataType: "json",
        data: formData,
        type: formObj.attr('method'),

        beforeSend: function (e) {
            $.blockUI({
                message:
                    '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Sedang proses...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                },
                overlayCSS: { opacity: 0.2 }
            });
        },
        error: function (e) {
            $.unblockUI()
            if (e.status == 400) {
                form_set_errors(e.responseJSON.errors, formObj);
                if (e.responseJSON.message) {
                    Swal.fire('', e.responseJSON.message, 'error');
                }
            } else {
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Silahkan ulangi kembali',
                    icon: 'error',
                    timer: 1000,
                    showConfirmButton: false,
                });
            }
        },
        success: function (response) {
            $.unblockUI()
            // console.log(response);
            if (response.success) {
                if (options.f_response) {
                    if (typeof options.f_response === "function") {
                        options.f_response(response);
                    }
                } else {
                    form_success(response);
                }
            } else {
                Swal.fire('', rensponse.message, 'error');
            }
        },
        complete: function (e) {
            btnObj.button('reset');
        }
    }, options);

    $.ajax(
        options
    );
}

function form_success(response) {
    if (response.message) {
        var swal_message = response.message;
    } else {
        var swal_message = "Data berhasil disimpan";
    }

    Swal.fire({
        title: '',
        text: swal_message,
        icon: 'success',
        timer: 1000,
        showConfirmButton: false,
    }).then(function () {
        if (response.redirect) {
            window.location.replace(response.redirect);
        }
    });
}

function form_set_errors(data_error, formObj) {
    // console.log(data_error);
    $.each(data_error, function (k, v) {
        var element = $("[name='" + k + "']", formObj);
        // console.log(element);
        var error = $("<span/>")   // creates a div element
            .addClass("error")   // add a class
            .html(v);

        element.closest('.form-control').addClass('error');


        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {
            error.insertAfter(element.next('span'));  // select2
        } else {
            error.insertAfter(element);               // default
        }
    });
}

$('body').on('click', '.table-delete', function () {
    Swal.fire({
        title: 'Apa Anda sudah yakin?',
        text: "Data yang Anda hapus tidak dapat dikembalikan",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: $(this).data("url"),
                data: { "_token": $(this).data('token') },
                success: function (data) {
                    table.draw();
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Data berhasil dihapus',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                },
                error: function (e) {
                    if (e.responseJSON.message) {
                        var swal_message = e.responseJSON.message;
                    } else {
                        var swal_message = "Data gagal dihapus";
                    }
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: swal_message,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        }
    })
});

// submit filter datatable
$('.submit-filter').on('click', function (e) {
    if ($(this).val() == 'reset') {
        $('.filter-table').find('input, select, textarea').val('');
        $('.filter-table').find('.select2').select2('val', '');
    }
    var target = $(this).data('target');
    $('#' + target).DataTable().draw();
});

$('.form_ajax').submit(function (e) {
    e.preventDefault();
    submitAjax($(this));
});

/**
 * btn untuk create
 */
$('.btn-link').on('click', function (e) {
    window.location.href = $(this).data('route');
});
