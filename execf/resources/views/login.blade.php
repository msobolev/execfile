<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>

        <link rel="stylesheet" href="<?PHP echo asset('login.css'); ?>" type="text/css" >
        
        
        
    </head>    
    <body>


<div class="main-popup">
  

<div class="top-logo"><a href="homepage"><img src="{{ asset('/images/new-logo.png') }}" width="336" height="61" alt="" title="" border="0" /></a></div>    
    
    

<div class="round-box-top"><img src="{{ asset('/images/top-shadow.jpg') }}" width="460" height="18"  alt="" title="" /></div>
<div class="round-box">
    {{-- <form name="frm_login" method="post" action="res-process.php?action=UserLogin"> --}}
    {!! Form::open(['url' => 'search'])   !!}
        <div class="inner-field-box">
            <div class="text">
                Email
            </div>
		
            <div class="field">
            <div id="loginbox_email" class="loginboxdiv">
            
                
                {!! Form::text('login_email',null,['class' => 'loginbox']) !!}
                
            </div>
            </div> 
		
            <div class="text">
                
                @if(isset($action) && $action == 'incorrectPassword')
                    <div style="display:;">
                        Incorrect password. Try again?
                    </div>
                @endif
                
                Password		
            </div>
		
            <div class="field1">
                <div id="loginbox_password" class="loginboxdiv">
                    {{-- <input class="loginbox" name="login_pass" id="login_pass" type="password" autocomplete="off" onfocus="ClassChangeFocus('loginbox_password');" onblur="ClassChangeBlur('loginbox_password');" /> --}}
                    {{-- {!! Form::password('login_email',null,['class' => 'loginbox','placeholder' => 'Name']) !!} --}}
                    {!! Form::password('login_pass',array('class' => 'loginbox')) !!}
                </div>
            </div>
		
        
                
            <div class="field">
            
            </div>


            <div id="submit_dutton" class="buttn-gray">
                <input name="image" value="Sign Up" src="{{ asset('/images/blue-signin-buttn.jpg') }}"  alt="Sign Up" style="border: 0px none;" type="image">
                
            </div>
        </div> 
    {{-- </form> --}}
    {{ csrf_field() }}    
    {!! Form::close()   !!} </form>
</div>

<div class="round-box-bottom"><img src="{{ asset('/images/bottom-shadow.jpg') }}" width="460" height="18"  alt="" title="" /></div>


<div class="bottom-coppyright-text">© {{--date("Y");--}} Execfile. All rights reserved.</div>

</div>
        
        
            
    
    </body>
</html> 