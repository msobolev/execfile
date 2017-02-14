;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
            
            
            $('.field, textarea').focus(function() {
                if(this.title==this.value) {
                    this.value = '';
                }
            }).blur(function(){
                if(this.value=='') {
                    this.value = this.title;
                }
            });

            
            
		// This class will be added to the expanded item
		var activeItemClass = 'widget-expanded';
		var accordionItemSelector = '.widget';
		var toggleSelector = '.widget-head';

		$(toggleSelector).on('click', function() {

			$(this)
				.next()
				.stop()
				.slideToggle()
				.closest(accordionItemSelector) // go up to the accordion item element
				.toggleClass(activeItemClass)
					.siblings()
					.removeClass(activeItemClass)
					.find('.widget-body')
					.slideUp();
		});


		//Data picker

		$( "#from" ).datepicker({
			numberOfMonths: 1,
			dayNames: ['Monday', 'Thuseday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sundai'],
			dayNamesShort: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			dayNamesMin: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        //dateFormat: 'yy-mm-dd' ,
                        dateFormat: 'mm-dd-yy' ,
			onClose: function( selectedDate ) {
				//$( "#to" ).datepicker( "option", "minDate", selectedDate );
                                $( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});

		$( "#to" ).datepicker({
			numberOfMonths: 1,
			dayNames: ['Monday', 'Thuseday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sundai'],
			dayNamesShort: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			dayNamesMin: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        //dateFormat: 'yy-mm-dd' ,
                        dateFormat: 'mm-dd-yy' ,
			onClose: function( selectedDate ) {
				//$( "#from" ).datepicker( "option", "maxDate", selectedDate );
                                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
    
                                var from_date = $("#from").val();
                                var to_date = $("#to").val();
                                //var type = $("#type").val();
                                var companyval = "";
                                var searchnow = "";
                                var type = "all";
                                if ($("#type").val() != '')
                                {
                                    type = $("#type").val();
                                }
                                if ($("#field-company-name").val() != '')
                                {
                                    companyval = $("#field-company-name").val();
                                }
                                
                                if ($("#developer").val() != '')
                                {
                                    searchnow = $("#developer").val();
                                }
                                var revenue = $("#hidden_revenue").val();
                                var employee_size = $("#hidden_employee_size").val();
                                
                                var mweb = $('#mweb').val();
                                
                                //alert("SEARCH NOW: "+searchnow);
                                //window.location.href = "http://stackoverflow.com";
                                //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+employee_size;
                                window.location.href = "http://www.execfile.com/home.php?searchnow="+searchnow+"&from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+employee_size+"&companyval="+companyval+"&mweb="+mweb;
                                
			}
		});
		
		// Search autocomplete

		  	var names = [ "Dropdown", "Dropdown", "Dropdown", "Dropdown" ];
			var accentMap = {
			  "á": "a",
			  "ö": "o"
			};
			
			var normalize = function( term ) {
			  var ret = "";
			  for ( var i = 0; i < term.length; i++ ) {
				ret += accentMap[ term.charAt(i) ] || term.charAt(i);
			  }
			  return ret;
			};
		 
			$( "#developer" ).autocomplete({
				source: function( request, response ) {
					var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
						response( $.grep( names, function( value ) {
							value = value.label || value.value || value;
							return matcher.test( value ) || matcher.test( normalize( value ) );
						})
					);
				}
			});

		  // slider range

			    $('.slider-range').each(function() {
			    	var $this = $(this),
			    		attrID = $(this).attr('id'),
			    		amount = $this.parent().find('.slider-input')
			    		
			    		trueValues = [],
			    		values = []
			    		
			    		trueValues = $this.data('truevalues').split(","),
			    		values = $this.data('values').split(",");
			    		
			    		 
		    		var slider = $this.slider({
		    		    orientation: 'horizontal',
		    		    range: true,
		    		    min: 0,
		    		    max: 8,
		    		    values: [0, 8],
		    		    slide: function(event, ui) {
		    		         var includeLeft = event.keyCode != $.ui.keyCode.RIGHT;
		    		         var includeRight = event.keyCode != $.ui.keyCode.LEFT;
		    		         var trueValues = $this.data('truevalues').split(","),
		    		     		 values = $this.data('values').split(",");

		    		         var value = findNearest(includeLeft, includeRight, ui.value)
			    		      	
		    		         if (ui.value == ui.values[0]) {
		    		             slider.slider('values', 0, value);
		    		         }
		    		         else {
		    		             slider.slider('values', 1, value);
		    		         }

		    		         amount.val( getRealValue(slider.slider('values', 0), trueValues) + ' - ' + getRealValue(slider.slider('values', 1), trueValues));
		    		         return false;
		    		     },
		    		     start: function( event, ui ) {
		    		     	 
		    		     },
                                     change: function( event, ui ) 
                                     {  
                                         
                                        // Getting new values of revenue slider Starts 
                                        var values;
                                        if (!ui.values) 
                                        {
                                            values = $("#" + event.target.id).slider("values");
                                        } 
                                        else 
                                        {
                                            values = ui.values;
                                        }
                                        if (values[0] == values[1]) 
                                        {
                                            return false;
                                        } 
                                        else 
                                        {
                                            var periodFrom;
                                            values[0] % 1 == 0 ? periodFrom = 'beginnig of the year' : periodFrom = 'year-end';
                                            var periodTo;
                                            values[1] % 1 == 0 ? periodTo = 'beginnig of the year' : periodTo = 'year-end';
                                            //alert('From ' + periodFrom + ' ' + parseInt(values[0]) + '<br />to ' + periodTo + ' ' + parseInt(values[1]));
                                            //alert('From: '+ parseInt(values[0]) + '<br />to:' + parseInt(values[1]));
                                            var lower_revenue = parseInt(values[0]);
                                            var upper_revenue = parseInt(values[1]);
                                            //alert("True val: "+trueValues[1]);  return false;
                                            //var lower_revenue = parseInt(trueValues[0]);
                                            //var upper_revenue = parseInt(trueValues[1]);
                                            
                                            
                                            var from_date = $("#from").val();
                                            var to_date = $("#to").val();
                                            //var type = $("#type").val(); 
                                            
                                            var type = "all";
                                            if ($("#type").val() != '')
                                            {
                                                type = $("#type").val();
                                            }
                                            
                                            var industries = "";
                                            if ($("#hidden_industires").val() != '')
                                            {
                                                industries = $("#hidden_industires").val();
                                            }

                                            var hidden_states = '';
                                            if ($("#hidden_states").val() != '')
                                            {
                                                hidden_states = $("#hidden_states").val();
                                            }
                                            var city_val = $('#city').val();
                                            
                                            var mweb = $('#mweb').val();

                                            var clicked_element = $(this).attr("id");
                                            if(clicked_element == "slider-range")
                                            {   
                                                var employee_size = $("#hidden_employee_size").val();
                                                setTimeout(function(){
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue;
                                                    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue+"&mweb="+mweb;
                                                    //your code to be executed after 1 seconds
                                                }, 3000); 
                                            }
                                            
                                            
                                            else
                                            if(clicked_element == "slider-range-secondary")
                                            {   
                                                var revenue = $("#hidden_revenue").val();
                                                setTimeout(function(){
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue;
                                                    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue+"&mweb="+mweb;
                                                    //your code to be executed after 1 seconds
                                                }, 3000); 
                                            }

                                            
                                            //setTimeout(function () { 
                                            //    window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+lower_revenue+","+upper_revenue) }
                                            //,200);
                                        }
                                        // Getting new values of revenue slider Ends  
                                         
                                         
                                    }
		    		})
			    });
			    
			    function findNearest(includeLeft, includeRight, value) {
			        var nearest = null;
			        var diff = null;
			        
			        for (var i = 0; i < values.length; i++) {
			            if ((includeLeft && values[i] <= value) || (includeRight && values[i] >= value)) {
			                var newDiff = Math.abs(value - values[i]);
			                if (diff == null || newDiff < diff) {
			                    nearest = values[i];
			                    diff = newDiff;
			                }
			            }
			        }
			        return nearest;
			    }
			    
			    function getRealValue(sliderValue, currentValue) {
			    	var trueValues = currentValue
			        for (var i = 0; i < values.length; i++) {
			            if (values[i] >= sliderValue) {
			                return trueValues[i];
			            }
			        }
			        return 0;
			    }

			//	tooltip
			function tooltipHelper () {
				var isTouch = false;
				if($win.width() > 1024) {
					if(isTouch) {
						return;
					}

					isTouch = true;

					$(document).tooltip();
				} else {
					if(!isTouch) {
						return;
					}

					isTouch = false;
				}
			}

			$win.on('load resize', function () {
				

				tooltipHelper();

				if ($win.width() < 768 && !$('.widget-move').length) {

					$('.sidebar .widgets').append('<li class="widget-move"></li>');
				}
								
				if ($win.width() < 768) {
					$(".download").prependTo(".widget-move");
					$(".alert-notice").prependTo(".widget-move");

				} else {
					$(".download").prependTo(".download-holder");
					$(".alert-notice").prependTo(".alert-holder");
				}
			});

			// dropdown

			$('.hasdropdown a').on('click', function (event) { 
                            var clicked_href = $(this).attr("href");
                            if(clicked_href == 'index.php?action=logout')
                            {
                                //$("#logout_li").trigger("click");
                                $('#logout_link').click(); 
                            }
                            else
                            if(clicked_href == 'accounts.php')
                            {
                                //$("#logout_li").trigger("click");
                                $('#accounts_link').click(); 
                            }
                            else
                            if(clicked_href == 'settings.php')
                            {
                                //$("#logout_li").trigger("click");
                                $('#settings_link').click(); 
                            }
                            
			 $(this).toggleClass('active');  
		
			 $('.nav-utilities .dropdown').toggleClass('show');
		
			 event.preventDefault();
			});

			//dropkick

			$(".select.dropkick").dropkick({
				mobile: true
			});

			// nav-secodnary

			 $('.nav-secondary .ico-cross').on('click', function (event) {
			 $(this).toggleClass('active');  
		
			  $(this).parent().parent().toggleClass('remove');
		
			 event.preventDefault();
			});

			// btn-menu

			$('.btn-menu').on('click', function (event) {
				 $(this).toggleClass('active');  
	
				 $('.sidebar, .content, .section-primary .section-head, html').toggleClass('js-show');
	
				event.preventDefault();
			});

			// tags

			  $('#tags_1').tagsInput({
			  	width:'auto',
			  	defaultText:'',
                                'delimiter': '|',
                                //'onChange' : changing,
                                //'onAddTag':adding,
                                'onRemoveTag':removing_tag,
			  });
	});
})(jQuery, window, document);




function removing_tag(e)
{
    //alert("SPAN VAL: "+e);
    var complete_url = $("#hidden_complete_url").val();
    //alert("Complete URL: "+complete_url);
    
    var url = new Url(complete_url);
    url.query.p = 1;
    
    if(e.indexOf("S:") > -1)
    {
        url.query.employee_size = '';
    }    
    
    if(e.indexOf("mil") > -1 || e.indexOf("bil") > -1)
    {
        url.query.revenue = '';
    }
    
    if(e.indexOf("IND:") > -1)
    {
        url.query.industries = '';
    }
    if(e.indexOf("STA:") > -1)
    {
        url.query.states = '';
    }
    if(e.indexOf("Appointments") > -1)
    {
        url.query.type = 'all';
    }
    if(e.indexOf("T:") > -1)
    {
        url.query.to_date = '';
        url.query.from_date = '';
    }
    if(e.indexOf("ZIP:") > -1)
    {
        url.query.zip = '';
    }
    if(e.indexOf("C:") > -1)
    {
        url.query.city = '';
    }
    if(e.indexOf("COMP:") > -1)
    {
        url.query.searchnow = '';
        url.query.companyval = '';
    }
    
    var types_arr = ["movements","Speaking","Media Mentions","Publication","Industry Awards","Funding","Jobs"];
    if(types_arr.indexOf(e) > -1)
    {
        url.query.type = 'all';
    }    
    
    //window.location.href = "http://45.55.139.16"+complete_url+"&rem="+e;
    window.location.href = url+"&rem="+e;
    
}


function adding()
{
    alert("Adding");
}

function AddTag(tag) {
alert("Added a tag: " + tag);
}

function changing()
{
    alert("SPAN VAL: "+$(this).html());
    //alert("THIS VAL : "+$(this).val());
    //alert("changing");
}


function ResultDownload()
{
    document.frmResultDownload.submit();
}


function CreateAlert()
{
    document.frmCreateAlert.submit();
}


/*

function getSalesForceLink(personal_id)
{
    var xmlhttp;
    //xmlhttp=GetXmlHttpObject();
    //xmlhttp=new XMLHttpRequest();
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
      {
      alert ("Browser does not support HTTP Request");
      return;
      }

    //var sval =document.getElementById(str).value;
    var url="getuser.php";
    url=url+"?type=sflink&p_id="+personal_id;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=ForwardingToLink;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}

function ForwardingToLink()
{
    if (xmlhttp.readyState==4)
    {
        //document.getElementById("div_state_edit").innerHTML=xmlhttp.responseText;
        alert("RES: "+xmlhttp.responseText);
    }
}



$(".salesforce").click(function(){
    $.ajax({url: "getuser.php?p_id=112", success: function(result){
        //$("#div1").html(result);
        alert("RES: "+result);
    }});
});
*/

function getSalesForceLink(personal_id)
{
    //alert("personal ID: "+personal_id);
    $.ajax({url: "getuser.php?p_id="+personal_id, success: function(result){
        //$("#div1").html(result);
        //alert(result);
        //console.log(result);
        window.location.href = result; //"http://stackoverflow.com";
        //alert("RES: "+result);
    }});
}