 (function($) {
    $(document).ready(function() {


$('p').each(function() {
    var $this = $(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0 || $(this).find('br').length )
        $this.remove();

    
});

$('#main').each(function() {
    $(this).children('.row').addClass('blockwrapper');
});

$('#myTab').tabCollapse();

$('#example').DataTable();
$('li.dropdown').children('a').addClass('dropdown-toggle');
$('a.dropdown-toggle').children('i').addClass('fa fa-angle-down');


$('.navmenu li.dropdown').click(function(){
var tmp = $(this);
$('.navmenu li.dropdown.open').each(function() {
  $( this ).removeClass( "open" );
});

$(tmp).toggleClass("open");
});



$("#register").click(function () {
//alert('here');
    $(".light-gray.login-page").addClass("hide");
    $(".light-gray.register-page.hide").removeClass("hide");
});
$("#login").click(function () {
//alert('here');
    $(".light-gray.register-page").addClass("hide");
    $(".light-gray.login-page").removeClass("hide");
});



 //------step form process--------//
 var form = $("#example-advanced-form").show();
$(document).on('click','#example-advanced-form #lastoption, #update-advanced-form #lastoption',function(){
                $('input[name="optionsRadios"]').prop('checked', false);
                $('#optionsRadios4').prop('checked', true);
                $('#lastoption').addClass('required')

})
$(document).on('click','#example-advanced-form .optionval, #update-advanced-form .optionval',function(){
                $(this).prop('checked', true);
                $('#optionsRadios4').prop('checked', false);
                $('#lastoption').removeClass('required')
})
form.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    labels: {
             finish : "Submit <i class='fa fa-spinner fa-spin loaderimg' style='display:none;'></i>",
        
    },
   // transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 )
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles

            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }

        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            form.steps("previous");
        }
    },
   
    onFinishing: function (event, currentIndex)
    {
        
      
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        
                $('#example-advanced-form .loaderimg').css('display','inline-block');
                event.preventDefault();
                //$('.loader').show();
                var fd = new FormData(this);
                fd.append('action', 'formprocess');  
                fd.append('data', $(this).serialize());  

                $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                contentType: false,
                processData: false,
                success: function(data){
                $('#example-advanced-form .loaderimg').css('display','none');
                   // window.location.href = 'http://192.168.0.51/adv_therapeutics/dashboard/';
                   window.location.href = 'http://advtx.3hammers.com/dashboard/?redirect=success';
                },
                error: function(){
                    alert('something went wrong.')
                }
                });

    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
  
});

 //------step form update process--------//
 var updateform = $("#update-advanced-form").show();

updateform.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    labels: {
             finish : "Submit <i class='fa fa-spinner fa-spin loaderimg' style='display:none;'></i>",
        
    },
   // transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 )
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            updateform.find(".body:eq(" + newIndex + ") label.error").remove();
            updateform.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        
        updateform.validate().settings.ignore = ":disabled,:hidden";
        return updateform.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            updateform.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            updateform.steps("previous");
        }
    },
   
    onFinishing: function (event, currentIndex)
    {
        
        updateform.validate().settings.ignore = ":disabled";
        return updateform.valid();
    },
    onFinished: function (event, currentIndex)
    {
            $('#update-advanced-form .loaderimg').css('display','inline-block');
               
                event.preventDefault();
                var fd = new FormData(this);
                fd.append('action', 'updateformprocess');  
                fd.append('data', $(this).serialize());  

                $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                contentType: false,
                processData: false,
                success: function(data){
                 $('#update-advanced-form .loaderimg').css('display','none');
                    //window.location.href = 'http://192.168.0.51/adv_therapeutics/dashboard/';
                    window.location.href = 'http://advtx.3hammers.com/dashboard/?val=success';                    
                },
                });

    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
  
});

// auto complete form//
$('#example-advanced-form #username, #update-advanced-form #username').autoComplete({
        minChars: 0,
        source: function(name, response) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: 'action=get_listing_names&name='+name,
                success: function(data) {
                    response(data);
                }
            });
        },
        onSelect: function(e, term, item){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: 'action=get_names_information&name='+item.data('val'),
                success: function(data) {
                    $('#example-advanced-form #firstname, #update-advanced-form #firstname').val(data.firstname)
                    //$('#example-advanced-form #middlename, ').val(data.middlename)
                    $('#example-advanced-form #lastname, #update-advanced-form #lastname').val(data.lastname)
                    $('#example-advanced-form #emailadd, #update-advanced-form #emailadd').val(data.user_email)
                    $('#example-advanced-form #phonenumber, #update-advanced-form #phonenumber').val(data.phone)
                    $('#example-advanced-form #dyear, #update-advanced-form #dyear').val(data.dyear)
                    $('#example-advanced-form #dmonth, #update-advanced-form #dmonth').val(data.dmonth)
                    $('#example-advanced-form #dday, #update-advanced-form #dday').val(data.dday)
                   // response(data);
                }
            });
    }
    });



// form validation submit registration and login

        $('form#pippin_registration_form').validate();
        $('form#pippin_login_form').validate();
        $('form#pippin_patient_form').validate();

        $(document).on('submit', 'form#pippin_registration_form', function(e) {
            if ($('#pp_email').val() == '' || $('#pp_password').val() == '') {
                $('form#pippin_registration_form').validate();
                return false;
            } else {
                $('.loaderimg').show();
                var ctrl = $(this);
                var fd = new FormData(this);
                fd.append('action', 'register');  
                fd.append('data', $(this).serialize());
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    processData: false,
                    contentType: false,
                    data: fd,
                    success: function(data) {
                        $('.loaderimg').hide()
                        if (data == 'true') {
                            //  setTimeout(function(){ $('.successmsg').fadeOut() }, 5000);
                            $('.successmsg').html('Please check your email to verify your email address.').show();
                            $('section.login-page').removeClass('hide')
                            $('section.register-page').addClass('hide')
                            $('#pippin_registration_form').trigger("reset");

                        
                        } else if (data == 'exist_username') {
                            $('.errormsg').html('Username Already Exist').show();
                             }else if (data == 'exist') {
                            $('.errormsg').html('Email Already Exist').show();
                                } else if (data == 'invalid') {
                            $('.errormsg').html('Invalid Email').show();
                             } else if (data == 'empty') {
                            $('.errormsg').html('Password empty').show();
                              }else if (data == 'match') {
                             $('.errormsg').html('Password do not matched').show();
                            }
                            $('#pippin_registration_form').trigger("reset");
                        // $('.modal-footer button').trigger('click') 

                    },
                    //dataType: 'JSON',
                }); //ajax
            }
            //e.preventDefault();
            //return false;

        });


 //---------------- Login form Submit --------------//

        $(document).on('submit', 'form#pippin_login_form', function(e) {
            if ($('#pp_user_login').val() == '' || $('#pp_user_pass').val() == '') {
                $('form#pippin_login_form').validate();
                return false;
            } else {
                $('.loaderimg').show()
                var ctrl = $(this);
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        'action': 'login',
                        'data': $('#pippin_login_form').serialize(),
                    },
                    success: function(data) {
                        $('.loaderimg').hide()
                        if (data.success == 'true') {
                            window.location.href = data.url + '/dashboard/';
                        } else if (data.success == 'invalid') {
                             $('.errormsg1').html('Email address not registered.').show();
                    
                        } else if (data.success == 'empty') {
                            $('.errormsg1').html('Password empty').show();
                     
                        } else if (data.success == 'incorrect') {
                            $('.errormsg1').html('Password is incorrect').show();
                  
                        }
                        else if (data.success == 'notverified') {
                            $('.errormsg1').html('Email address is not verified yet.Please check your email.').show();
                       
                        } else if (data.success == 'patient') {
                            $('.errormsg1').html(' Not allowed for patient. ').show();
                        
                        }

                    },
                    dataType: 'JSON',
                });
            }
            e.preventDefault();
            return false;

        });



//+++++++ Patient registration form +++++++++

    $(document).on('submit', "form#pippin_patient_form", function(e){

            // if (!($('#pippin_request_form').valid())) {
            // // $("form#pippin_request_form").validate();
            // return false;
            //    //e.preventDefault(); 
            // } else {
                $(".loaderimg").show();
        // AJAX Code To Submit Form.
        $.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: 'JSON',
        data: {
            'action': 'patient' ,
            'data' : $('#pippin_patient_form').serialize(),
                },
            cache: false,
            success: function(data) {
                    $('.loaderimg').hide()
                    if (data.success == 'success') {
                    $('.successMessage').html('Successfully registered.').show().fadeOut(6000);
                    $('#pippin_patient_form').trigger("reset");
                }else if( data.success == 'user_exist'){
                    $('.errorMessage').html('Username already exist. Please register with different username.').show();

                }else if( data.success == 'email_exist'){

                    $('.errorMessage').html('Email address already exist. Please register with different email address').show();
                }
                },

            error: function(data){
                    $('.loaderimg').hide()
                    $('.errorMessage').html('Something went wrong. Please try again.').show();
                    //$('#pippin_patient_form').trigger("reset");
                }        
            }); //ajax    
        });


/* Reset Password */

$(document).on('submit','#reset-password',function(){
        $('.loaderimg').show();
    var password = $('#newpass').val()
    var cpassword = $('#newconfirmpass').val()
    var id = $('#user_id').val()
    $.ajax({
        url:ajaxurl,
        type:'POST',
        data: {
            'action':'newpasswordset',
            'password': password, 
            'id': id,
            'cpassword': cpassword
        },
        success:function(data){
                $('.loaderimg').hide();
                if(data.message == 'success'){
$('.successmsg1').html('Your password successfully updated.').css({
                                'background': '#4CAF50 none repeat scroll 0 0',
                                'color': '#fff',
                                'padding': '10px',
                                'text-align': 'center',
                                'margin':'10px'
                            });   

}   else if(data.message == 'incorrect'){
$('.errormsg1').html('Password do not matched.').css({
                                'background': '#e52d27 none repeat scroll 0 0',
                                'color': '#fff',
                                'padding': '10px',
                                'text-align': 'center',
                                'margin':'10px'

                            });            
}
        },
        error:function(error){
            $('.errormsg1').html('Something went wrong.')

        },
        dataType:'JSON'
    })
})

//=========== Password Reset ==============//


 $('form#pippin_forgetpass_form').validate();

 $(document).on('submit','#pippin_forgetpass_form',function(){
    $('.loaderimg').show();
    var email = $('#pippin_email_address').val()
    $.ajax({
        url: ajaxurl,
        type:'POST',
        data: {
            'action':'passwordreset',
            'email': email
        },
        success:function(data){
                $('.loaderimg').hide();
                if(data.message == 'success'){
                    $('.successmsg').html('Please find the link in email to reset password.').css({
                                'background': '#4CAF50 none repeat scroll 0 0',
                                'color': '#fff',
                                'padding': '10px',
                                'text-align': 'center',
                            });
                }
            else{
                $('.errormsg').html('Email address is not registered.').css({
                                'background': '#e52d27 none repeat scroll 0 0',
                                'color': '#fff',
                                'padding': '10px',
                                'text-align': 'center',
                            });
            }
        },
        error:function(error){
            $('.errormsg').html('Something went wrong.').css({
                                'background': '#e52d27 none repeat scroll 0 0',
                                'color': '#fff',
                                'padding': '10px',
                                'text-align': 'center',
                            });

        },
        dataType:'JSON'
    })
}) 

//---------edit profile---------//

$(document).on('submit','#pippin_edit_form',function(){
               $('.loaderimg').show();
                var ctrl = $(this);
                var fd = new FormData(this);
                fd.append('action', 'edit_profile');  
                fd.append('data', $(this).serialize());
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    processData: false,
                    contentType: false,
                    data: fd,
                    success: function(data) {
                        $('.loaderimg').hide()
                        if ( data == 'success' ) {
                            $('html, body').animate({scrollTop: '0px'}, 0);
                            $('.successmsg').html('Update Successfully.').show();
                            setTimeout(function(){
                                window.location.reload();
                            }, 500)

                        } else if ( data == 'invalid' ) {
                            $('.errormsg').html('Invalid Email').show();
                        } else if( data == 'false' ) {
                            $('.errormsg').html('Update unsuccessful').show();
                        }
                        $('#pippin_registration_form').trigger("reset");

                    },
                }); //ajax
})
 //-------end------------//


// // +++++++++++++ formwidgets

    // $("#demoForm").formwizard({ 
                                    
    //                 formPluginEnabled: true,
    //                 validationEnabled: true,
    //                 focusFirstInput : true,
    //                 formOptions :{
    //                                            type:"POST",
    //                                             url : ajaxurl,
    //                                             data : {action: "registration"},
    //                     success: function(data){
    //                                                 $("#demoForm").hide();
                                                    
    //                                                 $(".success").show();
    //                                                 $("#data").hide();
                                                    
    //                                                 //$("#status").fadeTo(500,1,function(){ $(this).html("You are now registered!").fadeTo(5000, 0); })
    //                                             },
    //                     beforeSubmit: function(data){$("#data").html("Processing... ");},
    //                     dataType: 'json',
    //                     resetForm: true
    //                 }   
    //              }
    //             );


$('#datepicker').combodate({
    firstItem: 'name',
    minYear: 1800,
    maxYear: 2017,
    minuteStep: 10
});
$('#pp_dob').combodate({
    firstItem: 'name',
    minYear: 1800,
    maxYear: 2017,
    minuteStep: 10
});

//---load more section ----//
 size_li = $(".news-list").size();
    x=2;
    $('.news-list:lt('+x+')').show();
    
       $('.loadmorebtn').click(function () {
           x= (x+2 <= size_li) ? x+2 : size_li;
           $('.news-list:lt('+x+')').show();
           if( x == size_li){
            $('.loadmorebtn').hide()
           }
       });

   });
 })(window.jQuery);

 function readfeatured10(input,classname) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('.register-page .'+classname).css('background-image','url('+ e.target.result + ')')
                };
                $('.register-page .'+classname).show()
                

                reader.readAsDataURL(input.files[0]);
            }else{
                $('.register-page .'+classname).css('background-image','url()')
                
            }
} 