(function($){
	var timeout;
	var location;
	var location2;
	var window_width;
	var window_height; 
	var window_ratio;
	var header_ratio;
	var header_height;
	var header_width;
	var image_width;
	var image_height;
	var image_ratio;
	var menu_height;
	var footer_height;
	var this_context;
	
	
	//get the page size
	var getSize=function(){
		
		window_width = $(window).width();
		window_height = $(window).height();
		$('#menu .open .m_inner').css('bottom',0);
		$('#menu .open').removeClass('open');
		setTimeout(function(){


			if(window_height < 800){
				$('#slogan .logo').addClass('low');
			}else{
				$('#slogan .logo').removeClass('low');
			}

			$('#slogan').removeClass('small');
			$('body').removeClass('slim');
			
			
			if($('body.front').length && ($('#triptych').position().top < ($('#slogan').outerHeight()+$('#slogan').position().top))){
				$('#slogan').addClass('small');
			}
			if(window_height < 400 || ($('body.front').length && $('#triptych').position().top < ($('#slogan').outerHeight()+$('#slogan').position().top))){
				$('body').addClass('slim');
			}
			
			//add film strip behaviours
			if($('.page-node .film-strip').length){

				filmstrip_reset();
			}		
		});



		//alert(window_width+' x '+window_height);
		menu_height = $('#menu_editor').height()+$('#menu').height()+$('#toolbar').height()+$('#search_bar').not('.front_search').height();
		footer_height = $('#footer').height();
		header_height = window_height - menu_height;
		window_ratio = window_width/window_height;
		header_ratio = window_width/header_height;
		$('#header, #identity_image').height(header_height);
		
			
	}
	
	//set filter text
	var setFilter=function(){
		//change the filter text to 'select' only once shs has finished it's ajax
		$('.shs-wrapper-processed').ajaxStop(function(event, xhr, settings) {
			$('#filters select').wrap('<span class="select_wrapper"></span>');
			$('#filters option').each(function(){
				if($(this).html() === '- None -'){
					$(this).html('-- Select --');
				}
			});
		})		
	}
	
	//hide and show form elements on validation
	var timer;
	var validate=function(elem){
		clearTimeout(timer);
		function loop(){
			console.log('validating');
			if($(elem).val().length < 6){
				$(elem).parents('form').find('.form-submit').hide();
				$(elem).parents('form').find('.captcha').hide();
			}else{
				$(elem).parents('form').find('.form-submit').show();
				$(elem).parents('form').find('.captcha').show();
			}
			timer = setTimeout(function(){
				loop();
			},500);
		};
		loop();			
	}
	
	//smooth scroll for anchor links
	var smoothscroll = function(){
		$('a[href*="#"]:not([href="#"])').click(function() {
			if (location2.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location2.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					$('html, body').animate({
						scrollTop: target.offset().top
					}, 500);
					return false;
				}
			}
		});
	}
	
	//set the new bookmark count
	var bookmark_count = function(){
		var count = Cookies.get('bookmark_count');
		if(count > 0){
			$('.bookmarks .count').html(count);
			$('.bookmarks .icon').addClass('c1 text');
		}else{
			$('.bookmarks .count').html('');
			$('.bookmarks .icon').removeClass('c1 text');
		}
	}

	//film strip behaviours
	var filmstrip = function(){
					

		//filmstrip_reset();
		
		if($('.page-node .film-strip').length){
			
			
			$('.film-strip .fs_right .arrow').click(function(){
				$('.film-strip .fsmask').show();
				$('.film-strip-image.first').removeClass('first').addClass('oldfirst');
				var lft=$('.film-strip .fs_inner').position().left;
				$('.film-strip .fs_inner').stop().animate({
					'left':lft+$('.film-strip .last').attr('data-left')*-1
				},800,function(){
					setTimeout(function(){
						$('.film-strip .fsmask').hide();
					},200);
					
					$('.film-strip-image.last').removeClass('last').addClass('first');
					$('.film-strip .fs_left .arrow').show('fast');
					filmstrip_size();
					if(!$('.film-strip-image.last').length){
						$('.film-strip .fs_right .arrow').hide('fast');
					}				
				})
				
			});
			$('.film-strip .fs_left .arrow').click(function(){
				$('.film-strip .fsmask').show();
				$('.film-strip-image.last').removeClass('last')
				var lft=$('.film-strip .fs_inner').position().left;
				$('.film-strip .fs_inner').stop().animate({
					'left':lft+$('.film-strip .oldfirst').last().attr('data-left')*-1
				},800,function(){
					setTimeout(function(){
						$('.film-strip .fsmask').hide();
					},200);
					$('.film-strip-image.first').removeClass('first').addClass('last');
					$('.film-strip-image.oldfirst').last().removeClass('oldfirst').addClass('first');
					$('.film-strip .fs_left .arrow').show('fast');
					
					if(!$('.film-strip-image.oldfirst').length){
						$('.film-strip .fs_left .arrow').hide('fast');
					}
					filmstrip_size();				
				})
				
			});
		}
	}
	var filmstrip_reset = function(){

		window_width = $(window).width();
		$('.page-node .film-strip').width(window_width);
		$('.film-strip .oldfirst').removeClass('oldfirst');
		$('.film-strip .first').removeClass('first');
		$('.film-strip .last').removeClass('last');
		$('.film-strip .arrow').css('display','none');
		$('.page-node .film-strip .view-content').attr('style','');
		$('.page-node .film-strip .fs_inner').attr('style','');
		
		if($('.page-node .film-strip').length && $('.page-node .film-strip .fs_inner').width() > window_width){

			$('.film-strip-image').first().addClass('first');
			$('.page-node .film-strip .fs_inner').css({
				'position':'absolute',
				'left':0
			});
			$('.page-node .film-strip .view-content').css({
				'left':0,
			});	
			setTimeout(function(){
				filmstrip_size();
			});
			
		}else{
			filmstrip_hack();
		}	
	}
	var filmstrip_hack=function(){
		$('.film-strip-image').each(function(){
			//stripwidth = stripwidth+$(this).outerWidth();
			var width = $(this).find('img').width();
			var height = $(this).find('img').height();
			if(width > 0){
				$(this).find('img').attr('height',height).attr('width',width);
				$(this).find('a').width(width);
				$(this).width(width);				
			}else{
				var that = this;
				$(this).find('img').load(function(){
					var width = $(that).find('img').width();
					var height = $(that).find('img').height();
					$(that).find('img').attr('height',height).attr('width',width);
					$(that).find('a').width(width);
					$(that).width(width);					
				});
			}

		});		
	}
	var filmstrip_size=function(){
		window_width = $(window).width();
		$('.page-node .film-strip').width(window_width);

		filmstrip_hack();
		
		if($('.page-node .film-strip').length && $('.page-node .film-strip .fs_inner').width() > window_width){

			$('.film-strip .fs_right .arrow').show('fast');
			$('.film-strip-image').each(function(){
				var right = $(this).offset().left+$(this).outerWidth();
				if(right > window_width && !$('.film-strip-image.last').length){
					$(this).addClass('last');
				}
				$(this).attr('data-left',$(this).offset().left);
				$(this).attr('data-right',right);
			});
		}else if($('.page-node .film-strip').length){
			$('.page-node .film-strip .view-content').css(null);
			$('.page-node .film-strip .fs_inner').css(null);			
		}		
	}

	Drupal.behaviors.film = {		
		attach: function (context, settings) {

			this_context = context;
			if(context.location){
				
				location2 = context.location;
				location = context.location.pathname.replace(/ /g,'');
			}
			//alert(location);
			//handle the bookmarks page
			if(location === '/bookmarks' || location === '/bookmarks/'){
				var count = $('.search-widget').length;
				Cookies.set('bookmark_count', count, { expires: 30 });
				bookmark_count();
			}
			//handle the front page
			if(location === '/' || location === '/front'){
				front();
			}
			//handle the search page
			if(location === '/search' || location === '/search/'){
				search();
			}
			//handle the /production page
			if(location === '/production' || location === '/production/'){
				//prevent the double ajax trigger that simple hierarchical select module causes
				timeout = setTimeout(function(){
					clearTimeout(timeout);
					production();
				});				
			}
			//handle the locations page

			if(location === '/locations' || location === '/locations/'){
				//prevent the double ajax trigger that simple hierarchical select module causes
				timeout = setTimeout(function(){
					clearTimeout(timeout);
					locations();
				});
			}
			//Counter for new bookmarks
			var count = Cookies.get('bookmark_count');
			$('.button.bookmark, span.bookmark').unbind('click.bookmark').bind('click.bookmark',function(){
				var action = $(this).find('a').html();
				if(!count){
					count=0;
				}
				if (action === "Bookmark"){
					count++;
					Cookies.set('bookmark_count', count, { expires: 30 });				
				}else if(count*1 > 0){
					count--;
					Cookies.set('bookmark_count', count, { expires: 30 });
				}
				console.log(count);
				bookmark_count();
			});
			
			
			$('html').once('film',function(){
				var roles = $('body').attr('data-roles').split(',');
				
				//add click confirmation to publish for normal users
				if(roles.indexOf('3') === -1 && roles.indexOf('4') === -1){
					$('#tabs a').each(function(){
						if($(this).html() === 'Publish'){
							$(this).click(function(){
								return confirm('Publishing cannot be undone and will notify an editor to review your item.\n\nAre you sure that you wish to publish?')
							});
						}
					});
				}
				
				bookmark_count();
				if($('#search_bar .form-text')[0]){
					var query = context.location.search.split('&');
					var strLength;
					for(i=0;i<query.length;i++){
						var query_val = query[i].split('=')[1] || '';
						query_val = query_val.replace('+',' ');
						var query_context = query[i].split('=')[0];
						if(query_context === '?search_api_views_fulltext'){
							$('#search_bar .form-text')[0]['value']= query_val;
							strLength = query_val.length * 2;
						}						
					}
					
					//$('#search_bar .form-text').attr('placeholder','Find anyone, anything, anywhere....').focus();
					//$('#search_bar .form-text').focus();
					if(strLength){
						$('#search_bar .form-text')[0].setSelectionRange(strLength, strLength);
					}
					
					$('.address-block').each(function(){
						if($(this).html().replace(/ /g,'').length < 5){
							$(this).parents('.block').hide();
						};
					});
				}

				
					
				
				
				//main menu colours
				$('#main-menu li.active').addClass('c3 text');
				$('#menu_mid a').not('.active').hover(function(){
					$(this).addClass('c2 text');
				},function(){
					$(this).removeClass('c2 text');					
				});
				//placeholder for search bar
				
				//mask over film strip images
				//$('.film-strip-image a').addClass('mask');
				
				getSize();
				var minHeight = window_height-footer_height-menu_height;

				$('#mid_wrap').css('min-height',minHeight);
				
				if($('#comments').length > 0){
					comments();
				}
				
				//main menu trigger
				//$('#main_menu_right .forgot').appendTo($('#main_menu_right .form-actions'));
				
				var menopen = function(item,type){

					if(type === 'info' && $('#menu_right .item.menu').hasClass('open')){
						menopen($('#menu_right .item.menu')[0],'menu');
					}else if(type === 'menu' && $('#menu_right .item.info').hasClass('open')){
						menopen($('#menu_right .item.info')[0],'info');
					}
					if($(item).hasClass('open')){
						$(item).removeClass('open');
						$('#main_'+type+'_right').removeClass('open');
						$('#main_'+type+'_right .m_inner').css('bottom',0);
					}else{
						$(item).addClass('open');
						$('#main_'+type+'_right').addClass('open');
						$('#main_'+type+'_right .m_inner').css('bottom',$('#main_'+type+'_right .m_inner').outerHeight()*-1);
					}					
				}
				$('#menu_right .item.menu, #menu_right .item.info').click(function(){
					
					if($(this).hasClass('menu')){
						menopen(this,'menu');
					}else{
						menopen(this,'info');
					}
					
				});
				
				//add film strip behaviours
				if($('.page-node .film-strip').length){
					filmstrip();
				}
				//page resize functions
				var timeout2;
				$(window).resize(function(){
					clearTimeout(timeout2);
					timeout2=setTimeout(function(){

						getSize();
						if($('body.front').length){
							headerSize();
						}								
					},1);
				});				
				
			});		
		}		
	}
	//various hacks on the comments 
	var comments=function(){
		

		$("time.timeago").timeago();
		$('#comments .comment').each(function(){
			$(this).find('.comment_show').insertAfter($(this).find('.avatar'));
		});
		$('#comments .c_links li').addClass('c1 bdr');
		$('#comments .comment_show').each(function(){
			$(this).html('<div class="spacer"></div><div class="inner">'+$(this).html().replace(' Comments to this comment','')+'</div>');
			$(this).addClass('c1 bg').children('.inner').addClass('c7 text font1 bold');
		});
		if(!$('#wide_bottom').length){
			$('#comment_this_form').insertAfter('#content');
		}else{
			$('#wide_bottom').prepend($('#comment_this_form'));
			$('#comment_this_form').append('<div class="divider c7 bg"></div>');
		};
		
		$('#comment_this_form .form-submit, #comments .form-submit').hide();
		$('#comment_this_form textarea, #comments textarea').focus(function(){
			validate(this);
		});
		
		var prev_div;
		var prev_a
		var wrap = function(that){
			if($(that).hasClass('indented')){
				var comment_group = $(that).wrap('<div class = "comment_group"></div>');
				$(comment_group).parents('.comment_group').first().prepend($(prev_div)).prepend($(prev_a));
			}
			if($(that)[0].tagName === 'A'){
				prev_a = that;
			};
			prev_div = that;			
		}
		$('#comments .inner_wrap').children('*').each(function(){
			wrap(this);
		});
		$('#comments .inner_wrap').children('.comment_group').each(function(){
			$(this).children('.indented').each(function(){
				
				$(this).children('*').each(function(){
					wrap(this);
				});				
			});			
		})
		
		$('.comment_group').each(function(){
			if($(this).children('.indented').find('.new').length){
				$(this).children('.comment').find('.comment_show').removeClass('c1').addClass('c3');
				$(this).children('.indented').children('.comment').each(function(){
					if($(this).find('.new').length){
						$('this').find('.comment_show').removeClass('c1').addClass('c3');;
					}
				});
			}
		});
		
		
	}
	//page functions for the search page
	var search = function(){
		console.log('search');
		if($('input[name="search_api_views_fulltext"]').val()){
			var string=$('input[name="search_api_views_fulltext"]').val().replace(/ /g,'+');
			var href = '/search-xls?search_api_views_fulltext='+string;
			$('.xls_download a').attr('href',href);
		}
	}	
	//page functions for the front page	
	
	//fit the front page content to the header
	var headerSize=function(){
		if(header_ratio > image_ratio){
			$('#identity_image').addClass('w100').removeClass('h100');
			$('#identity_image img').css({
				'left':'auto',
				'top':(header_height - $('#identity_image img').height())/2
			});
		}else{
			$('#identity_image').addClass('h100').removeClass('w100');
			$('#identity_image img').css({
				'top':'auto',
				'left':(window_width - $('#identity_image img').width())/2
			});
			
		}
		//$('html, body').scrollTop(0);
	}
	
	var front=function(){

		$('#triptych .button').hover(function(){
			$(this).addClass('c1 bg');
		},function(){
			$(this).removeClass('c1 bg');
		});
		$('#header .why').hover(function(){
			$(this).addClass('c4 text');
		},function(){
			$(this).removeClass('c4 text');
			
		});
		$('.troy .link a').hover(function(){
			$(this).addClass('c4 bg');
		},function(){
			$(this).removeClass('c4 bg');
			
		});;
		smoothscroll();
		

		//get a random image for the front header
		var string='['+$('.identity_urls').html()+']';
		string = string.replace(/\s/g,''); 
		var front_images=JSON.parse(string);
		
		var getSlide=function(){
			var rnd = Math.floor(Math.random()*(front_images.length))+0;
			if (rnd == Cookies.get('slide')){
				getSlide();
			}else{
				Cookies.set('slide', rnd, { path: '' });
				$('#identity_image img').attr('src',front_images[rnd]);
			}			
		}
		
		
		//get viewport size
		$('#identity_image img').load(function(){
			
			image_width = $('#identity_image img').width();
			image_height = $('#identity_image img').height();
			//alert(image_width+' x '+image_height);
			image_ratio = image_width/image_height;
			headerSize();
		});
		
		getSlide();

	}
	//page functions for the /production page
	var production=function(){
		$('.c1.text.button').hover(function(){
			$(this).find('a').addClass('c2 bg').css('color','white');
			$(this).find('span').css('color','white');
		},function(){
			$(this).find('a').removeClass('c2 bg').css('color','inherit');
			$(this).find('span').css('color','inherit');
		});
		
		var tid = $('#edit-shs-term-node-tid-depth').val();
		$('.xls_download a').attr('href','/xls-production?shs_term_node_tid_depth='+tid);
		$('#filters select').addClass('c2 bg');
		setFilter();
		/*
		$('.product-widget').hover(function(){
			$(this).find('.inner').addClass('c5 bg');
		},function(){
			$(this).find('.inner').removeClass('c5 bg');
		});
		* */
		$('.action_call .inner').once('film',function(){
			$(this).hover(function(){
				$(this).addClass('c5 bg');
			},function(){
				$(this).removeClass('c5 bg');
			});
		});
		$('#contact_form .captcha').hide();
		$('#contact_form textarea, #contact_form input').not('.form-actions input').focus(function(){
			$('#contact_form .captcha').stop().show("slow");
		});
		
		$('body').once('film',function(){
			$('.production-row a').not('.edit').addClass('c1 text');

			$('.production-row').each(function(){
				var id=$(this).find('.id_nid').attr('id');
				$('#context_menu').append('<a class="c2 text font2 semibold" href="#'+id+'">'+$(this).find('h1').children('.inner').html()+'</a>');
			});
		});
		smoothscroll();
		if(location2['hash']){
			console.log(location2['hash']);
			var target = $(location2['hash']);
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 500);
		}
	}		
	//page functions for the /locations page
	var locations=function(){
	
		$('.c1.text.button').hover(function(){
			$(this).find('a, div').addClass('c3 bg').css('color','white');
			$(this).find('span').css('color','white');
		},function(){
			$(this).find('a, div').removeClass('c3 bg').css('color','inherit');
			$(this).find('span').css('color','inherit');
		});
		var tid = $('#edit-shs-term-node-tid-depth').val();

		if(tid === 'All'){
			$('.xls_download .download').hide();
		}else{
			$('.xls_download a').attr('href','/xls-locations?shs_term_node_tid_depth='+tid);
		}
			
		//various styling hacks
		$('.location-preview .previews img').addClass('c7 bg');
		$('#filters select').addClass('c3 bg');
		
		
		
		setFilter();
		$('.action_call a').once('film',function(){
			$(this).hover(function(){
				$(this).addClass('c5 bg');
			},function(){
				$(this).removeClass('c5 bg');
			});
		});
		var hovertime;
		$('.location-preview .trigger, .location-preview .previews, .location-preview .desktop_trigger, .location-preview .links').each(function(){
			$(this).hover(function(){
				var that = this;
				setTimeout(function(){
					$(that).parents('.location-preview').addClass('active desktop');
				});
				
			},function(){
				$('.active.desktop').removeClass('active desktop');
			});

		});
		$('.location-preview .trigger, .location-preview .previews, .location-preview .desktop_trigger, .location-preview .links').each(function(){
			$(this).click(function(){

				if(!$(this).parents('.location-preview').hasClass('active')){
					$('.location-preview .active').removeClass('active');
					$(this).parents('.location-preview').addClass('active');
				}
			});			
		})		
	}
	

	

})(jQuery)
