/*! jQuery Validation Plugin - v1.11.1 - 3/22/2013\n* https://github.com/jzaefferer/jquery-validation
* Copyright (c) 2013 Jörn Zaefferer; Licensed MIT */(function(t){t.extend(t.fn,{validate:function(e){if(!this.length)return e&&e.debug&&window.console&&console.warn("Nothing selected, can't validate, returning nothing."),void 0;var i=t.data(this[0],"validator");return i?i:(this.attr("novalidate","novalidate"),i=new t.validator(e,this[0]),t.data(this[0],"validator",i),i.settings.onsubmit&&(this.validateDelegate(":submit","click",function(e){i.settings.submitHandler&&(i.submitButton=e.target),t(e.target).hasClass("cancel")&&(i.cancelSubmit=!0),void 0!==t(e.target).attr("formnovalidate")&&(i.cancelSubmit=!0)}),this.submit(function(e){function s(){var s;return i.settings.submitHandler?(i.submitButton&&(s=t("<input type='hidden'/>").attr("name",i.submitButton.name).val(t(i.submitButton).val()).appendTo(i.currentForm)),i.settings.submitHandler.call(i,i.currentForm,e),i.submitButton&&s.remove(),!1):!0}return i.settings.debug&&e.preventDefault(),i.cancelSubmit?(i.cancelSubmit=!1,s()):i.form()?i.pendingRequest?(i.formSubmitted=!0,!1):s():(i.focusInvalid(),!1)})),i)},valid:function(){if(t(this[0]).is("form"))return this.validate().form();var e=!0,i=t(this[0].form).validate();return this.each(function(){e=e&&i.element(this)}),e},removeAttrs:function(e){var i={},s=this;return t.each(e.split(/\s/),function(t,e){i[e]=s.attr(e),s.removeAttr(e)}),i},rules:function(e,i){var s=this[0];if(e){var r=t.data(s.form,"validator").settings,n=r.rules,a=t.validator.staticRules(s);switch(e){case"add":t.extend(a,t.validator.normalizeRule(i)),delete a.messages,n[s.name]=a,i.messages&&(r.messages[s.name]=t.extend(r.messages[s.name],i.messages));break;case"remove":if(!i)return delete n[s.name],a;var u={};return t.each(i.split(/\s/),function(t,e){u[e]=a[e],delete a[e]}),u}}var o=t.validator.normalizeRules(t.extend({},t.validator.classRules(s),t.validator.attributeRules(s),t.validator.dataRules(s),t.validator.staticRules(s)),s);if(o.required){var l=o.required;delete o.required,o=t.extend({required:l},o)}return o}}),t.extend(t.expr[":"],{blank:function(e){return!t.trim(""+t(e).val())},filled:function(e){return!!t.trim(""+t(e).val())},unchecked:function(e){return!t(e).prop("checked")}}),t.validator=function(e,i){this.settings=t.extend(!0,{},t.validator.defaults,e),this.currentForm=i,this.init()},t.validator.format=function(e,i){return 1===arguments.length?function(){var i=t.makeArray(arguments);return i.unshift(e),t.validator.format.apply(this,i)}:(arguments.length>2&&i.constructor!==Array&&(i=t.makeArray(arguments).slice(1)),i.constructor!==Array&&(i=[i]),t.each(i,function(t,i){e=e.replace(RegExp("\\{"+t+"\\}","g"),function(){return i})}),e)},t.extend(t.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",validClass:"valid",errorElement:"label",focusInvalid:!0,errorContainer:t([]),errorLabelContainer:t([]),onsubmit:!0,ignore:":hidden",ignoreTitle:!1,onfocusin:function(t){this.lastActive=t,this.settings.focusCleanup&&!this.blockFocusCleanup&&(this.settings.unhighlight&&this.settings.unhighlight.call(this,t,this.settings.errorClass,this.settings.validClass),this.addWrapper(this.errorsFor(t)).hide())},onfocusout:function(t){this.checkable(t)||!(t.name in this.submitted)&&this.optional(t)||this.element(t)},onkeyup:function(t,e){(9!==e.which||""!==this.elementValue(t))&&(t.name in this.submitted||t===this.lastElement)&&this.element(t)},onclick:function(t){t.name in this.submitted?this.element(t):t.parentNode.name in this.submitted&&this.element(t.parentNode)},highlight:function(e,i,s){"radio"===e.type?this.findByName(e.name).addClass(i).removeClass(s):t(e).addClass(i).removeClass(s)},unhighlight:function(e,i,s){"radio"===e.type?this.findByName(e.name).removeClass(i).addClass(s):t(e).removeClass(i).addClass(s)}},setDefaults:function(e){t.extend(t.validator.defaults,e)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",creditcard:"Please enter a valid credit card number.",equalTo:"Please enter the same value again.",maxlength:t.validator.format("Please enter no more than {0} characters."),minlength:t.validator.format("Please enter at least {0} characters."),rangelength:t.validator.format("Please enter a value between {0} and {1} characters long."),range:t.validator.format("Please enter a value between {0} and {1}."),max:t.validator.format("Please enter a value less than or equal to {0}."),min:t.validator.format("Please enter a value greater than or equal to {0}.")},autoCreateRanges:!1,prototype:{init:function(){function e(e){var i=t.data(this[0].form,"validator"),s="on"+e.type.replace(/^validate/,"");i.settings[s]&&i.settings[s].call(i,this[0],e)}this.labelContainer=t(this.settings.errorLabelContainer),this.errorContext=this.labelContainer.length&&this.labelContainer||t(this.currentForm),this.containers=t(this.settings.errorContainer).add(this.settings.errorLabelContainer),this.submitted={},this.valueCache={},this.pendingRequest=0,this.pending={},this.invalid={},this.reset();var i=this.groups={};t.each(this.settings.groups,function(e,s){"string"==typeof s&&(s=s.split(/\s/)),t.each(s,function(t,s){i[s]=e})});var s=this.settings.rules;t.each(s,function(e,i){s[e]=t.validator.normalizeRule(i)}),t(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ","focusin focusout keyup",e).validateDelegate("[type='radio'], [type='checkbox'], select, option","click",e),this.settings.invalidHandler&&t(this.currentForm).bind("invalid-form.validate",this.settings.invalidHandler)},form:function(){return this.checkForm(),t.extend(this.submitted,this.errorMap),this.invalid=t.extend({},this.errorMap),this.valid()||t(this.currentForm).triggerHandler("invalid-form",[this]),this.showErrors(),this.valid()},checkForm:function(){this.prepareForm();for(var t=0,e=this.currentElements=this.elements();e[t];t++)this.check(e[t]);return this.valid()},element:function(e){e=this.validationTargetFor(this.clean(e)),this.lastElement=e,this.prepareElement(e),this.currentElements=t(e);var i=this.check(e)!==!1;return i?delete this.invalid[e.name]:this.invalid[e.name]=!0,this.numberOfInvalids()||(this.toHide=this.toHide.add(this.containers)),this.showErrors(),i},showErrors:function(e){if(e){t.extend(this.errorMap,e),this.errorList=[];for(var i in e)this.errorList.push({message:e[i],element:this.findByName(i)[0]});this.successList=t.grep(this.successList,function(t){return!(t.name in e)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){t.fn.resetForm&&t(this.currentForm).resetForm(),this.submitted={},this.lastElement=null,this.prepareForm(),this.hideErrors(),this.elements().removeClass(this.settings.errorClass).removeData("previousValue")},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(t){var e=0;for(var i in t)e++;return e},hideErrors:function(){this.addWrapper(this.toHide).hide()},valid:function(){return 0===this.size()},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{t(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").focus().trigger("focusin")}catch(e){}},findLastActive:function(){var e=this.lastActive;return e&&1===t.grep(this.errorList,function(t){return t.element.name===e.name}).length&&e},elements:function(){var e=this,i={};return t(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function(){return!this.name&&e.settings.debug&&window.console&&console.error("%o has no name assigned",this),this.name in i||!e.objectLength(t(this).rules())?!1:(i[this.name]=!0,!0)})},clean:function(e){return t(e)[0]},errors:function(){var e=this.settings.errorClass.replace(" ",".");return t(this.settings.errorElement+"."+e,this.errorContext)},reset:function(){this.successList=[],this.errorList=[],this.errorMap={},this.toShow=t([]),this.toHide=t([]),this.currentElements=t([])},prepareForm:function(){this.reset(),this.toHide=this.errors().add(this.containers)},prepareElement:function(t){this.reset(),this.toHide=this.errorsFor(t)},elementValue:function(e){var i=t(e).attr("type"),s=t(e).val();return"radio"===i||"checkbox"===i?t("input[name='"+t(e).attr("name")+"']:checked").val():"string"==typeof s?s.replace(/\r/g,""):s},check:function(e){e=this.validationTargetFor(this.clean(e));var i,s=t(e).rules(),r=!1,n=this.elementValue(e);for(var a in s){var u={method:a,parameters:s[a]};try{if(i=t.validator.methods[a].call(this,n,e,u.parameters),"dependency-mismatch"===i){r=!0;continue}if(r=!1,"pending"===i)return this.toHide=this.toHide.not(this.errorsFor(e)),void 0;if(!i)return this.formatAndAdd(e,u),!1}catch(o){throw this.settings.debug&&window.console&&console.log("Exception occurred when checking element "+e.id+", check the '"+u.method+"' method.",o),o}}return r?void 0:(this.objectLength(s)&&this.successList.push(e),!0)},customDataMessage:function(e,i){return t(e).data("msg-"+i.toLowerCase())||e.attributes&&t(e).attr("data-msg-"+i.toLowerCase())},customMessage:function(t,e){var i=this.settings.messages[t];return i&&(i.constructor===String?i:i[e])},findDefined:function(){for(var t=0;arguments.length>t;t++)if(void 0!==arguments[t])return arguments[t];return void 0},defaultMessage:function(e,i){return this.findDefined(this.customMessage(e.name,i),this.customDataMessage(e,i),!this.settings.ignoreTitle&&e.title||void 0,t.validator.messages[i],"<strong>Warning: No message defined for "+e.name+"</strong>")},formatAndAdd:function(e,i){var s=this.defaultMessage(e,i.method),r=/\$?\{(\d+)\}/g;"function"==typeof s?s=s.call(this,i.parameters,e):r.test(s)&&(s=t.validator.format(s.replace(r,"{$1}"),i.parameters)),this.errorList.push({message:s,element:e}),this.errorMap[e.name]=s,this.submitted[e.name]=s},addWrapper:function(t){return this.settings.wrapper&&(t=t.add(t.parent(this.settings.wrapper))),t},defaultShowErrors:function(){var t,e;for(t=0;this.errorList[t];t++){var i=this.errorList[t];this.settings.highlight&&this.settings.highlight.call(this,i.element,this.settings.errorClass,this.settings.validClass),this.showLabel(i.element,i.message)}if(this.errorList.length&&(this.toShow=this.toShow.add(this.containers)),this.settings.success)for(t=0;this.successList[t];t++)this.showLabel(this.successList[t]);if(this.settings.unhighlight)for(t=0,e=this.validElements();e[t];t++)this.settings.unhighlight.call(this,e[t],this.settings.errorClass,this.settings.validClass);this.toHide=this.toHide.not(this.toShow),this.hideErrors(),this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return t(this.errorList).map(function(){return this.element})},showLabel:function(e,i){var s=this.errorsFor(e);s.length?(s.removeClass(this.settings.validClass).addClass(this.settings.errorClass),s.html(i)):(s=t("<"+this.settings.errorElement+">").attr("for",this.idOrName(e)).addClass(this.settings.errorClass).html(i||""),this.settings.wrapper&&(s=s.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()),this.labelContainer.append(s).length||(this.settings.errorPlacement?this.settings.errorPlacement(s,t(e)):s.insertAfter(e))),!i&&this.settings.success&&(s.text(""),"string"==typeof this.settings.success?s.addClass(this.settings.success):this.settings.success(s,e)),this.toShow=this.toShow.add(s)},errorsFor:function(e){var i=this.idOrName(e);return this.errors().filter(function(){return t(this).attr("for")===i})},idOrName:function(t){return this.groups[t.name]||(this.checkable(t)?t.name:t.id||t.name)},validationTargetFor:function(t){return this.checkable(t)&&(t=this.findByName(t.name).not(this.settings.ignore)[0]),t},checkable:function(t){return/radio|checkbox/i.test(t.type)},findByName:function(e){return t(this.currentForm).find("[name='"+e+"']")},getLength:function(e,i){switch(i.nodeName.toLowerCase()){case"select":return t("option:selected",i).length;case"input":if(this.checkable(i))return this.findByName(i.name).filter(":checked").length}return e.length},depend:function(t,e){return this.dependTypes[typeof t]?this.dependTypes[typeof t](t,e):!0},dependTypes:{"boolean":function(t){return t},string:function(e,i){return!!t(e,i.form).length},"function":function(t,e){return t(e)}},optional:function(e){var i=this.elementValue(e);return!t.validator.methods.required.call(this,i,e)&&"dependency-mismatch"},startRequest:function(t){this.pending[t.name]||(this.pendingRequest++,this.pending[t.name]=!0)},stopRequest:function(e,i){this.pendingRequest--,0>this.pendingRequest&&(this.pendingRequest=0),delete this.pending[e.name],i&&0===this.pendingRequest&&this.formSubmitted&&this.form()?(t(this.currentForm).submit(),this.formSubmitted=!1):!i&&0===this.pendingRequest&&this.formSubmitted&&(t(this.currentForm).triggerHandler("invalid-form",[this]),this.formSubmitted=!1)},previousValue:function(e){return t.data(e,"previousValue")||t.data(e,"previousValue",{old:null,valid:!0,message:this.defaultMessage(e,"remote")})}},classRuleSettings:{required:{required:!0},email:{email:!0},url:{url:!0},date:{date:!0},dateISO:{dateISO:!0},number:{number:!0},digits:{digits:!0},creditcard:{creditcard:!0}},addClassRules:function(e,i){e.constructor===String?this.classRuleSettings[e]=i:t.extend(this.classRuleSettings,e)},classRules:function(e){var i={},s=t(e).attr("class");return s&&t.each(s.split(" "),function(){this in t.validator.classRuleSettings&&t.extend(i,t.validator.classRuleSettings[this])}),i},attributeRules:function(e){var i={},s=t(e),r=s[0].getAttribute("type");for(var n in t.validator.methods){var a;"required"===n?(a=s.get(0).getAttribute(n),""===a&&(a=!0),a=!!a):a=s.attr(n),/min|max/.test(n)&&(null===r||/number|range|text/.test(r))&&(a=Number(a)),a?i[n]=a:r===n&&"range"!==r&&(i[n]=!0)}return i.maxlength&&/-1|2147483647|524288/.test(i.maxlength)&&delete i.maxlength,i},dataRules:function(e){var i,s,r={},n=t(e);for(i in t.validator.methods)s=n.data("rule-"+i.toLowerCase()),void 0!==s&&(r[i]=s);return r},staticRules:function(e){var i={},s=t.data(e.form,"validator");return s.settings.rules&&(i=t.validator.normalizeRule(s.settings.rules[e.name])||{}),i},normalizeRules:function(e,i){return t.each(e,function(s,r){if(r===!1)return delete e[s],void 0;if(r.param||r.depends){var n=!0;switch(typeof r.depends){case"string":n=!!t(r.depends,i.form).length;break;case"function":n=r.depends.call(i,i)}n?e[s]=void 0!==r.param?r.param:!0:delete e[s]}}),t.each(e,function(s,r){e[s]=t.isFunction(r)?r(i):r}),t.each(["minlength","maxlength"],function(){e[this]&&(e[this]=Number(e[this]))}),t.each(["rangelength","range"],function(){var i;e[this]&&(t.isArray(e[this])?e[this]=[Number(e[this][0]),Number(e[this][1])]:"string"==typeof e[this]&&(i=e[this].split(/[\s,]+/),e[this]=[Number(i[0]),Number(i[1])]))}),t.validator.autoCreateRanges&&(e.min&&e.max&&(e.range=[e.min,e.max],delete e.min,delete e.max),e.minlength&&e.maxlength&&(e.rangelength=[e.minlength,e.maxlength],delete e.minlength,delete e.maxlength)),e},normalizeRule:function(e){if("string"==typeof e){var i={};t.each(e.split(/\s/),function(){i[this]=!0}),e=i}return e},addMethod:function(e,i,s){t.validator.methods[e]=i,t.validator.messages[e]=void 0!==s?s:t.validator.messages[e],3>i.length&&t.validator.addClassRules(e,t.validator.normalizeRule(e))},methods:{required:function(e,i,s){if(!this.depend(s,i))return"dependency-mismatch";if("select"===i.nodeName.toLowerCase()){var r=t(i).val();return r&&r.length>0}return this.checkable(i)?this.getLength(e,i)>0:t.trim(e).length>0},email:function(t,e){return this.optional(e)||/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(t)},url:function(t,e){return this.optional(e)||/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(t)},date:function(t,e){return this.optional(e)||!/Invalid|NaN/.test(""+new Date(t))},dateISO:function(t,e){return this.optional(e)||/^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(t)},number:function(t,e){return this.optional(e)||/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(t)},digits:function(t,e){return this.optional(e)||/^\d+$/.test(t)},creditcard:function(t,e){if(this.optional(e))return"dependency-mismatch";if(/[^0-9 \-]+/.test(t))return!1;var i=0,s=0,r=!1;t=t.replace(/\D/g,"");for(var n=t.length-1;n>=0;n--){var a=t.charAt(n);s=parseInt(a,10),r&&(s*=2)>9&&(s-=9),i+=s,r=!r}return 0===i%10},minlength:function(e,i,s){var r=t.isArray(e)?e.length:this.getLength(t.trim(e),i);return this.optional(i)||r>=s},maxlength:function(e,i,s){var r=t.isArray(e)?e.length:this.getLength(t.trim(e),i);return this.optional(i)||s>=r},rangelength:function(e,i,s){var r=t.isArray(e)?e.length:this.getLength(t.trim(e),i);return this.optional(i)||r>=s[0]&&s[1]>=r},min:function(t,e,i){return this.optional(e)||t>=i},max:function(t,e,i){return this.optional(e)||i>=t},range:function(t,e,i){return this.optional(e)||t>=i[0]&&i[1]>=t},equalTo:function(e,i,s){var r=t(s);return this.settings.onfocusout&&r.unbind(".validate-equalTo").bind("blur.validate-equalTo",function(){t(i).valid()}),e===r.val()},remote:function(e,i,s){if(this.optional(i))return"dependency-mismatch";var r=this.previousValue(i);if(this.settings.messages[i.name]||(this.settings.messages[i.name]={}),r.originalMessage=this.settings.messages[i.name].remote,this.settings.messages[i.name].remote=r.message,s="string"==typeof s&&{url:s}||s,r.old===e)return r.valid;r.old=e;var n=this;this.startRequest(i);var a={};return a[i.name]=e,t.ajax(t.extend(!0,{url:s,mode:"abort",port:"validate"+i.name,dataType:"json",data:a,success:function(s){n.settings.messages[i.name].remote=r.originalMessage;var a=s===!0||"true"===s;if(a){var u=n.formSubmitted;n.prepareElement(i),n.formSubmitted=u,n.successList.push(i),delete n.invalid[i.name],n.showErrors()}else{var o={},l=s||n.defaultMessage(i,"remote");o[i.name]=r.message=t.isFunction(l)?l(e):l,n.invalid[i.name]=!0,n.showErrors(o)}r.valid=a,n.stopRequest(i,a)}},s)),"pending"}}}),t.format=t.validator.format})(jQuery),function(t){var e={};if(t.ajaxPrefilter)t.ajaxPrefilter(function(t,i,s){var r=t.port;"abort"===t.mode&&(e[r]&&e[r].abort(),e[r]=s)});else{var i=t.ajax;t.ajax=function(s){var r=("mode"in s?s:t.ajaxSettings).mode,n=("port"in s?s:t.ajaxSettings).port;return"abort"===r?(e[n]&&e[n].abort(),e[n]=i.apply(this,arguments),e[n]):i.apply(this,arguments)}}}(jQuery),function(t){t.extend(t.fn,{validateDelegate:function(e,i,s){return this.bind(i,function(i){var r=t(i.target);return r.is(e)?s.apply(r,arguments):void 0})}})}(jQuery);
/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: FR (French; français)
 */
(function ($) {
	$.extend($.validator.messages, {
		required: "Ce champ est obligatoire.",
		remote: "Veuillez corriger ce champ.",
		email: "Veuillez fournir une adresse électronique valide.",
		url: "Veuillez fournir une adresse URL valide.",
		date: "Veuillez fournir une date valide.",
		dateISO: "Veuillez fournir une date valide (ISO).",
		number: "Veuillez fournir un numéro valide.",
		digits: "Veuillez fournir seulement des chiffres.",
		creditcard: "Veuillez fournir un numéro de carte de crédit valide.",
		equalTo: "Veuillez fournir encore la même valeur.",
		accept: "Veuillez fournir une valeur avec une extension valide.",
		maxlength: $.validator.format("Veuillez fournir au plus {0} caractères."),
		minlength: $.validator.format("Veuillez fournir au moins {0} caractères."),
		rangelength: $.validator.format("Veuillez fournir une valeur qui contient entre {0} et {1} caractères."),
		range: $.validator.format("Veuillez fournir une valeur entre {0} et {1}."),
		max: $.validator.format("Veuillez fournir une valeur inférieur ou égal à {0}."),
		min: $.validator.format("Veuillez fournir une valeur supérieur ou égal à {0}."),
		maxWords: $.validator.format("Veuillez fournir au plus {0} mots."),
		minWords: $.validator.format("Veuillez fournir au moins {0} mots."),
		rangeWords: $.validator.format("Veuillez fournir entre {0} et {1} mots."),
		letterswithbasicpunc: "Veuillez fournir seulement des lettres et des signes de ponctuation.",
		alphanumeric: "Veuillez fournir seulement des lettres, nombres, espaces et soulignages",
		lettersonly: "Veuillez fournir seulement des lettres.",
		nowhitespace: "Veuillez ne pas inscrire d'espaces blancs.",
		ziprange: "Veuillez fournir un code postal entre 902xx-xxxx et 905-xx-xxxx.",
		integer: "Veuillez fournir un nombre non décimal qui est positif ou négatif.",
		vinUS: "Veuillez fournir un numéro d'identification du véhicule (VIN).",
		dateITA: "Veuillez fournir une date valide.",
		time: "Veuillez fournir une heure valide entre 00:00 et 23:59.",
		phoneUS: "Veuillez fournir un numéro de téléphone valide.",
		phoneUK: "Veuillez fournir un numéro de téléphone valide.",
		mobileUK: "Veuillez fournir un numéro de téléphone mobile valide.",
		strippedminlength: $.validator.format("Veuillez fournir au moins {0} caractères."),
		email2: "Veuillez fournir une adresse électronique valide.",
		url2: "Veuillez fournir une adresse URL valide.",
		creditcardtypes: "Veuillez fournir un numéro de carte de crédit valide.",
		ipv4: "Veuillez fournir une adresse IP v4 valide.",
		ipv6: "Veuillez fournir une adresse IP v6 valide.",
		require_from_group: "Veuillez fournir au moins {0} de ces champs."
	});
}(jQuery));
/*
 * jQuery Plugin: Tokenizing Autocomplete Text Entry
 * Version 1.6.0
 *
 * Copyright (c) 2009 James Smith (http://loopj.com)
 * Licensed jointly under the GPL and MIT licenses,
 * choose which one suits your project best!
 *
 */

(function ($) {
// Default settings
var DEFAULT_SETTINGS = {
	// Search settings
    method: "GET",
    contentType: "json",
    queryParam: "q",
    searchDelay: 300,
    minChars: 1,
    propertyToSearch: "name",
    jsonContainer: null,

	// Display settings
    hintText: "Type in a search term",
    noResultsText: "No results",
    searchingText: "Searching...",
    deleteText: "&times;",
    animateDropdown: true,

	// Tokenization settings
    tokenLimit: null,
    tokenDelimiter: ",",
    preventDuplicates: false,

	// Output settings
    tokenValue: "id",

	// Prepopulation settings
    prePopulate: null,
    processPrePopulate: false,

	// Manipulation settings
    idPrefix: "token-input-",

	// Formatters
    resultsFormatter: function(item){ return "<li>" + item[this.propertyToSearch]+ "</li>" },
    tokenFormatter: function(item) { return "<li><p>" + item[this.propertyToSearch] + "</p></li>" },

	// Callbacks
    onResult: null,
    onAdd: null,
    onDelete: null,
    onReady: null
};

// Default classes to use when theming
var DEFAULT_CLASSES = {
    tokenList: "token-input-list",
    token: "token-input-token",
    tokenDelete: "token-input-delete-token",
    selectedToken: "token-input-selected-token",
    highlightedToken: "token-input-highlighted-token",
    dropdown: "token-input-dropdown",
    dropdownItem: "token-input-dropdown-item",
    dropdownItem2: "token-input-dropdown-item2",
    selectedDropdownItem: "token-input-selected-dropdown-item",
    inputToken: "token-input-input-token"
};

// Input box position "enum"
var POSITION = {
    BEFORE: 0,
    AFTER: 1,
    END: 2
};

// Keys "enum"
var KEY = {
    BACKSPACE: 8,
    TAB: 9,
    ENTER: 13,
    ESCAPE: 27,
    SPACE: 32,
    PAGE_UP: 33,
    PAGE_DOWN: 34,
    END: 35,
    HOME: 36,
    LEFT: 37,
    UP: 38,
    RIGHT: 39,
    DOWN: 40,
    NUMPAD_ENTER: 108,
    COMMA: 188
};

// Additional public (exposed) methods
var methods = {
    init: function(url_or_data_or_function, options) {
        var settings = $.extend({}, DEFAULT_SETTINGS, options || {});

        return this.each(function () {
            $(this).data("tokenInputObject", new $.TokenList(this, url_or_data_or_function, settings));
        });
    },
    clear: function() {
        this.data("tokenInputObject").clear();
        return this;
    },
    add: function(item) {
        this.data("tokenInputObject").add(item);
        return this;
    },
    remove: function(item) {
        this.data("tokenInputObject").remove(item);
        return this;
    },
    get: function() {
    	return this.data("tokenInputObject").getTokens();
   	}
}

// Expose the .tokenInput function to jQuery as a plugin
$.fn.tokenInput = function (method) {
    // Method calling and initialization logic
    if(methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else {
        return methods.init.apply(this, arguments);
    }
};

// TokenList class for each input
$.TokenList = function (input, url_or_data, settings) {
    //
    // Initialization
    //

    // Configure the data source
    if($.type(url_or_data) === "string" || $.type(url_or_data) === "function") {
        // Set the url to query against
        settings.url = url_or_data;

        // If the URL is a function, evaluate it here to do our initalization work
        var url = computeURL();

        // Make a smart guess about cross-domain if it wasn't explicitly specified
        if(settings.crossDomain === undefined) {
            if(url.indexOf("://") === -1) {
                settings.crossDomain = false;
            } else {
                settings.crossDomain = (location.href.split(/\/+/g)[1] !== url.split(/\/+/g)[1]);
            }
        }
    } else if(typeof(url_or_data) === "object") {
        // Set the local data to search through
        settings.local_data = url_or_data;
    }

    // Build class names
    if(settings.classes) {
        // Use custom class names
        settings.classes = $.extend({}, DEFAULT_CLASSES, settings.classes);
    } else if(settings.theme) {
        // Use theme-suffixed default class names
        settings.classes = {};
        $.each(DEFAULT_CLASSES, function(key, value) {
            settings.classes[key] = value + "-" + settings.theme;
        });
    } else {
        settings.classes = DEFAULT_CLASSES;
    }


    // Save the tokens
    var saved_tokens = [];

    // Keep track of the number of tokens in the list
    var token_count = 0;

    // Basic cache to save on db hits
    var cache = new $.TokenList.Cache();

    // Keep track of the timeout, old vals
    var timeout;
    var input_val;

    // Create a new text input an attach keyup events
    var input_box = $("<input type=\"text\"  autocomplete=\"off\">")
        .css({
            outline: "none"
        })
        .attr("id", settings.idPrefix + input.id)
        .focus(function () {
            if (settings.tokenLimit === null || settings.tokenLimit !== token_count) {
                show_dropdown_hint();
            }
        })
        .blur(function () {
            hide_dropdown();
            $(this).val("");
        })
        .bind("keyup keydown blur update", resize_input)
        .keydown(function (event) {
            var previous_token;
            var next_token;

            switch(event.keyCode) {
                case KEY.LEFT:
                case KEY.RIGHT:
                case KEY.UP:
                case KEY.DOWN:
                    if(!$(this).val()) {
                        previous_token = input_token.prev();
                        next_token = input_token.next();

                        if((previous_token.length && previous_token.get(0) === selected_token) || (next_token.length && next_token.get(0) === selected_token)) {
                            // Check if there is a previous/next token and it is selected
                            if(event.keyCode === KEY.LEFT || event.keyCode === KEY.UP) {
                                deselect_token($(selected_token), POSITION.BEFORE);
                            } else {
                                deselect_token($(selected_token), POSITION.AFTER);
                            }
                        } else if((event.keyCode === KEY.LEFT || event.keyCode === KEY.UP) && previous_token.length) {
                            // We are moving left, select the previous token if it exists
                            select_token($(previous_token.get(0)));
                        } else if((event.keyCode === KEY.RIGHT || event.keyCode === KEY.DOWN) && next_token.length) {
                            // We are moving right, select the next token if it exists
                            select_token($(next_token.get(0)));
                        }
                    } else {
                        var dropdown_item = null;

                        if(event.keyCode === KEY.DOWN || event.keyCode === KEY.RIGHT) {
                            dropdown_item = $(selected_dropdown_item).next();
                        } else {
                            dropdown_item = $(selected_dropdown_item).prev();
                        }

                        if(dropdown_item.length) {
                            select_dropdown_item(dropdown_item);
                        }
                        return false;
                    }
                    break;

                case KEY.BACKSPACE:
                    previous_token = input_token.prev();

                    if(!$(this).val().length) {
                        if(selected_token) {
                            delete_token($(selected_token));
                            hidden_input.change();
                        } else if(previous_token.length) {
                            select_token($(previous_token.get(0)));
                        }

                        return false;
                    } else if($(this).val().length === 1) {
                        hide_dropdown();
                    } else {
                        // set a timeout just long enough to let this function finish.
                        setTimeout(function(){do_search();}, 5);
                    }
                    break;

                case KEY.TAB:
                case KEY.ENTER:
                case KEY.NUMPAD_ENTER:
                case KEY.COMMA:
                  if(selected_dropdown_item) {
                    add_token($(selected_dropdown_item).data("tokeninput"));
                    hidden_input.change();
                    return false;
                  }
                  break;

                case KEY.ESCAPE:
                  hide_dropdown();
                  return true;

                default:
                    if(String.fromCharCode(event.which)) {
                        // set a timeout just long enough to let this function finish.
                        setTimeout(function(){do_search();}, 5);
                    }
                    break;
            }
        });

    // Keep a reference to the original input box
    var hidden_input = $(input)
                           .hide()
                           .val("")
                           .focus(function () {
                               input_box.focus();
                           })
                           .blur(function () {
                               input_box.blur();
                           });

    // Keep a reference to the selected token and dropdown item
    var selected_token = null;
    var selected_token_index = 0;
    var selected_dropdown_item = null;

    // The list to store the token items in
    var token_list = $("<ul />")
        .addClass(settings.classes.tokenList)
        .click(function (event) {
            var li = $(event.target).closest("li");
            if(li && li.get(0) && $.data(li.get(0), "tokeninput")) {
                toggle_select_token(li);
            } else {
                // Deselect selected token
                if(selected_token) {
                    deselect_token($(selected_token), POSITION.END);
                }

                // Focus input box
                input_box.focus();
            }
        })
        .mouseover(function (event) {
            var li = $(event.target).closest("li");
            if(li && selected_token !== this) {
                li.addClass(settings.classes.highlightedToken);
            }
        })
        .mouseout(function (event) {
            var li = $(event.target).closest("li");
            if(li && selected_token !== this) {
                li.removeClass(settings.classes.highlightedToken);
            }
        })
        .insertBefore(hidden_input);

    // The token holding the input box
    var input_token = $("<li />")
        .addClass(settings.classes.inputToken)
        .appendTo(token_list)
        .append(input_box);

    // The list to store the dropdown items in
    var dropdown = $("<div>")
        .addClass(settings.classes.dropdown)
        .appendTo("body")
        .hide();

    // Magic element to help us resize the text input
    var input_resizer = $("<tester/>")
        .insertAfter(input_box)
        .css({
            position: "absolute",
            top: -9999,
            left: -9999,
            width: "auto",
            fontSize: input_box.css("fontSize"),
            fontFamily: input_box.css("fontFamily"),
            fontWeight: input_box.css("fontWeight"),
            letterSpacing: input_box.css("letterSpacing"),
            whiteSpace: "nowrap"
        });

    // Pre-populate list if items exist
    hidden_input.val("");
    var li_data = settings.prePopulate || hidden_input.data("pre");
    if(settings.processPrePopulate && $.isFunction(settings.onResult)) {
        li_data = settings.onResult.call(hidden_input, li_data);
    }
    if(li_data && li_data.length) {
        $.each(li_data, function (index, value) {
            insert_token(value);
            checkTokenLimit();
        });
    }

    // Initialization is done
    if($.isFunction(settings.onReady)) {
        settings.onReady.call();
    }

    //
    // Public functions
    //

    this.clear = function() {
        token_list.children("li").each(function() {
            if ($(this).children("input").length === 0) {
                delete_token($(this));
            }
        });
    }

    this.add = function(item) {
        add_token(item);
    }

    this.remove = function(item) {
        token_list.children("li").each(function() {
            if ($(this).children("input").length === 0) {
                var currToken = $(this).data("tokeninput");
                var match = true;
                for (var prop in item) {
                    if (item[prop] !== currToken[prop]) {
                        match = false;
                        break;
                    }
                }
                if (match) {
                    delete_token($(this));
                }
            }
        });
    }
    
    this.getTokens = function() {
   		return saved_tokens;
   	}

    //
    // Private functions
    //

    function checkTokenLimit() {
        if(settings.tokenLimit !== null && token_count >= settings.tokenLimit) {
            input_box.hide();
            hide_dropdown();
            return;
        }
    }

    function resize_input() {
        if(input_val === (input_val = input_box.val())) {return;}

        // Enter new content into resizer and resize input accordingly
        var escaped = input_val.replace(/&/g, '&amp;').replace(/\s/g,' ').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        input_resizer.html(escaped);
        input_box.width(input_resizer.width() + 30);
    }

    function is_printable_character(keycode) {
        return ((keycode >= 48 && keycode <= 90) ||     // 0-1a-z
                (keycode >= 96 && keycode <= 111) ||    // numpad 0-9 + - / * .
                (keycode >= 186 && keycode <= 192) ||   // ; = , - . / ^
                (keycode >= 219 && keycode <= 222));    // ( \ ) '
    }

    // Inner function to a token to the list
    function insert_token(item) {
        var this_token = settings.tokenFormatter(item);
        this_token = $(this_token)
          .addClass(settings.classes.token)
          .insertBefore(input_token);

        // The 'delete token' button
        $("<span>" + settings.deleteText + "</span>")
            .addClass(settings.classes.tokenDelete)
            .appendTo(this_token)
            .click(function () {
                delete_token($(this).parent());
                hidden_input.change();
                return false;
            });

        // Store data on the token
        var token_data = {"id": item.id};
        token_data[settings.propertyToSearch] = item[settings.propertyToSearch];
        $.data(this_token.get(0), "tokeninput", item);

        // Save this token for duplicate checking
        saved_tokens = saved_tokens.slice(0,selected_token_index).concat([token_data]).concat(saved_tokens.slice(selected_token_index));
        selected_token_index++;

        // Update the hidden input
        update_hidden_input(saved_tokens, hidden_input);

        token_count += 1;

        // Check the token limit
        if(settings.tokenLimit !== null && token_count >= settings.tokenLimit) {
            input_box.hide();
            hide_dropdown();
        }

        return this_token;
    }

    // Add a token to the token list based on user input
    function add_token (item) {
        var callback = settings.onAdd;

        // See if the token already exists and select it if we don't want duplicates
        if(token_count > 0 && settings.preventDuplicates) {
            var found_existing_token = null;
            token_list.children().each(function () {
                var existing_token = $(this);
                var existing_data = $.data(existing_token.get(0), "tokeninput");
                if(existing_data && existing_data.id === item.id) {
                    found_existing_token = existing_token;
                    return false;
                }
            });

            if(found_existing_token) {
                select_token(found_existing_token);
                input_token.insertAfter(found_existing_token);
                input_box.focus();
                return;
            }
        }

        // Insert the new tokens
        if(settings.tokenLimit == null || token_count < settings.tokenLimit) {
            insert_token(item);
            checkTokenLimit();
        }

        // Clear input box
        input_box.val("");

        // Don't show the help dropdown, they've got the idea
        hide_dropdown();

        // Execute the onAdd callback if defined
        if($.isFunction(callback)) {
            callback.call(hidden_input,item);
        }
    }

    // Select a token in the token list
    function select_token (token) {
        token.addClass(settings.classes.selectedToken);
        selected_token = token.get(0);

        // Hide input box
        input_box.val("");

        // Hide dropdown if it is visible (eg if we clicked to select token)
        hide_dropdown();
    }

    // Deselect a token in the token list
    function deselect_token (token, position) {
        token.removeClass(settings.classes.selectedToken);
        selected_token = null;

        if(position === POSITION.BEFORE) {
            input_token.insertBefore(token);
            selected_token_index--;
        } else if(position === POSITION.AFTER) {
            input_token.insertAfter(token);
            selected_token_index++;
        } else {
            input_token.appendTo(token_list);
            selected_token_index = token_count;
        }

        // Show the input box and give it focus again
        input_box.focus();
    }

    // Toggle selection of a token in the token list
    function toggle_select_token(token) {
        var previous_selected_token = selected_token;

        if(selected_token) {
            deselect_token($(selected_token), POSITION.END);
        }

        if(previous_selected_token === token.get(0)) {
            deselect_token(token, POSITION.END);
        } else {
            select_token(token);
        }
    }

    // Delete a token from the token list
    function delete_token (token) {
        // Remove the id from the saved list
        var token_data = $.data(token.get(0), "tokeninput");
        var callback = settings.onDelete;

        var index = token.prevAll().length;
        if(index > selected_token_index) index--;

        // Delete the token
        token.remove();
        selected_token = null;

        // Show the input box and give it focus again
        input_box.focus();

        // Remove this token from the saved list
        saved_tokens = saved_tokens.slice(0,index).concat(saved_tokens.slice(index+1));
        if(index < selected_token_index) selected_token_index--;

        // Update the hidden input
        update_hidden_input(saved_tokens, hidden_input);

        token_count -= 1;

        if(settings.tokenLimit !== null) {
            input_box
                .show()
                .val("")
                .focus();
        }

        // Execute the onDelete callback if defined
        if($.isFunction(callback)) {
            callback.call(hidden_input,token_data);
        }
    }

    // Update the hidden input box value
    function update_hidden_input(saved_tokens, hidden_input) {
        var token_values = $.map(saved_tokens, function (el) {
            return el[settings.tokenValue];
        });
        hidden_input.val(token_values.join(settings.tokenDelimiter));

    }

    // Hide and clear the results dropdown
    function hide_dropdown () {
        dropdown.hide().empty();
        selected_dropdown_item = null;
    }

    function show_dropdown() {
        dropdown
            .css({
                position: "absolute",
                top: $(token_list).offset().top + $(token_list).outerHeight(),
                left: $(token_list).offset().left,
                zindex: 999
            })
            .show();
    }

    function show_dropdown_searching () {
        if(settings.searchingText) {
            dropdown.html("<p>"+settings.searchingText+"</p>");
            show_dropdown();
        }
    }

    function show_dropdown_hint () {
        if(settings.hintText) {
            dropdown.html("<p>"+settings.hintText+"</p>");
            show_dropdown();
        }
    }

    // Highlight the query part of the search term
    function highlight_term(value, term) {
        return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<b>$1</b>");
    }
    
    function find_value_and_highlight_term(template, value, term) {
        return template.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + value + ")(?![^<>]*>)(?![^&;]+;)", "g"), highlight_term(value, term));
    }

    // Populate the results dropdown with some results
    function populate_dropdown (query, results) {
        if(results && results.length) {
            dropdown.empty();
            var dropdown_ul = $("<ul>")
                .appendTo(dropdown)
                .mouseover(function (event) {
                    select_dropdown_item($(event.target).closest("li"));
                })
                .mousedown(function (event) {
                    add_token($(event.target).closest("li").data("tokeninput"));
                    hidden_input.change();
                    return false;
                })
                .hide();

            $.each(results, function(index, value) {
                var this_li = settings.resultsFormatter(value);
                
                this_li = find_value_and_highlight_term(this_li ,value[settings.propertyToSearch], query);            
                
                this_li = $(this_li).appendTo(dropdown_ul);
                
                if(index % 2) {
                    this_li.addClass(settings.classes.dropdownItem);
                } else {
                    this_li.addClass(settings.classes.dropdownItem2);
                }

                if(index === 0) {
                    select_dropdown_item(this_li);
                }

                $.data(this_li.get(0), "tokeninput", value);
            });

            show_dropdown();

            if(settings.animateDropdown) {
                dropdown_ul.slideDown("fast");
            } else {
                dropdown_ul.show();
            }
        } else {
            if(settings.noResultsText) {
                dropdown.html("<p>"+settings.noResultsText+"</p>");
                show_dropdown();
            }
        }
    }

    // Highlight an item in the results dropdown
    function select_dropdown_item (item) {
        if(item) {
            if(selected_dropdown_item) {
                deselect_dropdown_item($(selected_dropdown_item));
            }

            item.addClass(settings.classes.selectedDropdownItem);
            selected_dropdown_item = item.get(0);
        }
    }

    // Remove highlighting from an item in the results dropdown
    function deselect_dropdown_item (item) {
        item.removeClass(settings.classes.selectedDropdownItem);
        selected_dropdown_item = null;
    }

    // Do a search and show the "searching" dropdown if the input is longer
    // than settings.minChars
    function do_search() {
        var query = input_box.val().toLowerCase();

        if(query && query.length) {
            if(selected_token) {
                deselect_token($(selected_token), POSITION.AFTER);
            }

            if(query.length >= settings.minChars) {
                show_dropdown_searching();
                clearTimeout(timeout);

                timeout = setTimeout(function(){
                    run_search(query);
                }, settings.searchDelay);
            } else {
                hide_dropdown();
            }
        }
    }

    // Do the actual search
    function run_search(query) {
        var cache_key = query + computeURL();
        var cached_results = cache.get(cache_key);
        if(cached_results) {
            populate_dropdown(query, cached_results);
        } else {
            // Are we doing an ajax search or local data search?
            if(settings.url) {
                var url = computeURL();
                // Extract exisiting get params
                var ajax_params = {};
                ajax_params.data = {};
                if(url.indexOf("?") > -1) {
                    var parts = url.split("?");
                    ajax_params.url = parts[0];

                    var param_array = parts[1].split("&");
                    $.each(param_array, function (index, value) {
                        var kv = value.split("=");
                        ajax_params.data[kv[0]] = kv[1];
                    });
                } else {
                    ajax_params.url = url;
                }

                // Prepare the request
                ajax_params.data[settings.queryParam] = query;
                ajax_params.type = settings.method;
                ajax_params.dataType = settings.contentType;
                if(settings.crossDomain) {
                    ajax_params.dataType = "jsonp";
                }

                // Attach the success callback
                ajax_params.success = function(results) {
                  if($.isFunction(settings.onResult)) {
                      results = settings.onResult.call(hidden_input, results);
                  }
                  cache.add(cache_key, settings.jsonContainer ? results[settings.jsonContainer] : results);

                  // only populate the dropdown if the results are associated with the active search query
                  if(input_box.val().toLowerCase() === query) {
                      populate_dropdown(query, settings.jsonContainer ? results[settings.jsonContainer] : results);
                  }
                };

                // Make the request
                $.ajax(ajax_params);
            } else if(settings.local_data) {
                // Do the search through local data
                var results = $.grep(settings.local_data, function (row) {
                    return row[settings.propertyToSearch].toLowerCase().indexOf(query.toLowerCase()) > -1;
                });

                if($.isFunction(settings.onResult)) {
                    results = settings.onResult.call(hidden_input, results);
                }
                cache.add(cache_key, results);
                populate_dropdown(query, results);
            }
        }
    }

    // compute the dynamic URL
    function computeURL() {
        var url = settings.url;
        if(typeof settings.url == 'function') {
            url = settings.url.call();
        }
        return url;
    }
};

// Really basic cache for the results
$.TokenList.Cache = function (options) {
    var settings = $.extend({
        max_size: 500
    }, options);

    var data = {};
    var size = 0;

    var flush = function () {
        data = {};
        size = 0;
    };

    this.add = function (query, results) {
        if(size > settings.max_size) {
            flush();
        }

        if(!data[query]) {
            size += 1;
        }

        data[query] = results;
    };

    this.get = function (query) {
        return data[query];
    };
};
}(jQuery));

// MSDropDown - jquery.dd.js
// author: Marghoob Suleman - http://www.marghoobsuleman.com/
// Date: 10 Nov, 2012 
// Version: 3.5.2
// Revision: 27
// web: www.marghoobsuleman.com
/*
// msDropDown is free jQuery Plugin: you can redistribute it and/or modify
// it under the terms of the either the MIT License or the Gnu General Public License (GPL) Version 2
*/ 
;eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('4 1E=1E||{};(9($){1E={3Y:{2o:\'3.5.2\'},3Z:"5D 5E",3q:20,41:9(v){6(v!==14){$(".2X").1m({1w:\'3r\',2b:\'4L\'})}1d{$(".2X").1m({1w:\'4M\',2b:\'3s\'})}},3t:\'\',3u:9(a,b,c){c=c||"42";4 d;25(c.2p()){1i"42":1i"4N":d=$(a).2o(b).1b("1V");1j}15 d}};$.3v={};$.2o={};$.2Y(11,$.3v,1E);$.2Y(11,$.2o,1E);6($.1P.1M===1B){$.1P.1M=$.1P.5F}6($.1P.18===1B){$.1P.18=$.1P.5G;$.1P.1x=$.1P.5H}6(1y $.3w.4O===\'9\'){$.3w[\':\'].43=$.3w.4O(9(b){15 9(a){15 $(a).1p().3x().3y(b.3x())>=0}})}1d{$.3w[\':\'].43=9(a,i,m){15 $(a).1p().3x().3y(m[3].3x())>=0}}9 1V(q,t){4 t=$.2Y(11,{1N:{1b:1g,1n:0,3z:1g,2c:0,1Q:14,2Z:5I},3A:\'1V\',1w:5J,1W:7,3B:0,30:11,1J:5K,26:14,3C:\'5L\',2q:\'1X\',3D:\'3r\',2d:11,1C:\'\',3E:0.7,44:11,3F:0,1u:14,3G:\'5M\',2e:\'\',2f:\'\',2g:11,1F:11,2r:11,18:{3u:1g,2G:1g,3H:1g,28:1g,1G:1g,2H:1g,2I:1g,1X:1g,45:1g,48:1g,2s:1g,2J:1g,31:1g,2t:1g,2u:1g}},t);4 u=1a;4 x={49:\'5N\',1R:\'5O\',4a:\'5P\',2h:\'5Q\',1l:\'5R\'};4 y={1V:t.3A,32:\'32\',4P:\'5S 5T\',4b:\'4b\',3I:\'3I\',2K:\'2K\',1q:\'1q\',2X:\'2X\',4Q:\'4Q\',4R:\'4R\',19:\'19\',4c:\'4c\',3J:"3J",4d:"4d",1h:"1h",33:"5U",34:\'34\',3K:\'3K\'};4 z={12:\'5V\',2v:\'2v\',4S:\'5W 4T\',3L:"3L"};4 A=14,1Y=14,1k=14,3M={},q,35={},36=14;4 B=40,4e=38,4f=37,4g=39,4U=27,4h=13,3a=47,4i=16,4j=17,4V=8,4W=46;4 C=14,2i=14,3b=1g,2L=14,3c,5X=14;4 D=3d,3e=4k.5Y.5Z,4X=3e.60(/61/i);t.2g=t.2g.2j();t.1F=t.1F.2j();4 E=9(a){15(62.4Y.2j.4Z(a)=="[50 51]")?11:14};4 F=9(){4 a=3e.3y("63");6(a>0){15 2w(3e.64(a+5,3e.3y(".",a)))}1d{15 0}};4 G=9(){t.3A=$("#"+q).1b("65")||t.3A;t.1W=$("#"+q).1b("66")||t.1W;6($("#"+q).1b("52")==14){t.30=$("#"+q).1b("52")};t.26=$("#"+q).1b("53")||t.26;t.3C=$("#"+q).1b("67")||t.3C;t.2q=$("#"+q).1b("2q")||t.2q;t.3D=$("#"+q).1b("68")||t.3D;t.2d=$("#"+q).1b("69")||t.2d;t.3E=$("#"+q).1b("6a")||t.3E;t.3F=$("#"+q).1b("54")||t.3F;t.1u=$("#"+q).1b("6b")||t.1u;t.3G=$("#"+q).1b("6c")||t.3G;t.2e=$("#"+q).1b("2e")||t.2e;t.2f=$("#"+q).1b("2f")||t.2f;t.2g=$("#"+q).1b("6d")||t.2g;t.1F=$("#"+q).1b("6e")||t.1F;t.2r=$("#"+q).1b("6f")||t.2r;t.2g=t.2g.2j();t.1F=t.1F.2j();t.2r=t.2r.2j()};4 H=9(a){6(3M[a]===1B){3M[a]=D.6g(a)}15 3M[a]};4 I=9(a){4 b=L("1l");15 $("#"+b+" 12."+z.12).1o(a)};4 J=9(){6(t.1N.1b){4 a=["1h","1D","1r"];2M{6(!q.1H){q.1H="42"+1E.3q};t.1N.1b=55(t.1N.1b);4 b="6h"+(1E.3q++);4 c={};c.1H=b;c.3z=t.1N.3z||q.1H;6(t.1N.2c>0){c.2c=t.1N.2c};c.1Q=t.1N.1Q;4 d=O("4N",c);1Z(4 i=0;i<t.1N.1b.1c;i++){4 f=t.1N.1b[i];4 g=3N 4l(f.1p,f.1f);1Z(4 p 3O f){6(p.2p()!=\'1p\'){4 h=($.6i(p.2p(),a)!=-1)?"1b-":"";g.6j(h+p,f[p])}};d.1K[i]=g};H(q.1H).1s(d);d.1n=t.1N.1n;$(d).1m({2Z:t.1N.2Z+\'2N\'});q=d}2O(e){6k"6l 6m 6n 6o 3O 6p 1b.";}}};4 K=9(){J();6(!q.1H){q.1H="6q"+(1E.3q++)};q=q.1H;u.6r=q;G();1k=H(q).2K;4 a=t.1u;6(a.2j()==="11"){H(q).1Q=11;t.1u=11};A=(H(q).2c>1||H(q).1Q==11)?11:14;6(A){1Y=H(q).1Q};56();57();1v("58",2k());1v("59",$("#"+q+" 1S:19"));4 b=L("1l");3c=$("#"+b+" 12."+y.19);6(t.2g==="11"){$("#"+q).18("2H",9(){21(1a.1n)})};H(q).4m=9(e){$("#"+q).2o().1b("1V").4m()}};4 L=9(a){15 q+x[a]};4 M=9(a){4 s=(a.1C===1B)?"":a.1C.5a;15 s};4 N=9(a){4 b=\'\',1r=\'\',1h=\'\',1f=-1,1p=\'\',1e=\'\',1z=\'\',1o;6(a!==1B){4 c=a.1r||"";6(c!=""){4 d=/^\\{.*\\}$/;4 e=d.6s(c);6(e&&t.2d){4 f=55("["+c+"]")};1r=(e&&t.2d)?f[0].1r:1r;1h=(e&&t.2d)?f[0].1h:1h;b=(e&&t.2d)?f[0].1D:c;1z=(e&&t.2d)?f[0].1z:1z;1o=a.1o};1p=a.1p||\'\';1f=a.1f||\'\';1e=a.1e||"";1r=$(a).1M("1b-1r")||$(a).1b("1r")||(1r||"");1h=$(a).1M("1b-1h")||$(a).1b("1h")||(1h||"");b=$(a).1M("1b-1D")||$(a).1b("1D")||(b||"");1z=$(a).1M("1b-1z")||$(a).1b("1z")||(1z||"");1o=$(a).1o()};4 o={1D:b,1r:1r,1h:1h,1f:1f,1p:1p,1e:1e,1z:1z,1o:1o};15 o};4 O=9(a,b,c){4 d=D.6t(a);6(b){1Z(4 i 3O b){25(i){1i"1C":d.1C.5a=b[i];1j;2P:d[i]=b[i];1j}}};6(c){d.6u=c};15 d};4 P=9(){4 a=L("49");6($("#"+a).1c==0){4 b={1C:\'1w: 4M;4n: 2x;2b: 3s;\',1e:y.2X};b.1H=a;4 c=O("2Q",b);$("#"+q).5b(c);$("#"+q).6v($("#"+a))}1d{$("#"+a).1m({1w:0,4n:\'2x\',2b:\'3s\'})};H(q).3f=-1};4 Q=9(){4 a=(t.1F=="11")?" 2R":"";4 b={1e:y.1V+" 5c"+a};4 c=M(H(q));4 w=$("#"+q).6w();b.1C="2Z: "+w+"2N;";6(c.1c>0){b.1C=b.1C+""+c};b.1H=L("1R");b.3f=H(q).3f;4 d=O("2Q",b);15 d};4 R=9(){4 a;6(H(q).1n>=0){a=H(q).1K[H(q).1n]}1d{a={1f:\'\',1p:\'\'}}4 b="",4o="";4 c=$("#"+q).1b("53");6(c){t.26=c};6(t.26!=14){b=" "+t.26;4o=" "+a.1e};4 d=(t.1F=="11")?" "+z.2v:"";4 e=O("2Q",{1e:y.32+b+d});4 f=O("2l",{1e:y.4c});4 g=O("2l",{1e:y.4P});4 h=L("4a");4 i=O("2l",{1e:y.3I+4o,1H:h});4 j=N(a);4 k=j.1D;4 l=j.1p||"";6(k!=""&&t.30){4 m=O("3P");m.4p=k;6(j.1z!=""){m.1e=j.1z+" "}};4 n=O("2l",{1e:y.33},l);e.1s(f);e.1s(g);6(m){i.1s(m)};i.1s(n);e.1s(i);4 o=O("2l",{1e:y.1h},j.1h);i.1s(o);15 e};4 S=9(){4 a=L("2h");4 b=(t.1F=="11")?"2R":"";4 c=O("2y",{1H:a,5d:\'1p\',1f:\'\',6x:\'1x\',1e:\'1p 4T \'+b,1C:\'22: 2z\'});15 c};4 T=9(a){4 b={};4 c=M(a);6(c.1c>0){b.1C=c};4 d=(a.2K)?y.2K:y.1q;d=(a.19)?(d+" "+y.19):d;d=d+" "+z.12;b.1e=d;6(t.26!=14){b.1e=d+" "+a.1e};4 e=O("12",b);4 f=N(a);6(f.1r!=""){e.1r=f.1r};4 g=f.1D;6(g!=""&&t.30){4 h=O("3P");h.4p=g;6(f.1z!=""){h.1e=f.1z+" "}};6(f.1h!=""){4 i=O("2l",{1e:y.1h},f.1h)};4 j=a.1p||"";4 k=O("2l",{1e:y.33},j);6(t.1u===11){4 l=O("2y",{5d:\'3g\',3z:q+t.3G+\'[]\',1f:a.1f||"",1e:"3g"});e.1s(l);6(t.1u===11){l.29=(a.19)?11:14}};6(h){e.1s(h)};e.1s(k);6(i){e.1s(i)}1d{6(h){h.1e=h.1e+z.3L}};4 m=O("2Q",{1e:\'6y\'});e.1s(m);15 e};4 U=9(){4 a=L("1l");4 b={1e:y.4b+" 6z "+z.4S,1H:a};6(A==14){b.1C="z-1o: "+t.1J}1d{b.1C="z-1o:1"};4 c=$("#"+q).1b("54")||t.3F;6(c){b.1C=(b.1C||"")+";2Z:"+c};4 d=O("2Q",b);4 e=O("4q");6(t.26!=14){e.1e=t.26};4 f=H(q).23;1Z(4 i=0;i<f.1c;i++){4 g=f[i];4 h;6(g.4r.2p()=="3J"){h=O("12",{1e:y.3J});4 k=O("2l",{1e:y.4d},g.33);h.1s(k);4 l=g.23;4 m=O("4q");1Z(4 j=0;j<l.1c;j++){4 n=T(l[j]);m.1s(n)};h.1s(m)}1d{h=T(g)};e.1s(h)};d.1s(e);15 d};4 V=9(a){4 b=L("1l");6(a){6(a==-1){$("#"+b).1m({1w:"3r",4n:"3r"})}1d{$("#"+b).1m("1w",a+"2N")};15 14};4 c;4 d=H(q).1K.1c;6(d>t.1W||t.1W){4 e=$("#"+b+" 12:6A");4 f=2w(e.1m("5e-6B"))+2w(e.1m("5e-2a"));6(t.3B===0){$("#"+b).1m({5f:\'2x\',22:\'3Q\'});t.3B=3h.6C(e.1w());$("#"+b).1m({5f:\'1T\'});6(!A||t.1u===11){$("#"+b).1m({22:\'2z\'})}};c=((t.3B+f)*3h.5g(t.1W,d))+3}1d 6(A){c=$("#"+q).1w()};15 c};4 W=9(){4 j=L("1l");$("#"+j).18("1X",9(e){6(1k===11)15 14;e.1U();e.2m();6(A){3R()}});$("#"+j+" 12."+y.1q).18("1X",9(e){6(e.5h.4r.2p()!=="2y"){2A(1a)}});$("#"+j+" 12."+y.1q).18("2t",9(e){6(1k===11)15 14;3c=$("#"+j+" 12."+y.19);3b=1a;e.1U();e.2m();6(t.1u===11){6(e.5h.4r.2p()==="2y"){2i=11}};6(A===11){6(1Y){6(C===11){$(1a).1t(y.19);4 a=$("#"+j+" 12."+y.19);4 b=I(1a);6(a.1c>1){4 c=$("#"+j+" 12."+z.12);4 d=I(a[0]);4 f=I(a[1]);6(b>f){d=(b);f=f+1};1Z(4 i=3h.5g(d,f);i<=3h.6D(d,f);i++){4 g=c[i];6($(g).3S(y.1q)){$(g).1t(y.19)}}}}1d 6(2i===11){$(1a).6E(y.19);6(t.1u===11){4 h=1a.4s[0];h.29=!h.29}}1d{$("#"+j+" 12."+y.19).1I(y.19);$("#"+j+" 2y:3g").1M("29",14);$(1a).1t(y.19);6(t.1u===11){1a.4s[0].29=11}}}1d{$("#"+j+" 12."+y.19).1I(y.19);$(1a).1t(y.19)}}1d{$("#"+j+" 12."+y.19).1I(y.19);$(1a).1t(y.19)}});$("#"+j+" 12."+y.1q).18("3i",9(e){6(1k===11)15 14;e.1U();e.2m();6(3b!=1g){6(1Y){$(1a).1t(y.19);6(t.1u===11){1a.4s[0].29=11}}}});$("#"+j+" 12."+y.1q).18("2s",9(e){6(1k===11)15 14;$(1a).1t(y.34)});$("#"+j+" 12."+y.1q).18("2J",9(e){6(1k===11)15 14;$("#"+j+" 12."+y.34).1I(y.34)});$("#"+j+" 12."+y.1q).18("2u",9(e){6(1k===11)15 14;e.1U();e.2m();6(t.1u===11){2i=14};4 a=$("#"+j+" 12."+y.19).1c;2L=(3c.1c!=a||a==0)?11:14;3j();3k();3R();3b=1g});6(t.44==14){$("#"+j+" 12."+z.12).18("1X",9(e){6(1k===11)15 14;2B(1a,"1X")});$("#"+j+" 12."+z.12).18("3i",9(e){6(1k===11)15 14;2B(1a,"3i")});$("#"+j+" 12."+z.12).18("2s",9(e){6(1k===11)15 14;2B(1a,"2s")});$("#"+j+" 12."+z.12).18("2J",9(e){6(1k===11)15 14;2B(1a,"2J")});$("#"+j+" 12."+z.12).18("2t",9(e){6(1k===11)15 14;2B(1a,"2t")});$("#"+j+" 12."+z.12).18("2u",9(e){6(1k===11)15 14;2B(1a,"2u")})}};4 X=9(){4 a=L("1l");$("#"+a).1x("1X");$("#"+a+" 12."+y.1q).1x("3i");$("#"+a+" 12."+y.1q).1x("1X");$("#"+a+" 12."+y.1q).1x("2s");$("#"+a+" 12."+y.1q).1x("2J");$("#"+a+" 12."+y.1q).1x("2t");$("#"+a+" 12."+y.1q).1x("2u")};4 Y=9(a,b,c){$("#"+a).1x(b,c);$("#"+a).4t(b);$("#"+a).18(b,c)};4 Z=9(){4 a=L("1R");4 b=L("2h");4 c=L("1l");$("#"+a).18(t.2q,9(e){6(1k===11)15 14;1O(t.2q);e.1U();e.2m();3T(e)});$("#"+a).18("2S",9(e){4 k=e.6F;6(!36&&(k==4h||k==4e||k==B||k==4f||k==4g||(k>=3a&&!A))){3T(e);6(k>=3a){4u()}1d{e.1U();e.6G()}}});$("#"+a).18("31",4v);$("#"+a).18("2I",4w);$("#"+b).18("2I",9(e){Y(a,"31",4v)});W();$("#"+a).18("45",5i);$("#"+a).18("48",5j);$("#"+a).18("3i",5k);$("#"+a).18("6H",5l);$("#"+a).18("2t",5m);$("#"+a).18("2u",5n)};4 4v=9(e){1O("31")};4 4w=9(e){1O("2I")};4 3U=9(){4 a=L("1R");4 b=L("1l");6(A===11&&t.1u===14){$("#"+a+" ."+y.32).3l();$("#"+b).1m({22:\'3Q\',2b:\'4L\'})}1d{6(t.1u===14){1Y=14};$("#"+a+" ."+y.32).2C();$("#"+b).1m({22:\'2z\',2b:\'3s\'});4 c=$("#"+b+" 12."+y.19)[0];$("#"+b+" 12."+y.19).1I(y.19);4 d=I($(c).1t(y.19));21(d)};V(V())};4 4x=9(){4 a=L("1R");4 b=(1k==11)?t.3E:1;6(1k===11){$("#"+a).1t(y.3K)}1d{$("#"+a).1I(y.3K)}};4 5o=9(){4 a=L("2h");6(t.2r=="11"){$("#"+a).18("2T",5p)};3U();4x()};4 57=9(){4 a=Q();4 b=R();a.1s(b);4 c=S();a.1s(c);4 d=U();a.1s(d);$("#"+q).5b(a);P();5o();Z();4 e=L("1l");6(t.2e!=\'\'){$("#"+e).2e(t.2e)};6(t.2f!=\'\'){$("#"+e).2f(t.2f)};6(1y t.18.3u=="9"){t.18.3u.24(u,1A)}};4 4y=9(b){4 c=L("1l");$("#"+c+" 12."+z.12).1I(y.19);6(t.1u===11){$("#"+c+" 12."+z.12+" 2y.3g").1M("29",14)};6(E(b)===11){1Z(4 i=0;i<b.1c;i++){4z(b[i])}}1d{4z(b)};9 4z(a){$($("#"+c+" 12."+z.12)[a]).1t(y.19);6(t.1u===11){$($("#"+c+" 12."+z.12)[a]).3m("2y.3g").1M("29","29")}}};4 4A=9(a,b){4 c=L("1l");4 d=a||$("#"+c+" 12."+y.19);1Z(4 i=0;i<d.1c;i++){4 e=(b===11)?d[i]:I(d[i]);H(q).1K[e].19="19"};21(d)};4 3j=9(){4 a=L("1l");4 b=$("#"+a+" 12."+y.19);6(1Y&&(C||2i)||2L){H(q).1n=-1};4 c;6(b.1c==0){c=-1}1d 6(b.1c>1){4A(b)}1d{c=I($("#"+a+" 12."+y.19))};6((H(q).1n!=c||2L)&&b.1c<=1){2L=14;4 e=3n("2H");H(q).1n=c;21(c);6(1y t.18.2H=="9"){4 d=2k();t.18.2H(d.1b,d.1L)};$("#"+q).4t("2H")}};4 21=9(a,b){6(a!==1B){4 c,1f,2D;6(a==-1){c=-1;1f="";2D="";2E(-1)}1d{6(1y a!="50"){4 d=H(q).1K[a];H(q).1n=a;c=a;1f=N(d);2D=(a>=0)?H(q).1K[a].1p:"";2E(1B,1f);1f=1f.1f}1d{c=(b&&b.1o)||H(q).1n;1f=(b&&b.1f)||H(q).1f;2D=(b&&b.1p)||H(q).1K[H(q).1n].1p||"";2E(c)}};1v("1n",c);1v("1f",1f);1v("2D",2D);1v("23",H(q).23);1v("58",2k());1v("59",$("#"+q+" 1S:19"))}};4 3n=9(a){4 b={2U:14,2V:14,2n:14};4 c=$("#"+q);2M{6(c.1M("18"+a)!==1g){b.2n=11;b.2U=11}}2O(e){}4 d;6(1y $.5q=="9"){d=$.5q(c[0],"4B")}1d{d=c.1b("4B")};6(d&&d[a]){b.2n=11;b.2V=11};15 b};4 3R=9(){3k();$("5r").18("1X",2A);$(3d).18("2S",4C);$(3d).18("2T",4D)};4 3k=9(){$("5r").1x("1X",2A);$(3d).1x("2S",4C);$(3d).1x("2T",4D)};4 5p=9(e){6(e.2W<3a&&e.2W!=4V&&e.2W!=4W){15 14};4 a=L("1l");4 b=L("2h");4 c=H(b).1f;6(c.1c==0){$("#"+a+" 12:2x").2C();V(V())}1d{$("#"+a+" 12").3l();4 d=$("#"+a+" 12:43(\'"+c+"\')").2C();6($("#"+a+" 12:1T").1c<=t.1W){V(-1)};6(d.1c>0&&!A||!1Y){$("#"+a+" ."+y.19).1I(y.19);$(d[0]).1t(y.19)}};6(!A){3o()}};4 4u=9(){6(t.2r=="11"){4 a=L("1R");4 b=L("2h");6($("#"+b+":2x").1c>0&&2i==14){$("#"+b+":2x").2C().6I("");Y(a,"2I",4w);H(b).31()}}};4 5s=9(){4 a=L("2h");6($("#"+a+":1T").1c>0){$("#"+a+":1T").3l();H(a).2I()}};4 4C=9(a){4 b=L("2h");4 c=L("1l");25(a.2W){1i B:1i 4g:a.1U();a.2m();5t();1j;1i 4e:1i 4f:a.1U();a.2m();5u();1j;1i 4U:1i 4h:a.1U();a.2m();2A();4 d=$("#"+c+" 12."+y.19).1c;2L=(3c.1c!=d||d==0)?11:14;3j();3k();3b=1g;1j;1i 4i:C=11;1j;1i 4j:2i=11;1j;2P:6(a.2W>=3a&&A===14){4u()};1j};6(1k===11)15 14;1O("2S")};4 4D=9(a){25(a.2W){1i 4i:C=14;1j;1i 4j:2i=14;1j};6(1k===11)15 14;1O("2T")};4 5i=9(a){6(1k===11)15 14;1O("45")};4 5j=9(a){6(1k===11)15 14;1O("48")};4 5k=9(a){6(1k===11)15 14;a.1U();1O("2s")};4 5l=9(a){6(1k===11)15 14;a.1U();1O("2J")};4 5m=9(a){6(1k===11)15 14;1O("2t")};4 5n=9(a){6(1k===11)15 14;1O("2u")};4 3V=9(a,b){4 c={2U:14,2V:14,2n:14};6($(a).1M("18"+b)!=1B){c.2n=11;c.2U=11};4 d=$(a).1b("4B");6(d&&d[b]){c.2n=11;c.2V=11};15 c};4 2B=9(a,b){6(t.44==14){4 c=H(q).1K[I(a)];6(3V(c,b).2n===11){6(3V(c,b).2U===11){c["18"+b]()};6(3V(c,b).2V===11){25(b){1i"2S":1i"2T":1j;2P:$(c).4t(b);1j}};15 14}}};4 1O=9(a){6(1y t.18[a]=="9"){t.18[a].24(1a,1A)};6(3n(a).2n===11){6(3n(a).2U===11){H(q)["18"+a]()}1d 6(3n(a).2V===11){25(a){1i"2S":1i"2T":1j;2P:$("#"+q).6J(a);1j}};15 14}};4 3W=9(a){4 b=L("1l");a=(a!==1B)?a:$("#"+b+" 12."+y.19);6(a.1c>0){4 c=2w(($(a).2b().2a));4 d=2w($("#"+b).1w());6(c>d){4 e=c+$("#"+b).3p()-(d/2);$("#"+b).5v({3p:e},5w)}}};4 5t=9(){4 b=L("1l");4 c=$("#"+b+" 12:1T."+z.12);4 d=$("#"+b+" 12:1T."+y.19);d=(d.1c==0)?c[0]:d;4 e=$("#"+b+" 12:1T."+z.12).1o(d);6((e<c.1c-1)){e=4E(e);6(e<c.1c){6(!C||!A||!1Y){$("#"+b+" ."+y.19).1I(y.19)};$(c[e]).1t(y.19);2E(e);6(A==11){3j()};3W($(c[e]))};6(!A){3o()}};9 4E(a){a=a+1;6(a>c.1c){15 a};6($(c[a]).3S(y.1q)===11){15 a};15 a=4E(a)}};4 5u=9(){4 b=L("1l");4 c=$("#"+b+" 12:1T."+y.19);4 d=$("#"+b+" 12:1T."+z.12);4 e=$("#"+b+" 12:1T."+z.12).1o(c[0]);6(e>=0){e=4F(e);6(e>=0){6(!C||!A||!1Y){$("#"+b+" ."+y.19).1I(y.19)};$(d[e]).1t(y.19);2E(e);6(A==11){3j()};6(2w(($(d[e]).2b().2a+$(d[e]).1w()))<=0){4 f=($("#"+b).3p()-$("#"+b).1w())-$(d[e]).1w();$("#"+b).5v({3p:f},5w)}};6(!A){3o()}};9 4F(a){a=a-1;6(a<0){15 a};6($(d[a]).3S(y.1q)===11){15 a};15 a=4F(a)}};4 3o=9(){4 a=L("1R");4 b=L("1l");4 c=$("#"+a).5x();4 d=$("#"+a).1w();4 e=$(4k).1w();4 f=$(4k).3p();4 g=$("#"+b).1w();4 h=$("#"+a).1w();4 i=t.3D.2p();6(((e+f)<3h.6K(g+d+c.2a)||i==\'6L\')&&i!=\'6M\'){h=g;$("#"+b).1m({2a:"-"+h+"2N",22:\'3Q\',1J:t.1J});6(t.1F=="11"){$("#"+a).1I("2R 2v").1t("3X")};4 h=$("#"+b).5x().2a;6(h<-10){$("#"+b).1m({2a:(2w($("#"+b).1m("2a"))-h+20+f)+"2N",1J:t.1J});6(t.1F=="11"){$("#"+a).1I("3X 2v").1t("2R")}}}1d{$("#"+b).1m({2a:h+"2N",1J:t.1J});6(t.1F=="11"){$("#"+a).1I("2R 3X").1t("2v")}};6(4X){6(F()<=7){$(\'2Q.5c\').1m("1J",t.1J-10);$("#"+a).1m("1J",t.1J+5)}}};4 3T=9(e){6(1k===11)15 14;4 a=L("1R");4 b=L("1l");6(!36){36=11;6(1E.3t!=\'\'){$("#"+1E.3t).1m({22:"2z"})};1E.3t=b;$("#"+b+" 12:2x").2C();3o();4 c=t.3C;6(c==""||c=="2z"){$("#"+b).1m({22:"3Q"});3W();6(1y t.18.2G=="9"){4 d=2k();t.18.2G(d.1b,d.1L)}}1d{$("#"+b)[c]("6N",9(){3W();6(1y t.18.2G=="9"){4 d=2k();t.18.2G(d.1b,d.1L)}})};3R()}1d{6(t.2q!==\'2s\'){2A()}}};4 2A=9(e){36=14;4 a=L("1R");4 b=L("1l");6(A===14||t.1u===11){$("#"+b).1m({22:"2z"});6(t.1F=="11"){$("#"+a).1I("2v 3X").1t("2R")}};3k();6(1y t.18.3H=="9"){4 d=2k();t.18.3H(d.1b,d.1L)};5s();V(V());$("#"+b).1m({1J:1});2E(H(q).1n)};4 56=9(){2M{35=$.2Y(11,{},H(q));1Z(4 i 3O 35){6(1y 35[i]!="9"){u[i]=35[i]}}}2O(e){};u.2D=(H(q).1n>=0)?H(q).1K[H(q).1n].1p:"";u.3Y=1E.3Y.2o;u.3Z=1E.3Z};4 4G=9(a){6(a!=1g&&1y a!="1B"){4 b=L("1l");4 c=N(a);4 d=$("#"+b+" 12."+z.12+":4H("+(a.1o)+")");15{1b:c,1L:d,1S:a,1o:a.1o}};15 1g};4 2k=9(){4 a=L("1l");4 b=H(q);4 c,1L,1S,1o;6(b.1n==-1){c=1g;1L=1g;1S=1g;1o=-1}1d{1L=$("#"+a+" 12."+y.19);6(1L.1c>1){4 d=[],4I=[],6O=[];1Z(4 i=0;i<1L.1c;i++){4 e=I(1L[i]);d.5y(e);4I.5y(b.1K[e])};c=d;1S=4I;1o=d}1d{1S=b.1K[b.1n];c=N(1S);1o=b.1n}};15{1b:c,1L:1L,1o:1o,1S:1S}};4 2E=9(a,b){4 c=L("4a");4 d={};6(a==-1){d.1p="&6P;";d.1e="";d.1h="";d.1D=""}1d 6(1y a!="1B"){4 e=H(q).1K[a];d=N(e)}1d{d=b};$("#"+c).3m("."+y.33).4J(d.1p);H(c).1e=y.3I+" "+d.1e;6(d.1h!=""){$("#"+c).3m("."+y.1h).4J(d.1h).2C()}1d{$("#"+c).3m("."+y.1h).4J("").3l()};4 f=$("#"+c).3m("3P");6(f.1c>0){$(f).1G()};6(d.1D!=""&&t.30){f=O("3P",{4p:d.1D});$("#"+c).2f(f);6(d.1z!=""){f.1e=d.1z+" "};6(d.1h==""){f.1e=f.1e+z.3L}}};4 1v=9(p,v){u[p]=v};4 4K=9(a,b,i){4 c=L("1l");4 d=14;25(a){1i"28":4 e=T(b||H(q).1K[i]);4 f;6(1A.1c==3){f=i}1d{f=$("#"+c+" 12."+z.12).1c-1};6(f<0||!f){$("#"+c+" 4q").2e(e)}1d{4 g=$("#"+c+" 12."+z.12)[f];$(g).6Q(e)};X();W();6(t.18.28!=1g){t.18.28.24(1a,1A)};1j;1i"1G":d=$($("#"+c+" 12."+z.12)[i]).3S(y.19);$("#"+c+" 12."+z.12+":4H("+i+")").1G();4 h=$("#"+c+" 12."+y.1q);6(d==11){6(h.1c>0){$(h[0]).1t(y.19);4 j=$("#"+c+" 12."+z.12).1o(h[0]);21(j)}};6(h.1c==0){21(-1)};6($("#"+c+" 12."+z.12).1c<t.1W&&!A){V(-1)};6(t.18.1G!=1g){t.18.1G.24(1a,1A)};1j}};1a.6R=9(){4 a=1A[0];51.4Y.6S.4Z(1A);25(a){1i"28":u.28.24(1a,1A);1j;1i"1G":u.1G.24(1a,1A);1j;2P:2M{H(q)[a].24(H(q),1A)}2O(e){};1j}};1a.28=9(){4 a,1f,1r,1D,1h;4 b=1A[0];6(1y b=="6T"){a=b;1f=a;2F=3N 4l(a,1f)}1d{a=b.1p||\'\';1f=b.1f||a;1r=b.1r||\'\';1D=b.1D||\'\';1h=b.1h||\'\';2F=3N 4l(a,1f);$(2F).1b("1h",1h);$(2F).1b("1D",1D);$(2F).1b("1r",1r)};1A[0]=2F;H(q).28.24(H(q),1A);1v("23",H(q)["23"]);1v("1c",H(q).1c);4K("28",2F,1A[1])};1a.1G=9(i){H(q).1G(i);1v("23",H(q)["23"]);1v("1c",H(q).1c);4K("1G",1B,i)};1a.5z=9(a,b){6(1y a=="1B"||1y b=="1B")15 14;a=a.2j();2M{1v(a,b)}2O(e){};25(a){1i"2c":H(q)[a]=b;6(b==0){H(q).1Q=14};A=(H(q).2c>1||H(q).1Q==11)?11:14;3U();1j;1i"1Q":H(q)[a]=b;A=(H(q).2c>1||H(q).1Q==11)?11:14;1Y=H(q).1Q;3U();1v(a,b);1j;1i"2K":H(q)[a]=b;1k=b;4x();1j;1i"1n":1i"1f":6(a=="1n"&&E(b)===11){$("#"+q+" 1S").1M("19",14);4A(b,11);4y(b)}1d{H(q)[a]=b;4y(H(q).1n);21(H(q).1n)};1j;1i"1c":4 c=L("1l");6(b<H(q).1c){H(q)[a]=b;6(b==0){$("#"+c+" 12."+z.12).1G();21(-1)}1d{$("#"+c+" 12."+z.12+":6U("+(b-1)+")").1G();6($("#"+c+" 12."+y.19).1c==0){$("#"+c+" 12."+y.1q+":4H(0)").1t(y.19)}};1v(a,b);1v("23",H(q)["23"])};1j;1i"1H":1j;2P:2M{H(q)[a]=b;1v(a,b)}2O(e){};1j}};1a.6V=9(a){15 u[a]||H(q)[a]};1a.1T=9(a){4 b=L("1R");6(a===11){$("#"+b).2C()}1d 6(a===14){$("#"+b).3l()}1d{15($("#"+b).1m("22")=="2z")?14:11}};1a.41=9(v){1E.41(v)};1a.3H=9(){2A()};1a.2G=9(){3T()};1a.5A=9(r){6(1y r=="1B"||r==0){15 14};t.1W=r;V(V())};1a.1W=1a.5A;1a.18=9(a,b){$("#"+q).18(a,b)};1a.1x=9(a,b){$("#"+q).1x(a,b)};1a.6W=1a.18;1a.6X=9(){15 2k()};1a.5B=9(){4 a=H(q).5B.24(H(q),1A);15 4G(a)};1a.5C=9(){4 a=H(q).5C.24(H(q),1A);15 4G(a)};1a.6Y=9(a){1a.5z("1f",a)};1a.6Z=9(){4 a=L("49");4 b=L("1R");$("#"+b+", #"+b+" *").1x();H(q).3f=H(b).3f;$("#"+b).1G();$("#"+q).70().71($("#"+q));$("#"+q).1b("1V",1g)};1a.4m=9(){21(H(q).1n)};K()};$.1P.2Y({3v:9(b){15 1a.72(9(){6(!$(1a).1b(\'1V\')){4 a=3N 1V(1a,b);$(1a).1b(\'1V\',a)}})}});$.1P.2o=$.1P.3v})(73);',62,438,'||||var||if|||function||||||||||||||||||||||||||||||||||||||||||||||||||||||true|li||false|return|||on|selected|this|data|length|else|className|value|null|description|case|break|isDisabled|postChildID|css|selectedIndex|index|text|enabled|title|appendChild|addClass|enableCheckbox|cy|height|off|typeof|imagecss|arguments|undefined|style|image|msBeautify|roundedCorner|remove|id|removeClass|zIndex|options|ui|prop|byJson|cn|fn|multiple|postID|option|visible|preventDefault|dd|visibleRows|click|isMultiple|for||bW|display|children|apply|switch|useSprite||add|checked|top|position|size|jsonTitle|append|prepend|reverseMode|postTitleTextID|controlHolded|toString|cw|span|stopPropagation|hasEvent|msDropdown|toLowerCase|event|enableAutoFilter|mouseover|mousedown|mouseup|borderRadiusTp|parseInt|hidden|input|none|ct|cm|show|selectedText|cx|opt|open|change|blur|mouseout|disabled|forcedTrigger|try|px|catch|default|div|borderRadius|keydown|keyup|byElement|byJQuery|keyCode|ddOutOfVision|extend|width|showIcon|focus|ddTitle|label|hover|orginial|isOpen||||ALPHABETS_START|lastTarget|oldSelected|document|ua|tabIndex|checkbox|Math|mouseenter|bV|bZ|hide|find|bX|cr|scrollTop|counter|auto|absolute|oldDiv|create|msDropDown|expr|toUpperCase|indexOf|name|mainCSS|rowHeight|animStyle|openDirection|disabledOpacity|childWidth|checkboxNameSuffix|close|ddTitleText|optgroup|disabledAll|fnone|cacheElement|new|in|img|block|bY|hasClass|cs|bP|cl|co|borderRadiusBtm|version|author||debug|dropdown|Contains|disabledOptionEvents|dblclick|||mousemove|postElementHolder|postTitleID|ddChild|divider|optgroupTitle|UP_ARROW|LEFT_ARROW|RIGHT_ARROW|ENTER|SHIFT|CONTROL|window|Option|refresh|overflow|selectedClass|src|ul|nodeName|childNodes|trigger|cb|bN|bO|bQ|bT|updateNow|bU|events|cd|ce|getNext|getPrev|cv|eq|op|html|cz|relative|0px|select|createPseudo|arrow|borderTop|noBorderTop|ddChildMore|shadow|ESCAPE|BACKSPACE|DELETE|isIE|prototype|call|object|Array|showicon|usesprite|childwidth|eval|cu|bS|uiData|selectedOptions|cssText|after|ddcommon|type|padding|visibility|min|target|cf|cg|ch|ci|cj|ck|bR|ca|_data|body|cc|cp|cq|animate|500|offset|push|set|showRows|namedItem|item|Marghoob|Suleman|attr|bind|unbind|250|120|9999|slideDown|_mscheck|_msddHolder|_msdd|_title|_titleText|_child|ddArrow|arrowoff|ddlabel|_msddli_|border|isCreated|navigator|userAgent|match|msie|Object|MSIE|substring|maincss|visiblerows|animstyle|opendirection|jsontitle|disabledopacity|enablecheckbox|checkboxnamesuffix|reversemode|roundedcorner|enableautofilter|getElementById|msdropdown|inArray|setAttribute|throw|There|is|an|error|json|msdrpdd|element|test|createElement|innerHTML|appendTo|outerWidth|autocomplete|clear|ddchild_|first|bottom|ceil|max|toggleClass|which|stopImmediatePropagation|mouseleave|val|triggerHandler|floor|alwaysup|alwaysdown|fast|ind|nbsp|before|act|shift|string|gt|get|addMyEvent|getData|setIndexByValue|destroy|parent|replaceWith|each|jQuery'.split('|'),0,{}));