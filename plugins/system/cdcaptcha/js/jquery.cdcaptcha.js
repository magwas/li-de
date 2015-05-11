/**
 * Core Design Captcha plugin for Joomla! 2.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		2.5.x.2.0.6
 * @copyright	Copyright (C) 2007 - 2012 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

if (typeof(jQuery) == 'function') {
	
	(function($) {
		
		$.fn.cdcaptcha = function(options) {

			// set defaults
			var defaults = {
				doNotUseCondition : null,
				submitElement : 'input[type="submit"]',
				prependElement: '',
				position : 'before',
				scriptDeclaration : null,
				sliderStart : null,
				sliderStop : null,
				scope : '',
				uitheme : 'ui-lightness',
				random : '',
				additionalBoxStyle : '',
				autoFormSubmit : false,
				rememberFields : {},
				slideCaptchaUp : 500,
				headerText : 'Captcha',
				infoText : 'Proves you\'re human and slide to unlock.',
				lockedText : 'Locked',
				unlockedText : 'Unlocked',
				inputValue: 1,
				saltValue: 9,
				checkValue: 10
			},
			opts = $.extend(defaults, options);
			
			// use global defaults
			if (typeof($.fn.cdcaptcha.globalDefaults) === 'object') {
				opts = $.extend(opts, $.fn.cdcaptcha.globalDefaults);
			}
			
			return this.each(function() {
				
				// no random
				if (!opts.random) return false;
				
				// check defaults
				opts.submitElement = opts.submitElement || 'input[type="submit"]';
				opts.prependElement = opts.prependElement || opts.submitElement;
				opts.position = opts.position || 'before';
				
				var form = $(this),
				captcha_container = {},
				submitElement = $(opts.submitElement, form),
				prependElement = $(opts.prependElement, form),
				captcha_tmpl =
				'<div id="cdcaptcha"'+ (opts.additionalBoxStyle ? ' style="' + opts.additionalBoxStyle + '"' : '') +'>' + 
					'<div class="' + opts.uitheme + '">' +
						'<div class="ui-widget ui-widget-content ui-corner-all cdcaptcha_content">' + 
							'<div class="captcha_header">' + opts.headerText + '</div>' +
							'<div class="infotext">' + opts.infoText + '</div>' +
							'<div class="slider"></div>' +
							'<div class="cleaner" />' +
							'<div class="status">' +
								'<div class="status_locked active"><span class="icon_active" />' + opts.lockedText + '</div>' +
								'<div class="status_unlocked"><span class="icon_inactive" />' + opts.unlockedText + '</div>' +
								'<div class="cleaner" />' +
							'</div>' +
							'<input type="hidden" name="cdcaptcha_' + opts.scope + '" value="0" />' +
						'</div>' + 
					'</div>' +
					'<div class="poweredby">Captcha by <a href="http://www.greatjoomla.com/" target="_blank" title="Great Joomla!">Great Joomla!</a></div>' +
				'</div>';
				
				// disable Captcha via function
				if (typeof(opts.doNotUseCondition) === 'function') {
					if(typeof(opts.doNotUseCondition(form)) === 'boolean' && opts.doNotUseCondition(form) === true) {
						return true;
					}
				}
				
				// remember fields routine
				if (empty(opts.rememberFields) === false && typeof(opts.rememberFields) === 'object') {
					$.each(opts.rememberFields, function(el, val) {
						
						if (typeof(val) === 'object') {
							$.each(val, function(val_el, val_val) {
								form.find('[name="' + el + '\[' + val_el + '\]' + '"]').val(val_val);
							});
						} else {
							// value is a string
							form.find('[name="' + el + '"]').val(val);
						}
						
					});
				}
				
				if (opts.position === 'before') {
					prependElement.before(captcha_tmpl);
					captcha_container = prependElement.prev('#cdcaptcha');
				} else {
					prependElement.after(captcha_tmpl);
					captcha_container = prependElement.next('#cdcaptcha');
				}
				
				// prevent non button submit elements
				var isFormButton = false;
				if(submitElement.is('button') || submitElement.is('input')) {
					isFormButton = true;	
				}
				
				if (isFormButton) {
					// disable submit button
					submitElement.prop('disabled', true);
				}
				
				var cdcaptcha_input = $('input:hidden[name="cdcaptcha_' + opts.scope + '"]', form),
				locked = $('.status .status_locked', form),
				unlocked = $('.status .status_unlocked', form);
				
				var captcha_enabled = false;
				
				// slider functionality
				// there must be ".prop('slide', '')" because of compatibility with Mootools 1.2.4
				$(".slider", form).prop('slide', '').slider({
					animate: true,
					value: 0,
					max: opts.inputValue,
					step: opts.inputValue,
					range: 'min',
					start : function(event, ui) {
						// call function if set and at last!!!
						if (typeof(opts.sliderStart) === 'function') {
							opts.sliderStart(form, $(this));
						}
					},
					stop: function(event, ui) {
						// set value of usercheck
						cdcaptcha_input.val(ui.value + opts.saltValue);
						
						// enable submit button
						if(cdcaptcha_input.val() == opts.checkValue) {
							// enable
							if (isFormButton) {
								submitElement.prop('disabled', false);
								
								// // UI buttons routine
								uiButtonsRoutine(submitElement);
							}
							cdcaptcha_input.val(opts.random);
							
							locked.removeClass('active').children('span').removeClass('icon_active').addClass('icon_inactive');
							unlocked.addClass('active').children('span').removeClass('icon_inactive').addClass('icon_active');
							
							captcha_container.css({
								border : 'none'
							});
							
							captcha_enabled = true;
							
							// form autosubmit
							if (opts.autoFormSubmit === true) {
								// must be "click" not "submit"
								submitElement.click();
							}
							
							// slide captcha element up if required
							if (opts.slideCaptchaUp != 0) {
								captcha_container.slideUp(opts.slideCaptchaUp);
							}
							
						} else{
							// disable
							if (isFormButton) {
								submitElement.attr('disabled', 'disabled');
								
								// UI buttons routine
								uiButtonsRoutine(submitElement);
							}
							cdcaptcha_input.val(0);
							
							locked.addClass('active').children('span').removeClass('icon_inactive').addClass('icon_active');
							unlocked.removeClass('active').children('span').removeClass('icon_active').addClass('icon_inactive');
							
							captcha_enabled = false;
						}
						
						// call function if set and at last!!!
						if (typeof(opts.sliderStop) === 'function') {
							opts.sliderStop(form, $(this));
						}
					}
				});
				
				// prevent submit if captcha not enabled
				form.submit(function(e) {
					
					if (captcha_enabled === true) return true;
					
					captcha_container.animate({
						    border : '2px solid red'
						  }, 150);
					
					e.preventDefault();
					return false;
				});
				
				// call function if set and at last!!!
				if (typeof(opts.scriptDeclaration) === 'function') {
					opts.scriptDeclaration(form, captcha_container);
				}
				
			});
		};
		
		/**
		 * Add new jQuery expression
		 */
		$.expr[':'].nextToLast = function(obj, ind, prop, node){
		     // if ind is 2 less than the length of the array of nodes, keep it
		     if (ind == node.length-2) {
		          return true;
		     } else {
		          // else, remove the node
		          return false;
		     }
		};
		
		/**
		 * Manage UI buttons
		 * 
		 * @param		submitElement
		 * @return		void
		 */
		function uiButtonsRoutine(submitElement) {
			// no UI
			if (submitElement.hasClass('ui-button') === false) return false;
			
			switch(submitElement.is(':disabled') ? 0 : 1) {
				case 0:
					submitElement.button('disable');
					break;
				case 1:
					submitElement.button('enable');
					break;
			}
		};
		
		/**
		 * PHP.js wrapper for "empty" function
		 * 
		 * @param mixed_var
		 * @return string
		 */
		function empty(mixed_var) {
			var key;if(mixed_var===""||mixed_var===0||mixed_var==="0"||mixed_var===null||mixed_var===false||typeof mixed_var==='undefined'){return true}if(typeof mixed_var=='object'){for(key in mixed_var){return false}return true}return false;
		};
		
	})(jQuery);
}