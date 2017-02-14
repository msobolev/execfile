function filter_email(email_id)
{
    //alert("Email ID:"+email_id);
    //alert("in filter email");

    var banned_domain_array = ["@gmail.", "@hotmail.", "@yahoo.","@aol.com","@msn."];
    var email = document.getElementById(email_id).value;
    //var email = email_id;
// alert("EMAIL: "+email);
    var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    //alert("REG.TEST: "+reg.test(email));

    if(reg.test(email)==false)
    {
       // alert("IN IF");
        document.getElementById(email_id).focus();
        return false;
    }
    else
    {
        //alert("IN ELSE");
        var start_position = email.indexOf('@');
        var email_part = email.substring(start_position);
        var end_position = email_part.indexOf('.');
        var find_part = email_part.substring(0,end_position+1);
        var pemail = banned_domain_array;//[banned_domain_array];
        //alert("Find_part: "+find_part);
        var email_result = include(pemail, find_part);
        if(email_result)
        {
            //alert("IN ELSE IF");
            //alert("Enter your Work Email Address");
            //document.getElementById('div_email_status').innerHTML='Enter your Work Email Address';
            document.getElementById(email_id).focus();
            alert("Please enter a work email address");
            return false;
        }
        else
        {
            //alert("IN ELSE ELSE");
            return true;
        }    
    }
}


function include(arr, obj) 
{
    var arrLen = arr.length;		
    for(var i=0; i<arrLen; i++) 
    {
        if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
    }
}