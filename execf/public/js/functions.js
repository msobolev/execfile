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
					.find('.widget-body');
					//.slideUp();
		});


		//Data picker

		$( "#from" ).datepicker({
			numberOfMonths: 1,
			//dayNames: ['Monday', 'Thuseday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sundai'],
			//dayNamesShort: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			//dayNamesMin: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        
                        //dayNames: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
			//dayNamesShort: ['Mon', 'Tues', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			//dayNamesMin: ['Mon', 'Tues', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        
                        //dateFormat: 'yy-mm-dd' ,
                        dateFormat: 'mm-dd-yy' ,
			onClose: function( selectedDate ) {
				//$( "#to" ).datepicker( "option", "minDate", selectedDate );
                                $( "#to" ).datepicker( "option", "minDate", selectedDate );
                                
                                var to_date = $("#to").val();
                                var from_date = $("#from").val();
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
                                
                                
                                var zip_val = $('#zip').val();
                                var city_val = $('#city').val();
                                var hidden_states = '';
                                if ($("#hidden_states").val() != '')
                                {
                                    hidden_states = $("#hidden_states").val();
                                }
                                var industries = "";
                                if ($("#hidden_industires").val() != '')
                                {
                                    industries = $("#hidden_industires").val();
                                }
                                //alert("HID IND: "+$("#hidden_industires").val());
                                var link = get_parameters('from_data',from_date);
                                
                                
                                
			}
		});

		$( "#to" ).datepicker({
			numberOfMonths: 1,
			//dayNames: ['Monday', 'Thuseday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sundai'],
			//dayNamesShort: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			//dayNamesMin: ['Mon', 'Thu', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
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
                                
                                
                                var zip_val = $('#zip').val();
                                var city_val = $('#city').val();
                                var hidden_states = '';
                                if ($("#hidden_states").val() != '')
                                {
                                    hidden_states = $("#hidden_states").val();
                                }
                                var industries = "";
                                if ($("#hidden_industires").val() != '')
                                {
                                    industries = $("#hidden_industires").val();
                                }
                                
                                //alert("IN TO");
                                var link = get_parameters('to_date',to_date);
                                //alert("SEARCH NOW: "+searchnow);
                                //window.location.href = "http://stackoverflow.com";
                                //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+employee_size;
                                //window.location.href = "http://www.execfile.com/home.php?searchnow="+searchnow+"&from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&zip="+zip_val+"&revenue="+revenue+"&employee_size="+employee_size+"&companyval="+companyval+"&mweb="+mweb;
                                //window.location.href =  link;
                                
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
//$( ".slider-range" ).slider( "value", 3 );
			    /*$('.slider-range').each(function() {*/
			    $('#slider-range, #slider-range-secondary').each(function() {
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
                                            var hidden_states = '';
                                            if ($("#hidden_states").val() != '')
                                            {
                                                hidden_states = $("#hidden_states").val();
                                            }
                                            
                                            
                                            var mweb = $('#mweb').val();

                                            var clicked_element = $(this).attr("id");
                                            
                                            var zip_val = $('#zip').val();
                                            
                                            if ($("#field-company-name").val() != '')
                                            {
                                                companyval = $("#field-company-name").val();
                                            }  
                                            
                                            //if(clicked_element == "slider-range")
                                            if(clicked_element == "slider-range_1")
                                            {   
                                                var employee_size = $("#hidden_employee_size").val();
                                                setTimeout(function(){
                                                    
                                                    
                                                    var link = get_parameters('revenue',lower_revenue+":"+upper_revenue);
                                                    
                                                    
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue;
                                                    //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&zip="+zip_val+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
                                                    //your code to be executed after 1 seconds
                                                }, 3000); 
                                            }
                                            
                                            
                                            else
                                            if(clicked_element == "slider-range-secondary")
                                            {   
                                                var revenue = $("#hidden_revenue").val();
                                                setTimeout(function(){
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue;
                                                    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&zip="+zip_val+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
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
                            
                            
                            $('#slider-range_1').each(function() {
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
                                            var hidden_states = '';
                                            if ($("#hidden_states").val() != '')
                                            {
                                                hidden_states = $("#hidden_states").val();
                                            }
                                            
                                            
                                            var mweb = $('#mweb').val();

                                            var clicked_element = $(this).attr("id");
                                            
                                            var zip_val = $('#zip').val();
                                            
                                            var companyval = '';
                                            //if($("#field-company-name"))
                                            //alert("NAME: "+$("#field-company-name").val());
                                            //if(typeof $("#field-company-name") != 'undefined')
                                            //{
                                                if ($("#field-company-name").val() != '')
                                                {
                                                    companyval = $("#field-company-name").val();
                                                } 
                                            //} 
                                             
                                            
                                            //if(clicked_element == "slider-range")
                                            if(clicked_element == "slider-range_1")
                                            {   
                                                var employee_size = $("#hidden_employee_size").val();
                                                setTimeout(function(){
                                                    
                                                    var link = get_parameters('revenue',lower_revenue+":"+upper_revenue);
                                                    
                                                    
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue;
                                                    //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&zip="+zip_val+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
                                                    //your code to be executed after 1 seconds
                                                }, 3000); 
                                            }
                                            
                                            else
                                            if(clicked_element == "slider-range-secondary_1")
                                            {   
                                                var revenue = $("#hidden_revenue").val();
                                                setTimeout(function(){
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue;
                                                    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&zip="+zip_val+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
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
                            
                            $('#slider-range-secondary_1').each(function() {
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
                                            var zip_val = $('#zip').val();
                                            
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
                                            var companyval = '';
                                            if ($("#field-company-name").val() != '')
                                            {
                                                companyval = $("#field-company-name").val();
                                            }
                                            
                                            //if(clicked_element == "slider-range")
                                            if(clicked_element == "slider-range_1")
                                            {
                                                
                                                var employee_size = $("#hidden_employee_size").val();
                                                setTimeout(function(){
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue;
                                                    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&zip="+zip_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&employee_size="+employee_size+"&revenue="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
                                                    //your code to be executed after 1 seconds
                                                }, 3000); 
                                            }
                                            
                                            else
                                            if(clicked_element == "slider-range-secondary_1")
                                            {   
                                                var revenue = $("#hidden_revenue").val();
                                                setTimeout(function(){
                                                    //alert(lower_revenue+":"+upper_revenue); return;
                                                    var link = get_parameters('employee_size',lower_revenue+":"+upper_revenue);
                                                    
                                                    
                                                    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue;
                                                    //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&city="+city_val+"&zip="+zip_val+"&industries="+industries+"&states="+hidden_states+"&type="+type+"&revenue="+revenue+"&employee_size="+lower_revenue+","+upper_revenue+"&companyval="+companyval+"&mweb="+mweb;
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
                            
                            
                            
                            
                            if(clicked_href == 'logout')
                            {
                                
                                var root_path = $('#root_path').val(); 
                                //$("#logout_li").trigger("click");
                                //$("#logout_link").attr("href", root_path+"/logout")
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
		
			 //event.preventDefault();
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
    //alert(e);
    
    var link = get_parameters('rem',e);
    
    //alert(e.indexOf("COMP:"));
    //window.location.href = "http://45.55.139.16"+complete_url+"&rem="+e;
    //window.location.href = url+"&rem="+e;
    
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




function get_parameters(type,val)
{
    //var base_url = 'http://www.execfile.com/execf/public/index.php';
    
    var link = '';
    var industries = 0;
    var from_date = '';
    var to_date = '';
    var revenue = '';
    var employee_size = '';
    var revenue = '';
    var city;
    var state;
    var zip;
    var alert_type;
    var searchnow = '0';
    var rem = '0';
    
    if(type == 'alert_type')
        var alert_type = val;
    else
    {
        var alert_type = $("#type").val();
    } 
    
    if(type == 'ind')
        var industries = val;
    else
    {
        var industries = 0;
        if ($("#hidden_industires").val() != '')
        {
            industries = $("#hidden_industires").val();
        }
    }    
    
    if(type == 'from_data')
        from_date = val;
    else
    {
        //alert("in else");
        var from_date = $("#from").val();
    }
    if(from_date == '')
        from_date = 0;
    
    //alert("FROM DATE: "+from_date);
    if(type == 'to_date')
        to_date = val;
    else
    {
        var to_date = $("#to").val();
    }    
    if(to_date == '')
        to_date = 0;
    
    
    if(type == 'searchnow')
        var searchnow = val;
    else
    {
        var searchnow = $("#developer").val();
    } 
    if(searchnow == '')
        searchnow = 0;
    
    
    
    if(type == 'companyval')
        var companyval = val;
    else
    {
        var companyval = $("#field-company-name").val();
    } 
    if(companyval == '')
        companyval = 0;
    
    
    if(type == 'org')
        var org = val;
    else
    {
        var org = 0;
    } 
    
    
    //var revenue = $("#hidden_revenue").val();
    //var employee_size = $("#hidden_employee_size").val();
    
    
    if(type == 'revenue')
    {
        var res = val.replace(":", ",");
        revenue = res;
    }
    else
    if(typeof("#hidden_revenue") != "undefined" && $("#hidden_revenue").val() != '' && $("#hidden_revenue").val() != '-1')
        revenue = $("#hidden_revenue").val();
    if(revenue == '')
        revenue = '-1';
    
    
    if(type == 'employee_size')
    {
        var res = val.replace(":", ",");
        employee_size = res;
    }
    else
    if(typeof("#hidden_employee_size") != "undefined" && $("#hidden_employee_size").val() != '' && $("#hidden_employee_size").val() != '-1')
        employee_size = $("#hidden_employee_size").val();
    if(employee_size == '')
        employee_size = '-1';
    
    
    if(type == 'city')
        city = val;
    else
    {
        var city = $("#city").val();
    }    
    if(city == '')
        city = 0;
    
    if(type == 'state')
    {    
        if(val != '')
            state = val;
        else
            state = '0';
    }    
    else
    {
        state = 0;
        if ($("#hidden_state").val() != '')
        {
            state = $("#hidden_state").val();
        }
    } 
    
    if(type == 'zip')
        zip = val;
    else
    {
        var zip = $("#zip").val();
    }    
    if(zip == '')
        zip = 0;
    
    //alert("TYPE: "+type);
    //alert("E: "+val);
    if(type == 'rem')
        rem = val;
    
    
    //alert("This searchnow: "+searchnow);
            //var this_link = "http://www.execfile.com/execf/public/index.php/search/movement/"+industries+"/"+from_data+"/"+to_date;
    //var this_link = $search_url+ "/movement";
    var this_link = $base_url+ "/search/"+alert_type+"/"+industries+"/"+from_date+"/"+to_date+"/"+revenue+"/"+employee_size+"/"+city+"/"+state+"/"+zip+"/"+searchnow+"/"+companyval+"/"+rem+"/"+org;
    //console.log("new search url ",this_link);
    //return link;
    window.location.href = this_link;
    //alert("after");
    //return false;
    //return parameters;
        
}