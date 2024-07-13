$(document).ready(function(){

    $('.contact_no').keyup(function() {

        var contact = $(this).val();
        var isNumeric = /^\d+$/.test(contact); // Regular expression to test if the input is numeric
        var sub = contact.substring(0, 2);
        var length = contact.length
        if(!isNumeric) {
            $('#contact_no_res').html('<p style="color:red">Contact no must contain only numeric digits</p>');
        }
        else if (sub != '01') {
            $('#contact_no_res').html('<p style="color:red">Contact no  must be start at 01</p>')
        } else if (length == 11) {
            $('#contact_no_res').html('<p style="color:green">Contact no is valid</p>')
        } else if (length != 11) {
            $('#contact_no_res').html(
                '<p style="color:red">Contact no length must be 11 character</p>')
        }
    });

    $('#medicalTest').click(function(){
        $.ajax({
            url: '/medicalTest',
            method: 'GET',
            success:function(){

            }
        });
    })

})

