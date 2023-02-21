$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error : function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == 401) {
            Swal.fire({
                text: "Login Expired",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Logout!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            })
            .then(function () {
                $('#form_logout').submit();
            });
        }
        else if (jqXHR.status == 403) {
            location.href = '/403';
        }
        else if (jqXHR.status == 404) {
            location.href = '/404';
        }
        else if (jqXHR.status == 500) {
            // location.href = '/500';
        }
    }
});

const sendData = function(url, method = "GET", data = {}) {
    return $.ajax({
        url : url,
        type: method,
        data : data
    });
}

const formDelete = function (
    link, 
    name,
    forcedelete = false,
    yesBtn = "Yes, delete!", 
    noBtn = "No, cancel",
)
{
    return new Promise((resolve, reject) => {
        let settingDelete = {
            text: "Are you sure you want to delete " + name + "?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: yesBtn,
            cancelButtonText: noBtn,
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        };
        
        if(forcedelete){
            settingDelete.input = 'checkbox';
            settingDelete.inputValue = 0;
            settingDelete.inputPlaceholder = "Check For Force Delete";
        }

        Swal.fire(settingDelete)
            .then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        text: "You have deleted " + name + "!.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    })
                    .then(function () {
                        
                    });
                    if(forcedelete) link += '?force-delete='+result.value;
                    $('#form-delete').attr('action', link)
                    $('#form-delete').submit();
                        
                } 
                else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: name + " was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            })
    })
}

const formSubmit = function(url, method = 'POST', data) {
    return new Promise((resolve, reject) => {
        let successStatus = method == 'POST' ? "submitted" : 'updated';
        Object.keys(data).forEach(key => data[key] === undefined && delete data[key]);
        sendData(url, method, data)
            .done((data) => {
                Swal.fire({
                    text: `Form has been successfully ${successStatus}!`,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
                .then(function (result) {
                    resolve(data)
                });
            })
            .fail( xhr => {

                if(xhr.status == 422) 
                {
                    let errors = xhr.responseJSON.errors; //obj
                    Object.keys(errors).forEach( function(key) {
                        errors[key].forEach(err => {
                            $(`#error_${key}`).html(err);
                        })
                    })
                }
                else
                {
                    let err = xhr.responseJSON;
                    Swal.fire({
                        text: err.msg,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
                
                reject(xhr);
            });
    })
}

const generateAutoFill = function(formId = '', data = {}) {
    return new Promise((resolve, reject) => {
        $('#'+formId).trigger("reset");
        Object.keys(data).forEach( function(key) {
            let inputEl = $(`#${formId}`).find(`[name="${key}"]`);
            if(inputEl){
                let val = data[key] ?? "";
                //handle checkbox
                if(inputEl.attr('type') == 'checkbox')
                {
                    //handle multiple checkbox like permission in role
                    if(inputEl.hasClass('form-check-input-multiple') && Array.isArray(val)){
                        val.forEach(element => {
                            $(`#${formId}`).find(`[id="${element.name}"]`).prop('checked',1)
                        })
                    }
                    else {
                        inputEl.prop('checked', val == 1)
                    }
                }
                //handle number parse to float
                else if(inputEl.attr('type') == 'number')
                {
                    inputEl.val(`${parseFloat(val) ?? 0}`);
                }
                //handle select 2
                else if(inputEl.hasClass('custom-select2'))
                {
                    inputEl.val(val.split(","))
                    inputEl.trigger('change');
                }
                else
                {
                    inputEl.val(val);
                }
                
            }
        })
        resolve(data);
    })
}

const initModalInput = function(url, method, onLoad = null) {
    return new Promise((resolve, reject) => {
        const element = document.getElementById(`modal_input`);
        const form = element.querySelector(`#modal_input_form`);
        const modal = new bootstrap.Modal(element);  
    
        // Close button handler
        const closeButton = element.querySelector('[data-comp-modal-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();
            form.reset(); // Reset form	
            modal.hide(); // Hide modal
            $('.invalid-feedback').html(""); //set null error
        });
    
        // Cancel button handler
        const cancelButton = element.querySelector('[data-comp-modal-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();
            form.reset(); // Reset form	
            modal.hide(); // Hide modal
            $('.invalid-feedback').html(""); //set null error
        });

        $('#btn-add').on('click', function(e){
  
            $("#modal_input_form").find('[data-comp-modal-action="submit"]').removeAttr('data-kt-indicator');
            $("#modal_input_form").find('[data-comp-modal-action="submit"]').prop('disabled', false);
            
            if(typeof onLoad === 'function'){
                onLoad()
            }
    
            const notice = element.querySelector('.notice');
            if(notice !== null){
                notice.classList.add('d-none');
            }
    
            //reset form
            form.reset();
            $('.custom-select2').val("").trigger('change');
    
            //change title status
            element.querySelector("#title_status").innerHTML = "Create";

            // set form
            form.action = url
            form.method = method
    
            $('#modal_input').modal('show');
        })

        resolve('oke')
    })
}

const initModalSubmit = function(anotherData = {}, onLoad = null, onSuccess = null, onError = null) {
    $('#modal_input_form').on("submit", function(e) {
        e.preventDefault();
        $('.invalid-feedback').html(""); //set null error
        $(this).find('[data-comp-modal-action="submit"]').attr('data-kt-indicator', 'on');
        $(this).find('[data-comp-modal-action="submit"]').prop('disabled', true);

        let data = $(this).serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});

        if(typeof onLoad === 'function'){
            onLoad(data)
        }

        var formAction = $(this).attr("action");
        var formMethod = $(this).attr("method");
        
        data = Object.assign(data, dataImageBase64, anotherData)

        // select multiple
        $(this).find('[multiple]').each(function() {
            let name = $(this).attr('name')
            let val  = $(this).val()
            data[name] = val
        })

        formSubmit(formAction, formMethod, data)
            .then(res => {
                if(typeof onSuccess === 'function'){
                    onSuccess(data)
                }
                $("#modal_input").modal("hide");
            })
            .catch(xhr => {
                $(this).find('[data-comp-modal-action="submit"]').removeAttr('data-kt-indicator');
                $(this).find('[data-comp-modal-action="submit"]').prop('disabled', false);

                if(typeof onError === 'function'){
                    onError(xhr)
                }
            })
    })
}

const customDataTable = function (id, opt = {}) {
    let dtId = '#'+id;
    var datatable = $(dtId).DataTable(opt);
    
    $(dtId).on( 'click', '.table-delete', function () {
        let link = $(this).data('link');
        let name = $(this).data('name');
        formDelete(link, name, false)
            .then((data) => {
                location.reload();
            });
    });

    return datatable;
}

// wrap(data, 90).join("<br/>");
function wrap(s, w) {
    let arr = [];
    while (s.length > 0) {
        arr.push(s.substring(0, w));
        s = s.substring(w);
    }
    return arr
};

function thousendSeperator(data, decimal = 2) {
    if(data){
        let res = (Math.round(data * 100) / 100).toFixed(decimal);
        return res.toString(decimal).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    return 0;
}

function setSelectData(id, placeholder = null, data = {}, url = null, urlMethod = 'GET'){
    $('#'+id).html("");
    if(placeholder)
    {
        $('#'+id).append(`
            <option value="">${placeholder}</option>
        `);
    }

    if(Object.keys(data).length > 0) 
    {
        Object.keys(data).forEach(key => {
            $('#'+id).append(`
                <option value="${key}">${data[key]}</option>
            `);
        })
    }
    else
    {
        sendData(url, urlMethod)
            .done(res => {
                let data = res.data;
                Object.keys(data).forEach( function(key) {
                    $('#'+id).append(`
                        <option value="${key}">${data[key]}</option>
                    `);
                })
            })
    }

}

let dataImageBase64 = {};
function getBase64Image(file)
{
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error)
    });
}

$('#modal_input').find('#modal_input_form').find('input[type=file]').on('change', function(){
    let name = $(this).attr('name');
    let filePath = $(this).prop('files')[0];
    if(typeof filePath !== 'undefined'){
        getBase64Image(filePath).then(res => {
            dataImageBase64[name] = res
        })
    }
});

$(document).ready(function() {
    //hide error datatable
    if($.fn.dataTable){
        $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
            console.log(message);
        };
    }
});
