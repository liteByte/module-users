var myCaptcha = null;

jQuery( document ).ready(function() {

    validatorDefaults();

    $(document)
        .ajaxStart(function(){jQuery("body").addClass("loading"); })
        .ajaxStop(function(){jQuery("body").removeClass("loading"); });

    jQuery(function(){
        validateFormRegister();
        validateFormLogin()
    });

    jQuery('#login-form-link').click(function(e) {
        jQuery("#login-form").delay(100).fadeIn(100);
        jQuery("#register-form").fadeOut(100);
        jQuery('#register-form-link').removeClass('active');
        jQuery(this).addClass('active');
        e.preventDefault();

    });

    jQuery('#register-form-link').click(function(e) {

        displayCapchat();
        resetFormRegister();
        jQuery("#register-form").delay(100).fadeIn(100);
        jQuery("#login-form").fadeOut(100);
        jQuery('#login-form-link').removeClass('active');
        jQuery(this).addClass('active');
        e.preventDefault();
    });

    jQuery(document.body).submit(function( event ) {
        event.preventDefault();
        var id = jQuery(event.target)[0].id;

        switch(id) {
            case ID_FORM_LOGIN:
                userLogin();
                break;
            case ID_FORM_REGISTER:
                registerUser();
                break;
            default:
                return;
        }
    });

});

function validatorDefaults(){
    jQuery.validator.setDefaults({
        errorClass: 'help-block',
        highlight: function(element){
            jQuery(element)
                .closest('.form-group')
                .addClass('has-error');
        },
        unhighlight: function(element) {
            jQuery(element)
                .closest('.form-group')
                .removeClass('has-error');
        }
    });
}

function validateFormRegister(){

    var form = jQuery( "#" + ID_FORM_REGISTER );
    form.validate({
        rules: {
            username: {
                required: true,
                minlength: 5
            },
            email: {
                required: true,
                email: true
            },
            re_password: {
                required: true
            },
            confirmpassword: {
                equalTo: "#re_password",
                required: true
            }
        },
        messages: {
            username: {
                required: FIELD_REQUIRED_USERNAME
            },
            email:{
                required: FIELD_REQUIRED_EMAIL,
                email: FIELD_VALID_EMAIL
            },
            re_password:{
                required: FIELD_REQUIRED_PASSWORD
            },
            confirmpassword: {
                equalTo: FIELD_EQUAL_CONFIRM_PASSWORD,
                required: FIELD_REQUIRED_CONFIRM_PASSWORD
            }
        }
    });
}

function validateFormLogin(){

    var form = jQuery( "#" + ID_FORM_LOGIN );
    form.validate({
        rules: {
            username: {
                required: true,
                minlength: 5
            }
        },
        submitHandler: function(form) {
            userLogin();
        }
    });
}

function registerUser(){
    var data;
    var $email = jQuery.trim(jQuery("input[name='email']").val());
    $capchat = grecaptcha.getResponse();

    data = {
        username: jQuery(RE_INPUT_USERNAME).val(),
        email: $email,
        password : jQuery(RE_INPUT_PASSWORD).val(),
        method: METHOD_REGISTER,
        captcha: $capchat

    };
    var register = jQuery.ajax({
        crossDomain: true,
        type: "POST",
        url: FILE_REQUEST,
        contentType: "application/json; charset=UTF-8",
        data: JSON.stringify(data),
        dataType : "json",
        beforeSend: function(data){},
        success: function(data, textStatus, xhr){
            if(xhr.status == 200){
                resetFormRegister();
                gotoLogin()
                showSuccess();
            }
        },
        error: function(err){
            showError(err);
        },
        complete: function(){},
        statusCode: {
            400: function (err) {
            }
        }
    });

    register.always(function() {
        displayCapchat();
    });

}


function showError(err){
    $error = err.status;
    $json  = JSON.parse(err.responseText);
    $msg = $json["msg"];
    console.log($error + " " + $msg);

    BootstrapDialog.show({
        type:  BootstrapDialog.TYPE_DANGER,
        title: "Error",
        message: $msg,
        cssClass: 'login-dialog',
    });

}


function showSuccess(){
    BootstrapDialog.show({
        type:  BootstrapDialog.TYPE_SUCCESS,
        title: "Message",
        message: "Usuario registrado",
        cssClass: 'login-dialog',
    });
}



function userLogin(){
    var data;
    data = {
        username: jQuery(INPUT_USERNAME).val(),
        password: jQuery(INPUT_PASSWORD).val(),
        method: METHOD_LOGIN
    };

    var login =  jQuery.ajax({
        crossDomain: true,
        type: "POST",
        url: FILE_REQUEST,
        contentType: "application/json; charset=UTF-8",
        data: JSON.stringify(data),
        dataType: "json",
        beforeSend: function(data){
            console.log( "beforeSend" );
        },
        success: function (data) {
            console.log( "success" )
            console.log( data );
        },
        error: function (err) {
            console.log( err );
        },
        complete: function(){
            console.log( "complete" );
        },
        statusCode: {
            404: function() {
                alert( "page not found" );
            }
        }

    }).done(function(){
        console.log( "done" );
    }).fail(function() {
        console.log( "fail" );
    }).always(function() {
        console.log( "always" );
    });

    login.always(function() {
        console.log( "second complete" );
    });
}

function resetFormRegister(){
    jQuery(RE_INPUT_USERNAME).val('');
    jQuery(RE_INPUT_EMAIL).val('');
    jQuery(RE_INPUT_PASSWORD).val('');
    jQuery(RE_CONFIRM_INPUT_PASSWORD).val('');
    jQuery('.form-group').removeClass('has-error');
    jQuery('.help-block').hide();

}

function gotoLogin(){
    jQuery('#login-form-link').click();
}


function displayCapchat() {
    if (myCaptcha === null)
        myCaptcha = grecaptcha.render(document.getElementById('recapchat'), {
            'sitekey': "6LdCwyUUAAAAAGTSn0zuLMqk8wBxxEm9PV9XHm5e",
            'theme': 'light',
            'callback' : function(response) {
                console.log(response);
            }
        });
    else
        grecaptcha.reset(myCaptcha);
}

var onloadCallback = function() {
//            alert("grecaptcha is ready!");
};

var verifyCallback = function(response) {
//            alert(response);
};