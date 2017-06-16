
const FILE_REQUEST = "request.php";
const ID_FORM_LOGIN = "login-form";
const ID_FORM_REGISTER = "register-form";

const METHOD_LOGIN = "LOGIN";
const METHOD_REGISTER = "REGISTER";


/* INPUT REGISTER */
const RE_INPUT_USERNAME = "#re_username";
const RE_INPUT_EMAIL= "#re_email";
const RE_INPUT_PASSWORD = "#re_password";
const RE_CONFIRM_INPUT_PASSWORD = "#confirmpassword";



/* INPUT LOGIN */
const INPUT_USERNAME = "#username";
const INPUT_PASSWORD = "#password";

jQuery( document ).ready(function() {

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
        jQuery("#register-form").delay(100).fadeIn(100);
        jQuery("#login-form").fadeOut(100);
        jQuery('#login-form-link').removeClass('active');
        jQuery(this).addClass('active');
        e.preventDefault();
    });

});



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
                equalTo: "#re_password"
            }
        },
        messages: {
            username: {
                required: "necesario",
                minlength: "minimo 5"
            }
        },
        submitHandler: function(form) {
            console.log("register");
            registerUser();
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
    data = {
        username: jQuery(RE_INPUT_USERNAME).val(),
        email: $email,
        pass : jQuery(RE_INPUT_PASSWORD).val(),
        method: METHOD_REGISTER
    };
    console.log(data);
    var register = jQuery.ajax({
        crossDomain: true,
        type: "POST",
        url: FILE_REQUEST,
        contentType: "application/json; charset=UTF-8",
        data: JSON.stringify(data),
        dataType : "json",
        beforeSend: function(data){},
        success: function(data){},
        error: function(err){},
        complete: function(){},
        statusCode: {
            404: function () {
                alert( "page not found" );
            }
        }
    });

    register.register(function() {
        console.log( "second complete" );
    });

}

function userLogin(){
    var data;
    data = {
        username: jQuery(INPUT_USERNAME).val(),
        password: jQuery(INPUT_PASSWORD).val()
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

