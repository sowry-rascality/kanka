import{c as A}from"./_commonjsHelpers-725317a4.js";var h={},I={get exports(){return h},set exports(s){h=s}};(function(s,_){(function(o,l){s.exports=l()})(A,function(){var o="__v-click-outside",l=typeof window<"u",T=typeof navigator<"u",b=l&&("ontouchstart"in window||T&&navigator.msMaxTouchPoints>0)?["touchstart"]:["click"],p=function(e){var n=e.event,r=e.handler;(0,e.middleware)(n)&&r(n)},w=function(e,n){var r=function(t){var a=typeof t=="function";if(!a&&typeof t!="object")throw new Error("v-click-outside: Binding value must be a function or an object");return{handler:a?t:t.handler,middleware:t.middleware||function(i){return i},events:t.events||b,isActive:t.isActive!==!1,detectIframe:t.detectIframe!==!1,capture:!!t.capture}}(n.value),v=r.handler,x=r.middleware,y=r.detectIframe,f=r.capture;if(r.isActive){if(e[o]=r.events.map(function(t){return{event:t,srcTarget:document.documentElement,handler:function(a){return function(i){var d=i.el,c=i.event,m=i.handler,u=i.middleware,k=c.path||c.composedPath&&c.composedPath();(k?k.indexOf(d)<0:!d.contains(c.target))&&p({event:c,handler:m,middleware:u})}({el:e,event:a,handler:v,middleware:x})},capture:f}}),y){var O={event:"blur",srcTarget:window,handler:function(t){return function(a){var i=a.el,d=a.event,c=a.handler,m=a.middleware;setTimeout(function(){var u=document.activeElement;u&&u.tagName==="IFRAME"&&!i.contains(u)&&p({event:d,handler:c,middleware:m})},0)}({el:e,event:t,handler:v,middleware:x})},capture:f};e[o]=[].concat(e[o],[O])}e[o].forEach(function(t){var a=t.event,i=t.srcTarget,d=t.handler;return setTimeout(function(){e[o]&&i.addEventListener(a,d,f)},0)})}},g=function(e){(e[o]||[]).forEach(function(n){return n.srcTarget.removeEventListener(n.event,n.handler,n.capture)}),delete e[o]},E=l?{beforeMount:w,updated:function(e,n){var r=n.value,v=n.oldValue;JSON.stringify(r)!==JSON.stringify(v)&&(g(e),w(e,{value:r}))},unmounted:g}:{};return{install:function(e){e.directive("click-outside",E)},directive:E}})})(I);const C=h;export{C as v};
