define(["jquery","TYPO3/CMS/Backend/Modal","TYPO3/CMS/Backend/Severity"],(function(e,t,n){return function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=11)}([function(t,n){t.exports=e},function(e,n){e.exports=t},,function(e,t){e.exports=n},,,,,,,,function(e,t,n){"use strict";n.r(t);var r=n(0),o=n.n(r),i=n(1),a=n.n(i),l=n(3),u=n.n(l),c={triggerSelector:".t3js-setup-wizard-trigger",modalContentSelector:".t3js-setup-wizard-step1 .step-content",initialize:function(){o()(document).on("click",c.triggerSelector,(function(e){e.preventDefault();var t=o()(this),n=o()(c.modalContentSelector).clone(),r=[{text:t.data("button-close-text")||"Close",active:!0,btnClass:"btn-default",trigger:function(){a.a.currentModal.trigger("modal-dismiss")}},{text:t.data("button-ok-text")||"OK",btnClass:"btn-primary",trigger:function(e){a.a.currentModal.trigger("modal-dismiss"),self.location.href=t.attr("href").replace("%40title",a.a.currentModal.find('input[name="title"]').val()).replace("%40template",a.a.currentModal.find('input[name="template"]:checked').length).replace("%40install",a.a.currentModal.find('input[name="install"]:checked').length)}}];a.a.show("Blog Setup Wizard",n,u.a.notice,r)}))}};c.initialize()}])}));