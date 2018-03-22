<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Execfile</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="<? //=DIR_JS?>validation.js" language="javascript"></script> -->


<link rel="stylesheet" href="<?PHP echo asset('home_style.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('home_style_tags.css'); ?>" type="text/css" >


<script language="javascript">
function ChangePasswordSubmit()
{
	var pass = document.getElementById('password').value;
        var rpass = document.getElementById('repassword').value;
	if(pass=='')
	{
		alert('Please type in your password');
		document.getElementById('password').focus();
		return false;
	}
	else
	if(rpass=='')
	{
		alert('Please type in your Re-password');
		document.getElementById('repassword').focus();
		return false;
	}
        else
	if(pass!=rpass)
	{
		alert('The password you typed in should match. Please try again');
		document.getElementById('password').focus();
		return false;
	}
        else
        {    
            FormValueSubmit('frmChangePassword');
        }    
}

function FormValueSubmit(frmID){document.getElementById(frmID).submit();}

</script>     
    
    
</head>
<body class="blue_body">
<div>
<div style="margin:0px auto;width:990px;">    
    <div style="padding-top:0px;margin-top:8px;">
        <a href="{{ url('search') }}" class="logo"></a>
        <!-- <h1 style="padding-left:0px;"><a href="home.php?funtion=hr"><img width="257" height="24" src="css/images/new-logo.png"></a></h1> -->
    </div>

    <div class="content_div" style="margin-top:20px;">
    <?PHP
    if($msg != '')    
    {    
    ?>
    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }
    else
    {    
    ?>
    <div class="intro-content" style="width:400px;margin: 0 auto;">
    <!-- <h3 style="text-align:left;width:100%;padding:0px 0px 15px 0px;margin:0px;">Request A Demo</h3> -->
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Reset Your Password</h1>

    <div class="form-sing-up">
        
        {{ Form::open(array('url' => 'forgot-password','onSubmit'=>'return ChangePasswordSubmit()')) }}
            <div class="form-body">

                <div class="form-row">
                    <label for="field-email" class="form-label hidden">New Password</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;" type="password" class="field" name="password" id="password" value="" placeholder="New Password">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Re-type Password</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;" type="password" class="field" name="repassword" id="repassword" value="" placeholder="Re-type Password">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                
                
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="reset_pw" name="reset_pw" value="1">
                <input type="hidden" id="user_email" name="user_email" value="<?=$user_email?>">
                <input type="submit" value="Save" class="form-btn"> <!--  onclick="return filter_email();" -->
            </div><!-- /.form-actions -->
        {{ csrf_field() }} 
        {!! Form::close()   !!}
    </div><!-- /.form-sing-up -->
    </div><!-- /.intro-content -->
    <?PHP
    }
    ?>

    
        </div>
</div>
</div>
    
</body>
</html>