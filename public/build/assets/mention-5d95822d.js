Array.prototype.find||(Array.prototype.find=function(b){if(this===null)throw new TypeError("Array.prototype.find called on null or undefined");if(typeof b!="function")throw new TypeError("predicate must be a function");for(var e=Object(this),t=e.length>>>0,i=arguments[1],n,r=0;r<t;r++)if(n=e[r],b.call(i,n,r,e))return n});if(window&&typeof window.CustomEvent!="function"){let b=function(e,t){t=t||{bubbles:!1,cancelable:!1,detail:void 0};var i=document.createEvent("CustomEvent");return i.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),i};typeof window.Event<"u"&&(b.prototype=window.Event.prototype),window.CustomEvent=b}class A{constructor(e){this.tribute=e,this.tribute.events=this}static keys(){return[{key:9,value:"TAB"},{key:8,value:"DELETE"},{key:13,value:"ENTER"},{key:27,value:"ESCAPE"},{key:32,value:"SPACE"},{key:38,value:"UP"},{key:40,value:"DOWN"}]}bind(e){e.boundKeydown=this.keydown.bind(e,this),e.boundKeyup=this.keyup.bind(e,this),e.boundInput=this.input.bind(e,this),e.addEventListener("keydown",e.boundKeydown,!1),e.addEventListener("keyup",e.boundKeyup,!1),e.addEventListener("input",e.boundInput,!1)}unbind(e){e.removeEventListener("keydown",e.boundKeydown,!1),e.removeEventListener("keyup",e.boundKeyup,!1),e.removeEventListener("input",e.boundInput,!1),delete e.boundKeydown,delete e.boundKeyup,delete e.boundInput}keydown(e,t){e.shouldDeactivate(t)&&(e.tribute.isActive=!1,e.tribute.hideMenu());let i=this;e.commandEvent=!1,A.keys().forEach(n=>{n.key===t.keyCode&&(e.commandEvent=!0,e.callbacks()[n.value.toLowerCase()](t,i))})}input(e,t){e.inputEvent=!0,e.keyup.call(this,e,t)}click(e,t){let i=e.tribute;if(i.menu&&i.menu.contains(t.target)){let n=t.target;for(t.preventDefault(),t.stopPropagation();n.nodeName.toLowerCase()!=="li";)if(n=n.parentNode,!n||n===i.menu)throw new Error("cannot find the <li> container for the click");i.selectItemAtIndex(n.getAttribute("data-index"),t),i.hideMenu()}else i.current.element&&!i.current.externalTrigger&&(i.current.externalTrigger=!1,setTimeout(()=>i.hideMenu()))}keyup(e,t){if(e.inputEvent&&(e.inputEvent=!1),e.updateSelection(this),t.keyCode!==27){if(!e.tribute.allowSpaces&&e.tribute.hasTrailingSpace){e.tribute.hasTrailingSpace=!1,e.commandEvent=!0,e.callbacks().space(t,this);return}if(!e.tribute.isActive)if(e.tribute.autocompleteMode)e.callbacks().triggerChar(t,this,"");else{let i=e.getKeyCode(e,this,t);if(isNaN(i)||!i)return;let n=e.tribute.triggers().find(r=>r.charCodeAt(0)===i);typeof n<"u"&&e.callbacks().triggerChar(t,this,n)}e.tribute.current.mentionText.length<e.tribute.current.collection.menuShowMinLength||((e.tribute.current.trigger||e.tribute.autocompleteMode)&&e.commandEvent===!1||e.tribute.isActive&&t.keyCode===8)&&e.tribute.showMenuFor(this,!0)}}shouldDeactivate(e){if(!this.tribute.isActive)return!1;if(this.tribute.current.mentionText.length===0){let t=!1;return A.keys().forEach(i=>{e.keyCode===i.key&&(t=!0)}),!t}return!1}getKeyCode(e,t,i){let n=e.tribute,r=n.range.getTriggerInfo(!1,n.hasTrailingSpace,!0,n.allowSpaces,n.autocompleteMode);return r?r.mentionTriggerChar.charCodeAt(0):!1}updateSelection(e){this.tribute.current.element=e;let t=this.tribute.range.getTriggerInfo(!1,this.tribute.hasTrailingSpace,!0,this.tribute.allowSpaces,this.tribute.autocompleteMode);t&&(this.tribute.current.selectedPath=t.mentionSelectedPath,this.tribute.current.mentionText=t.mentionText,this.tribute.current.selectedOffset=t.mentionSelectedOffset)}callbacks(){return{triggerChar:(e,t,i)=>{let n=this.tribute;n.current.trigger=i;let r=n.collection.find(o=>o.trigger===i);n.current.collection=r,n.current.mentionText.length>=n.current.collection.menuShowMinLength&&n.inputEvent&&n.showMenuFor(t,!0)},enter:(e,t)=>{this.tribute.isActive&&this.tribute.current.filteredItems&&(e.preventDefault(),e.stopPropagation(),setTimeout(()=>{this.tribute.selectItemAtIndex(this.tribute.menuSelected,e),this.tribute.hideMenu()},0))},escape:(e,t)=>{this.tribute.isActive&&(e.preventDefault(),e.stopPropagation(),this.tribute.isActive=!1,this.tribute.hideMenu())},tab:(e,t)=>{this.callbacks().enter(e,t)},space:(e,t)=>{this.tribute.isActive&&(this.tribute.spaceSelectsMatch?this.callbacks().enter(e,t):this.tribute.allowSpaces||(e.stopPropagation(),setTimeout(()=>{this.tribute.hideMenu(),this.tribute.isActive=!1},0)))},up:(e,t)=>{if(this.tribute.isActive&&this.tribute.current.filteredItems){e.preventDefault(),e.stopPropagation();let i=this.tribute.current.filteredItems.length,n=this.tribute.menuSelected;i>n&&n>0?(this.tribute.menuSelected--,this.setActiveLi()):n===0&&(this.tribute.menuSelected=i-1,this.setActiveLi(),this.tribute.menu.scrollTop=this.tribute.menu.scrollHeight)}},down:(e,t)=>{if(this.tribute.isActive&&this.tribute.current.filteredItems){e.preventDefault(),e.stopPropagation();let i=this.tribute.current.filteredItems.length-1,n=this.tribute.menuSelected;i>n?(this.tribute.menuSelected++,this.setActiveLi()):i===n&&(this.tribute.menuSelected=0,this.setActiveLi(),this.tribute.menu.scrollTop=0)}},delete:(e,t)=>{this.tribute.isActive&&this.tribute.current.mentionText.length<1?this.tribute.hideMenu():this.tribute.isActive&&this.tribute.showMenuFor(t)}}}setActiveLi(e){let t=this.tribute.menu.querySelectorAll("li"),i=t.length>>>0;e&&(this.tribute.menuSelected=parseInt(e));for(let n=0;n<i;n++){let r=t[n];if(n===this.tribute.menuSelected){r.classList.add(this.tribute.current.collection.selectClass);let o=r.getBoundingClientRect(),s=this.tribute.menu.getBoundingClientRect();if(o.bottom>s.bottom){let l=o.bottom-s.bottom;this.tribute.menu.scrollTop+=l}else if(o.top<s.top){let l=s.top-o.top;this.tribute.menu.scrollTop-=l}}else r.classList.remove(this.tribute.current.collection.selectClass)}}getFullHeight(e,t){let i=e.getBoundingClientRect().height;if(t){let n=e.currentStyle||window.getComputedStyle(e);return i+parseFloat(n.marginTop)+parseFloat(n.marginBottom)}return i}}class M{constructor(e){this.tribute=e,this.tribute.menuEvents=this,this.menu=this.tribute.menu}bind(e){this.menuClickEvent=this.tribute.events.click.bind(null,this),this.menuContainerScrollEvent=this.debounce(()=>{this.tribute.isActive&&this.tribute.showMenuFor(this.tribute.current.element,!1)},300,!1),this.windowResizeEvent=this.debounce(()=>{this.tribute.isActive&&this.tribute.range.positionMenuAtCaret(!0)},300,!1),this.tribute.range.getDocument().addEventListener("MSPointerDown",this.menuClickEvent,!1),this.tribute.range.getDocument().addEventListener("mousedown",this.menuClickEvent,!1),window.addEventListener("resize",this.windowResizeEvent),this.menuContainer?this.menuContainer.addEventListener("scroll",this.menuContainerScrollEvent,!1):window.addEventListener("scroll",this.menuContainerScrollEvent)}unbind(e){this.tribute.range.getDocument().removeEventListener("mousedown",this.menuClickEvent,!1),this.tribute.range.getDocument().removeEventListener("MSPointerDown",this.menuClickEvent,!1),window.removeEventListener("resize",this.windowResizeEvent),this.menuContainer?this.menuContainer.removeEventListener("scroll",this.menuContainerScrollEvent,!1):window.removeEventListener("scroll",this.menuContainerScrollEvent)}debounce(e,t,i){var n;return()=>{var r=this,o=arguments,s=()=>{n=null,i||e.apply(r,o)},l=i&&!n;clearTimeout(n),n=setTimeout(s,t),l&&e.apply(r,o)}}}class L{constructor(e){this.tribute=e,this.tribute.range=this}getDocument(){let e;return this.tribute.current.collection&&(e=this.tribute.current.collection.iframe),e?e.contentWindow.document:document}positionMenuAtCaret(e){let t=this.tribute.current,i,n=this.getTriggerInfo(!1,this.tribute.hasTrailingSpace,!0,this.tribute.allowSpaces,this.tribute.autocompleteMode);if(typeof n<"u"){if(!this.tribute.positionMenu){this.tribute.menu.style.cssText="display: block;";return}this.isContentEditable(t.element)?i=this.getContentEditableCaretPosition(n.mentionPosition):i=this.getTextAreaOrInputUnderlinePosition(this.tribute.current.element,n.mentionPosition),this.tribute.menu.style.cssText=`top: ${i.top}px;
                                     left: ${i.left}px;
                                     right: ${i.right}px;
                                     bottom: ${i.bottom}px;
                                     position: absolute;
                                     display: block;`,i.left==="auto"&&(this.tribute.menu.style.left="auto"),i.top==="auto"&&(this.tribute.menu.style.top="auto"),e&&this.scrollIntoView(),window.setTimeout(()=>{let r={width:this.tribute.menu.offsetWidth,height:this.tribute.menu.offsetHeight},o=this.isMenuOffScreen(i,r),s=window.innerWidth>r.width&&(o.left||o.right),l=window.innerHeight>r.height&&(o.top||o.bottom);(s||l)&&(this.tribute.menu.style.cssText="display: none",this.positionMenuAtCaret(e))},0)}else this.tribute.menu.style.cssText="display: none"}get menuContainerIsBody(){return this.tribute.menuContainer===document.body||!this.tribute.menuContainer}selectElement(e,t,i){let n,r=e;if(t)for(var o=0;o<t.length;o++){if(r=r.childNodes[t[o]],r===void 0)return;for(;r.length<i;)i-=r.length,r=r.nextSibling;r.childNodes.length===0&&!r.length&&(r=r.previousSibling)}let s=this.getWindowSelection();n=this.getDocument().createRange(),n.setStart(r,i),n.setEnd(r,i),n.collapse(!0);try{s.removeAllRanges()}catch{}s.addRange(n),e.focus()}replaceTriggerText(e,t,i,n,r){let o=this.getTriggerInfo(!0,i,t,this.tribute.allowSpaces,this.tribute.autocompleteMode);if(o!==void 0){let s=this.tribute.current,l=new CustomEvent("tribute-replaced",{detail:{item:r,instance:s,context:o,event:n}});if(this.isContentEditable(s.element)){let c=typeof this.tribute.replaceTextSuffix=="string"?this.tribute.replaceTextSuffix:" ";e+=c;let u=o.mentionPosition+o.mentionText.length;this.tribute.autocompleteMode||(u+=o.mentionTriggerChar.length),this.pasteHtml(e,o.mentionPosition,u)}else{let c=this.tribute.current.element,u=typeof this.tribute.replaceTextSuffix=="string"?this.tribute.replaceTextSuffix:" ";e+=u;let d=o.mentionPosition,a=o.mentionPosition+o.mentionText.length+u.length;this.tribute.autocompleteMode||(a+=o.mentionTriggerChar.length-1),c.value=c.value.substring(0,d)+e+c.value.substring(a,c.value.length),c.selectionStart=d+e.length,c.selectionEnd=d+e.length}s.element.dispatchEvent(new CustomEvent("input",{bubbles:!0})),s.element.dispatchEvent(l)}}pasteHtml(e,t,i){let n,r;r=this.getWindowSelection(),n=this.getDocument().createRange(),n.setStart(r.anchorNode,t),n.setEnd(r.anchorNode,i),n.deleteContents();let o=this.getDocument().createElement("div");o.innerHTML=e;let s=this.getDocument().createDocumentFragment(),l,c;for(;l=o.firstChild;)c=s.appendChild(l);n.insertNode(s),c&&(n=n.cloneRange(),n.setStartAfter(c),n.collapse(!0),r.removeAllRanges(),r.addRange(n))}getWindowSelection(){return this.tribute.collection.iframe?this.tribute.collection.iframe.contentWindow.getSelection():window.getSelection()}getNodePositionInParent(e){if(e.parentNode===null)return 0;for(var t=0;t<e.parentNode.childNodes.length;t++)if(e.parentNode.childNodes[t]===e)return t}getContentEditableSelectedPath(e){let t=this.getWindowSelection(),i=t.anchorNode,n=[],r;if(i!=null){let o,s=i.contentEditable;for(;i!==null&&s!=="true";)o=this.getNodePositionInParent(i),n.push(o),i=i.parentNode,i!==null&&(s=i.contentEditable);return n.reverse(),r=t.getRangeAt(0).startOffset,{selected:i,path:n,offset:r}}}getTextPrecedingCurrentSelection(){let e=this.tribute.current,t="";if(this.isContentEditable(e.element)){let i=this.getWindowSelection().anchorNode;if(i!=null){let n=i.textContent,r=this.getWindowSelection().getRangeAt(0).startOffset;n&&r>=0&&(t=n.substring(0,r))}}else{let i=this.tribute.current.element;if(i){let n=i.selectionStart;i.value&&n>=0&&(t=i.value.substring(0,n))}}return t}getLastWordInText(e){e=e.replace(/\u00A0/g," ");let t=e.split(/\s+/),i=t.length-1;return t[i].trim()}getTriggerInfo(e,t,i,n,r){let o=this.tribute.current,s,l,c;if(!this.isContentEditable(o.element))s=this.tribute.current.element;else{let a=this.getContentEditableSelectedPath(o);a&&(s=a.selected,l=a.path,c=a.offset)}let u=this.getTextPrecedingCurrentSelection(),d=this.getLastWordInText(u);if(r)return{mentionPosition:u.length-d.length,mentionText:d,mentionSelectedElement:s,mentionSelectedPath:l,mentionSelectedOffset:c};if(u!=null){let a=-1,p;if(this.tribute.collection.forEach(h=>{let m=h.trigger,f=h.requireLeadingSpace?this.lastIndexWithLeadingSpace(u,m):u.lastIndexOf(m);f>a&&(a=f,p=m,i=h.requireLeadingSpace)}),a>=0&&(a===0||!i||/[\xA0\s]/g.test(u.substring(a-1,a)))){let h=u.substring(a+p.length,u.length);p=u.substring(a,a+p.length);let m=h.substring(0,1),f=h.length>0&&(m===" "||m===" ");t&&(h=h.trim());let w=n?/[^\S ]/g:/[\xA0\s]/g;if(this.tribute.hasTrailingSpace=w.test(h),!f&&(e||!w.test(h)))return{mentionPosition:a,mentionText:h,mentionSelectedElement:s,mentionSelectedPath:l,mentionSelectedOffset:c,mentionTriggerChar:p}}}}lastIndexWithLeadingSpace(e,t){let i=e.split("").reverse().join(""),n=-1;for(let r=0,o=e.length;r<o;r++){let s=r===e.length-1,l=/\s/.test(i[r+1]),c=!0;for(let u=t.length-1;u>=0;u--)if(t[u]!==i[r-u]){c=!1;break}if(c&&(s||l)){n=e.length-1-r;break}}return n}isContentEditable(e){return e.nodeName!=="INPUT"&&e.nodeName!=="TEXTAREA"}isMenuOffScreen(e,t){let i=window.innerWidth,n=window.innerHeight,r=document.documentElement,o=(window.pageXOffset||r.scrollLeft)-(r.clientLeft||0),s=(window.pageYOffset||r.scrollTop)-(r.clientTop||0),l=typeof e.top=="number"?e.top:s+n-e.bottom-t.height,c=typeof e.right=="number"?e.right:e.left+t.width,u=typeof e.bottom=="number"?e.bottom:e.top+t.height,d=typeof e.left=="number"?e.left:o+i-e.right-t.width;return{top:l<Math.floor(s),right:c>Math.ceil(o+i),bottom:u>Math.ceil(s+n),left:d<Math.floor(o)}}getMenuDimensions(){let e={width:null,height:null};return this.tribute.menu.style.cssText=`top: 0px;
                                 left: 0px;
                                 position: fixed;
                                 display: block;
                                 visibility; hidden;`,e.width=this.tribute.menu.offsetWidth,e.height=this.tribute.menu.offsetHeight,this.tribute.menu.style.cssText="display: none;",e}getTextAreaOrInputUnderlinePosition(e,t,i){let n=["direction","boxSizing","width","height","overflowX","overflowY","borderTopWidth","borderRightWidth","borderBottomWidth","borderLeftWidth","paddingTop","paddingRight","paddingBottom","paddingLeft","fontStyle","fontVariant","fontWeight","fontStretch","fontSize","fontSizeAdjust","lineHeight","fontFamily","textAlign","textTransform","textIndent","textDecoration","letterSpacing","wordSpacing"],r=window.mozInnerScreenX!==null,o=this.getDocument().createElement("div");o.id="input-textarea-caret-position-mirror-div",this.getDocument().body.appendChild(o);let s=o.style,l=window.getComputedStyle?getComputedStyle(e):e.currentStyle;s.whiteSpace="pre-wrap",e.nodeName!=="INPUT"&&(s.wordWrap="break-word"),s.position="absolute",s.visibility="hidden",n.forEach(S=>{s[S]=l[S]}),r?(s.width=`${parseInt(l.width)-2}px`,e.scrollHeight>parseInt(l.height)&&(s.overflowY="scroll")):s.overflow="hidden",o.textContent=e.value.substring(0,t),e.nodeName==="INPUT"&&(o.textContent=o.textContent.replace(/\s/g," "));let c=this.getDocument().createElement("span");c.textContent=e.value.substring(t)||".",o.appendChild(c);let u=e.getBoundingClientRect(),d=document.documentElement,a=(window.pageXOffset||d.scrollLeft)-(d.clientLeft||0),p=(window.pageYOffset||d.scrollTop)-(d.clientTop||0),h=0,m=0;this.menuContainerIsBody&&(h=u.top,m=u.left);let f={top:h+p+c.offsetTop+parseInt(l.borderTopWidth)+parseInt(l.fontSize)-e.scrollTop,left:m+a+c.offsetLeft+parseInt(l.borderLeftWidth)},w=window.innerWidth,y=window.innerHeight,v=this.getMenuDimensions(),T=this.isMenuOffScreen(f,v);T.right&&(f.right=w-f.left,f.left="auto");let x=this.tribute.menuContainer?this.tribute.menuContainer.offsetHeight:this.getDocument().body.offsetHeight;if(T.bottom){let S=this.tribute.menuContainer?this.tribute.menuContainer.getBoundingClientRect():this.getDocument().body.getBoundingClientRect(),g=x-(y-S.top);f.bottom=g+(y-u.top-c.offsetTop),f.top="auto"}return T=this.isMenuOffScreen(f,v),T.left&&(f.left=w>v.width?a+w-v.width:a,delete f.right),T.top&&(f.top=y>v.height?p+y-v.height:p,delete f.bottom),this.getDocument().body.removeChild(o),f}getContentEditableCaretPosition(e){let t,i=this.getWindowSelection();t=this.getDocument().createRange(),t.setStart(i.anchorNode,e),t.setEnd(i.anchorNode,e),t.collapse(!1);let n=t.getBoundingClientRect(),r=document.documentElement,o=(window.pageXOffset||r.scrollLeft)-(r.clientLeft||0),s=(window.pageYOffset||r.scrollTop)-(r.clientTop||0),l=n.left,c=n.top,u={left:l+o,top:c+n.height+s},d=window.innerWidth,a=window.innerHeight,p=this.getMenuDimensions(),h=this.isMenuOffScreen(u,p);h.right&&(u.left="auto",u.right=d-n.left-o);let m=this.tribute.menuContainer?this.tribute.menuContainer.offsetHeight:this.getDocument().body.offsetHeight;if(h.bottom){let f=this.tribute.menuContainer?this.tribute.menuContainer.getBoundingClientRect():this.getDocument().body.getBoundingClientRect(),w=m-(a-f.top);u.top="auto",u.bottom=w+(a-n.top)}return h=this.isMenuOffScreen(u,p),h.left&&(u.left=d>p.width?o+d-p.width:o,delete u.right),h.top&&(u.top=a>p.height?s+a-p.height:s,delete u.bottom),this.menuContainerIsBody||(u.left=u.left?u.left-this.tribute.menuContainer.offsetLeft:u.left,u.top=u.top?u.top-this.tribute.menuContainer.offsetTop:u.top),u}scrollIntoView(e){let t=20,i,n=100,r=this.menu;if(typeof r>"u")return;for(;i===void 0||i.height===0;)if(i=r.getBoundingClientRect(),i.height===0&&(r=r.childNodes[0],r===void 0||!r.getBoundingClientRect))return;let o=i.top,s=o+i.height;if(o<0)window.scrollTo(0,window.pageYOffset+i.top-t);else if(s>window.innerHeight){let l=window.pageYOffset+i.top-t;l-window.pageYOffset>n&&(l=window.pageYOffset+n);let c=window.pageYOffset-(window.innerHeight-s);c>l&&(c=l),window.scrollTo(0,c)}}}class k{constructor(e){this.tribute=e,this.tribute.search=this}simpleFilter(e,t){return t.filter(i=>this.test(e,i))}test(e,t){return this.match(e,t)!==null}match(e,t,i){i=i||{},t.length;let n=i.pre||"",r=i.post||"",o=i.caseSensitive&&t||t.toLowerCase();if(i.skip)return{rendered:t,score:0};e=i.caseSensitive&&e||e.toLowerCase();let s=this.traverse(o,e,0,0,[]);return s?{rendered:this.render(t,s.cache,n,r),score:s.score}:null}traverse(e,t,i,n,r){if(t.length===n)return{score:this.calculateScore(r),cache:r.slice()};if(e.length===i||t.length-n>e.length-i)return;let o=t[n],s=e.indexOf(o,i),l,c;for(;s>-1;){if(r.push(s),c=this.traverse(e,t,s+1,n+1,r),r.pop(),!c)return l;(!l||l.score<c.score)&&(l=c),s=e.indexOf(o,s+1)}return l}calculateScore(e){let t=0,i=1;return e.forEach((n,r)=>{r>0&&(e[r-1]+1===n?i+=i+1:i=1),t+=i}),t}render(e,t,i,n){var r=e.substring(0,t[0]);return t.forEach((o,s)=>{r+=i+e[o]+n+e.substring(o+1,t[s+1]?t[s+1]:e.length)}),r}filter(e,t,i){return i=i||{},t.reduce((n,r,o,s)=>{let l=r;i.extract&&(l=i.extract(r),l||(l=""));let c=this.match(e,l,i);return c!=null&&(n[n.length]={string:c.rendered,score:c.score,index:o,original:r}),n},[]).sort((n,r)=>{let o=r.score-n.score;return o||n.index-r.index})}}class C{constructor({values:e=null,iframe:t=null,selectClass:i="highlight",containerClass:n="tribute-container",itemClass:r="",trigger:o="@",autocompleteMode:s=!1,selectTemplate:l=null,menuItemTemplate:c=null,lookup:u="key",fillAttr:d="value",collection:a=null,menuContainer:p=null,noMatchTemplate:h=null,requireLeadingSpace:m=!0,allowSpaces:f=!1,replaceTextSuffix:w=null,positionMenu:y=!0,spaceSelectsMatch:v=!1,searchOpts:T={},menuItemLimit:x=null,menuShowMinLength:S=0}){if(this.autocompleteMode=s,this.menuSelected=0,this.current={},this.inputEvent=!1,this.isActive=!1,this.menuContainer=p,this.allowSpaces=f,this.replaceTextSuffix=w,this.positionMenu=y,this.hasTrailingSpace=!1,this.spaceSelectsMatch=v,this.autocompleteMode&&(o="",f=!1),e)this.collection=[{trigger:o,iframe:t,selectClass:i,containerClass:n,itemClass:r,selectTemplate:(l||C.defaultSelectTemplate).bind(this),menuItemTemplate:(c||C.defaultMenuItemTemplate).bind(this),noMatchTemplate:(g=>typeof g=="string"?g.trim()===""?null:g:typeof g=="function"?g.bind(this):h||function(){return"<li>No Match Found!</li>"}.bind(this))(h),lookup:u,fillAttr:d,values:e,requireLeadingSpace:m,searchOpts:T,menuItemLimit:x,menuShowMinLength:S}];else if(a)this.autocompleteMode&&console.warn("Tribute in autocomplete mode does not work for collections"),this.collection=a.map(g=>({trigger:g.trigger||o,iframe:g.iframe||t,selectClass:g.selectClass||i,containerClass:g.containerClass||n,itemClass:g.itemClass||r,selectTemplate:(g.selectTemplate||C.defaultSelectTemplate).bind(this),menuItemTemplate:(g.menuItemTemplate||C.defaultMenuItemTemplate).bind(this),noMatchTemplate:(E=>typeof E=="string"?E.trim()===""?null:E:typeof E=="function"?E.bind(this):h||function(){return"<li>No Match Found!</li>"}.bind(this))(h),lookup:g.lookup||u,fillAttr:g.fillAttr||d,values:g.values,requireLeadingSpace:g.requireLeadingSpace,searchOpts:g.searchOpts||T,menuItemLimit:g.menuItemLimit||x,menuShowMinLength:g.menuShowMinLength||S}));else throw new Error("[Tribute] No collection specified.");new L(this),new A(this),new M(this),new k(this)}get isActive(){return this._isActive}set isActive(e){if(this._isActive!=e&&(this._isActive=e,this.current.element)){let t=new CustomEvent(`tribute-active-${e}`);this.current.element.dispatchEvent(t)}}static defaultSelectTemplate(e){return typeof e>"u"?`${this.current.collection.trigger}${this.current.mentionText}`:this.range.isContentEditable(this.current.element)?'<span class="tribute-mention">'+(this.current.collection.trigger+e.original[this.current.collection.fillAttr])+"</span>":this.current.collection.trigger+e.original[this.current.collection.fillAttr]}static defaultMenuItemTemplate(e){return e.string}static inputTypes(){return["TEXTAREA","INPUT"]}triggers(){return this.collection.map(e=>e.trigger)}attach(e){if(!e)throw new Error("[Tribute] Must pass in a DOM node or NodeList.");if(typeof jQuery<"u"&&e instanceof jQuery&&(e=e.get()),e.constructor===NodeList||e.constructor===HTMLCollection||e.constructor===Array){let i=e.length;for(var t=0;t<i;++t)this._attach(e[t])}else this._attach(e)}_attach(e){e.hasAttribute("data-tribute")&&console.warn("Tribute was already bound to "+e.nodeName),this.ensureEditable(e),this.events.bind(e),e.setAttribute("data-tribute",!0)}ensureEditable(e){if(C.inputTypes().indexOf(e.nodeName)===-1)if(e.contentEditable)e.contentEditable=!0;else throw new Error("[Tribute] Cannot bind to "+e.nodeName)}createMenu(e){let t=this.range.getDocument().createElement("div"),i=this.range.getDocument().createElement("ul");return t.className=e,t.appendChild(i),this.menuContainer?this.menuContainer.appendChild(t):this.range.getDocument().body.appendChild(t)}showMenuFor(e,t){if(this.isActive&&this.current.element===e&&this.current.mentionText===this.currentMentionTextSnapshot)return;this.currentMentionTextSnapshot=this.current.mentionText,this.menu||(this.menu=this.createMenu(this.current.collection.containerClass),e.tributeMenu=this.menu,this.menuEvents.bind(this.menu)),this.isActive=!0,this.menuSelected=0,this.current.mentionText||(this.current.mentionText="");const i=n=>{if(!this.isActive)return;let r=this.search.filter(this.current.mentionText,n,{pre:this.current.collection.searchOpts.pre||"<span>",post:this.current.collection.searchOpts.post||"</span>",skip:this.current.collection.searchOpts.skip,extract:l=>{if(typeof this.current.collection.lookup=="string")return l[this.current.collection.lookup];if(typeof this.current.collection.lookup=="function")return this.current.collection.lookup(l,this.current.mentionText);throw new Error("Invalid lookup attribute, lookup must be string or function.")}});this.current.collection.menuItemLimit&&(r=r.slice(0,this.current.collection.menuItemLimit)),this.current.filteredItems=r;let o=this.menu.querySelector("ul");if(this.range.positionMenuAtCaret(t),!r.length){let l=new CustomEvent("tribute-no-match",{detail:this.menu});this.current.element.dispatchEvent(l),typeof this.current.collection.noMatchTemplate=="function"&&!this.current.collection.noMatchTemplate()||!this.current.collection.noMatchTemplate?this.hideMenu():typeof this.current.collection.noMatchTemplate=="function"?o.innerHTML=this.current.collection.noMatchTemplate():o.innerHTML=this.current.collection.noMatchTemplate;return}o.innerHTML="";let s=this.range.getDocument().createDocumentFragment();r.forEach((l,c)=>{let u=this.range.getDocument().createElement("li");u.setAttribute("data-index",c),u.className=this.current.collection.itemClass,u.addEventListener("mousemove",d=>{let[a,p]=this._findLiTarget(d.target);d.movementY!==0&&this.events.setActiveLi(p)}),this.menuSelected===c&&u.classList.add(this.current.collection.selectClass),u.innerHTML=this.current.collection.menuItemTemplate(l),s.appendChild(u)}),o.appendChild(s)};typeof this.current.collection.values=="function"?this.current.collection.values(this.current.mentionText,i):i(this.current.collection.values)}_findLiTarget(e){if(!e)return[];const t=e.getAttribute("data-index");return t?[e,t]:this._findLiTarget(e.parentNode)}showMenuForCollection(e,t){e!==document.activeElement&&this.placeCaretAtEnd(e),this.current.collection=this.collection[t||0],this.current.externalTrigger=!0,this.current.element=e,e.isContentEditable?this.insertTextAtCursor(this.current.collection.trigger):this.insertAtCaret(e,this.current.collection.trigger),this.showMenuFor(e)}placeCaretAtEnd(e){if(e.focus(),typeof window.getSelection<"u"&&typeof document.createRange<"u"){var t=document.createRange();t.selectNodeContents(e),t.collapse(!1);var i=window.getSelection();i.removeAllRanges(),i.addRange(t)}else if(typeof document.body.createTextRange<"u"){var n=document.body.createTextRange();n.moveToElementText(e),n.collapse(!1),n.select()}}insertTextAtCursor(e){var t,i;t=window.getSelection(),i=t.getRangeAt(0),i.deleteContents();var n=document.createTextNode(e);i.insertNode(n),i.selectNodeContents(n),i.collapse(!1),t.removeAllRanges(),t.addRange(i)}insertAtCaret(e,t){var i=e.scrollTop,n=e.selectionStart,r=e.value.substring(0,n),o=e.value.substring(e.selectionEnd,e.value.length);e.value=r+t+o,n=n+t.length,e.selectionStart=n,e.selectionEnd=n,e.focus(),e.scrollTop=i}hideMenu(){this.menu&&(this.menu.style.cssText="display: none;",this.isActive=!1,this.menuSelected=0,this.current={})}selectItemAtIndex(e,t){if(e=parseInt(e),typeof e!="number"||isNaN(e))return;let i=this.current.filteredItems[e],n=this.current.collection.selectTemplate(i);n!==null&&this.replaceText(n,t,i)}replaceText(e,t,i){this.range.replaceTriggerText(e,!0,!0,t,i)}_append(e,t,i){if(typeof e.values=="function")throw new Error("Unable to append to values, as it is a function.");i?e.values=t:e.values=e.values.concat(t)}append(e,t,i){let n=parseInt(e);if(typeof n!="number")throw new Error("please provide an index for the collection to update.");let r=this.collection[n];this._append(r,t,i)}appendCurrent(e,t){if(this.isActive)this._append(this.current.collection,e,t);else throw new Error("No active state. Please use append instead and pass an index.")}detach(e){if(!e)throw new Error("[Tribute] Must pass in a DOM node or NodeList.");if(typeof jQuery<"u"&&e instanceof jQuery&&(e=e.get()),e.constructor===NodeList||e.constructor===HTMLCollection||e.constructor===Array){let i=e.length;for(var t=0;t<i;++t)this._detach(e[t])}else this._detach(e)}_detach(e){this.events.unbind(e),e.tributeMenu&&this.menuEvents.unbind(e.tributeMenu),setTimeout(()=>{e.removeAttribute("data-tribute"),this.isActive=!1,e.tributeMenu&&e.tributeMenu.remove()})}}function I(){var b,e;const t=".kanka-mentions";if(e=$(t),e.length===0)return;b=e.first().data("remote");var i=new C({values:function(r,o){n(r,s=>o(s))},lookup:"name",menuShowMinLength:3,selectTemplate:function(r){return"["+r.original.model_type+":"+r.original.id+"]"},noMatchTemplate:function(){return null}});i.attach(document.querySelectorAll(t));function n(r,o){let s=new XMLHttpRequest;s.onreadystatechange=function(){if(s.readyState===4)if(s.status===200){var c=JSON.parse(s.responseText);o(c)}else s.status===403&&o([])};let l=b+"?q="+r;s.open("GET",l,!0),s.send()}}export{I as d};
