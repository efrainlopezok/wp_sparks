/**
 * wp-color-picker-alpha
 *
 * Overwrite Automattic Iris for enabled Alpha Channel in wpColorPicker
 * Only run in input and is defined data alpha in true
 *
 * Version: 2.1.3
 * https://github.com/kallookoo/wp-color-picker-alpha
 * Licensed under the GPLv2 license.
 */
!function(t){if(!t.wp.wpColorPicker.prototype._hasAlpha){var o="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==",r='<div class="wp-picker-holder" />',a='<div class="wp-picker-container" />',e='<input type="button" class="button button-small" />',i=void 0!==wpColorPickerL10n.current;if(i)var n='<a tabindex="0" class="wp-color-result" />';else{n='<button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text"></span></button>';var l="<label></label>",s='<span class="screen-reader-text"></span>'}Color.fn.toString=function(){if(this._alpha<1)return this.toCSS("rgba",this._alpha).replace(/\s+/g,"");var t=parseInt(this._color,10).toString(16);return this.error?"":(t.length<6&&(t=("00000"+t).substr(-6)),"#"+t)},t.widget("wp.wpColorPicker",t.wp.wpColorPicker,{_hasAlpha:!0,_create:function(){if(t.support.iris){var p=this,c=p.element;if(t.extend(p.options,c.data()),"hue"===p.options.type)return p._createHueOnly();p.close=t.proxy(p.close,p),p.initialValue=c.val(),c.addClass("wp-color-picker"),i?(c.hide().wrap(a),p.wrap=c.parent(),p.toggler=t(n).insertBefore(c).css({backgroundColor:p.initialValue}).attr("title",wpColorPickerL10n.pick).attr("data-current",wpColorPickerL10n.current),p.pickerContainer=t(r).insertAfter(c),p.button=t(e).addClass("hidden")):(c.parent("label").length||(c.wrap(l),p.wrappingLabelText=t(s).insertBefore(c).text(wpColorPickerL10n.defaultLabel)),p.wrappingLabel=c.parent(),p.wrappingLabel.wrap(a),p.wrap=p.wrappingLabel.parent(),p.toggler=t(n).insertBefore(p.wrappingLabel).css({backgroundColor:p.initialValue}),p.toggler.find(".wp-color-result-text").text(wpColorPickerL10n.pick),p.pickerContainer=t(r).insertAfter(p.wrappingLabel),p.button=t(e)),p.options.defaultColor?(p.button.addClass("wp-picker-default").val(wpColorPickerL10n.defaultString),i||p.button.attr("aria-label",wpColorPickerL10n.defaultAriaLabel)):(p.button.addClass("wp-picker-clear").val(wpColorPickerL10n.clear),i||p.button.attr("aria-label",wpColorPickerL10n.clearAriaLabel)),i?c.wrap('<span class="wp-picker-input-wrap" />').after(p.button):(p.wrappingLabel.wrap('<span class="wp-picker-input-wrap hidden" />').after(p.button),p.inputWrapper=c.closest(".wp-picker-input-wrap")),c.iris({target:p.pickerContainer,hide:p.options.hide,width:p.options.width,mode:p.options.mode,palettes:p.options.palettes,change:function(r,a){p.options.alpha?(p.toggler.css({"background-image":"url("+o+")"}),i?p.toggler.html('<span class="color-alpha" />'):(p.toggler.css({position:"relative"}),0==p.toggler.find("span.color-alpha").length&&p.toggler.append('<span class="color-alpha" />')),p.toggler.find("span.color-alpha").css({width:"30px",height:"24px",position:"absolute",top:0,left:0,"border-top-left-radius":"2px","border-bottom-left-radius":"2px",background:a.color.toString()})):p.toggler.css({backgroundColor:a.color.toString()}),t.isFunction(p.options.change)&&p.options.change.call(this,r,a)}}),c.val(p.initialValue),p._addListeners(),p.options.hide||p.toggler.click()}},_addListeners:function(){var o=this;o.wrap.on("click.wpcolorpicker",function(t){t.stopPropagation()}),o.toggler.click(function(){o.toggler.hasClass("wp-picker-open")?o.close():o.open()}),o.element.on("change",function(r){(""===t(this).val()||o.element.hasClass("iris-error"))&&(o.options.alpha?(i&&o.toggler.removeAttr("style"),o.toggler.find("span.color-alpha").css("backgroundColor","")):o.toggler.css("backgroundColor",""),t.isFunction(o.options.clear)&&o.options.clear.call(this,r))}),o.button.on("click",function(r){t(this).hasClass("wp-picker-clear")?(o.element.val(""),o.options.alpha?(i&&o.toggler.removeAttr("style"),o.toggler.find("span.color-alpha").css("backgroundColor","")):o.toggler.css("backgroundColor",""),t.isFunction(o.options.clear)&&o.options.clear.call(this,r)):t(this).hasClass("wp-picker-default")&&o.element.val(o.options.defaultColor).change()})}}),t.widget("a8c.iris",t.a8c.iris,{_create:function(){if(this._super(),this.options.alpha=this.element.data("alpha")||!1,this.element.is(":input")||(this.options.alpha=!1),void 0!==this.options.alpha&&this.options.alpha){var o=this,r=o.element,a=t('<div class="iris-strip iris-slider iris-alpha-slider"><div class="iris-slider-offset iris-slider-offset-alpha"></div></div>').appendTo(o.picker.find(".iris-picker-inner")),e={aContainer:a,aSlider:a.find(".iris-slider-offset-alpha")};void 0!==r.data("custom-width")?o.options.customWidth=parseInt(r.data("custom-width"))||0:o.options.customWidth=100,o.options.defaultWidth=r.width(),(o._color._alpha<1||-1!=o._color.toString().indexOf("rgb"))&&r.width(parseInt(o.options.defaultWidth+o.options.customWidth)),t.each(e,function(t,r){o.controls[t]=r}),o.controls.square.css({"margin-right":"0"});var i=o.picker.width()-o.controls.square.width()-20,n=i/6,l=i/2-n;t.each(["aContainer","strip"],function(t,r){o.controls[r].width(l).css({"margin-left":n+"px"})}),o._initControls(),o._change()}},_initControls:function(){if(this._super(),this.options.alpha){var t=this;t.controls.aSlider.slider({orientation:"vertical",min:0,max:100,step:1,value:parseInt(100*t._color._alpha),slide:function(o,r){t._color._alpha=parseFloat(r.value/100),t._change.apply(t,arguments)}})}},_change:function(){this._super();var t=this,r=t.element;if(this.options.alpha){var a=t.controls,e=parseInt(100*t._color._alpha),i=t._color.toRgb(),n=["rgb("+i.r+","+i.g+","+i.b+") 0%","rgba("+i.r+","+i.g+","+i.b+", 0) 100%"],l=t.options.defaultWidth,s=t.options.customWidth,p=t.picker.closest(".wp-picker-container").find(".wp-color-result");a.aContainer.css({background:"linear-gradient(to bottom, "+n.join(", ")+"), url("+o+")"}),p.hasClass("wp-picker-open")&&(a.aSlider.slider("value",e),t._color._alpha<1?(a.strip.attr("style",a.strip.attr("style").replace(/rgba\(([0-9]+,)(\s+)?([0-9]+,)(\s+)?([0-9]+)(,(\s+)?[0-9\.]+)\)/g,"rgb($1$3$5)")),r.width(parseInt(l+s))):r.width(l))}(r.data("reset-alpha")||!1)&&t.picker.find(".iris-palette-container").on("click.palette",".iris-palette",function(){t._color._alpha=1,t.active="external",t._change()})},_addInputListeners:function(t){var o=this,r=function(r){var a=new Color(t.val()),e=t.val();t.removeClass("iris-error"),a.error?""!==e&&t.addClass("iris-error"):a.toString()!==o._color.toString()&&("keyup"===r.type&&e.match(/^[0-9a-fA-F]{3}$/)||o._setOption("color",a.toString()))};t.on("change",r).on("keyup",o._debounce(r,100)),o.options.hide&&t.on("focus",function(){o.show()})}})}}(jQuery);

/**
 * mfnFieldColor
 */

(function($) {

  /* globals jQuery */

  "use strict";

  /**
   * $(document).ready
   * Specify a function to execute when the DOM is fully loaded.
   */

  $(function($) {

    $( 'input.has-colorpicker' ).wpColorPicker({
    	mode	: 'hsl',
    	width	: 275
    });

  });

})(jQuery);
