<form id="<?=$form_id?>" name="request_demo_form" method="post">    
    <span>First Name:</span> <input class="rd_input" type="text" id="<?=$first_name_field_name?>" name="first_name_rq">&nbsp;&nbsp; 
    <span>Last Name:</span> <input class="rd_input" type="text" id="<?=$last_name_field_name?>" name="last_name_rq">&nbsp;&nbsp; 
    <span>Work Email:</span> <input class="rd_input" type="text" id="<?=$email_field_name?>" name="email_rq">&nbsp;&nbsp;
    <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
    <span class="rdf">
        <a onclick="thisFormSubmit('<?=$first_name_field_name?>','<?=$last_name_field_name?>','<?=$email_field_name?>','<?=$form_id?>')" href="javascript:void(0);">Sign Up</a>
    </span>
</form>