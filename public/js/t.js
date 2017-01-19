/*! jQuery v2.1.4 | (c) 2005, 2015 jQuery Foundation, Inc. | jquery.org/license */
!function(a,b){"object"==typeof module&&"object"==typeof module.exports?module.exports=a.document?b(a,!0):function(a){if(!a.document)throw new Error("jQuery requires a window with a document");return b(a)}:b(a)}("undefined"!=typeof window?window:this,function(a,b){var c=[],d=c.slice,e=c.concat,f=c.push,g=c.indexOf,h={},i=h.toString,j=h.hasOwnProperty,k={},l=a.document,m="2.1.4",n=function(a,b){return new n.fn.init(a,b)},o=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,p=/^-ms-/,q=/-([\da-z])/gi,r=function(a,b){return b.toUpperCase()};n.fn=n.prototype={jquery:m,constructor:n,selector:"",length:0,toArray:function(){return d.call(this)},get:function(a){return null!=a?0>a?this[a+this.length]:this[a]:d.call(this)},pushStack:function(a){var b=n.merge(this.constructor(),a);return b.prevObject=this,b.context=this.context,b},each:function(a,b){return n.each(this,a,b)},map:function(a){return this.pushStack(n.map(this,function(b,c){return a.call(b,c,b)}))},slice:function(){return this.pushStack(d.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(a){var b=this.length,c=+a+(0>a?b:0);return this.pushStack(c>=0&&b>c?[this[c]]:[])},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:c.sort,splice:c.splice},n.extend=n.fn.extend=function(){var a,b,c,d,e,f,g=arguments[0]||{},h=1,i=arguments.length,j=!1;for("boolean"==typeof g&&(j=g,g=arguments[h]||{},h++),"object"==typeof g||n.isFunction(g)||(g={}),h===i&&(g=this,h--);i>h;h++)if(null!=(a=arguments[h]))for(b in a)c=g[b],d=a[b],g!==d&&(j&&d&&(n.isPlainObject(d)||(e=n.isArray(d)))?(e?(e=!1,f=c&&n.isArray(c)?c:[]):f=c&&n.isPlainObject(c)?c:{},g[b]=n.extend(j,f,d)):void 0!==d&&(g[b]=d));return g},n.extend({expando:"jQuery"+(m+Math.random()).replace(/\D/g,""),isReady:!0,error:function(a){throw new Error(a)},noop:function(){},isFunction:function(a){return"function"===n.type(a)},isArray:Array.isArray,isWindow:function(a){return null!=a&&a===a.window},isNumeric:function(a){return!n.isArray(a)&&a-parseFloat(a)+1>=0},isPlainObject:function(a){return"object"!==n.type(a)||a.nodeType||n.isWindow(a)?!1:a.constructor&&!j.call(a.constructor.prototype,"isPrototypeOf")?!1:!0},isEmptyObject:function(a){var b;for(b in a)return!1;return!0},type:function(a){return null==a?a+"":"object"==typeof a||"function"==typeof a?h[i.call(a)]||"object":typeof a},globalEval:function(a){var b,c=eval;a=n.trim(a),a&&(1===a.indexOf("use strict")?(b=l.createElement("script"),b.text=a,l.head.appendChild(b).parentNode.removeChild(b)):c(a))},camelCase:function(a){return a.replace(p,"ms-").replace(q,r)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toLowerCase()===b.toLowerCase()},each:function(a,b,c){var d,e=0,f=a.length,g=s(a);if(c){if(g){for(;f>e;e++)if(d=b.apply(a[e],c),d===!1)break}else for(e in a)if(d=b.apply(a[e],c),d===!1)break}else if(g){for(;f>e;e++)if(d=b.call(a[e],e,a[e]),d===!1)break}else for(e in a)if(d=b.call(a[e],e,a[e]),d===!1)break;return a},trim:function(a){return null==a?"":(a+"").replace(o,"")},makeArray:function(a,b){var c=b||[];return null!=a&&(s(Object(a))?n.merge(c,"string"==typeof a?[a]:a):f.call(c,a)),c},inArray:function(a,b,c){return null==b?-1:g.call(b,a,c)},merge:function(a,b){for(var c=+b.length,d=0,e=a.length;c>d;d++)a[e++]=b[d];return a.length=e,a},grep:function(a,b,c){for(var d,e=[],f=0,g=a.length,h=!c;g>f;f++)d=!b(a[f],f),d!==h&&e.push(a[f]);return e},map:function(a,b,c){var d,f=0,g=a.length,h=s(a),i=[];if(h)for(;g>f;f++)d=b(a[f],f,c),null!=d&&i.push(d);else for(f in a)d=b(a[f],f,c),null!=d&&i.push(d);return e.apply([],i)},guid:1,proxy:function(a,b){var c,e,f;return"string"==typeof b&&(c=a[b],b=a,a=c),n.isFunction(a)?(e=d.call(arguments,2),f=function(){return a.apply(b||this,e.concat(d.call(arguments)))},f.guid=a.guid=a.guid||n.guid++,f):void 0},now:Date.now,support:k}),n.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(a,b){h["[object "+b+"]"]=b.toLowerCase()});function s(a){var b="length"in a&&a.length,c=n.type(a);return"function"===c||n.isWindow(a)?!1:1===a.nodeType&&b?!0:"array"===c||0===b||"number"==typeof b&&b>0&&b-1 in a}var t=function(a){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u="sizzle"+1*new Date,v=a.document,w=0,x=0,y=ha(),z=ha(),A=ha(),B=function(a,b){return a===b&&(l=!0),0},C=1<<31,D={}.hasOwnProperty,E=[],F=E.pop,G=E.push,H=E.push,I=E.slice,J=function(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1},K="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",L="[\\x20\\t\\r\\n\\f]",M="(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",N=M.replace("w","w#"),O="\\["+L+"*("+M+")(?:"+L+"*([*^$|!~]?=)"+L+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+N+"))|)"+L+"*\\]",P=":("+M+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+O+")*)|.*)\\)|)",Q=new RegExp(L+"+","g"),R=new RegExp("^"+L+"+|((?:^|[^\\\\])(?:\\\\.)*)"+L+"+$","g"),S=new RegExp("^"+L+"*,"+L+"*"),T=new RegExp("^"+L+"*([>+~]|"+L+")"+L+"*"),U=new RegExp("="+L+"*([^\\]'\"]*?)"+L+"*\\]","g"),V=new RegExp(P),W=new RegExp("^"+N+"$"),X={ID:new RegExp("^#("+M+")"),CLASS:new RegExp("^\\.("+M+")"),TAG:new RegExp("^("+M.replace("w","w*")+")"),ATTR:new RegExp("^"+O),PSEUDO:new RegExp("^"+P),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+L+"*(even|odd|(([+-]|)(\\d*)n|)"+L+"*(?:([+-]|)"+L+"*(\\d+)|))"+L+"*\\)|)","i"),bool:new RegExp("^(?:"+K+")$","i"),needsContext:new RegExp("^"+L+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+L+"*((?:-\\d)?\\d*)"+L+"*\\)|)(?=[^-]|$)","i")},Y=/^(?:input|select|textarea|button)$/i,Z=/^h\d$/i,$=/^[^{]+\{\s*\[native \w/,_=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,aa=/[+~]/,ba=/'|\\/g,ca=new RegExp("\\\\([\\da-f]{1,6}"+L+"?|("+L+")|.)","ig"),da=function(a,b,c){var d="0x"+b-65536;return d!==d||c?b:0>d?String.fromCharCode(d+65536):String.fromCharCode(d>>10|55296,1023&d|56320)},ea=function(){m()};try{H.apply(E=I.call(v.childNodes),v.childNodes),E[v.childNodes.length].nodeType}catch(fa){H={apply:E.length?function(a,b){G.apply(a,I.call(b))}:function(a,b){var c=a.length,d=0;while(a[c++]=b[d++]);a.length=c-1}}}function ga(a,b,d,e){var f,h,j,k,l,o,r,s,w,x;if((b?b.ownerDocument||b:v)!==n&&m(b),b=b||n,d=d||[],k=b.nodeType,"string"!=typeof a||!a||1!==k&&9!==k&&11!==k)return d;if(!e&&p){if(11!==k&&(f=_.exec(a)))if(j=f[1]){if(9===k){if(h=b.getElementById(j),!h||!h.parentNode)return d;if(h.id===j)return d.push(h),d}else if(b.ownerDocument&&(h=b.ownerDocument.getElementById(j))&&t(b,h)&&h.id===j)return d.push(h),d}else{if(f[2])return H.apply(d,b.getElementsByTagName(a)),d;if((j=f[3])&&c.getElementsByClassName)return H.apply(d,b.getElementsByClassName(j)),d}if(c.qsa&&(!q||!q.test(a))){if(s=r=u,w=b,x=1!==k&&a,1===k&&"object"!==b.nodeName.toLowerCase()){o=g(a),(r=b.getAttribute("id"))?s=r.replace(ba,"\\$&"):b.setAttribute("id",s),s="[id='"+s+"'] ",l=o.length;while(l--)o[l]=s+ra(o[l]);w=aa.test(a)&&pa(b.parentNode)||b,x=o.join(",")}if(x)try{return H.apply(d,w.querySelectorAll(x)),d}catch(y){}finally{r||b.removeAttribute("id")}}}return i(a.replace(R,"$1"),b,d,e)}function ha(){var a=[];function b(c,e){return a.push(c+" ")>d.cacheLength&&delete b[a.shift()],b[c+" "]=e}return b}function ia(a){return a[u]=!0,a}function ja(a){var b=n.createElement("div");try{return!!a(b)}catch(c){return!1}finally{b.parentNode&&b.parentNode.removeChild(b),b=null}}function ka(a,b){var c=a.split("|"),e=a.length;while(e--)d.attrHandle[c[e]]=b}function la(a,b){var c=b&&a,d=c&&1===a.nodeType&&1===b.nodeType&&(~b.sourceIndex||C)-(~a.sourceIndex||C);if(d)return d;if(c)while(c=c.nextSibling)if(c===b)return-1;return a?1:-1}function ma(a){return function(b){var c=b.nodeName.toLowerCase();return"input"===c&&b.type===a}}function na(a){return function(b){var c=b.nodeName.toLowerCase();return("input"===c||"button"===c)&&b.type===a}}function oa(a){return ia(function(b){return b=+b,ia(function(c,d){var e,f=a([],c.length,b),g=f.length;while(g--)c[e=f[g]]&&(c[e]=!(d[e]=c[e]))})})}function pa(a){return a&&"undefined"!=typeof a.getElementsByTagName&&a}c=ga.support={},f=ga.isXML=function(a){var b=a&&(a.ownerDocument||a).documentElement;return b?"HTML"!==b.nodeName:!1},m=ga.setDocument=function(a){var b,e,g=a?a.ownerDocument||a:v;return g!==n&&9===g.nodeType&&g.documentElement?(n=g,o=g.documentElement,e=g.defaultView,e&&e!==e.top&&(e.addEventListener?e.addEventListener("unload",ea,!1):e.attachEvent&&e.attachEvent("onunload",ea)),p=!f(g),c.attributes=ja(function(a){return a.className="i",!a.getAttribute("className")}),c.getElementsByTagName=ja(function(a){return a.appendChild(g.createComment("")),!a.getElementsByTagName("*").length}),c.getElementsByClassName=$.test(g.getElementsByClassName),c.getById=ja(function(a){return o.appendChild(a).id=u,!g.getElementsByName||!g.getElementsByName(u).length}),c.getById?(d.find.ID=function(a,b){if("undefined"!=typeof b.getElementById&&p){var c=b.getElementById(a);return c&&c.parentNode?[c]:[]}},d.filter.ID=function(a){var b=a.replace(ca,da);return function(a){return a.getAttribute("id")===b}}):(delete d.find.ID,d.filter.ID=function(a){var b=a.replace(ca,da);return function(a){var c="undefined"!=typeof a.getAttributeNode&&a.getAttributeNode("id");return c&&c.value===b}}),d.find.TAG=c.getElementsByTagName?function(a,b){return"undefined"!=typeof b.getElementsByTagName?b.getElementsByTagName(a):c.qsa?b.querySelectorAll(a):void 0}:function(a,b){var c,d=[],e=0,f=b.getElementsByTagName(a);if("*"===a){while(c=f[e++])1===c.nodeType&&d.push(c);return d}return f},d.find.CLASS=c.getElementsByClassName&&function(a,b){return p?b.getElementsByClassName(a):void 0},r=[],q=[],(c.qsa=$.test(g.querySelectorAll))&&(ja(function(a){o.appendChild(a).innerHTML="<a id='"+u+"'></a><select id='"+u+"-\f]' msallowcapture=''><option selected=''></option></select>",a.querySelectorAll("[msallowcapture^='']").length&&q.push("[*^$]="+L+"*(?:''|\"\")"),a.querySelectorAll("[selected]").length||q.push("\\["+L+"*(?:value|"+K+")"),a.querySelectorAll("[id~="+u+"-]").length||q.push("~="),a.querySelectorAll(":checked").length||q.push(":checked"),a.querySelectorAll("a#"+u+"+*").length||q.push(".#.+[+~]")}),ja(function(a){var b=g.createElement("input");b.setAttribute("type","hidden"),a.appendChild(b).setAttribute("name","D"),a.querySelectorAll("[name=d]").length&&q.push("name"+L+"*[*^$|!~]?="),a.querySelectorAll(":enabled").length||q.push(":enabled",":disabled"),a.querySelectorAll("*,:x"),q.push(",.*:")})),(c.matchesSelector=$.test(s=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.oMatchesSelector||o.msMatchesSelector))&&ja(function(a){c.disconnectedMatch=s.call(a,"div"),s.call(a,"[s!='']:x"),r.push("!=",P)}),q=q.length&&new RegExp(q.join("|")),r=r.length&&new RegExp(r.join("|")),b=$.test(o.compareDocumentPosition),t=b||$.test(o.contains)?function(a,b){var c=9===a.nodeType?a.documentElement:a,d=b&&b.parentNode;return a===d||!(!d||1!==d.nodeType||!(c.contains?c.contains(d):a.compareDocumentPosition&&16&a.compareDocumentPosition(d)))}:function(a,b){if(b)while(b=b.parentNode)if(b===a)return!0;return!1},B=b?function(a,b){if(a===b)return l=!0,0;var d=!a.compareDocumentPosition-!b.compareDocumentPosition;return d?d:(d=(a.ownerDocument||a)===(b.ownerDocument||b)?a.compareDocumentPosition(b):1,1&d||!c.sortDetached&&b.compareDocumentPosition(a)===d?a===g||a.ownerDocument===v&&t(v,a)?-1:b===g||b.ownerDocument===v&&t(v,b)?1:k?J(k,a)-J(k,b):0:4&d?-1:1)}:function(a,b){if(a===b)return l=!0,0;var c,d=0,e=a.parentNode,f=b.parentNode,h=[a],i=[b];if(!e||!f)return a===g?-1:b===g?1:e?-1:f?1:k?J(k,a)-J(k,b):0;if(e===f)return la(a,b);c=a;while(c=c.parentNode)h.unshift(c);c=b;while(c=c.parentNode)i.unshift(c);while(h[d]===i[d])d++;return d?la(h[d],i[d]):h[d]===v?-1:i[d]===v?1:0},g):n},ga.matches=function(a,b){return ga(a,null,null,b)},ga.matchesSelector=function(a,b){if((a.ownerDocument||a)!==n&&m(a),b=b.replace(U,"='$1']"),!(!c.matchesSelector||!p||r&&r.test(b)||q&&q.test(b)))try{var d=s.call(a,b);if(d||c.disconnectedMatch||a.document&&11!==a.document.nodeType)return d}catch(e){}return ga(b,n,null,[a]).length>0},ga.contains=function(a,b){return(a.ownerDocument||a)!==n&&m(a),t(a,b)},ga.attr=function(a,b){(a.ownerDocument||a)!==n&&m(a);var e=d.attrHandle[b.toLowerCase()],f=e&&D.call(d.attrHandle,b.toLowerCase())?e(a,b,!p):void 0;return void 0!==f?f:c.attributes||!p?a.getAttribute(b):(f=a.getAttributeNode(b))&&f.specified?f.value:null},ga.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)},ga.uniqueSort=function(a){var b,d=[],e=0,f=0;if(l=!c.detectDuplicates,k=!c.sortStable&&a.slice(0),a.sort(B),l){while(b=a[f++])b===a[f]&&(e=d.push(f));while(e--)a.splice(d[e],1)}return k=null,a},e=ga.getText=function(a){var b,c="",d=0,f=a.nodeType;if(f){if(1===f||9===f||11===f){if("string"==typeof a.textContent)return a.textContent;for(a=a.firstChild;a;a=a.nextSibling)c+=e(a)}else if(3===f||4===f)return a.nodeValue}else while(b=a[d++])c+=e(b);return c},d=ga.selectors={cacheLength:50,createPseudo:ia,match:X,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(a){return a[1]=a[1].replace(ca,da),a[3]=(a[3]||a[4]||a[5]||"").replace(ca,da),"~="===a[2]&&(a[3]=" "+a[3]+" "),a.slice(0,4)},CHILD:function(a){return a[1]=a[1].toLowerCase(),"nth"===a[1].slice(0,3)?(a[3]||ga.error(a[0]),a[4]=+(a[4]?a[5]+(a[6]||1):2*("even"===a[3]||"odd"===a[3])),a[5]=+(a[7]+a[8]||"odd"===a[3])):a[3]&&ga.error(a[0]),a},PSEUDO:function(a){var b,c=!a[6]&&a[2];return X.CHILD.test(a[0])?null:(a[3]?a[2]=a[4]||a[5]||"":c&&V.test(c)&&(b=g(c,!0))&&(b=c.indexOf(")",c.length-b)-c.length)&&(a[0]=a[0].slice(0,b),a[2]=c.slice(0,b)),a.slice(0,3))}},filter:{TAG:function(a){var b=a.replace(ca,da).toLowerCase();return"*"===a?function(){return!0}:function(a){return a.nodeName&&a.nodeName.toLowerCase()===b}},CLASS:function(a){var b=y[a+" "];return b||(b=new RegExp("(^|"+L+")"+a+"("+L+"|$)"))&&y(a,function(a){return b.test("string"==typeof a.className&&a.className||"undefined"!=typeof a.getAttribute&&a.getAttribute("class")||"")})},ATTR:function(a,b,c){return function(d){var e=ga.attr(d,a);return null==e?"!="===b:b?(e+="","="===b?e===c:"!="===b?e!==c:"^="===b?c&&0===e.indexOf(c):"*="===b?c&&e.indexOf(c)>-1:"$="===b?c&&e.slice(-c.length)===c:"~="===b?(" "+e.replace(Q," ")+" ").indexOf(c)>-1:"|="===b?e===c||e.slice(0,c.length+1)===c+"-":!1):!0}},CHILD:function(a,b,c,d,e){var f="nth"!==a.slice(0,3),g="last"!==a.slice(-4),h="of-type"===b;return 1===d&&0===e?function(a){return!!a.parentNode}:function(b,c,i){var j,k,l,m,n,o,p=f!==g?"nextSibling":"previousSibling",q=b.parentNode,r=h&&b.nodeName.toLowerCase(),s=!i&&!h;if(q){if(f){while(p){l=b;while(l=l[p])if(h?l.nodeName.toLowerCase()===r:1===l.nodeType)return!1;o=p="only"===a&&!o&&"nextSibling"}return!0}if(o=[g?q.firstChild:q.lastChild],g&&s){k=q[u]||(q[u]={}),j=k[a]||[],n=j[0]===w&&j[1],m=j[0]===w&&j[2],l=n&&q.childNodes[n];while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if(1===l.nodeType&&++m&&l===b){k[a]=[w,n,m];break}}else if(s&&(j=(b[u]||(b[u]={}))[a])&&j[0]===w)m=j[1];else while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if((h?l.nodeName.toLowerCase()===r:1===l.nodeType)&&++m&&(s&&((l[u]||(l[u]={}))[a]=[w,m]),l===b))break;return m-=e,m===d||m%d===0&&m/d>=0}}},PSEUDO:function(a,b){var c,e=d.pseudos[a]||d.setFilters[a.toLowerCase()]||ga.error("unsupported pseudo: "+a);return e[u]?e(b):e.length>1?(c=[a,a,"",b],d.setFilters.hasOwnProperty(a.toLowerCase())?ia(function(a,c){var d,f=e(a,b),g=f.length;while(g--)d=J(a,f[g]),a[d]=!(c[d]=f[g])}):function(a){return e(a,0,c)}):e}},pseudos:{not:ia(function(a){var b=[],c=[],d=h(a.replace(R,"$1"));return d[u]?ia(function(a,b,c,e){var f,g=d(a,null,e,[]),h=a.length;while(h--)(f=g[h])&&(a[h]=!(b[h]=f))}):function(a,e,f){return b[0]=a,d(b,null,f,c),b[0]=null,!c.pop()}}),has:ia(function(a){return function(b){return ga(a,b).length>0}}),contains:ia(function(a){return a=a.replace(ca,da),function(b){return(b.textContent||b.innerText||e(b)).indexOf(a)>-1}}),lang:ia(function(a){return W.test(a||"")||ga.error("unsupported lang: "+a),a=a.replace(ca,da).toLowerCase(),function(b){var c;do if(c=p?b.lang:b.getAttribute("xml:lang")||b.getAttribute("lang"))return c=c.toLowerCase(),c===a||0===c.indexOf(a+"-");while((b=b.parentNode)&&1===b.nodeType);return!1}}),target:function(b){var c=a.location&&a.location.hash;return c&&c.slice(1)===b.id},root:function(a){return a===o},focus:function(a){return a===n.activeElement&&(!n.hasFocus||n.hasFocus())&&!!(a.type||a.href||~a.tabIndex)},enabled:function(a){return a.disabled===!1},disabled:function(a){return a.disabled===!0},checked:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&!!a.checked||"option"===b&&!!a.selected},selected:function(a){return a.parentNode&&a.parentNode.selectedIndex,a.selected===!0},empty:function(a){for(a=a.firstChild;a;a=a.nextSibling)if(a.nodeType<6)return!1;return!0},parent:function(a){return!d.pseudos.empty(a)},header:function(a){return Z.test(a.nodeName)},input:function(a){return Y.test(a.nodeName)},button:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&"button"===a.type||"button"===b},text:function(a){var b;return"input"===a.nodeName.toLowerCase()&&"text"===a.type&&(null==(b=a.getAttribute("type"))||"text"===b.toLowerCase())},first:oa(function(){return[0]}),last:oa(function(a,b){return[b-1]}),eq:oa(function(a,b,c){return[0>c?c+b:c]}),even:oa(function(a,b){for(var c=0;b>c;c+=2)a.push(c);return a}),odd:oa(function(a,b){for(var c=1;b>c;c+=2)a.push(c);return a}),lt:oa(function(a,b,c){for(var d=0>c?c+b:c;--d>=0;)a.push(d);return a}),gt:oa(function(a,b,c){for(var d=0>c?c+b:c;++d<b;)a.push(d);return a})}},d.pseudos.nth=d.pseudos.eq;for(b in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})d.pseudos[b]=ma(b);for(b in{submit:!0,reset:!0})d.pseudos[b]=na(b);function qa(){}qa.prototype=d.filters=d.pseudos,d.setFilters=new qa,g=ga.tokenize=function(a,b){var c,e,f,g,h,i,j,k=z[a+" "];if(k)return b?0:k.slice(0);h=a,i=[],j=d.preFilter;while(h){(!c||(e=S.exec(h)))&&(e&&(h=h.slice(e[0].length)||h),i.push(f=[])),c=!1,(e=T.exec(h))&&(c=e.shift(),f.push({value:c,type:e[0].replace(R," ")}),h=h.slice(c.length));for(g in d.filter)!(e=X[g].exec(h))||j[g]&&!(e=j[g](e))||(c=e.shift(),f.push({value:c,type:g,matches:e}),h=h.slice(c.length));if(!c)break}return b?h.length:h?ga.error(a):z(a,i).slice(0)};function ra(a){for(var b=0,c=a.length,d="";c>b;b++)d+=a[b].value;return d}function sa(a,b,c){var d=b.dir,e=c&&"parentNode"===d,f=x++;return b.first?function(b,c,f){while(b=b[d])if(1===b.nodeType||e)return a(b,c,f)}:function(b,c,g){var h,i,j=[w,f];if(g){while(b=b[d])if((1===b.nodeType||e)&&a(b,c,g))return!0}else while(b=b[d])if(1===b.nodeType||e){if(i=b[u]||(b[u]={}),(h=i[d])&&h[0]===w&&h[1]===f)return j[2]=h[2];if(i[d]=j,j[2]=a(b,c,g))return!0}}}function ta(a){return a.length>1?function(b,c,d){var e=a.length;while(e--)if(!a[e](b,c,d))return!1;return!0}:a[0]}function ua(a,b,c){for(var d=0,e=b.length;e>d;d++)ga(a,b[d],c);return c}function va(a,b,c,d,e){for(var f,g=[],h=0,i=a.length,j=null!=b;i>h;h++)(f=a[h])&&(!c||c(f,d,e))&&(g.push(f),j&&b.push(h));return g}function wa(a,b,c,d,e,f){return d&&!d[u]&&(d=wa(d)),e&&!e[u]&&(e=wa(e,f)),ia(function(f,g,h,i){var j,k,l,m=[],n=[],o=g.length,p=f||ua(b||"*",h.nodeType?[h]:h,[]),q=!a||!f&&b?p:va(p,m,a,h,i),r=c?e||(f?a:o||d)?[]:g:q;if(c&&c(q,r,h,i),d){j=va(r,n),d(j,[],h,i),k=j.length;while(k--)(l=j[k])&&(r[n[k]]=!(q[n[k]]=l))}if(f){if(e||a){if(e){j=[],k=r.length;while(k--)(l=r[k])&&j.push(q[k]=l);e(null,r=[],j,i)}k=r.length;while(k--)(l=r[k])&&(j=e?J(f,l):m[k])>-1&&(f[j]=!(g[j]=l))}}else r=va(r===g?r.splice(o,r.length):r),e?e(null,g,r,i):H.apply(g,r)})}function xa(a){for(var b,c,e,f=a.length,g=d.relative[a[0].type],h=g||d.relative[" "],i=g?1:0,k=sa(function(a){return a===b},h,!0),l=sa(function(a){return J(b,a)>-1},h,!0),m=[function(a,c,d){var e=!g&&(d||c!==j)||((b=c).nodeType?k(a,c,d):l(a,c,d));return b=null,e}];f>i;i++)if(c=d.relative[a[i].type])m=[sa(ta(m),c)];else{if(c=d.filter[a[i].type].apply(null,a[i].matches),c[u]){for(e=++i;f>e;e++)if(d.relative[a[e].type])break;return wa(i>1&&ta(m),i>1&&ra(a.slice(0,i-1).concat({value:" "===a[i-2].type?"*":""})).replace(R,"$1"),c,e>i&&xa(a.slice(i,e)),f>e&&xa(a=a.slice(e)),f>e&&ra(a))}m.push(c)}return ta(m)}function ya(a,b){var c=b.length>0,e=a.length>0,f=function(f,g,h,i,k){var l,m,o,p=0,q="0",r=f&&[],s=[],t=j,u=f||e&&d.find.TAG("*",k),v=w+=null==t?1:Math.random()||.1,x=u.length;for(k&&(j=g!==n&&g);q!==x&&null!=(l=u[q]);q++){if(e&&l){m=0;while(o=a[m++])if(o(l,g,h)){i.push(l);break}k&&(w=v)}c&&((l=!o&&l)&&p--,f&&r.push(l))}if(p+=q,c&&q!==p){m=0;while(o=b[m++])o(r,s,g,h);if(f){if(p>0)while(q--)r[q]||s[q]||(s[q]=F.call(i));s=va(s)}H.apply(i,s),k&&!f&&s.length>0&&p+b.length>1&&ga.uniqueSort(i)}return k&&(w=v,j=t),r};return c?ia(f):f}return h=ga.compile=function(a,b){var c,d=[],e=[],f=A[a+" "];if(!f){b||(b=g(a)),c=b.length;while(c--)f=xa(b[c]),f[u]?d.push(f):e.push(f);f=A(a,ya(e,d)),f.selector=a}return f},i=ga.select=function(a,b,e,f){var i,j,k,l,m,n="function"==typeof a&&a,o=!f&&g(a=n.selector||a);if(e=e||[],1===o.length){if(j=o[0]=o[0].slice(0),j.length>2&&"ID"===(k=j[0]).type&&c.getById&&9===b.nodeType&&p&&d.relative[j[1].type]){if(b=(d.find.ID(k.matches[0].replace(ca,da),b)||[])[0],!b)return e;n&&(b=b.parentNode),a=a.slice(j.shift().value.length)}i=X.needsContext.test(a)?0:j.length;while(i--){if(k=j[i],d.relative[l=k.type])break;if((m=d.find[l])&&(f=m(k.matches[0].replace(ca,da),aa.test(j[0].type)&&pa(b.parentNode)||b))){if(j.splice(i,1),a=f.length&&ra(j),!a)return H.apply(e,f),e;break}}}return(n||h(a,o))(f,b,!p,e,aa.test(a)&&pa(b.parentNode)||b),e},c.sortStable=u.split("").sort(B).join("")===u,c.detectDuplicates=!!l,m(),c.sortDetached=ja(function(a){return 1&a.compareDocumentPosition(n.createElement("div"))}),ja(function(a){return a.innerHTML="<a href='#'></a>","#"===a.firstChild.getAttribute("href")})||ka("type|href|height|width",function(a,b,c){return c?void 0:a.getAttribute(b,"type"===b.toLowerCase()?1:2)}),c.attributes&&ja(function(a){return a.innerHTML="<input/>",a.firstChild.setAttribute("value",""),""===a.firstChild.getAttribute("value")})||ka("value",function(a,b,c){return c||"input"!==a.nodeName.toLowerCase()?void 0:a.defaultValue}),ja(function(a){return null==a.getAttribute("disabled")})||ka(K,function(a,b,c){var d;return c?void 0:a[b]===!0?b.toLowerCase():(d=a.getAttributeNode(b))&&d.specified?d.value:null}),ga}(a);n.find=t,n.expr=t.selectors,n.expr[":"]=n.expr.pseudos,n.unique=t.uniqueSort,n.text=t.getText,n.isXMLDoc=t.isXML,n.contains=t.contains;var u=n.expr.match.needsContext,v=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,w=/^.[^:#\[\.,]*$/;function x(a,b,c){if(n.isFunction(b))return n.grep(a,function(a,d){return!!b.call(a,d,a)!==c});if(b.nodeType)return n.grep(a,function(a){return a===b!==c});if("string"==typeof b){if(w.test(b))return n.filter(b,a,c);b=n.filter(b,a)}return n.grep(a,function(a){return g.call(b,a)>=0!==c})}n.filter=function(a,b,c){var d=b[0];return c&&(a=":not("+a+")"),1===b.length&&1===d.nodeType?n.find.matchesSelector(d,a)?[d]:[]:n.find.matches(a,n.grep(b,function(a){return 1===a.nodeType}))},n.fn.extend({find:function(a){var b,c=this.length,d=[],e=this;if("string"!=typeof a)return this.pushStack(n(a).filter(function(){for(b=0;c>b;b++)if(n.contains(e[b],this))return!0}));for(b=0;c>b;b++)n.find(a,e[b],d);return d=this.pushStack(c>1?n.unique(d):d),d.selector=this.selector?this.selector+" "+a:a,d},filter:function(a){return this.pushStack(x(this,a||[],!1))},not:function(a){return this.pushStack(x(this,a||[],!0))},is:function(a){return!!x(this,"string"==typeof a&&u.test(a)?n(a):a||[],!1).length}});var y,z=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,A=n.fn.init=function(a,b){var c,d;if(!a)return this;if("string"==typeof a){if(c="<"===a[0]&&">"===a[a.length-1]&&a.length>=3?[null,a,null]:z.exec(a),!c||!c[1]&&b)return!b||b.jquery?(b||y).find(a):this.constructor(b).find(a);if(c[1]){if(b=b instanceof n?b[0]:b,n.merge(this,n.parseHTML(c[1],b&&b.nodeType?b.ownerDocument||b:l,!0)),v.test(c[1])&&n.isPlainObject(b))for(c in b)n.isFunction(this[c])?this[c](b[c]):this.attr(c,b[c]);return this}return d=l.getElementById(c[2]),d&&d.parentNode&&(this.length=1,this[0]=d),this.context=l,this.selector=a,this}return a.nodeType?(this.context=this[0]=a,this.length=1,this):n.isFunction(a)?"undefined"!=typeof y.ready?y.ready(a):a(n):(void 0!==a.selector&&(this.selector=a.selector,this.context=a.context),n.makeArray(a,this))};A.prototype=n.fn,y=n(l);var B=/^(?:parents|prev(?:Until|All))/,C={children:!0,contents:!0,next:!0,prev:!0};n.extend({dir:function(a,b,c){var d=[],e=void 0!==c;while((a=a[b])&&9!==a.nodeType)if(1===a.nodeType){if(e&&n(a).is(c))break;d.push(a)}return d},sibling:function(a,b){for(var c=[];a;a=a.nextSibling)1===a.nodeType&&a!==b&&c.push(a);return c}}),n.fn.extend({has:function(a){var b=n(a,this),c=b.length;return this.filter(function(){for(var a=0;c>a;a++)if(n.contains(this,b[a]))return!0})},closest:function(a,b){for(var c,d=0,e=this.length,f=[],g=u.test(a)||"string"!=typeof a?n(a,b||this.context):0;e>d;d++)for(c=this[d];c&&c!==b;c=c.parentNode)if(c.nodeType<11&&(g?g.index(c)>-1:1===c.nodeType&&n.find.matchesSelector(c,a))){f.push(c);break}return this.pushStack(f.length>1?n.unique(f):f)},index:function(a){return a?"string"==typeof a?g.call(n(a),this[0]):g.call(this,a.jquery?a[0]:a):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(a,b){return this.pushStack(n.unique(n.merge(this.get(),n(a,b))))},addBack:function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}});function D(a,b){while((a=a[b])&&1!==a.nodeType);return a}n.each({parent:function(a){var b=a.parentNode;return b&&11!==b.nodeType?b:null},parents:function(a){return n.dir(a,"parentNode")},parentsUntil:function(a,b,c){return n.dir(a,"parentNode",c)},next:function(a){return D(a,"nextSibling")},prev:function(a){return D(a,"previousSibling")},nextAll:function(a){return n.dir(a,"nextSibling")},prevAll:function(a){return n.dir(a,"previousSibling")},nextUntil:function(a,b,c){return n.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return n.dir(a,"previousSibling",c)},siblings:function(a){return n.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return n.sibling(a.firstChild)},contents:function(a){return a.contentDocument||n.merge([],a.childNodes)}},function(a,b){n.fn[a]=function(c,d){var e=n.map(this,b,c);return"Until"!==a.slice(-5)&&(d=c),d&&"string"==typeof d&&(e=n.filter(d,e)),this.length>1&&(C[a]||n.unique(e),B.test(a)&&e.reverse()),this.pushStack(e)}});var E=/\S+/g,F={};function G(a){var b=F[a]={};return n.each(a.match(E)||[],function(a,c){b[c]=!0}),b}n.Callbacks=function(a){a="string"==typeof a?F[a]||G(a):n.extend({},a);var b,c,d,e,f,g,h=[],i=!a.once&&[],j=function(l){for(b=a.memory&&l,c=!0,g=e||0,e=0,f=h.length,d=!0;h&&f>g;g++)if(h[g].apply(l[0],l[1])===!1&&a.stopOnFalse){b=!1;break}d=!1,h&&(i?i.length&&j(i.shift()):b?h=[]:k.disable())},k={add:function(){if(h){var c=h.length;!function g(b){n.each(b,function(b,c){var d=n.type(c);"function"===d?a.unique&&k.has(c)||h.push(c):c&&c.length&&"string"!==d&&g(c)})}(arguments),d?f=h.length:b&&(e=c,j(b))}return this},remove:function(){return h&&n.each(arguments,function(a,b){var c;while((c=n.inArray(b,h,c))>-1)h.splice(c,1),d&&(f>=c&&f--,g>=c&&g--)}),this},has:function(a){return a?n.inArray(a,h)>-1:!(!h||!h.length)},empty:function(){return h=[],f=0,this},disable:function(){return h=i=b=void 0,this},disabled:function(){return!h},lock:function(){return i=void 0,b||k.disable(),this},locked:function(){return!i},fireWith:function(a,b){return!h||c&&!i||(b=b||[],b=[a,b.slice?b.slice():b],d?i.push(b):j(b)),this},fire:function(){return k.fireWith(this,arguments),this},fired:function(){return!!c}};return k},n.extend({Deferred:function(a){var b=[["resolve","done",n.Callbacks("once memory"),"resolved"],["reject","fail",n.Callbacks("once memory"),"rejected"],["notify","progress",n.Callbacks("memory")]],c="pending",d={state:function(){return c},always:function(){return e.done(arguments).fail(arguments),this},then:function(){var a=arguments;return n.Deferred(function(c){n.each(b,function(b,f){var g=n.isFunction(a[b])&&a[b];e[f[1]](function(){var a=g&&g.apply(this,arguments);a&&n.isFunction(a.promise)?a.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[f[0]+"With"](this===d?c.promise():this,g?[a]:arguments)})}),a=null}).promise()},promise:function(a){return null!=a?n.extend(a,d):d}},e={};return d.pipe=d.then,n.each(b,function(a,f){var g=f[2],h=f[3];d[f[1]]=g.add,h&&g.add(function(){c=h},b[1^a][2].disable,b[2][2].lock),e[f[0]]=function(){return e[f[0]+"With"](this===e?d:this,arguments),this},e[f[0]+"With"]=g.fireWith}),d.promise(e),a&&a.call(e,e),e},when:function(a){var b=0,c=d.call(arguments),e=c.length,f=1!==e||a&&n.isFunction(a.promise)?e:0,g=1===f?a:n.Deferred(),h=function(a,b,c){return function(e){b[a]=this,c[a]=arguments.length>1?d.call(arguments):e,c===i?g.notifyWith(b,c):--f||g.resolveWith(b,c)}},i,j,k;if(e>1)for(i=new Array(e),j=new Array(e),k=new Array(e);e>b;b++)c[b]&&n.isFunction(c[b].promise)?c[b].promise().done(h(b,k,c)).fail(g.reject).progress(h(b,j,i)):--f;return f||g.resolveWith(k,c),g.promise()}});var H;n.fn.ready=function(a){return n.ready.promise().done(a),this},n.extend({isReady:!1,readyWait:1,holdReady:function(a){a?n.readyWait++:n.ready(!0)},ready:function(a){(a===!0?--n.readyWait:n.isReady)||(n.isReady=!0,a!==!0&&--n.readyWait>0||(H.resolveWith(l,[n]),n.fn.triggerHandler&&(n(l).triggerHandler("ready"),n(l).off("ready"))))}});function I(){l.removeEventListener("DOMContentLoaded",I,!1),a.removeEventListener("load",I,!1),n.ready()}n.ready.promise=function(b){return H||(H=n.Deferred(),"complete"===l.readyState?setTimeout(n.ready):(l.addEventListener("DOMContentLoaded",I,!1),a.addEventListener("load",I,!1))),H.promise(b)},n.ready.promise();var J=n.access=function(a,b,c,d,e,f,g){var h=0,i=a.length,j=null==c;if("object"===n.type(c)){e=!0;for(h in c)n.access(a,b,h,c[h],!0,f,g)}else if(void 0!==d&&(e=!0,n.isFunction(d)||(g=!0),j&&(g?(b.call(a,d),b=null):(j=b,b=function(a,b,c){return j.call(n(a),c)})),b))for(;i>h;h++)b(a[h],c,g?d:d.call(a[h],h,b(a[h],c)));return e?a:j?b.call(a):i?b(a[0],c):f};n.acceptData=function(a){return 1===a.nodeType||9===a.nodeType||!+a.nodeType};function K(){Object.defineProperty(this.cache={},0,{get:function(){return{}}}),this.expando=n.expando+K.uid++}K.uid=1,K.accepts=n.acceptData,K.prototype={key:function(a){if(!K.accepts(a))return 0;var b={},c=a[this.expando];if(!c){c=K.uid++;try{b[this.expando]={value:c},Object.defineProperties(a,b)}catch(d){b[this.expando]=c,n.extend(a,b)}}return this.cache[c]||(this.cache[c]={}),c},set:function(a,b,c){var d,e=this.key(a),f=this.cache[e];if("string"==typeof b)f[b]=c;else if(n.isEmptyObject(f))n.extend(this.cache[e],b);else for(d in b)f[d]=b[d];return f},get:function(a,b){var c=this.cache[this.key(a)];return void 0===b?c:c[b]},access:function(a,b,c){var d;return void 0===b||b&&"string"==typeof b&&void 0===c?(d=this.get(a,b),void 0!==d?d:this.get(a,n.camelCase(b))):(this.set(a,b,c),void 0!==c?c:b)},remove:function(a,b){var c,d,e,f=this.key(a),g=this.cache[f];if(void 0===b)this.cache[f]={};else{n.isArray(b)?d=b.concat(b.map(n.camelCase)):(e=n.camelCase(b),b in g?d=[b,e]:(d=e,d=d in g?[d]:d.match(E)||[])),c=d.length;while(c--)delete g[d[c]]}},hasData:function(a){return!n.isEmptyObject(this.cache[a[this.expando]]||{})},discard:function(a){a[this.expando]&&delete this.cache[a[this.expando]]}};var L=new K,M=new K,N=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,O=/([A-Z])/g;function P(a,b,c){var d;if(void 0===c&&1===a.nodeType)if(d="data-"+b.replace(O,"-$1").toLowerCase(),c=a.getAttribute(d),"string"==typeof c){try{c="true"===c?!0:"false"===c?!1:"null"===c?null:+c+""===c?+c:N.test(c)?n.parseJSON(c):c}catch(e){}M.set(a,b,c)}else c=void 0;return c}n.extend({hasData:function(a){return M.hasData(a)||L.hasData(a)},data:function(a,b,c){
return M.access(a,b,c)},removeData:function(a,b){M.remove(a,b)},_data:function(a,b,c){return L.access(a,b,c)},_removeData:function(a,b){L.remove(a,b)}}),n.fn.extend({data:function(a,b){var c,d,e,f=this[0],g=f&&f.attributes;if(void 0===a){if(this.length&&(e=M.get(f),1===f.nodeType&&!L.get(f,"hasDataAttrs"))){c=g.length;while(c--)g[c]&&(d=g[c].name,0===d.indexOf("data-")&&(d=n.camelCase(d.slice(5)),P(f,d,e[d])));L.set(f,"hasDataAttrs",!0)}return e}return"object"==typeof a?this.each(function(){M.set(this,a)}):J(this,function(b){var c,d=n.camelCase(a);if(f&&void 0===b){if(c=M.get(f,a),void 0!==c)return c;if(c=M.get(f,d),void 0!==c)return c;if(c=P(f,d,void 0),void 0!==c)return c}else this.each(function(){var c=M.get(this,d);M.set(this,d,b),-1!==a.indexOf("-")&&void 0!==c&&M.set(this,a,b)})},null,b,arguments.length>1,null,!0)},removeData:function(a){return this.each(function(){M.remove(this,a)})}}),n.extend({queue:function(a,b,c){var d;return a?(b=(b||"fx")+"queue",d=L.get(a,b),c&&(!d||n.isArray(c)?d=L.access(a,b,n.makeArray(c)):d.push(c)),d||[]):void 0},dequeue:function(a,b){b=b||"fx";var c=n.queue(a,b),d=c.length,e=c.shift(),f=n._queueHooks(a,b),g=function(){n.dequeue(a,b)};"inprogress"===e&&(e=c.shift(),d--),e&&("fx"===b&&c.unshift("inprogress"),delete f.stop,e.call(a,g,f)),!d&&f&&f.empty.fire()},_queueHooks:function(a,b){var c=b+"queueHooks";return L.get(a,c)||L.access(a,c,{empty:n.Callbacks("once memory").add(function(){L.remove(a,[b+"queue",c])})})}}),n.fn.extend({queue:function(a,b){var c=2;return"string"!=typeof a&&(b=a,a="fx",c--),arguments.length<c?n.queue(this[0],a):void 0===b?this:this.each(function(){var c=n.queue(this,a,b);n._queueHooks(this,a),"fx"===a&&"inprogress"!==c[0]&&n.dequeue(this,a)})},dequeue:function(a){return this.each(function(){n.dequeue(this,a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,b){var c,d=1,e=n.Deferred(),f=this,g=this.length,h=function(){--d||e.resolveWith(f,[f])};"string"!=typeof a&&(b=a,a=void 0),a=a||"fx";while(g--)c=L.get(f[g],a+"queueHooks"),c&&c.empty&&(d++,c.empty.add(h));return h(),e.promise(b)}});var Q=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,R=["Top","Right","Bottom","Left"],S=function(a,b){return a=b||a,"none"===n.css(a,"display")||!n.contains(a.ownerDocument,a)},T=/^(?:checkbox|radio)$/i;!function(){var a=l.createDocumentFragment(),b=a.appendChild(l.createElement("div")),c=l.createElement("input");c.setAttribute("type","radio"),c.setAttribute("checked","checked"),c.setAttribute("name","t"),b.appendChild(c),k.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,b.innerHTML="<textarea>x</textarea>",k.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue}();var U="undefined";k.focusinBubbles="onfocusin"in a;var V=/^key/,W=/^(?:mouse|pointer|contextmenu)|click/,X=/^(?:focusinfocus|focusoutblur)$/,Y=/^([^.]*)(?:\.(.+)|)$/;function Z(){return!0}function $(){return!1}function _(){try{return l.activeElement}catch(a){}}n.event={global:{},add:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.get(a);if(r){c.handler&&(f=c,c=f.handler,e=f.selector),c.guid||(c.guid=n.guid++),(i=r.events)||(i=r.events={}),(g=r.handle)||(g=r.handle=function(b){return typeof n!==U&&n.event.triggered!==b.type?n.event.dispatch.apply(a,arguments):void 0}),b=(b||"").match(E)||[""],j=b.length;while(j--)h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o&&(l=n.event.special[o]||{},o=(e?l.delegateType:l.bindType)||o,l=n.event.special[o]||{},k=n.extend({type:o,origType:q,data:d,handler:c,guid:c.guid,selector:e,needsContext:e&&n.expr.match.needsContext.test(e),namespace:p.join(".")},f),(m=i[o])||(m=i[o]=[],m.delegateCount=0,l.setup&&l.setup.call(a,d,p,g)!==!1||a.addEventListener&&a.addEventListener(o,g,!1)),l.add&&(l.add.call(a,k),k.handler.guid||(k.handler.guid=c.guid)),e?m.splice(m.delegateCount++,0,k):m.push(k),n.event.global[o]=!0)}},remove:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.hasData(a)&&L.get(a);if(r&&(i=r.events)){b=(b||"").match(E)||[""],j=b.length;while(j--)if(h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o){l=n.event.special[o]||{},o=(d?l.delegateType:l.bindType)||o,m=i[o]||[],h=h[2]&&new RegExp("(^|\\.)"+p.join("\\.(?:.*\\.|)")+"(\\.|$)"),g=f=m.length;while(f--)k=m[f],!e&&q!==k.origType||c&&c.guid!==k.guid||h&&!h.test(k.namespace)||d&&d!==k.selector&&("**"!==d||!k.selector)||(m.splice(f,1),k.selector&&m.delegateCount--,l.remove&&l.remove.call(a,k));g&&!m.length&&(l.teardown&&l.teardown.call(a,p,r.handle)!==!1||n.removeEvent(a,o,r.handle),delete i[o])}else for(o in i)n.event.remove(a,o+b[j],c,d,!0);n.isEmptyObject(i)&&(delete r.handle,L.remove(a,"events"))}},trigger:function(b,c,d,e){var f,g,h,i,k,m,o,p=[d||l],q=j.call(b,"type")?b.type:b,r=j.call(b,"namespace")?b.namespace.split("."):[];if(g=h=d=d||l,3!==d.nodeType&&8!==d.nodeType&&!X.test(q+n.event.triggered)&&(q.indexOf(".")>=0&&(r=q.split("."),q=r.shift(),r.sort()),k=q.indexOf(":")<0&&"on"+q,b=b[n.expando]?b:new n.Event(q,"object"==typeof b&&b),b.isTrigger=e?2:3,b.namespace=r.join("."),b.namespace_re=b.namespace?new RegExp("(^|\\.)"+r.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,b.result=void 0,b.target||(b.target=d),c=null==c?[b]:n.makeArray(c,[b]),o=n.event.special[q]||{},e||!o.trigger||o.trigger.apply(d,c)!==!1)){if(!e&&!o.noBubble&&!n.isWindow(d)){for(i=o.delegateType||q,X.test(i+q)||(g=g.parentNode);g;g=g.parentNode)p.push(g),h=g;h===(d.ownerDocument||l)&&p.push(h.defaultView||h.parentWindow||a)}f=0;while((g=p[f++])&&!b.isPropagationStopped())b.type=f>1?i:o.bindType||q,m=(L.get(g,"events")||{})[b.type]&&L.get(g,"handle"),m&&m.apply(g,c),m=k&&g[k],m&&m.apply&&n.acceptData(g)&&(b.result=m.apply(g,c),b.result===!1&&b.preventDefault());return b.type=q,e||b.isDefaultPrevented()||o._default&&o._default.apply(p.pop(),c)!==!1||!n.acceptData(d)||k&&n.isFunction(d[q])&&!n.isWindow(d)&&(h=d[k],h&&(d[k]=null),n.event.triggered=q,d[q](),n.event.triggered=void 0,h&&(d[k]=h)),b.result}},dispatch:function(a){a=n.event.fix(a);var b,c,e,f,g,h=[],i=d.call(arguments),j=(L.get(this,"events")||{})[a.type]||[],k=n.event.special[a.type]||{};if(i[0]=a,a.delegateTarget=this,!k.preDispatch||k.preDispatch.call(this,a)!==!1){h=n.event.handlers.call(this,a,j),b=0;while((f=h[b++])&&!a.isPropagationStopped()){a.currentTarget=f.elem,c=0;while((g=f.handlers[c++])&&!a.isImmediatePropagationStopped())(!a.namespace_re||a.namespace_re.test(g.namespace))&&(a.handleObj=g,a.data=g.data,e=((n.event.special[g.origType]||{}).handle||g.handler).apply(f.elem,i),void 0!==e&&(a.result=e)===!1&&(a.preventDefault(),a.stopPropagation()))}return k.postDispatch&&k.postDispatch.call(this,a),a.result}},handlers:function(a,b){var c,d,e,f,g=[],h=b.delegateCount,i=a.target;if(h&&i.nodeType&&(!a.button||"click"!==a.type))for(;i!==this;i=i.parentNode||this)if(i.disabled!==!0||"click"!==a.type){for(d=[],c=0;h>c;c++)f=b[c],e=f.selector+" ",void 0===d[e]&&(d[e]=f.needsContext?n(e,this).index(i)>=0:n.find(e,this,null,[i]).length),d[e]&&d.push(f);d.length&&g.push({elem:i,handlers:d})}return h<b.length&&g.push({elem:this,handlers:b.slice(h)}),g},props:"altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){return null==a.which&&(a.which=null!=b.charCode?b.charCode:b.keyCode),a}},mouseHooks:{props:"button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,b){var c,d,e,f=b.button;return null==a.pageX&&null!=b.clientX&&(c=a.target.ownerDocument||l,d=c.documentElement,e=c.body,a.pageX=b.clientX+(d&&d.scrollLeft||e&&e.scrollLeft||0)-(d&&d.clientLeft||e&&e.clientLeft||0),a.pageY=b.clientY+(d&&d.scrollTop||e&&e.scrollTop||0)-(d&&d.clientTop||e&&e.clientTop||0)),a.which||void 0===f||(a.which=1&f?1:2&f?3:4&f?2:0),a}},fix:function(a){if(a[n.expando])return a;var b,c,d,e=a.type,f=a,g=this.fixHooks[e];g||(this.fixHooks[e]=g=W.test(e)?this.mouseHooks:V.test(e)?this.keyHooks:{}),d=g.props?this.props.concat(g.props):this.props,a=new n.Event(f),b=d.length;while(b--)c=d[b],a[c]=f[c];return a.target||(a.target=l),3===a.target.nodeType&&(a.target=a.target.parentNode),g.filter?g.filter(a,f):a},special:{load:{noBubble:!0},focus:{trigger:function(){return this!==_()&&this.focus?(this.focus(),!1):void 0},delegateType:"focusin"},blur:{trigger:function(){return this===_()&&this.blur?(this.blur(),!1):void 0},delegateType:"focusout"},click:{trigger:function(){return"checkbox"===this.type&&this.click&&n.nodeName(this,"input")?(this.click(),!1):void 0},_default:function(a){return n.nodeName(a.target,"a")}},beforeunload:{postDispatch:function(a){void 0!==a.result&&a.originalEvent&&(a.originalEvent.returnValue=a.result)}}},simulate:function(a,b,c,d){var e=n.extend(new n.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?n.event.trigger(e,null,b):n.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},n.removeEvent=function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)},n.Event=function(a,b){return this instanceof n.Event?(a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||void 0===a.defaultPrevented&&a.returnValue===!1?Z:$):this.type=a,b&&n.extend(this,b),this.timeStamp=a&&a.timeStamp||n.now(),void(this[n.expando]=!0)):new n.Event(a,b)},n.Event.prototype={isDefaultPrevented:$,isPropagationStopped:$,isImmediatePropagationStopped:$,preventDefault:function(){var a=this.originalEvent;this.isDefaultPrevented=Z,a&&a.preventDefault&&a.preventDefault()},stopPropagation:function(){var a=this.originalEvent;this.isPropagationStopped=Z,a&&a.stopPropagation&&a.stopPropagation()},stopImmediatePropagation:function(){var a=this.originalEvent;this.isImmediatePropagationStopped=Z,a&&a.stopImmediatePropagation&&a.stopImmediatePropagation(),this.stopPropagation()}},n.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(a,b){n.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c,d=this,e=a.relatedTarget,f=a.handleObj;return(!e||e!==d&&!n.contains(d,e))&&(a.type=f.origType,c=f.handler.apply(this,arguments),a.type=b),c}}}),k.focusinBubbles||n.each({focus:"focusin",blur:"focusout"},function(a,b){var c=function(a){n.event.simulate(b,a.target,n.event.fix(a),!0)};n.event.special[b]={setup:function(){var d=this.ownerDocument||this,e=L.access(d,b);e||d.addEventListener(a,c,!0),L.access(d,b,(e||0)+1)},teardown:function(){var d=this.ownerDocument||this,e=L.access(d,b)-1;e?L.access(d,b,e):(d.removeEventListener(a,c,!0),L.remove(d,b))}}}),n.fn.extend({on:function(a,b,c,d,e){var f,g;if("object"==typeof a){"string"!=typeof b&&(c=c||b,b=void 0);for(g in a)this.on(g,b,c,a[g],e);return this}if(null==c&&null==d?(d=b,c=b=void 0):null==d&&("string"==typeof b?(d=c,c=void 0):(d=c,c=b,b=void 0)),d===!1)d=$;else if(!d)return this;return 1===e&&(f=d,d=function(a){return n().off(a),f.apply(this,arguments)},d.guid=f.guid||(f.guid=n.guid++)),this.each(function(){n.event.add(this,a,d,c,b)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,b,c){var d,e;if(a&&a.preventDefault&&a.handleObj)return d=a.handleObj,n(a.delegateTarget).off(d.namespace?d.origType+"."+d.namespace:d.origType,d.selector,d.handler),this;if("object"==typeof a){for(e in a)this.off(e,b,a[e]);return this}return(b===!1||"function"==typeof b)&&(c=b,b=void 0),c===!1&&(c=$),this.each(function(){n.event.remove(this,a,c,b)})},trigger:function(a,b){return this.each(function(){n.event.trigger(a,b,this)})},triggerHandler:function(a,b){var c=this[0];return c?n.event.trigger(a,b,c,!0):void 0}});var aa=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,ba=/<([\w:]+)/,ca=/<|&#?\w+;/,da=/<(?:script|style|link)/i,ea=/checked\s*(?:[^=]|=\s*.checked.)/i,fa=/^$|\/(?:java|ecma)script/i,ga=/^true\/(.*)/,ha=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,ia={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ia.optgroup=ia.option,ia.tbody=ia.tfoot=ia.colgroup=ia.caption=ia.thead,ia.th=ia.td;function ja(a,b){return n.nodeName(a,"table")&&n.nodeName(11!==b.nodeType?b:b.firstChild,"tr")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function ka(a){return a.type=(null!==a.getAttribute("type"))+"/"+a.type,a}function la(a){var b=ga.exec(a.type);return b?a.type=b[1]:a.removeAttribute("type"),a}function ma(a,b){for(var c=0,d=a.length;d>c;c++)L.set(a[c],"globalEval",!b||L.get(b[c],"globalEval"))}function na(a,b){var c,d,e,f,g,h,i,j;if(1===b.nodeType){if(L.hasData(a)&&(f=L.access(a),g=L.set(b,f),j=f.events)){delete g.handle,g.events={};for(e in j)for(c=0,d=j[e].length;d>c;c++)n.event.add(b,e,j[e][c])}M.hasData(a)&&(h=M.access(a),i=n.extend({},h),M.set(b,i))}}function oa(a,b){var c=a.getElementsByTagName?a.getElementsByTagName(b||"*"):a.querySelectorAll?a.querySelectorAll(b||"*"):[];return void 0===b||b&&n.nodeName(a,b)?n.merge([a],c):c}function pa(a,b){var c=b.nodeName.toLowerCase();"input"===c&&T.test(a.type)?b.checked=a.checked:("input"===c||"textarea"===c)&&(b.defaultValue=a.defaultValue)}n.extend({clone:function(a,b,c){var d,e,f,g,h=a.cloneNode(!0),i=n.contains(a.ownerDocument,a);if(!(k.noCloneChecked||1!==a.nodeType&&11!==a.nodeType||n.isXMLDoc(a)))for(g=oa(h),f=oa(a),d=0,e=f.length;e>d;d++)pa(f[d],g[d]);if(b)if(c)for(f=f||oa(a),g=g||oa(h),d=0,e=f.length;e>d;d++)na(f[d],g[d]);else na(a,h);return g=oa(h,"script"),g.length>0&&ma(g,!i&&oa(a,"script")),h},buildFragment:function(a,b,c,d){for(var e,f,g,h,i,j,k=b.createDocumentFragment(),l=[],m=0,o=a.length;o>m;m++)if(e=a[m],e||0===e)if("object"===n.type(e))n.merge(l,e.nodeType?[e]:e);else if(ca.test(e)){f=f||k.appendChild(b.createElement("div")),g=(ba.exec(e)||["",""])[1].toLowerCase(),h=ia[g]||ia._default,f.innerHTML=h[1]+e.replace(aa,"<$1></$2>")+h[2],j=h[0];while(j--)f=f.lastChild;n.merge(l,f.childNodes),f=k.firstChild,f.textContent=""}else l.push(b.createTextNode(e));k.textContent="",m=0;while(e=l[m++])if((!d||-1===n.inArray(e,d))&&(i=n.contains(e.ownerDocument,e),f=oa(k.appendChild(e),"script"),i&&ma(f),c)){j=0;while(e=f[j++])fa.test(e.type||"")&&c.push(e)}return k},cleanData:function(a){for(var b,c,d,e,f=n.event.special,g=0;void 0!==(c=a[g]);g++){if(n.acceptData(c)&&(e=c[L.expando],e&&(b=L.cache[e]))){if(b.events)for(d in b.events)f[d]?n.event.remove(c,d):n.removeEvent(c,d,b.handle);L.cache[e]&&delete L.cache[e]}delete M.cache[c[M.expando]]}}}),n.fn.extend({text:function(a){return J(this,function(a){return void 0===a?n.text(this):this.empty().each(function(){(1===this.nodeType||11===this.nodeType||9===this.nodeType)&&(this.textContent=a)})},null,a,arguments.length)},append:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=ja(this,a);b.appendChild(a)}})},prepend:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=ja(this,a);b.insertBefore(a,b.firstChild)}})},before:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this)})},after:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this.nextSibling)})},remove:function(a,b){for(var c,d=a?n.filter(a,this):this,e=0;null!=(c=d[e]);e++)b||1!==c.nodeType||n.cleanData(oa(c)),c.parentNode&&(b&&n.contains(c.ownerDocument,c)&&ma(oa(c,"script")),c.parentNode.removeChild(c));return this},empty:function(){for(var a,b=0;null!=(a=this[b]);b++)1===a.nodeType&&(n.cleanData(oa(a,!1)),a.textContent="");return this},clone:function(a,b){return a=null==a?!1:a,b=null==b?a:b,this.map(function(){return n.clone(this,a,b)})},html:function(a){return J(this,function(a){var b=this[0]||{},c=0,d=this.length;if(void 0===a&&1===b.nodeType)return b.innerHTML;if("string"==typeof a&&!da.test(a)&&!ia[(ba.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(aa,"<$1></$2>");try{for(;d>c;c++)b=this[c]||{},1===b.nodeType&&(n.cleanData(oa(b,!1)),b.innerHTML=a);b=0}catch(e){}}b&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(){var a=arguments[0];return this.domManip(arguments,function(b){a=this.parentNode,n.cleanData(oa(this)),a&&a.replaceChild(b,this)}),a&&(a.length||a.nodeType)?this:this.remove()},detach:function(a){return this.remove(a,!0)},domManip:function(a,b){a=e.apply([],a);var c,d,f,g,h,i,j=0,l=this.length,m=this,o=l-1,p=a[0],q=n.isFunction(p);if(q||l>1&&"string"==typeof p&&!k.checkClone&&ea.test(p))return this.each(function(c){var d=m.eq(c);q&&(a[0]=p.call(this,c,d.html())),d.domManip(a,b)});if(l&&(c=n.buildFragment(a,this[0].ownerDocument,!1,this),d=c.firstChild,1===c.childNodes.length&&(c=d),d)){for(f=n.map(oa(c,"script"),ka),g=f.length;l>j;j++)h=c,j!==o&&(h=n.clone(h,!0,!0),g&&n.merge(f,oa(h,"script"))),b.call(this[j],h,j);if(g)for(i=f[f.length-1].ownerDocument,n.map(f,la),j=0;g>j;j++)h=f[j],fa.test(h.type||"")&&!L.access(h,"globalEval")&&n.contains(i,h)&&(h.src?n._evalUrl&&n._evalUrl(h.src):n.globalEval(h.textContent.replace(ha,"")))}return this}}),n.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){n.fn[a]=function(a){for(var c,d=[],e=n(a),g=e.length-1,h=0;g>=h;h++)c=h===g?this:this.clone(!0),n(e[h])[b](c),f.apply(d,c.get());return this.pushStack(d)}});var qa,ra={};function sa(b,c){var d,e=n(c.createElement(b)).appendTo(c.body),f=a.getDefaultComputedStyle&&(d=a.getDefaultComputedStyle(e[0]))?d.display:n.css(e[0],"display");return e.detach(),f}function ta(a){var b=l,c=ra[a];return c||(c=sa(a,b),"none"!==c&&c||(qa=(qa||n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement),b=qa[0].contentDocument,b.write(),b.close(),c=sa(a,b),qa.detach()),ra[a]=c),c}var ua=/^margin/,va=new RegExp("^("+Q+")(?!px)[a-z%]+$","i"),wa=function(b){return b.ownerDocument.defaultView.opener?b.ownerDocument.defaultView.getComputedStyle(b,null):a.getComputedStyle(b,null)};function xa(a,b,c){var d,e,f,g,h=a.style;return c=c||wa(a),c&&(g=c.getPropertyValue(b)||c[b]),c&&(""!==g||n.contains(a.ownerDocument,a)||(g=n.style(a,b)),va.test(g)&&ua.test(b)&&(d=h.width,e=h.minWidth,f=h.maxWidth,h.minWidth=h.maxWidth=h.width=g,g=c.width,h.width=d,h.minWidth=e,h.maxWidth=f)),void 0!==g?g+"":g}function ya(a,b){return{get:function(){return a()?void delete this.get:(this.get=b).apply(this,arguments)}}}!function(){var b,c,d=l.documentElement,e=l.createElement("div"),f=l.createElement("div");if(f.style){f.style.backgroundClip="content-box",f.cloneNode(!0).style.backgroundClip="",k.clearCloneStyle="content-box"===f.style.backgroundClip,e.style.cssText="border:0;width:0;height:0;top:0;left:-9999px;margin-top:1px;position:absolute",e.appendChild(f);function g(){f.style.cssText="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute",f.innerHTML="",d.appendChild(e);var g=a.getComputedStyle(f,null);b="1%"!==g.top,c="4px"===g.width,d.removeChild(e)}a.getComputedStyle&&n.extend(k,{pixelPosition:function(){return g(),b},boxSizingReliable:function(){return null==c&&g(),c},reliableMarginRight:function(){var b,c=f.appendChild(l.createElement("div"));return c.style.cssText=f.style.cssText="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0",c.style.marginRight=c.style.width="0",f.style.width="1px",d.appendChild(e),b=!parseFloat(a.getComputedStyle(c,null).marginRight),d.removeChild(e),f.removeChild(c),b}})}}(),n.swap=function(a,b,c,d){var e,f,g={};for(f in b)g[f]=a.style[f],a.style[f]=b[f];e=c.apply(a,d||[]);for(f in b)a.style[f]=g[f];return e};var za=/^(none|table(?!-c[ea]).+)/,Aa=new RegExp("^("+Q+")(.*)$","i"),Ba=new RegExp("^([+-])=("+Q+")","i"),Ca={position:"absolute",visibility:"hidden",display:"block"},Da={letterSpacing:"0",fontWeight:"400"},Ea=["Webkit","O","Moz","ms"];function Fa(a,b){if(b in a)return b;var c=b[0].toUpperCase()+b.slice(1),d=b,e=Ea.length;while(e--)if(b=Ea[e]+c,b in a)return b;return d}function Ga(a,b,c){var d=Aa.exec(b);return d?Math.max(0,d[1]-(c||0))+(d[2]||"px"):b}function Ha(a,b,c,d,e){for(var f=c===(d?"border":"content")?4:"width"===b?1:0,g=0;4>f;f+=2)"margin"===c&&(g+=n.css(a,c+R[f],!0,e)),d?("content"===c&&(g-=n.css(a,"padding"+R[f],!0,e)),"margin"!==c&&(g-=n.css(a,"border"+R[f]+"Width",!0,e))):(g+=n.css(a,"padding"+R[f],!0,e),"padding"!==c&&(g+=n.css(a,"border"+R[f]+"Width",!0,e)));return g}function Ia(a,b,c){var d=!0,e="width"===b?a.offsetWidth:a.offsetHeight,f=wa(a),g="border-box"===n.css(a,"boxSizing",!1,f);if(0>=e||null==e){if(e=xa(a,b,f),(0>e||null==e)&&(e=a.style[b]),va.test(e))return e;d=g&&(k.boxSizingReliable()||e===a.style[b]),e=parseFloat(e)||0}return e+Ha(a,b,c||(g?"border":"content"),d,f)+"px"}function Ja(a,b){for(var c,d,e,f=[],g=0,h=a.length;h>g;g++)d=a[g],d.style&&(f[g]=L.get(d,"olddisplay"),c=d.style.display,b?(f[g]||"none"!==c||(d.style.display=""),""===d.style.display&&S(d)&&(f[g]=L.access(d,"olddisplay",ta(d.nodeName)))):(e=S(d),"none"===c&&e||L.set(d,"olddisplay",e?c:n.css(d,"display"))));for(g=0;h>g;g++)d=a[g],d.style&&(b&&"none"!==d.style.display&&""!==d.style.display||(d.style.display=b?f[g]||"":"none"));return a}n.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=xa(a,"opacity");return""===c?"1":c}}}},cssNumber:{columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":"cssFloat"},style:function(a,b,c,d){if(a&&3!==a.nodeType&&8!==a.nodeType&&a.style){var e,f,g,h=n.camelCase(b),i=a.style;return b=n.cssProps[h]||(n.cssProps[h]=Fa(i,h)),g=n.cssHooks[b]||n.cssHooks[h],void 0===c?g&&"get"in g&&void 0!==(e=g.get(a,!1,d))?e:i[b]:(f=typeof c,"string"===f&&(e=Ba.exec(c))&&(c=(e[1]+1)*e[2]+parseFloat(n.css(a,b)),f="number"),null!=c&&c===c&&("number"!==f||n.cssNumber[h]||(c+="px"),k.clearCloneStyle||""!==c||0!==b.indexOf("background")||(i[b]="inherit"),g&&"set"in g&&void 0===(c=g.set(a,c,d))||(i[b]=c)),void 0)}},css:function(a,b,c,d){var e,f,g,h=n.camelCase(b);return b=n.cssProps[h]||(n.cssProps[h]=Fa(a.style,h)),g=n.cssHooks[b]||n.cssHooks[h],g&&"get"in g&&(e=g.get(a,!0,c)),void 0===e&&(e=xa(a,b,d)),"normal"===e&&b in Da&&(e=Da[b]),""===c||c?(f=parseFloat(e),c===!0||n.isNumeric(f)?f||0:e):e}}),n.each(["height","width"],function(a,b){n.cssHooks[b]={get:function(a,c,d){return c?za.test(n.css(a,"display"))&&0===a.offsetWidth?n.swap(a,Ca,function(){return Ia(a,b,d)}):Ia(a,b,d):void 0},set:function(a,c,d){var e=d&&wa(a);return Ga(a,c,d?Ha(a,b,d,"border-box"===n.css(a,"boxSizing",!1,e),e):0)}}}),n.cssHooks.marginRight=ya(k.reliableMarginRight,function(a,b){return b?n.swap(a,{display:"inline-block"},xa,[a,"marginRight"]):void 0}),n.each({margin:"",padding:"",border:"Width"},function(a,b){n.cssHooks[a+b]={expand:function(c){for(var d=0,e={},f="string"==typeof c?c.split(" "):[c];4>d;d++)e[a+R[d]+b]=f[d]||f[d-2]||f[0];return e}},ua.test(a)||(n.cssHooks[a+b].set=Ga)}),n.fn.extend({css:function(a,b){return J(this,function(a,b,c){var d,e,f={},g=0;if(n.isArray(b)){for(d=wa(a),e=b.length;e>g;g++)f[b[g]]=n.css(a,b[g],!1,d);return f}return void 0!==c?n.style(a,b,c):n.css(a,b)},a,b,arguments.length>1)},show:function(){return Ja(this,!0)},hide:function(){return Ja(this)},toggle:function(a){return"boolean"==typeof a?a?this.show():this.hide():this.each(function(){S(this)?n(this).show():n(this).hide()})}});function Ka(a,b,c,d,e){return new Ka.prototype.init(a,b,c,d,e)}n.Tween=Ka,Ka.prototype={constructor:Ka,init:function(a,b,c,d,e,f){this.elem=a,this.prop=c,this.easing=e||"swing",this.options=b,this.start=this.now=this.cur(),this.end=d,this.unit=f||(n.cssNumber[c]?"":"px")},cur:function(){var a=Ka.propHooks[this.prop];return a&&a.get?a.get(this):Ka.propHooks._default.get(this)},run:function(a){var b,c=Ka.propHooks[this.prop];return this.options.duration?this.pos=b=n.easing[this.easing](a,this.options.duration*a,0,1,this.options.duration):this.pos=b=a,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),c&&c.set?c.set(this):Ka.propHooks._default.set(this),this}},Ka.prototype.init.prototype=Ka.prototype,Ka.propHooks={_default:{get:function(a){var b;return null==a.elem[a.prop]||a.elem.style&&null!=a.elem.style[a.prop]?(b=n.css(a.elem,a.prop,""),b&&"auto"!==b?b:0):a.elem[a.prop]},set:function(a){n.fx.step[a.prop]?n.fx.step[a.prop](a):a.elem.style&&(null!=a.elem.style[n.cssProps[a.prop]]||n.cssHooks[a.prop])?n.style(a.elem,a.prop,a.now+a.unit):a.elem[a.prop]=a.now}}},Ka.propHooks.scrollTop=Ka.propHooks.scrollLeft={set:function(a){a.elem.nodeType&&a.elem.parentNode&&(a.elem[a.prop]=a.now)}},n.easing={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2}},n.fx=Ka.prototype.init,n.fx.step={};var La,Ma,Na=/^(?:toggle|show|hide)$/,Oa=new RegExp("^(?:([+-])=|)("+Q+")([a-z%]*)$","i"),Pa=/queueHooks$/,Qa=[Va],Ra={"*":[function(a,b){var c=this.createTween(a,b),d=c.cur(),e=Oa.exec(b),f=e&&e[3]||(n.cssNumber[a]?"":"px"),g=(n.cssNumber[a]||"px"!==f&&+d)&&Oa.exec(n.css(c.elem,a)),h=1,i=20;if(g&&g[3]!==f){f=f||g[3],e=e||[],g=+d||1;do h=h||".5",g/=h,n.style(c.elem,a,g+f);while(h!==(h=c.cur()/d)&&1!==h&&--i)}return e&&(g=c.start=+g||+d||0,c.unit=f,c.end=e[1]?g+(e[1]+1)*e[2]:+e[2]),c}]};function Sa(){return setTimeout(function(){La=void 0}),La=n.now()}function Ta(a,b){var c,d=0,e={height:a};for(b=b?1:0;4>d;d+=2-b)c=R[d],e["margin"+c]=e["padding"+c]=a;return b&&(e.opacity=e.width=a),e}function Ua(a,b,c){for(var d,e=(Ra[b]||[]).concat(Ra["*"]),f=0,g=e.length;g>f;f++)if(d=e[f].call(c,b,a))return d}function Va(a,b,c){var d,e,f,g,h,i,j,k,l=this,m={},o=a.style,p=a.nodeType&&S(a),q=L.get(a,"fxshow");c.queue||(h=n._queueHooks(a,"fx"),null==h.unqueued&&(h.unqueued=0,i=h.empty.fire,h.empty.fire=function(){h.unqueued||i()}),h.unqueued++,l.always(function(){l.always(function(){h.unqueued--,n.queue(a,"fx").length||h.empty.fire()})})),1===a.nodeType&&("height"in b||"width"in b)&&(c.overflow=[o.overflow,o.overflowX,o.overflowY],j=n.css(a,"display"),k="none"===j?L.get(a,"olddisplay")||ta(a.nodeName):j,"inline"===k&&"none"===n.css(a,"float")&&(o.display="inline-block")),c.overflow&&(o.overflow="hidden",l.always(function(){o.overflow=c.overflow[0],o.overflowX=c.overflow[1],o.overflowY=c.overflow[2]}));for(d in b)if(e=b[d],Na.exec(e)){if(delete b[d],f=f||"toggle"===e,e===(p?"hide":"show")){if("show"!==e||!q||void 0===q[d])continue;p=!0}m[d]=q&&q[d]||n.style(a,d)}else j=void 0;if(n.isEmptyObject(m))"inline"===("none"===j?ta(a.nodeName):j)&&(o.display=j);else{q?"hidden"in q&&(p=q.hidden):q=L.access(a,"fxshow",{}),f&&(q.hidden=!p),p?n(a).show():l.done(function(){n(a).hide()}),l.done(function(){var b;L.remove(a,"fxshow");for(b in m)n.style(a,b,m[b])});for(d in m)g=Ua(p?q[d]:0,d,l),d in q||(q[d]=g.start,p&&(g.end=g.start,g.start="width"===d||"height"===d?1:0))}}function Wa(a,b){var c,d,e,f,g;for(c in a)if(d=n.camelCase(c),e=b[d],f=a[c],n.isArray(f)&&(e=f[1],f=a[c]=f[0]),c!==d&&(a[d]=f,delete a[c]),g=n.cssHooks[d],g&&"expand"in g){f=g.expand(f),delete a[d];for(c in f)c in a||(a[c]=f[c],b[c]=e)}else b[d]=e}function Xa(a,b,c){var d,e,f=0,g=Qa.length,h=n.Deferred().always(function(){delete i.elem}),i=function(){if(e)return!1;for(var b=La||Sa(),c=Math.max(0,j.startTime+j.duration-b),d=c/j.duration||0,f=1-d,g=0,i=j.tweens.length;i>g;g++)j.tweens[g].run(f);return h.notifyWith(a,[j,f,c]),1>f&&i?c:(h.resolveWith(a,[j]),!1)},j=h.promise({elem:a,props:n.extend({},b),opts:n.extend(!0,{specialEasing:{}},c),originalProperties:b,originalOptions:c,startTime:La||Sa(),duration:c.duration,tweens:[],createTween:function(b,c){var d=n.Tween(a,j.opts,b,c,j.opts.specialEasing[b]||j.opts.easing);return j.tweens.push(d),d},stop:function(b){var c=0,d=b?j.tweens.length:0;if(e)return this;for(e=!0;d>c;c++)j.tweens[c].run(1);return b?h.resolveWith(a,[j,b]):h.rejectWith(a,[j,b]),this}}),k=j.props;for(Wa(k,j.opts.specialEasing);g>f;f++)if(d=Qa[f].call(j,a,k,j.opts))return d;return n.map(k,Ua,j),n.isFunction(j.opts.start)&&j.opts.start.call(a,j),n.fx.timer(n.extend(i,{elem:a,anim:j,queue:j.opts.queue})),j.progress(j.opts.progress).done(j.opts.done,j.opts.complete).fail(j.opts.fail).always(j.opts.always)}n.Animation=n.extend(Xa,{tweener:function(a,b){n.isFunction(a)?(b=a,a=["*"]):a=a.split(" ");for(var c,d=0,e=a.length;e>d;d++)c=a[d],Ra[c]=Ra[c]||[],Ra[c].unshift(b)},prefilter:function(a,b){b?Qa.unshift(a):Qa.push(a)}}),n.speed=function(a,b,c){var d=a&&"object"==typeof a?n.extend({},a):{complete:c||!c&&b||n.isFunction(a)&&a,duration:a,easing:c&&b||b&&!n.isFunction(b)&&b};return d.duration=n.fx.off?0:"number"==typeof d.duration?d.duration:d.duration in n.fx.speeds?n.fx.speeds[d.duration]:n.fx.speeds._default,(null==d.queue||d.queue===!0)&&(d.queue="fx"),d.old=d.complete,d.complete=function(){n.isFunction(d.old)&&d.old.call(this),d.queue&&n.dequeue(this,d.queue)},d},n.fn.extend({fadeTo:function(a,b,c,d){return this.filter(S).css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=n.isEmptyObject(a),f=n.speed(b,c,d),g=function(){var b=Xa(this,n.extend({},a),f);(e||L.get(this,"finish"))&&b.stop(!0)};return g.finish=g,e||f.queue===!1?this.each(g):this.queue(f.queue,g)},stop:function(a,b,c){var d=function(a){var b=a.stop;delete a.stop,b(c)};return"string"!=typeof a&&(c=b,b=a,a=void 0),b&&a!==!1&&this.queue(a||"fx",[]),this.each(function(){var b=!0,e=null!=a&&a+"queueHooks",f=n.timers,g=L.get(this);if(e)g[e]&&g[e].stop&&d(g[e]);else for(e in g)g[e]&&g[e].stop&&Pa.test(e)&&d(g[e]);for(e=f.length;e--;)f[e].elem!==this||null!=a&&f[e].queue!==a||(f[e].anim.stop(c),b=!1,f.splice(e,1));(b||!c)&&n.dequeue(this,a)})},finish:function(a){return a!==!1&&(a=a||"fx"),this.each(function(){var b,c=L.get(this),d=c[a+"queue"],e=c[a+"queueHooks"],f=n.timers,g=d?d.length:0;for(c.finish=!0,n.queue(this,a,[]),e&&e.stop&&e.stop.call(this,!0),b=f.length;b--;)f[b].elem===this&&f[b].queue===a&&(f[b].anim.stop(!0),f.splice(b,1));for(b=0;g>b;b++)d[b]&&d[b].finish&&d[b].finish.call(this);delete c.finish})}}),n.each(["toggle","show","hide"],function(a,b){var c=n.fn[b];n.fn[b]=function(a,d,e){return null==a||"boolean"==typeof a?c.apply(this,arguments):this.animate(Ta(b,!0),a,d,e)}}),n.each({slideDown:Ta("show"),slideUp:Ta("hide"),slideToggle:Ta("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){n.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),n.timers=[],n.fx.tick=function(){var a,b=0,c=n.timers;for(La=n.now();b<c.length;b++)a=c[b],a()||c[b]!==a||c.splice(b--,1);c.length||n.fx.stop(),La=void 0},n.fx.timer=function(a){n.timers.push(a),a()?n.fx.start():n.timers.pop()},n.fx.interval=13,n.fx.start=function(){Ma||(Ma=setInterval(n.fx.tick,n.fx.interval))},n.fx.stop=function(){clearInterval(Ma),Ma=null},n.fx.speeds={slow:600,fast:200,_default:400},n.fn.delay=function(a,b){return a=n.fx?n.fx.speeds[a]||a:a,b=b||"fx",this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},function(){var a=l.createElement("input"),b=l.createElement("select"),c=b.appendChild(l.createElement("option"));a.type="checkbox",k.checkOn=""!==a.value,k.optSelected=c.selected,b.disabled=!0,k.optDisabled=!c.disabled,a=l.createElement("input"),a.value="t",a.type="radio",k.radioValue="t"===a.value}();var Ya,Za,$a=n.expr.attrHandle;n.fn.extend({attr:function(a,b){return J(this,n.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){n.removeAttr(this,a)})}}),n.extend({attr:function(a,b,c){var d,e,f=a.nodeType;if(a&&3!==f&&8!==f&&2!==f)return typeof a.getAttribute===U?n.prop(a,b,c):(1===f&&n.isXMLDoc(a)||(b=b.toLowerCase(),d=n.attrHooks[b]||(n.expr.match.bool.test(b)?Za:Ya)),
void 0===c?d&&"get"in d&&null!==(e=d.get(a,b))?e:(e=n.find.attr(a,b),null==e?void 0:e):null!==c?d&&"set"in d&&void 0!==(e=d.set(a,c,b))?e:(a.setAttribute(b,c+""),c):void n.removeAttr(a,b))},removeAttr:function(a,b){var c,d,e=0,f=b&&b.match(E);if(f&&1===a.nodeType)while(c=f[e++])d=n.propFix[c]||c,n.expr.match.bool.test(c)&&(a[d]=!1),a.removeAttribute(c)},attrHooks:{type:{set:function(a,b){if(!k.radioValue&&"radio"===b&&n.nodeName(a,"input")){var c=a.value;return a.setAttribute("type",b),c&&(a.value=c),b}}}}}),Za={set:function(a,b,c){return b===!1?n.removeAttr(a,c):a.setAttribute(c,c),c}},n.each(n.expr.match.bool.source.match(/\w+/g),function(a,b){var c=$a[b]||n.find.attr;$a[b]=function(a,b,d){var e,f;return d||(f=$a[b],$a[b]=e,e=null!=c(a,b,d)?b.toLowerCase():null,$a[b]=f),e}});var _a=/^(?:input|select|textarea|button)$/i;n.fn.extend({prop:function(a,b){return J(this,n.prop,a,b,arguments.length>1)},removeProp:function(a){return this.each(function(){delete this[n.propFix[a]||a]})}}),n.extend({propFix:{"for":"htmlFor","class":"className"},prop:function(a,b,c){var d,e,f,g=a.nodeType;if(a&&3!==g&&8!==g&&2!==g)return f=1!==g||!n.isXMLDoc(a),f&&(b=n.propFix[b]||b,e=n.propHooks[b]),void 0!==c?e&&"set"in e&&void 0!==(d=e.set(a,c,b))?d:a[b]=c:e&&"get"in e&&null!==(d=e.get(a,b))?d:a[b]},propHooks:{tabIndex:{get:function(a){return a.hasAttribute("tabindex")||_a.test(a.nodeName)||a.href?a.tabIndex:-1}}}}),k.optSelected||(n.propHooks.selected={get:function(a){var b=a.parentNode;return b&&b.parentNode&&b.parentNode.selectedIndex,null}}),n.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){n.propFix[this.toLowerCase()]=this});var ab=/[\t\r\n\f]/g;n.fn.extend({addClass:function(a){var b,c,d,e,f,g,h="string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).addClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ab," "):" ")){f=0;while(e=b[f++])d.indexOf(" "+e+" ")<0&&(d+=e+" ");g=n.trim(d),c.className!==g&&(c.className=g)}return this},removeClass:function(a){var b,c,d,e,f,g,h=0===arguments.length||"string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).removeClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ab," "):"")){f=0;while(e=b[f++])while(d.indexOf(" "+e+" ")>=0)d=d.replace(" "+e+" "," ");g=a?n.trim(d):"",c.className!==g&&(c.className=g)}return this},toggleClass:function(a,b){var c=typeof a;return"boolean"==typeof b&&"string"===c?b?this.addClass(a):this.removeClass(a):this.each(n.isFunction(a)?function(c){n(this).toggleClass(a.call(this,c,this.className,b),b)}:function(){if("string"===c){var b,d=0,e=n(this),f=a.match(E)||[];while(b=f[d++])e.hasClass(b)?e.removeClass(b):e.addClass(b)}else(c===U||"boolean"===c)&&(this.className&&L.set(this,"__className__",this.className),this.className=this.className||a===!1?"":L.get(this,"__className__")||"")})},hasClass:function(a){for(var b=" "+a+" ",c=0,d=this.length;d>c;c++)if(1===this[c].nodeType&&(" "+this[c].className+" ").replace(ab," ").indexOf(b)>=0)return!0;return!1}});var bb=/\r/g;n.fn.extend({val:function(a){var b,c,d,e=this[0];{if(arguments.length)return d=n.isFunction(a),this.each(function(c){var e;1===this.nodeType&&(e=d?a.call(this,c,n(this).val()):a,null==e?e="":"number"==typeof e?e+="":n.isArray(e)&&(e=n.map(e,function(a){return null==a?"":a+""})),b=n.valHooks[this.type]||n.valHooks[this.nodeName.toLowerCase()],b&&"set"in b&&void 0!==b.set(this,e,"value")||(this.value=e))});if(e)return b=n.valHooks[e.type]||n.valHooks[e.nodeName.toLowerCase()],b&&"get"in b&&void 0!==(c=b.get(e,"value"))?c:(c=e.value,"string"==typeof c?c.replace(bb,""):null==c?"":c)}}}),n.extend({valHooks:{option:{get:function(a){var b=n.find.attr(a,"value");return null!=b?b:n.trim(n.text(a))}},select:{get:function(a){for(var b,c,d=a.options,e=a.selectedIndex,f="select-one"===a.type||0>e,g=f?null:[],h=f?e+1:d.length,i=0>e?h:f?e:0;h>i;i++)if(c=d[i],!(!c.selected&&i!==e||(k.optDisabled?c.disabled:null!==c.getAttribute("disabled"))||c.parentNode.disabled&&n.nodeName(c.parentNode,"optgroup"))){if(b=n(c).val(),f)return b;g.push(b)}return g},set:function(a,b){var c,d,e=a.options,f=n.makeArray(b),g=e.length;while(g--)d=e[g],(d.selected=n.inArray(d.value,f)>=0)&&(c=!0);return c||(a.selectedIndex=-1),f}}}}),n.each(["radio","checkbox"],function(){n.valHooks[this]={set:function(a,b){return n.isArray(b)?a.checked=n.inArray(n(a).val(),b)>=0:void 0}},k.checkOn||(n.valHooks[this].get=function(a){return null===a.getAttribute("value")?"on":a.value})}),n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){n.fn[b]=function(a,c){return arguments.length>0?this.on(b,null,a,c):this.trigger(b)}}),n.fn.extend({hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return 1===arguments.length?this.off(a,"**"):this.off(b,a||"**",c)}});var cb=n.now(),db=/\?/;n.parseJSON=function(a){return JSON.parse(a+"")},n.parseXML=function(a){var b,c;if(!a||"string"!=typeof a)return null;try{c=new DOMParser,b=c.parseFromString(a,"text/xml")}catch(d){b=void 0}return(!b||b.getElementsByTagName("parsererror").length)&&n.error("Invalid XML: "+a),b};var eb=/#.*$/,fb=/([?&])_=[^&]*/,gb=/^(.*?):[ \t]*([^\r\n]*)$/gm,hb=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,ib=/^(?:GET|HEAD)$/,jb=/^\/\//,kb=/^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,lb={},mb={},nb="*/".concat("*"),ob=a.location.href,pb=kb.exec(ob.toLowerCase())||[];function qb(a){return function(b,c){"string"!=typeof b&&(c=b,b="*");var d,e=0,f=b.toLowerCase().match(E)||[];if(n.isFunction(c))while(d=f[e++])"+"===d[0]?(d=d.slice(1)||"*",(a[d]=a[d]||[]).unshift(c)):(a[d]=a[d]||[]).push(c)}}function rb(a,b,c,d){var e={},f=a===mb;function g(h){var i;return e[h]=!0,n.each(a[h]||[],function(a,h){var j=h(b,c,d);return"string"!=typeof j||f||e[j]?f?!(i=j):void 0:(b.dataTypes.unshift(j),g(j),!1)}),i}return g(b.dataTypes[0])||!e["*"]&&g("*")}function sb(a,b){var c,d,e=n.ajaxSettings.flatOptions||{};for(c in b)void 0!==b[c]&&((e[c]?a:d||(d={}))[c]=b[c]);return d&&n.extend(!0,a,d),a}function tb(a,b,c){var d,e,f,g,h=a.contents,i=a.dataTypes;while("*"===i[0])i.shift(),void 0===d&&(d=a.mimeType||b.getResponseHeader("Content-Type"));if(d)for(e in h)if(h[e]&&h[e].test(d)){i.unshift(e);break}if(i[0]in c)f=i[0];else{for(e in c){if(!i[0]||a.converters[e+" "+i[0]]){f=e;break}g||(g=e)}f=f||g}return f?(f!==i[0]&&i.unshift(f),c[f]):void 0}function ub(a,b,c,d){var e,f,g,h,i,j={},k=a.dataTypes.slice();if(k[1])for(g in a.converters)j[g.toLowerCase()]=a.converters[g];f=k.shift();while(f)if(a.responseFields[f]&&(c[a.responseFields[f]]=b),!i&&d&&a.dataFilter&&(b=a.dataFilter(b,a.dataType)),i=f,f=k.shift())if("*"===f)f=i;else if("*"!==i&&i!==f){if(g=j[i+" "+f]||j["* "+f],!g)for(e in j)if(h=e.split(" "),h[1]===f&&(g=j[i+" "+h[0]]||j["* "+h[0]])){g===!0?g=j[e]:j[e]!==!0&&(f=h[0],k.unshift(h[1]));break}if(g!==!0)if(g&&a["throws"])b=g(b);else try{b=g(b)}catch(l){return{state:"parsererror",error:g?l:"No conversion from "+i+" to "+f}}}return{state:"success",data:b}}n.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:ob,type:"GET",isLocal:hb.test(pb[1]),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":nb,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":n.parseJSON,"text xml":n.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(a,b){return b?sb(sb(a,n.ajaxSettings),b):sb(n.ajaxSettings,a)},ajaxPrefilter:qb(lb),ajaxTransport:qb(mb),ajax:function(a,b){"object"==typeof a&&(b=a,a=void 0),b=b||{};var c,d,e,f,g,h,i,j,k=n.ajaxSetup({},b),l=k.context||k,m=k.context&&(l.nodeType||l.jquery)?n(l):n.event,o=n.Deferred(),p=n.Callbacks("once memory"),q=k.statusCode||{},r={},s={},t=0,u="canceled",v={readyState:0,getResponseHeader:function(a){var b;if(2===t){if(!f){f={};while(b=gb.exec(e))f[b[1].toLowerCase()]=b[2]}b=f[a.toLowerCase()]}return null==b?null:b},getAllResponseHeaders:function(){return 2===t?e:null},setRequestHeader:function(a,b){var c=a.toLowerCase();return t||(a=s[c]=s[c]||a,r[a]=b),this},overrideMimeType:function(a){return t||(k.mimeType=a),this},statusCode:function(a){var b;if(a)if(2>t)for(b in a)q[b]=[q[b],a[b]];else v.always(a[v.status]);return this},abort:function(a){var b=a||u;return c&&c.abort(b),x(0,b),this}};if(o.promise(v).complete=p.add,v.success=v.done,v.error=v.fail,k.url=((a||k.url||ob)+"").replace(eb,"").replace(jb,pb[1]+"//"),k.type=b.method||b.type||k.method||k.type,k.dataTypes=n.trim(k.dataType||"*").toLowerCase().match(E)||[""],null==k.crossDomain&&(h=kb.exec(k.url.toLowerCase()),k.crossDomain=!(!h||h[1]===pb[1]&&h[2]===pb[2]&&(h[3]||("http:"===h[1]?"80":"443"))===(pb[3]||("http:"===pb[1]?"80":"443")))),k.data&&k.processData&&"string"!=typeof k.data&&(k.data=n.param(k.data,k.traditional)),rb(lb,k,b,v),2===t)return v;i=n.event&&k.global,i&&0===n.active++&&n.event.trigger("ajaxStart"),k.type=k.type.toUpperCase(),k.hasContent=!ib.test(k.type),d=k.url,k.hasContent||(k.data&&(d=k.url+=(db.test(d)?"&":"?")+k.data,delete k.data),k.cache===!1&&(k.url=fb.test(d)?d.replace(fb,"$1_="+cb++):d+(db.test(d)?"&":"?")+"_="+cb++)),k.ifModified&&(n.lastModified[d]&&v.setRequestHeader("If-Modified-Since",n.lastModified[d]),n.etag[d]&&v.setRequestHeader("If-None-Match",n.etag[d])),(k.data&&k.hasContent&&k.contentType!==!1||b.contentType)&&v.setRequestHeader("Content-Type",k.contentType),v.setRequestHeader("Accept",k.dataTypes[0]&&k.accepts[k.dataTypes[0]]?k.accepts[k.dataTypes[0]]+("*"!==k.dataTypes[0]?", "+nb+"; q=0.01":""):k.accepts["*"]);for(j in k.headers)v.setRequestHeader(j,k.headers[j]);if(k.beforeSend&&(k.beforeSend.call(l,v,k)===!1||2===t))return v.abort();u="abort";for(j in{success:1,error:1,complete:1})v[j](k[j]);if(c=rb(mb,k,b,v)){v.readyState=1,i&&m.trigger("ajaxSend",[v,k]),k.async&&k.timeout>0&&(g=setTimeout(function(){v.abort("timeout")},k.timeout));try{t=1,c.send(r,x)}catch(w){if(!(2>t))throw w;x(-1,w)}}else x(-1,"No Transport");function x(a,b,f,h){var j,r,s,u,w,x=b;2!==t&&(t=2,g&&clearTimeout(g),c=void 0,e=h||"",v.readyState=a>0?4:0,j=a>=200&&300>a||304===a,f&&(u=tb(k,v,f)),u=ub(k,u,v,j),j?(k.ifModified&&(w=v.getResponseHeader("Last-Modified"),w&&(n.lastModified[d]=w),w=v.getResponseHeader("etag"),w&&(n.etag[d]=w)),204===a||"HEAD"===k.type?x="nocontent":304===a?x="notmodified":(x=u.state,r=u.data,s=u.error,j=!s)):(s=x,(a||!x)&&(x="error",0>a&&(a=0))),v.status=a,v.statusText=(b||x)+"",j?o.resolveWith(l,[r,x,v]):o.rejectWith(l,[v,x,s]),v.statusCode(q),q=void 0,i&&m.trigger(j?"ajaxSuccess":"ajaxError",[v,k,j?r:s]),p.fireWith(l,[v,x]),i&&(m.trigger("ajaxComplete",[v,k]),--n.active||n.event.trigger("ajaxStop")))}return v},getJSON:function(a,b,c){return n.get(a,b,c,"json")},getScript:function(a,b){return n.get(a,void 0,b,"script")}}),n.each(["get","post"],function(a,b){n[b]=function(a,c,d,e){return n.isFunction(c)&&(e=e||d,d=c,c=void 0),n.ajax({url:a,type:b,dataType:e,data:c,success:d})}}),n._evalUrl=function(a){return n.ajax({url:a,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0})},n.fn.extend({wrapAll:function(a){var b;return n.isFunction(a)?this.each(function(b){n(this).wrapAll(a.call(this,b))}):(this[0]&&(b=n(a,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstElementChild)a=a.firstElementChild;return a}).append(this)),this)},wrapInner:function(a){return this.each(n.isFunction(a)?function(b){n(this).wrapInner(a.call(this,b))}:function(){var b=n(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=n.isFunction(a);return this.each(function(c){n(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){n.nodeName(this,"body")||n(this).replaceWith(this.childNodes)}).end()}}),n.expr.filters.hidden=function(a){return a.offsetWidth<=0&&a.offsetHeight<=0},n.expr.filters.visible=function(a){return!n.expr.filters.hidden(a)};var vb=/%20/g,wb=/\[\]$/,xb=/\r?\n/g,yb=/^(?:submit|button|image|reset|file)$/i,zb=/^(?:input|select|textarea|keygen)/i;function Ab(a,b,c,d){var e;if(n.isArray(b))n.each(b,function(b,e){c||wb.test(a)?d(a,e):Ab(a+"["+("object"==typeof e?b:"")+"]",e,c,d)});else if(c||"object"!==n.type(b))d(a,b);else for(e in b)Ab(a+"["+e+"]",b[e],c,d)}n.param=function(a,b){var c,d=[],e=function(a,b){b=n.isFunction(b)?b():null==b?"":b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};if(void 0===b&&(b=n.ajaxSettings&&n.ajaxSettings.traditional),n.isArray(a)||a.jquery&&!n.isPlainObject(a))n.each(a,function(){e(this.name,this.value)});else for(c in a)Ab(c,a[c],b,e);return d.join("&").replace(vb,"+")},n.fn.extend({serialize:function(){return n.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var a=n.prop(this,"elements");return a?n.makeArray(a):this}).filter(function(){var a=this.type;return this.name&&!n(this).is(":disabled")&&zb.test(this.nodeName)&&!yb.test(a)&&(this.checked||!T.test(a))}).map(function(a,b){var c=n(this).val();return null==c?null:n.isArray(c)?n.map(c,function(a){return{name:b.name,value:a.replace(xb,"\r\n")}}):{name:b.name,value:c.replace(xb,"\r\n")}}).get()}}),n.ajaxSettings.xhr=function(){try{return new XMLHttpRequest}catch(a){}};var Bb=0,Cb={},Db={0:200,1223:204},Eb=n.ajaxSettings.xhr();a.attachEvent&&a.attachEvent("onunload",function(){for(var a in Cb)Cb[a]()}),k.cors=!!Eb&&"withCredentials"in Eb,k.ajax=Eb=!!Eb,n.ajaxTransport(function(a){var b;return k.cors||Eb&&!a.crossDomain?{send:function(c,d){var e,f=a.xhr(),g=++Bb;if(f.open(a.type,a.url,a.async,a.username,a.password),a.xhrFields)for(e in a.xhrFields)f[e]=a.xhrFields[e];a.mimeType&&f.overrideMimeType&&f.overrideMimeType(a.mimeType),a.crossDomain||c["X-Requested-With"]||(c["X-Requested-With"]="XMLHttpRequest");for(e in c)f.setRequestHeader(e,c[e]);b=function(a){return function(){b&&(delete Cb[g],b=f.onload=f.onerror=null,"abort"===a?f.abort():"error"===a?d(f.status,f.statusText):d(Db[f.status]||f.status,f.statusText,"string"==typeof f.responseText?{text:f.responseText}:void 0,f.getAllResponseHeaders()))}},f.onload=b(),f.onerror=b("error"),b=Cb[g]=b("abort");try{f.send(a.hasContent&&a.data||null)}catch(h){if(b)throw h}},abort:function(){b&&b()}}:void 0}),n.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/(?:java|ecma)script/},converters:{"text script":function(a){return n.globalEval(a),a}}}),n.ajaxPrefilter("script",function(a){void 0===a.cache&&(a.cache=!1),a.crossDomain&&(a.type="GET")}),n.ajaxTransport("script",function(a){if(a.crossDomain){var b,c;return{send:function(d,e){b=n("<script>").prop({async:!0,charset:a.scriptCharset,src:a.url}).on("load error",c=function(a){b.remove(),c=null,a&&e("error"===a.type?404:200,a.type)}),l.head.appendChild(b[0])},abort:function(){c&&c()}}}});var Fb=[],Gb=/(=)\?(?=&|$)|\?\?/;n.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var a=Fb.pop()||n.expando+"_"+cb++;return this[a]=!0,a}}),n.ajaxPrefilter("json jsonp",function(b,c,d){var e,f,g,h=b.jsonp!==!1&&(Gb.test(b.url)?"url":"string"==typeof b.data&&!(b.contentType||"").indexOf("application/x-www-form-urlencoded")&&Gb.test(b.data)&&"data");return h||"jsonp"===b.dataTypes[0]?(e=b.jsonpCallback=n.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,h?b[h]=b[h].replace(Gb,"$1"+e):b.jsonp!==!1&&(b.url+=(db.test(b.url)?"&":"?")+b.jsonp+"="+e),b.converters["script json"]=function(){return g||n.error(e+" was not called"),g[0]},b.dataTypes[0]="json",f=a[e],a[e]=function(){g=arguments},d.always(function(){a[e]=f,b[e]&&(b.jsonpCallback=c.jsonpCallback,Fb.push(e)),g&&n.isFunction(f)&&f(g[0]),g=f=void 0}),"script"):void 0}),n.parseHTML=function(a,b,c){if(!a||"string"!=typeof a)return null;"boolean"==typeof b&&(c=b,b=!1),b=b||l;var d=v.exec(a),e=!c&&[];return d?[b.createElement(d[1])]:(d=n.buildFragment([a],b,e),e&&e.length&&n(e).remove(),n.merge([],d.childNodes))};var Hb=n.fn.load;n.fn.load=function(a,b,c){if("string"!=typeof a&&Hb)return Hb.apply(this,arguments);var d,e,f,g=this,h=a.indexOf(" ");return h>=0&&(d=n.trim(a.slice(h)),a=a.slice(0,h)),n.isFunction(b)?(c=b,b=void 0):b&&"object"==typeof b&&(e="POST"),g.length>0&&n.ajax({url:a,type:e,dataType:"html",data:b}).done(function(a){f=arguments,g.html(d?n("<div>").append(n.parseHTML(a)).find(d):a)}).complete(c&&function(a,b){g.each(c,f||[a.responseText,b,a])}),this},n.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(a,b){n.fn[b]=function(a){return this.on(b,a)}}),n.expr.filters.animated=function(a){return n.grep(n.timers,function(b){return a===b.elem}).length};var Ib=a.document.documentElement;function Jb(a){return n.isWindow(a)?a:9===a.nodeType&&a.defaultView}n.offset={setOffset:function(a,b,c){var d,e,f,g,h,i,j,k=n.css(a,"position"),l=n(a),m={};"static"===k&&(a.style.position="relative"),h=l.offset(),f=n.css(a,"top"),i=n.css(a,"left"),j=("absolute"===k||"fixed"===k)&&(f+i).indexOf("auto")>-1,j?(d=l.position(),g=d.top,e=d.left):(g=parseFloat(f)||0,e=parseFloat(i)||0),n.isFunction(b)&&(b=b.call(a,c,h)),null!=b.top&&(m.top=b.top-h.top+g),null!=b.left&&(m.left=b.left-h.left+e),"using"in b?b.using.call(a,m):l.css(m)}},n.fn.extend({offset:function(a){if(arguments.length)return void 0===a?this:this.each(function(b){n.offset.setOffset(this,a,b)});var b,c,d=this[0],e={top:0,left:0},f=d&&d.ownerDocument;if(f)return b=f.documentElement,n.contains(b,d)?(typeof d.getBoundingClientRect!==U&&(e=d.getBoundingClientRect()),c=Jb(f),{top:e.top+c.pageYOffset-b.clientTop,left:e.left+c.pageXOffset-b.clientLeft}):e},position:function(){if(this[0]){var a,b,c=this[0],d={top:0,left:0};return"fixed"===n.css(c,"position")?b=c.getBoundingClientRect():(a=this.offsetParent(),b=this.offset(),n.nodeName(a[0],"html")||(d=a.offset()),d.top+=n.css(a[0],"borderTopWidth",!0),d.left+=n.css(a[0],"borderLeftWidth",!0)),{top:b.top-d.top-n.css(c,"marginTop",!0),left:b.left-d.left-n.css(c,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||Ib;while(a&&!n.nodeName(a,"html")&&"static"===n.css(a,"position"))a=a.offsetParent;return a||Ib})}}),n.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(b,c){var d="pageYOffset"===c;n.fn[b]=function(e){return J(this,function(b,e,f){var g=Jb(b);return void 0===f?g?g[c]:b[e]:void(g?g.scrollTo(d?a.pageXOffset:f,d?f:a.pageYOffset):b[e]=f)},b,e,arguments.length,null)}}),n.each(["top","left"],function(a,b){n.cssHooks[b]=ya(k.pixelPosition,function(a,c){return c?(c=xa(a,b),va.test(c)?n(a).position()[b]+"px":c):void 0})}),n.each({Height:"height",Width:"width"},function(a,b){n.each({padding:"inner"+a,content:b,"":"outer"+a},function(c,d){n.fn[d]=function(d,e){var f=arguments.length&&(c||"boolean"!=typeof d),g=c||(d===!0||e===!0?"margin":"border");return J(this,function(b,c,d){var e;return n.isWindow(b)?b.document.documentElement["client"+a]:9===b.nodeType?(e=b.documentElement,Math.max(b.body["scroll"+a],e["scroll"+a],b.body["offset"+a],e["offset"+a],e["client"+a])):void 0===d?n.css(b,c,g):n.style(b,c,d,g)},b,f?d:void 0,f,null)}})}),n.fn.size=function(){return this.length},n.fn.andSelf=n.fn.addBack,"function"==typeof define&&define.amd&&define("jquery",[],function(){return n});var Kb=a.jQuery,Lb=a.$;return n.noConflict=function(b){return a.$===n&&(a.$=Lb),b&&a.jQuery===n&&(a.jQuery=Kb),n},typeof b===U&&(a.jQuery=a.$=n),n});

/*!
 * Bootstrap v3.3.5 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under the MIT license
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){"use strict";var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one("bsTransitionEnd",function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b(),a.support.transition&&(a.event.special.bsTransitionEnd={bindType:a.support.transition.end,delegateType:a.support.transition.end,handle:function(b){return a(b.target).is(this)?b.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var c=a(this),e=c.data("bs.alert");e||c.data("bs.alert",e=new d(this)),"string"==typeof b&&e[b].call(c)})}var c='[data-dismiss="alert"]',d=function(b){a(b).on("click",c,this.close)};d.VERSION="3.3.5",d.TRANSITION_DURATION=150,d.prototype.close=function(b){function c(){g.detach().trigger("closed.bs.alert").remove()}var e=a(this),f=e.attr("data-target");f||(f=e.attr("href"),f=f&&f.replace(/.*(?=#[^\s]*$)/,""));var g=a(f);b&&b.preventDefault(),g.length||(g=e.closest(".alert")),g.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(g.removeClass("in"),a.support.transition&&g.hasClass("fade")?g.one("bsTransitionEnd",c).emulateTransitionEnd(d.TRANSITION_DURATION):c())};var e=a.fn.alert;a.fn.alert=b,a.fn.alert.Constructor=d,a.fn.alert.noConflict=function(){return a.fn.alert=e,this},a(document).on("click.bs.alert.data-api",c,d.prototype.close)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.button"),f="object"==typeof b&&b;e||d.data("bs.button",e=new c(this,f)),"toggle"==b?e.toggle():b&&e.setState(b)})}var c=function(b,d){this.$element=a(b),this.options=a.extend({},c.DEFAULTS,d),this.isLoading=!1};c.VERSION="3.3.5",c.DEFAULTS={loadingText:"loading..."},c.prototype.setState=function(b){var c="disabled",d=this.$element,e=d.is("input")?"val":"html",f=d.data();b+="Text",null==f.resetText&&d.data("resetText",d[e]()),setTimeout(a.proxy(function(){d[e](null==f[b]?this.options[b]:f[b]),"loadingText"==b?(this.isLoading=!0,d.addClass(c).attr(c,c)):this.isLoading&&(this.isLoading=!1,d.removeClass(c).removeAttr(c))},this),0)},c.prototype.toggle=function(){var a=!0,b=this.$element.closest('[data-toggle="buttons"]');if(b.length){var c=this.$element.find("input");"radio"==c.prop("type")?(c.prop("checked")&&(a=!1),b.find(".active").removeClass("active"),this.$element.addClass("active")):"checkbox"==c.prop("type")&&(c.prop("checked")!==this.$element.hasClass("active")&&(a=!1),this.$element.toggleClass("active")),c.prop("checked",this.$element.hasClass("active")),a&&c.trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active")),this.$element.toggleClass("active")};var d=a.fn.button;a.fn.button=b,a.fn.button.Constructor=c,a.fn.button.noConflict=function(){return a.fn.button=d,this},a(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(c){var d=a(c.target);d.hasClass("btn")||(d=d.closest(".btn")),b.call(d,"toggle"),a(c.target).is('input[type="radio"]')||a(c.target).is('input[type="checkbox"]')||c.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(b){a(b.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(b.type))})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.carousel"),f=a.extend({},c.DEFAULTS,d.data(),"object"==typeof b&&b),g="string"==typeof b?b:f.slide;e||d.data("bs.carousel",e=new c(this,f)),"number"==typeof b?e.to(b):g?e[g]():f.interval&&e.pause().cycle()})}var c=function(b,c){this.$element=a(b),this.$indicators=this.$element.find(".carousel-indicators"),this.options=c,this.paused=null,this.sliding=null,this.interval=null,this.$active=null,this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",a.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",a.proxy(this.pause,this)).on("mouseleave.bs.carousel",a.proxy(this.cycle,this))};c.VERSION="3.3.5",c.TRANSITION_DURATION=600,c.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},c.prototype.keydown=function(a){if(!/input|textarea/i.test(a.target.tagName)){switch(a.which){case 37:this.prev();break;case 39:this.next();break;default:return}a.preventDefault()}},c.prototype.cycle=function(b){return b||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(a.proxy(this.next,this),this.options.interval)),this},c.prototype.getItemIndex=function(a){return this.$items=a.parent().children(".item"),this.$items.index(a||this.$active)},c.prototype.getItemForDirection=function(a,b){var c=this.getItemIndex(b),d="prev"==a&&0===c||"next"==a&&c==this.$items.length-1;if(d&&!this.options.wrap)return b;var e="prev"==a?-1:1,f=(c+e)%this.$items.length;return this.$items.eq(f)},c.prototype.to=function(a){var b=this,c=this.getItemIndex(this.$active=this.$element.find(".item.active"));return a>this.$items.length-1||0>a?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){b.to(a)}):c==a?this.pause().cycle():this.slide(a>c?"next":"prev",this.$items.eq(a))},c.prototype.pause=function(b){return b||(this.paused=!0),this.$element.find(".next, .prev").length&&a.support.transition&&(this.$element.trigger(a.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},c.prototype.next=function(){return this.sliding?void 0:this.slide("next")},c.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")},c.prototype.slide=function(b,d){var e=this.$element.find(".item.active"),f=d||this.getItemForDirection(b,e),g=this.interval,h="next"==b?"left":"right",i=this;if(f.hasClass("active"))return this.sliding=!1;var j=f[0],k=a.Event("slide.bs.carousel",{relatedTarget:j,direction:h});if(this.$element.trigger(k),!k.isDefaultPrevented()){if(this.sliding=!0,g&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var l=a(this.$indicators.children()[this.getItemIndex(f)]);l&&l.addClass("active")}var m=a.Event("slid.bs.carousel",{relatedTarget:j,direction:h});return a.support.transition&&this.$element.hasClass("slide")?(f.addClass(b),f[0].offsetWidth,e.addClass(h),f.addClass(h),e.one("bsTransitionEnd",function(){f.removeClass([b,h].join(" ")).addClass("active"),e.removeClass(["active",h].join(" ")),i.sliding=!1,setTimeout(function(){i.$element.trigger(m)},0)}).emulateTransitionEnd(c.TRANSITION_DURATION)):(e.removeClass("active"),f.addClass("active"),this.sliding=!1,this.$element.trigger(m)),g&&this.cycle(),this}};var d=a.fn.carousel;a.fn.carousel=b,a.fn.carousel.Constructor=c,a.fn.carousel.noConflict=function(){return a.fn.carousel=d,this};var e=function(c){var d,e=a(this),f=a(e.attr("data-target")||(d=e.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,""));if(f.hasClass("carousel")){var g=a.extend({},f.data(),e.data()),h=e.attr("data-slide-to");h&&(g.interval=!1),b.call(f,g),h&&f.data("bs.carousel").to(h),c.preventDefault()}};a(document).on("click.bs.carousel.data-api","[data-slide]",e).on("click.bs.carousel.data-api","[data-slide-to]",e),a(window).on("load",function(){a('[data-ride="carousel"]').each(function(){var c=a(this);b.call(c,c.data())})})}(jQuery),+function(a){"use strict";function b(b){var c,d=b.attr("data-target")||(c=b.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,"");return a(d)}function c(b){return this.each(function(){var c=a(this),e=c.data("bs.collapse"),f=a.extend({},d.DEFAULTS,c.data(),"object"==typeof b&&b);!e&&f.toggle&&/show|hide/.test(b)&&(f.toggle=!1),e||c.data("bs.collapse",e=new d(this,f)),"string"==typeof b&&e[b]()})}var d=function(b,c){this.$element=a(b),this.options=a.extend({},d.DEFAULTS,c),this.$trigger=a('[data-toggle="collapse"][href="#'+b.id+'"],[data-toggle="collapse"][data-target="#'+b.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};d.VERSION="3.3.5",d.TRANSITION_DURATION=350,d.DEFAULTS={toggle:!0},d.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},d.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b,e=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(e&&e.length&&(b=e.data("bs.collapse"),b&&b.transitioning))){var f=a.Event("show.bs.collapse");if(this.$element.trigger(f),!f.isDefaultPrevented()){e&&e.length&&(c.call(e,"hide"),b||e.data("bs.collapse",null));var g=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var h=function(){this.$element.removeClass("collapsing").addClass("collapse in")[g](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return h.call(this);var i=a.camelCase(["scroll",g].join("-"));this.$element.one("bsTransitionEnd",a.proxy(h,this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])}}}},d.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var e=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return a.support.transition?void this.$element[c](0).one("bsTransitionEnd",a.proxy(e,this)).emulateTransitionEnd(d.TRANSITION_DURATION):e.call(this)}}},d.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},d.prototype.getParent=function(){return a(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(a.proxy(function(c,d){var e=a(d);this.addAriaAndCollapsedClass(b(e),e)},this)).end()},d.prototype.addAriaAndCollapsedClass=function(a,b){var c=a.hasClass("in");a.attr("aria-expanded",c),b.toggleClass("collapsed",!c).attr("aria-expanded",c)};var e=a.fn.collapse;a.fn.collapse=c,a.fn.collapse.Constructor=d,a.fn.collapse.noConflict=function(){return a.fn.collapse=e,this},a(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(d){var e=a(this);e.attr("data-target")||d.preventDefault();var f=b(e),g=f.data("bs.collapse"),h=g?"toggle":e.data();c.call(f,h)})}(jQuery),+function(a){"use strict";function b(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}function c(c){c&&3===c.which||(a(e).remove(),a(f).each(function(){var d=a(this),e=b(d),f={relatedTarget:this};e.hasClass("open")&&(c&&"click"==c.type&&/input|textarea/i.test(c.target.tagName)&&a.contains(e[0],c.target)||(e.trigger(c=a.Event("hide.bs.dropdown",f)),c.isDefaultPrevented()||(d.attr("aria-expanded","false"),e.removeClass("open").trigger("hidden.bs.dropdown",f))))}))}function d(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new g(this)),"string"==typeof b&&d[b].call(c)})}var e=".dropdown-backdrop",f='[data-toggle="dropdown"]',g=function(b){a(b).on("click.bs.dropdown",this.toggle)};g.VERSION="3.3.5",g.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=b(e),g=f.hasClass("open");if(c(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(a(this)).on("click",c);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;e.trigger("focus").attr("aria-expanded","true"),f.toggleClass("open").trigger("shown.bs.dropdown",h)}return!1}},g.prototype.keydown=function(c){if(/(38|40|27|32)/.test(c.which)&&!/input|textarea/i.test(c.target.tagName)){var d=a(this);if(c.preventDefault(),c.stopPropagation(),!d.is(".disabled, :disabled")){var e=b(d),g=e.hasClass("open");if(!g&&27!=c.which||g&&27==c.which)return 27==c.which&&e.find(f).trigger("focus"),d.trigger("click");var h=" li:not(.disabled):visible a",i=e.find(".dropdown-menu"+h);if(i.length){var j=i.index(c.target);38==c.which&&j>0&&j--,40==c.which&&j<i.length-1&&j++,~j||(j=0),i.eq(j).trigger("focus")}}}};var h=a.fn.dropdown;a.fn.dropdown=d,a.fn.dropdown.Constructor=g,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=h,this},a(document).on("click.bs.dropdown.data-api",c).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",f,g.prototype.toggle).on("keydown.bs.dropdown.data-api",f,g.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",g.prototype.keydown)}(jQuery),+function(a){"use strict";function b(b,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},c.DEFAULTS,e.data(),"object"==typeof b&&b);f||e.data("bs.modal",f=new c(this,g)),"string"==typeof b?f[b](d):g.show&&f.show(d)})}var c=function(b,c){this.options=c,this.$body=a(document.body),this.$element=a(b),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};c.VERSION="3.3.5",c.TRANSITION_DURATION=300,c.BACKDROP_TRANSITION_DURATION=150,c.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},c.prototype.toggle=function(a){return this.isShown?this.hide():this.show(a)},c.prototype.show=function(b){var d=this,e=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(e),this.isShown||e.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){d.$element.one("mouseup.dismiss.bs.modal",function(b){a(b.target).is(d.$element)&&(d.ignoreBackdropClick=!0)})}),this.backdrop(function(){var e=a.support.transition&&d.$element.hasClass("fade");d.$element.parent().length||d.$element.appendTo(d.$body),d.$element.show().scrollTop(0),d.adjustDialog(),e&&d.$element[0].offsetWidth,d.$element.addClass("in"),d.enforceFocus();var f=a.Event("shown.bs.modal",{relatedTarget:b});e?d.$dialog.one("bsTransitionEnd",function(){d.$element.trigger("focus").trigger(f)}).emulateTransitionEnd(c.TRANSITION_DURATION):d.$element.trigger("focus").trigger(f)}))},c.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",a.proxy(this.hideModal,this)).emulateTransitionEnd(c.TRANSITION_DURATION):this.hideModal())},c.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.trigger("focus")},this))},c.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},c.prototype.resize=function(){this.isShown?a(window).on("resize.bs.modal",a.proxy(this.handleUpdate,this)):a(window).off("resize.bs.modal")},c.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.$body.removeClass("modal-open"),a.resetAdjustments(),a.resetScrollbar(),a.$element.trigger("hidden.bs.modal")})},c.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},c.prototype.backdrop=function(b){var d=this,e=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var f=a.support.transition&&e;if(this.$backdrop=a(document.createElement("div")).addClass("modal-backdrop "+e).appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",a.proxy(function(a){return this.ignoreBackdropClick?void(this.ignoreBackdropClick=!1):void(a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))},this)),f&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;f?this.$backdrop.one("bsTransitionEnd",b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):b()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var g=function(){d.removeBackdrop(),b&&b()};a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):g()}else b&&b()},c.prototype.handleUpdate=function(){this.adjustDialog()},c.prototype.adjustDialog=function(){var a=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&a?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!a?this.scrollbarWidth:""})},c.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},c.prototype.checkScrollbar=function(){var a=window.innerWidth;if(!a){var b=document.documentElement.getBoundingClientRect();a=b.right-Math.abs(b.left)}this.bodyIsOverflowing=document.body.clientWidth<a,this.scrollbarWidth=this.measureScrollbar()},c.prototype.setScrollbar=function(){var a=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",a+this.scrollbarWidth)},c.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)},c.prototype.measureScrollbar=function(){var a=document.createElement("div");a.className="modal-scrollbar-measure",this.$body.append(a);var b=a.offsetWidth-a.clientWidth;return this.$body[0].removeChild(a),b};var d=a.fn.modal;a.fn.modal=b,a.fn.modal.Constructor=c,a.fn.modal.noConflict=function(){return a.fn.modal=d,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(c){var d=a(this),e=d.attr("href"),f=a(d.attr("data-target")||e&&e.replace(/.*(?=#[^\s]+$)/,"")),g=f.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(e)&&e},f.data(),d.data());d.is("a")&&c.preventDefault(),f.one("show.bs.modal",function(a){a.isDefaultPrevented()||f.one("hidden.bs.modal",function(){d.is(":visible")&&d.trigger("focus")})}),b.call(f,g,this)})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof b&&b;(e||!/destroy|hide/.test(b))&&(e||d.data("bs.tooltip",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.type=null,this.options=null,this.enabled=null,this.timeout=null,this.hoverState=null,this.$element=null,this.inState=null,this.init("tooltip",a,b)};c.VERSION="3.3.5",c.TRANSITION_DURATION=150,c.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},c.prototype.init=function(b,c,d){if(this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d),this.$viewport=this.options.viewport&&a(a.isFunction(this.options.viewport)?this.options.viewport.call(this,this.$element):this.options.viewport.selector||this.options.viewport),this.inState={click:!1,hover:!1,focus:!1},this.$element[0]instanceof document.constructor&&!this.options.selector)throw new Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},c.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},c.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),b instanceof a.Event&&(c.inState["focusin"==b.type?"focus":"hover"]=!0),c.tip().hasClass("in")||"in"==c.hoverState?void(c.hoverState="in"):(clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show())},c.prototype.isInStateTrue=function(){for(var a in this.inState)if(this.inState[a])return!0;return!1},c.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),b instanceof a.Event&&(c.inState["focusout"==b.type?"focus":"hover"]=!1),c.isInStateTrue()?void 0:(clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide())},c.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(b);var d=a.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(b.isDefaultPrevented()||!d)return;var e=this,f=this.tip(),g=this.getUID(this.type);this.setContent(),f.attr("id",g),this.$element.attr("aria-describedby",g),this.options.animation&&f.addClass("fade");var h="function"==typeof this.options.placement?this.options.placement.call(this,f[0],this.$element[0]):this.options.placement,i=/\s?auto?\s?/i,j=i.test(h);j&&(h=h.replace(i,"")||"top"),f.detach().css({top:0,left:0,display:"block"}).addClass(h).data("bs."+this.type,this),this.options.container?f.appendTo(this.options.container):f.insertAfter(this.$element),this.$element.trigger("inserted.bs."+this.type);var k=this.getPosition(),l=f[0].offsetWidth,m=f[0].offsetHeight;if(j){var n=h,o=this.getPosition(this.$viewport);h="bottom"==h&&k.bottom+m>o.bottom?"top":"top"==h&&k.top-m<o.top?"bottom":"right"==h&&k.right+l>o.width?"left":"left"==h&&k.left-l<o.left?"right":h,f.removeClass(n).addClass(h)}var p=this.getCalculatedOffset(h,k,l,m);this.applyPlacement(p,h);var q=function(){var a=e.hoverState;e.$element.trigger("shown.bs."+e.type),e.hoverState=null,"out"==a&&e.leave(e)};a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",q).emulateTransitionEnd(c.TRANSITION_DURATION):q()}},c.prototype.applyPlacement=function(b,c){var d=this.tip(),e=d[0].offsetWidth,f=d[0].offsetHeight,g=parseInt(d.css("margin-top"),10),h=parseInt(d.css("margin-left"),10);isNaN(g)&&(g=0),isNaN(h)&&(h=0),b.top+=g,b.left+=h,a.offset.setOffset(d[0],a.extend({using:function(a){d.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),d.addClass("in");var i=d[0].offsetWidth,j=d[0].offsetHeight;"top"==c&&j!=f&&(b.top=b.top+f-j);var k=this.getViewportAdjustedDelta(c,b,i,j);k.left?b.left+=k.left:b.top+=k.top;var l=/top|bottom/.test(c),m=l?2*k.left-e+i:2*k.top-f+j,n=l?"offsetWidth":"offsetHeight";d.offset(b),this.replaceArrow(m,d[0][n],l)},c.prototype.replaceArrow=function(a,b,c){this.arrow().css(c?"left":"top",50*(1-a/b)+"%").css(c?"top":"left","")},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},c.prototype.hide=function(b){function d(){"in"!=e.hoverState&&f.detach(),e.$element.removeAttr("aria-describedby").trigger("hidden.bs."+e.type),b&&b()}var e=this,f=a(this.$tip),g=a.Event("hide.bs."+this.type);return this.$element.trigger(g),g.isDefaultPrevented()?void 0:(f.removeClass("in"),a.support.transition&&f.hasClass("fade")?f.one("bsTransitionEnd",d).emulateTransitionEnd(c.TRANSITION_DURATION):d(),this.hoverState=null,this)},c.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},c.prototype.hasContent=function(){return this.getTitle()},c.prototype.getPosition=function(b){b=b||this.$element;var c=b[0],d="BODY"==c.tagName,e=c.getBoundingClientRect();null==e.width&&(e=a.extend({},e,{width:e.right-e.left,height:e.bottom-e.top}));var f=d?{top:0,left:0}:b.offset(),g={scroll:d?document.documentElement.scrollTop||document.body.scrollTop:b.scrollTop()},h=d?{width:a(window).width(),height:a(window).height()}:null;return a.extend({},e,g,h,f)},c.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},c.prototype.getViewportAdjustedDelta=function(a,b,c,d){var e={top:0,left:0};if(!this.$viewport)return e;var f=this.options.viewport&&this.options.viewport.padding||0,g=this.getPosition(this.$viewport);if(/right|left/.test(a)){var h=b.top-f-g.scroll,i=b.top+f-g.scroll+d;h<g.top?e.top=g.top-h:i>g.top+g.height&&(e.top=g.top+g.height-i)}else{var j=b.left-f,k=b.left+f+c;j<g.left?e.left=g.left-j:k>g.right&&(e.left=g.left+g.width-k)}return e},c.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},c.prototype.getUID=function(a){do a+=~~(1e6*Math.random());while(document.getElementById(a));return a},c.prototype.tip=function(){if(!this.$tip&&(this.$tip=a(this.options.template),1!=this.$tip.length))throw new Error(this.type+" `template` option must consist of exactly 1 top-level element!");return this.$tip},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},c.prototype.enable=function(){this.enabled=!0},c.prototype.disable=function(){this.enabled=!1},c.prototype.toggleEnabled=function(){this.enabled=!this.enabled},c.prototype.toggle=function(b){var c=this;b&&(c=a(b.currentTarget).data("bs."+this.type),c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c))),b?(c.inState.click=!c.inState.click,c.isInStateTrue()?c.enter(c):c.leave(c)):c.tip().hasClass("in")?c.leave(c):c.enter(c)},c.prototype.destroy=function(){var a=this;clearTimeout(this.timeout),this.hide(function(){a.$element.off("."+a.type).removeData("bs."+a.type),a.$tip&&a.$tip.detach(),a.$tip=null,a.$arrow=null,a.$viewport=null})};var d=a.fn.tooltip;a.fn.tooltip=b,a.fn.tooltip.Constructor=c,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=d,this}}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof b&&b;(e||!/destroy|hide/.test(b))&&(e||d.data("bs.popover",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");c.VERSION="3.3.5",c.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),c.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),c.prototype.constructor=c,c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},c.prototype.hasContent=function(){return this.getTitle()||this.getContent()},c.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")};var d=a.fn.popover;a.fn.popover=b,a.fn.popover.Constructor=c,a.fn.popover.noConflict=function(){return a.fn.popover=d,this}}(jQuery),+function(a){"use strict";function b(c,d){this.$body=a(document.body),this.$scrollElement=a(a(c).is(document.body)?window:c),this.options=a.extend({},b.DEFAULTS,d),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",a.proxy(this.process,this)),this.refresh(),this.process()}function c(c){return this.each(function(){var d=a(this),e=d.data("bs.scrollspy"),f="object"==typeof c&&c;e||d.data("bs.scrollspy",e=new b(this,f)),"string"==typeof c&&e[c]()})}b.VERSION="3.3.5",b.DEFAULTS={offset:10},b.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},b.prototype.refresh=function(){var b=this,c="offset",d=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),a.isWindow(this.$scrollElement[0])||(c="position",d=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var b=a(this),e=b.data("target")||b.attr("href"),f=/^#./.test(e)&&a(e);return f&&f.length&&f.is(":visible")&&[[f[c]().top+d,e]]||null}).sort(function(a,b){return a[0]-b[0]}).each(function(){b.offsets.push(this[0]),b.targets.push(this[1])})},b.prototype.process=function(){var a,b=this.$scrollElement.scrollTop()+this.options.offset,c=this.getScrollHeight(),d=this.options.offset+c-this.$scrollElement.height(),e=this.offsets,f=this.targets,g=this.activeTarget;if(this.scrollHeight!=c&&this.refresh(),b>=d)return g!=(a=f[f.length-1])&&this.activate(a);if(g&&b<e[0])return this.activeTarget=null,this.clear();for(a=e.length;a--;)g!=f[a]&&b>=e[a]&&(void 0===e[a+1]||b<e[a+1])&&this.activate(f[a])},b.prototype.activate=function(b){this.activeTarget=b,this.clear();var c=this.selector+'[data-target="'+b+'"],'+this.selector+'[href="'+b+'"]',d=a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length&&(d=d.closest("li.dropdown").addClass("active")),
d.trigger("activate.bs.scrollspy")},b.prototype.clear=function(){a(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var d=a.fn.scrollspy;a.fn.scrollspy=c,a.fn.scrollspy.Constructor=b,a.fn.scrollspy.noConflict=function(){return a.fn.scrollspy=d,this},a(window).on("load.bs.scrollspy.data-api",function(){a('[data-spy="scroll"]').each(function(){var b=a(this);c.call(b,b.data())})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new c(this)),"string"==typeof b&&e[b]()})}var c=function(b){this.element=a(b)};c.VERSION="3.3.5",c.TRANSITION_DURATION=150,c.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.bs.tab",{relatedTarget:b[0]}),g=a.Event("show.bs.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.bs.tab",relatedTarget:b[0]}),b.trigger({type:"shown.bs.tab",relatedTarget:e[0]})})}}},c.prototype.activate=function(b,d,e){function f(){g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),h?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu").length&&b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),e&&e()}var g=d.find("> .active"),h=e&&a.support.transition&&(g.length&&g.hasClass("fade")||!!d.find("> .fade").length);g.length&&h?g.one("bsTransitionEnd",f).emulateTransitionEnd(c.TRANSITION_DURATION):f(),g.removeClass("in")};var d=a.fn.tab;a.fn.tab=b,a.fn.tab.Constructor=c,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(c){c.preventDefault(),b.call(a(this),"show")};a(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',e).on("click.bs.tab.data-api",'[data-toggle="pill"]',e)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.affix"),f="object"==typeof b&&b;e||d.data("bs.affix",e=new c(this,f)),"string"==typeof b&&e[b]()})}var c=function(b,d){this.options=a.extend({},c.DEFAULTS,d),this.$target=a(this.options.target).on("scroll.bs.affix.data-api",a.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",a.proxy(this.checkPositionWithEventLoop,this)),this.$element=a(b),this.affixed=null,this.unpin=null,this.pinnedOffset=null,this.checkPosition()};c.VERSION="3.3.5",c.RESET="affix affix-top affix-bottom",c.DEFAULTS={offset:0,target:window},c.prototype.getState=function(a,b,c,d){var e=this.$target.scrollTop(),f=this.$element.offset(),g=this.$target.height();if(null!=c&&"top"==this.affixed)return c>e?"top":!1;if("bottom"==this.affixed)return null!=c?e+this.unpin<=f.top?!1:"bottom":a-d>=e+g?!1:"bottom";var h=null==this.affixed,i=h?e:f.top,j=h?g:b;return null!=c&&c>=e?"top":null!=d&&i+j>=a-d?"bottom":!1},c.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(c.RESET).addClass("affix");var a=this.$target.scrollTop(),b=this.$element.offset();return this.pinnedOffset=b.top-a},c.prototype.checkPositionWithEventLoop=function(){setTimeout(a.proxy(this.checkPosition,this),1)},c.prototype.checkPosition=function(){if(this.$element.is(":visible")){var b=this.$element.height(),d=this.options.offset,e=d.top,f=d.bottom,g=Math.max(a(document).height(),a(document.body).height());"object"!=typeof d&&(f=e=d),"function"==typeof e&&(e=d.top(this.$element)),"function"==typeof f&&(f=d.bottom(this.$element));var h=this.getState(g,b,e,f);if(this.affixed!=h){null!=this.unpin&&this.$element.css("top","");var i="affix"+(h?"-"+h:""),j=a.Event(i+".bs.affix");if(this.$element.trigger(j),j.isDefaultPrevented())return;this.affixed=h,this.unpin="bottom"==h?this.getPinnedOffset():null,this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix","affixed")+".bs.affix")}"bottom"==h&&this.$element.offset({top:g-b-f})}};var d=a.fn.affix;a.fn.affix=b,a.fn.affix.Constructor=c,a.fn.affix.noConflict=function(){return a.fn.affix=d,this},a(window).on("load",function(){a('[data-spy="affix"]').each(function(){var c=a(this),d=c.data();d.offset=d.offset||{},null!=d.offsetBottom&&(d.offset.bottom=d.offsetBottom),null!=d.offsetTop&&(d.offset.top=d.offsetTop),b.call(c,d)})})}(jQuery);
/*!
 DataTables 1.10.12
 ©2008-2015 SpryMedia Ltd - datatables.net/license
*/
(function(h){"function"===typeof define&&define.amd?define(["jquery"],function(D){return h(D,window,document)}):"object"===typeof exports?module.exports=function(D,I){D||(D=window);I||(I="undefined"!==typeof window?require("jquery"):require("jquery")(D));return h(I,D,D.document)}:h(jQuery,window,document)})(function(h,D,I,k){function X(a){var b,c,d={};h.each(a,function(e){if((b=e.match(/^([^A-Z]+?)([A-Z])/))&&-1!=="a aa ai ao as b fn i m o s ".indexOf(b[1]+" "))c=e.replace(b[0],b[2].toLowerCase()),
d[c]=e,"o"===b[1]&&X(a[e])});a._hungarianMap=d}function K(a,b,c){a._hungarianMap||X(a);var d;h.each(b,function(e){d=a._hungarianMap[e];if(d!==k&&(c||b[d]===k))"o"===d.charAt(0)?(b[d]||(b[d]={}),h.extend(!0,b[d],b[e]),K(a[d],b[d],c)):b[d]=b[e]})}function Da(a){var b=m.defaults.oLanguage,c=a.sZeroRecords;!a.sEmptyTable&&(c&&"No data available in table"===b.sEmptyTable)&&E(a,a,"sZeroRecords","sEmptyTable");!a.sLoadingRecords&&(c&&"Loading..."===b.sLoadingRecords)&&E(a,a,"sZeroRecords","sLoadingRecords");
a.sInfoThousands&&(a.sThousands=a.sInfoThousands);(a=a.sDecimal)&&db(a)}function eb(a){A(a,"ordering","bSort");A(a,"orderMulti","bSortMulti");A(a,"orderClasses","bSortClasses");A(a,"orderCellsTop","bSortCellsTop");A(a,"order","aaSorting");A(a,"orderFixed","aaSortingFixed");A(a,"paging","bPaginate");A(a,"pagingType","sPaginationType");A(a,"pageLength","iDisplayLength");A(a,"searching","bFilter");"boolean"===typeof a.sScrollX&&(a.sScrollX=a.sScrollX?"100%":"");"boolean"===typeof a.scrollX&&(a.scrollX=
a.scrollX?"100%":"");if(a=a.aoSearchCols)for(var b=0,c=a.length;b<c;b++)a[b]&&K(m.models.oSearch,a[b])}function fb(a){A(a,"orderable","bSortable");A(a,"orderData","aDataSort");A(a,"orderSequence","asSorting");A(a,"orderDataType","sortDataType");var b=a.aDataSort;b&&!h.isArray(b)&&(a.aDataSort=[b])}function gb(a){if(!m.__browser){var b={};m.__browser=b;var c=h("<div/>").css({position:"fixed",top:0,left:0,height:1,width:1,overflow:"hidden"}).append(h("<div/>").css({position:"absolute",top:1,left:1,
width:100,overflow:"scroll"}).append(h("<div/>").css({width:"100%",height:10}))).appendTo("body"),d=c.children(),e=d.children();b.barWidth=d[0].offsetWidth-d[0].clientWidth;b.bScrollOversize=100===e[0].offsetWidth&&100!==d[0].clientWidth;b.bScrollbarLeft=1!==Math.round(e.offset().left);b.bBounding=c[0].getBoundingClientRect().width?!0:!1;c.remove()}h.extend(a.oBrowser,m.__browser);a.oScroll.iBarWidth=m.__browser.barWidth}function hb(a,b,c,d,e,f){var g,j=!1;c!==k&&(g=c,j=!0);for(;d!==e;)a.hasOwnProperty(d)&&
(g=j?b(g,a[d],d,a):a[d],j=!0,d+=f);return g}function Ea(a,b){var c=m.defaults.column,d=a.aoColumns.length,c=h.extend({},m.models.oColumn,c,{nTh:b?b:I.createElement("th"),sTitle:c.sTitle?c.sTitle:b?b.innerHTML:"",aDataSort:c.aDataSort?c.aDataSort:[d],mData:c.mData?c.mData:d,idx:d});a.aoColumns.push(c);c=a.aoPreSearchCols;c[d]=h.extend({},m.models.oSearch,c[d]);ja(a,d,h(b).data())}function ja(a,b,c){var b=a.aoColumns[b],d=a.oClasses,e=h(b.nTh);if(!b.sWidthOrig){b.sWidthOrig=e.attr("width")||null;var f=
(e.attr("style")||"").match(/width:\s*(\d+[pxem%]+)/);f&&(b.sWidthOrig=f[1])}c!==k&&null!==c&&(fb(c),K(m.defaults.column,c),c.mDataProp!==k&&!c.mData&&(c.mData=c.mDataProp),c.sType&&(b._sManualType=c.sType),c.className&&!c.sClass&&(c.sClass=c.className),h.extend(b,c),E(b,c,"sWidth","sWidthOrig"),c.iDataSort!==k&&(b.aDataSort=[c.iDataSort]),E(b,c,"aDataSort"));var g=b.mData,j=Q(g),i=b.mRender?Q(b.mRender):null,c=function(a){return"string"===typeof a&&-1!==a.indexOf("@")};b._bAttrSrc=h.isPlainObject(g)&&
(c(g.sort)||c(g.type)||c(g.filter));b._setter=null;b.fnGetData=function(a,b,c){var d=j(a,b,k,c);return i&&b?i(d,b,a,c):d};b.fnSetData=function(a,b,c){return R(g)(a,b,c)};"number"!==typeof g&&(a._rowReadObject=!0);a.oFeatures.bSort||(b.bSortable=!1,e.addClass(d.sSortableNone));a=-1!==h.inArray("asc",b.asSorting);c=-1!==h.inArray("desc",b.asSorting);!b.bSortable||!a&&!c?(b.sSortingClass=d.sSortableNone,b.sSortingClassJUI=""):a&&!c?(b.sSortingClass=d.sSortableAsc,b.sSortingClassJUI=d.sSortJUIAscAllowed):
!a&&c?(b.sSortingClass=d.sSortableDesc,b.sSortingClassJUI=d.sSortJUIDescAllowed):(b.sSortingClass=d.sSortable,b.sSortingClassJUI=d.sSortJUI)}function Y(a){if(!1!==a.oFeatures.bAutoWidth){var b=a.aoColumns;Fa(a);for(var c=0,d=b.length;c<d;c++)b[c].nTh.style.width=b[c].sWidth}b=a.oScroll;(""!==b.sY||""!==b.sX)&&ka(a);u(a,null,"column-sizing",[a])}function Z(a,b){var c=la(a,"bVisible");return"number"===typeof c[b]?c[b]:null}function $(a,b){var c=la(a,"bVisible"),c=h.inArray(b,c);return-1!==c?c:null}
function aa(a){var b=0;h.each(a.aoColumns,function(a,d){d.bVisible&&"none"!==h(d.nTh).css("display")&&b++});return b}function la(a,b){var c=[];h.map(a.aoColumns,function(a,e){a[b]&&c.push(e)});return c}function Ga(a){var b=a.aoColumns,c=a.aoData,d=m.ext.type.detect,e,f,g,j,i,h,l,q,t;e=0;for(f=b.length;e<f;e++)if(l=b[e],t=[],!l.sType&&l._sManualType)l.sType=l._sManualType;else if(!l.sType){g=0;for(j=d.length;g<j;g++){i=0;for(h=c.length;i<h;i++){t[i]===k&&(t[i]=B(a,i,e,"type"));q=d[g](t[i],a);if(!q&&
g!==d.length-1)break;if("html"===q)break}if(q){l.sType=q;break}}l.sType||(l.sType="string")}}function ib(a,b,c,d){var e,f,g,j,i,n,l=a.aoColumns;if(b)for(e=b.length-1;0<=e;e--){n=b[e];var q=n.targets!==k?n.targets:n.aTargets;h.isArray(q)||(q=[q]);f=0;for(g=q.length;f<g;f++)if("number"===typeof q[f]&&0<=q[f]){for(;l.length<=q[f];)Ea(a);d(q[f],n)}else if("number"===typeof q[f]&&0>q[f])d(l.length+q[f],n);else if("string"===typeof q[f]){j=0;for(i=l.length;j<i;j++)("_all"==q[f]||h(l[j].nTh).hasClass(q[f]))&&
d(j,n)}}if(c){e=0;for(a=c.length;e<a;e++)d(e,c[e])}}function N(a,b,c,d){var e=a.aoData.length,f=h.extend(!0,{},m.models.oRow,{src:c?"dom":"data",idx:e});f._aData=b;a.aoData.push(f);for(var g=a.aoColumns,j=0,i=g.length;j<i;j++)g[j].sType=null;a.aiDisplayMaster.push(e);b=a.rowIdFn(b);b!==k&&(a.aIds[b]=f);(c||!a.oFeatures.bDeferRender)&&Ha(a,e,c,d);return e}function ma(a,b){var c;b instanceof h||(b=h(b));return b.map(function(b,e){c=Ia(a,e);return N(a,c.data,e,c.cells)})}function B(a,b,c,d){var e=a.iDraw,
f=a.aoColumns[c],g=a.aoData[b]._aData,j=f.sDefaultContent,i=f.fnGetData(g,d,{settings:a,row:b,col:c});if(i===k)return a.iDrawError!=e&&null===j&&(L(a,0,"Requested unknown parameter "+("function"==typeof f.mData?"{function}":"'"+f.mData+"'")+" for row "+b+", column "+c,4),a.iDrawError=e),j;if((i===g||null===i)&&null!==j&&d!==k)i=j;else if("function"===typeof i)return i.call(g);return null===i&&"display"==d?"":i}function jb(a,b,c,d){a.aoColumns[c].fnSetData(a.aoData[b]._aData,d,{settings:a,row:b,col:c})}
function Ja(a){return h.map(a.match(/(\\.|[^\.])+/g)||[""],function(a){return a.replace(/\\./g,".")})}function Q(a){if(h.isPlainObject(a)){var b={};h.each(a,function(a,c){c&&(b[a]=Q(c))});return function(a,c,f,g){var j=b[c]||b._;return j!==k?j(a,c,f,g):a}}if(null===a)return function(a){return a};if("function"===typeof a)return function(b,c,f,g){return a(b,c,f,g)};if("string"===typeof a&&(-1!==a.indexOf(".")||-1!==a.indexOf("[")||-1!==a.indexOf("("))){var c=function(a,b,f){var g,j;if(""!==f){j=Ja(f);
for(var i=0,n=j.length;i<n;i++){f=j[i].match(ba);g=j[i].match(U);if(f){j[i]=j[i].replace(ba,"");""!==j[i]&&(a=a[j[i]]);g=[];j.splice(0,i+1);j=j.join(".");if(h.isArray(a)){i=0;for(n=a.length;i<n;i++)g.push(c(a[i],b,j))}a=f[0].substring(1,f[0].length-1);a=""===a?g:g.join(a);break}else if(g){j[i]=j[i].replace(U,"");a=a[j[i]]();continue}if(null===a||a[j[i]]===k)return k;a=a[j[i]]}}return a};return function(b,e){return c(b,e,a)}}return function(b){return b[a]}}function R(a){if(h.isPlainObject(a))return R(a._);
if(null===a)return function(){};if("function"===typeof a)return function(b,d,e){a(b,"set",d,e)};if("string"===typeof a&&(-1!==a.indexOf(".")||-1!==a.indexOf("[")||-1!==a.indexOf("("))){var b=function(a,d,e){var e=Ja(e),f;f=e[e.length-1];for(var g,j,i=0,n=e.length-1;i<n;i++){g=e[i].match(ba);j=e[i].match(U);if(g){e[i]=e[i].replace(ba,"");a[e[i]]=[];f=e.slice();f.splice(0,i+1);g=f.join(".");if(h.isArray(d)){j=0;for(n=d.length;j<n;j++)f={},b(f,d[j],g),a[e[i]].push(f)}else a[e[i]]=d;return}j&&(e[i]=e[i].replace(U,
""),a=a[e[i]](d));if(null===a[e[i]]||a[e[i]]===k)a[e[i]]={};a=a[e[i]]}if(f.match(U))a[f.replace(U,"")](d);else a[f.replace(ba,"")]=d};return function(c,d){return b(c,d,a)}}return function(b,d){b[a]=d}}function Ka(a){return G(a.aoData,"_aData")}function na(a){a.aoData.length=0;a.aiDisplayMaster.length=0;a.aiDisplay.length=0;a.aIds={}}function oa(a,b,c){for(var d=-1,e=0,f=a.length;e<f;e++)a[e]==b?d=e:a[e]>b&&a[e]--; -1!=d&&c===k&&a.splice(d,1)}function ca(a,b,c,d){var e=a.aoData[b],f,g=function(c,d){for(;c.childNodes.length;)c.removeChild(c.firstChild);
c.innerHTML=B(a,b,d,"display")};if("dom"===c||(!c||"auto"===c)&&"dom"===e.src)e._aData=Ia(a,e,d,d===k?k:e._aData).data;else{var j=e.anCells;if(j)if(d!==k)g(j[d],d);else{c=0;for(f=j.length;c<f;c++)g(j[c],c)}}e._aSortData=null;e._aFilterData=null;g=a.aoColumns;if(d!==k)g[d].sType=null;else{c=0;for(f=g.length;c<f;c++)g[c].sType=null;La(a,e)}}function Ia(a,b,c,d){var e=[],f=b.firstChild,g,j,i=0,n,l=a.aoColumns,q=a._rowReadObject,d=d!==k?d:q?{}:[],t=function(a,b){if("string"===typeof a){var c=a.indexOf("@");
-1!==c&&(c=a.substring(c+1),R(a)(d,b.getAttribute(c)))}},S=function(a){if(c===k||c===i)j=l[i],n=h.trim(a.innerHTML),j&&j._bAttrSrc?(R(j.mData._)(d,n),t(j.mData.sort,a),t(j.mData.type,a),t(j.mData.filter,a)):q?(j._setter||(j._setter=R(j.mData)),j._setter(d,n)):d[i]=n;i++};if(f)for(;f;){g=f.nodeName.toUpperCase();if("TD"==g||"TH"==g)S(f),e.push(f);f=f.nextSibling}else{e=b.anCells;f=0;for(g=e.length;f<g;f++)S(e[f])}if(b=b.firstChild?b:b.nTr)(b=b.getAttribute("id"))&&R(a.rowId)(d,b);return{data:d,cells:e}}
function Ha(a,b,c,d){var e=a.aoData[b],f=e._aData,g=[],j,i,n,l,q;if(null===e.nTr){j=c||I.createElement("tr");e.nTr=j;e.anCells=g;j._DT_RowIndex=b;La(a,e);l=0;for(q=a.aoColumns.length;l<q;l++){n=a.aoColumns[l];i=c?d[l]:I.createElement(n.sCellType);i._DT_CellIndex={row:b,column:l};g.push(i);if((!c||n.mRender||n.mData!==l)&&(!h.isPlainObject(n.mData)||n.mData._!==l+".display"))i.innerHTML=B(a,b,l,"display");n.sClass&&(i.className+=" "+n.sClass);n.bVisible&&!c?j.appendChild(i):!n.bVisible&&c&&i.parentNode.removeChild(i);
n.fnCreatedCell&&n.fnCreatedCell.call(a.oInstance,i,B(a,b,l),f,b,l)}u(a,"aoRowCreatedCallback",null,[j,f,b])}e.nTr.setAttribute("role","row")}function La(a,b){var c=b.nTr,d=b._aData;if(c){var e=a.rowIdFn(d);e&&(c.id=e);d.DT_RowClass&&(e=d.DT_RowClass.split(" "),b.__rowc=b.__rowc?pa(b.__rowc.concat(e)):e,h(c).removeClass(b.__rowc.join(" ")).addClass(d.DT_RowClass));d.DT_RowAttr&&h(c).attr(d.DT_RowAttr);d.DT_RowData&&h(c).data(d.DT_RowData)}}function kb(a){var b,c,d,e,f,g=a.nTHead,j=a.nTFoot,i=0===
h("th, td",g).length,n=a.oClasses,l=a.aoColumns;i&&(e=h("<tr/>").appendTo(g));b=0;for(c=l.length;b<c;b++)f=l[b],d=h(f.nTh).addClass(f.sClass),i&&d.appendTo(e),a.oFeatures.bSort&&(d.addClass(f.sSortingClass),!1!==f.bSortable&&(d.attr("tabindex",a.iTabIndex).attr("aria-controls",a.sTableId),Ma(a,f.nTh,b))),f.sTitle!=d[0].innerHTML&&d.html(f.sTitle),Na(a,"header")(a,d,f,n);i&&da(a.aoHeader,g);h(g).find(">tr").attr("role","row");h(g).find(">tr>th, >tr>td").addClass(n.sHeaderTH);h(j).find(">tr>th, >tr>td").addClass(n.sFooterTH);
if(null!==j){a=a.aoFooter[0];b=0;for(c=a.length;b<c;b++)f=l[b],f.nTf=a[b].cell,f.sClass&&h(f.nTf).addClass(f.sClass)}}function ea(a,b,c){var d,e,f,g=[],j=[],i=a.aoColumns.length,n;if(b){c===k&&(c=!1);d=0;for(e=b.length;d<e;d++){g[d]=b[d].slice();g[d].nTr=b[d].nTr;for(f=i-1;0<=f;f--)!a.aoColumns[f].bVisible&&!c&&g[d].splice(f,1);j.push([])}d=0;for(e=g.length;d<e;d++){if(a=g[d].nTr)for(;f=a.firstChild;)a.removeChild(f);f=0;for(b=g[d].length;f<b;f++)if(n=i=1,j[d][f]===k){a.appendChild(g[d][f].cell);
for(j[d][f]=1;g[d+i]!==k&&g[d][f].cell==g[d+i][f].cell;)j[d+i][f]=1,i++;for(;g[d][f+n]!==k&&g[d][f].cell==g[d][f+n].cell;){for(c=0;c<i;c++)j[d+c][f+n]=1;n++}h(g[d][f].cell).attr("rowspan",i).attr("colspan",n)}}}}function O(a){var b=u(a,"aoPreDrawCallback","preDraw",[a]);if(-1!==h.inArray(!1,b))C(a,!1);else{var b=[],c=0,d=a.asStripeClasses,e=d.length,f=a.oLanguage,g=a.iInitDisplayStart,j="ssp"==y(a),i=a.aiDisplay;a.bDrawing=!0;g!==k&&-1!==g&&(a._iDisplayStart=j?g:g>=a.fnRecordsDisplay()?0:g,a.iInitDisplayStart=
-1);var g=a._iDisplayStart,n=a.fnDisplayEnd();if(a.bDeferLoading)a.bDeferLoading=!1,a.iDraw++,C(a,!1);else if(j){if(!a.bDestroying&&!lb(a))return}else a.iDraw++;if(0!==i.length){f=j?a.aoData.length:n;for(j=j?0:g;j<f;j++){var l=i[j],q=a.aoData[l];null===q.nTr&&Ha(a,l);l=q.nTr;if(0!==e){var t=d[c%e];q._sRowStripe!=t&&(h(l).removeClass(q._sRowStripe).addClass(t),q._sRowStripe=t)}u(a,"aoRowCallback",null,[l,q._aData,c,j]);b.push(l);c++}}else c=f.sZeroRecords,1==a.iDraw&&"ajax"==y(a)?c=f.sLoadingRecords:
f.sEmptyTable&&0===a.fnRecordsTotal()&&(c=f.sEmptyTable),b[0]=h("<tr/>",{"class":e?d[0]:""}).append(h("<td />",{valign:"top",colSpan:aa(a),"class":a.oClasses.sRowEmpty}).html(c))[0];u(a,"aoHeaderCallback","header",[h(a.nTHead).children("tr")[0],Ka(a),g,n,i]);u(a,"aoFooterCallback","footer",[h(a.nTFoot).children("tr")[0],Ka(a),g,n,i]);d=h(a.nTBody);d.children().detach();d.append(h(b));u(a,"aoDrawCallback","draw",[a]);a.bSorted=!1;a.bFiltered=!1;a.bDrawing=!1}}function T(a,b){var c=a.oFeatures,d=c.bFilter;
c.bSort&&mb(a);d?fa(a,a.oPreviousSearch):a.aiDisplay=a.aiDisplayMaster.slice();!0!==b&&(a._iDisplayStart=0);a._drawHold=b;O(a);a._drawHold=!1}function nb(a){var b=a.oClasses,c=h(a.nTable),c=h("<div/>").insertBefore(c),d=a.oFeatures,e=h("<div/>",{id:a.sTableId+"_wrapper","class":b.sWrapper+(a.nTFoot?"":" "+b.sNoFooter)});a.nHolding=c[0];a.nTableWrapper=e[0];a.nTableReinsertBefore=a.nTable.nextSibling;for(var f=a.sDom.split(""),g,j,i,n,l,q,t=0;t<f.length;t++){g=null;j=f[t];if("<"==j){i=h("<div/>")[0];
n=f[t+1];if("'"==n||'"'==n){l="";for(q=2;f[t+q]!=n;)l+=f[t+q],q++;"H"==l?l=b.sJUIHeader:"F"==l&&(l=b.sJUIFooter);-1!=l.indexOf(".")?(n=l.split("."),i.id=n[0].substr(1,n[0].length-1),i.className=n[1]):"#"==l.charAt(0)?i.id=l.substr(1,l.length-1):i.className=l;t+=q}e.append(i);e=h(i)}else if(">"==j)e=e.parent();else if("l"==j&&d.bPaginate&&d.bLengthChange)g=ob(a);else if("f"==j&&d.bFilter)g=pb(a);else if("r"==j&&d.bProcessing)g=qb(a);else if("t"==j)g=rb(a);else if("i"==j&&d.bInfo)g=sb(a);else if("p"==
j&&d.bPaginate)g=tb(a);else if(0!==m.ext.feature.length){i=m.ext.feature;q=0;for(n=i.length;q<n;q++)if(j==i[q].cFeature){g=i[q].fnInit(a);break}}g&&(i=a.aanFeatures,i[j]||(i[j]=[]),i[j].push(g),e.append(g))}c.replaceWith(e);a.nHolding=null}function da(a,b){var c=h(b).children("tr"),d,e,f,g,j,i,n,l,q,t;a.splice(0,a.length);f=0;for(i=c.length;f<i;f++)a.push([]);f=0;for(i=c.length;f<i;f++){d=c[f];for(e=d.firstChild;e;){if("TD"==e.nodeName.toUpperCase()||"TH"==e.nodeName.toUpperCase()){l=1*e.getAttribute("colspan");
q=1*e.getAttribute("rowspan");l=!l||0===l||1===l?1:l;q=!q||0===q||1===q?1:q;g=0;for(j=a[f];j[g];)g++;n=g;t=1===l?!0:!1;for(j=0;j<l;j++)for(g=0;g<q;g++)a[f+g][n+j]={cell:e,unique:t},a[f+g].nTr=d}e=e.nextSibling}}}function qa(a,b,c){var d=[];c||(c=a.aoHeader,b&&(c=[],da(c,b)));for(var b=0,e=c.length;b<e;b++)for(var f=0,g=c[b].length;f<g;f++)if(c[b][f].unique&&(!d[f]||!a.bSortCellsTop))d[f]=c[b][f].cell;return d}function ra(a,b,c){u(a,"aoServerParams","serverParams",[b]);if(b&&h.isArray(b)){var d={},
e=/(.*?)\[\]$/;h.each(b,function(a,b){var c=b.name.match(e);c?(c=c[0],d[c]||(d[c]=[]),d[c].push(b.value)):d[b.name]=b.value});b=d}var f,g=a.ajax,j=a.oInstance,i=function(b){u(a,null,"xhr",[a,b,a.jqXHR]);c(b)};if(h.isPlainObject(g)&&g.data){f=g.data;var n=h.isFunction(f)?f(b,a):f,b=h.isFunction(f)&&n?n:h.extend(!0,b,n);delete g.data}n={data:b,success:function(b){var c=b.error||b.sError;c&&L(a,0,c);a.json=b;i(b)},dataType:"json",cache:!1,type:a.sServerMethod,error:function(b,c){var d=u(a,null,"xhr",
[a,null,a.jqXHR]);-1===h.inArray(!0,d)&&("parsererror"==c?L(a,0,"Invalid JSON response",1):4===b.readyState&&L(a,0,"Ajax error",7));C(a,!1)}};a.oAjaxData=b;u(a,null,"preXhr",[a,b]);a.fnServerData?a.fnServerData.call(j,a.sAjaxSource,h.map(b,function(a,b){return{name:b,value:a}}),i,a):a.sAjaxSource||"string"===typeof g?a.jqXHR=h.ajax(h.extend(n,{url:g||a.sAjaxSource})):h.isFunction(g)?a.jqXHR=g.call(j,b,i,a):(a.jqXHR=h.ajax(h.extend(n,g)),g.data=f)}function lb(a){return a.bAjaxDataGet?(a.iDraw++,C(a,
!0),ra(a,ub(a),function(b){vb(a,b)}),!1):!0}function ub(a){var b=a.aoColumns,c=b.length,d=a.oFeatures,e=a.oPreviousSearch,f=a.aoPreSearchCols,g,j=[],i,n,l,q=V(a);g=a._iDisplayStart;i=!1!==d.bPaginate?a._iDisplayLength:-1;var k=function(a,b){j.push({name:a,value:b})};k("sEcho",a.iDraw);k("iColumns",c);k("sColumns",G(b,"sName").join(","));k("iDisplayStart",g);k("iDisplayLength",i);var S={draw:a.iDraw,columns:[],order:[],start:g,length:i,search:{value:e.sSearch,regex:e.bRegex}};for(g=0;g<c;g++)n=b[g],
l=f[g],i="function"==typeof n.mData?"function":n.mData,S.columns.push({data:i,name:n.sName,searchable:n.bSearchable,orderable:n.bSortable,search:{value:l.sSearch,regex:l.bRegex}}),k("mDataProp_"+g,i),d.bFilter&&(k("sSearch_"+g,l.sSearch),k("bRegex_"+g,l.bRegex),k("bSearchable_"+g,n.bSearchable)),d.bSort&&k("bSortable_"+g,n.bSortable);d.bFilter&&(k("sSearch",e.sSearch),k("bRegex",e.bRegex));d.bSort&&(h.each(q,function(a,b){S.order.push({column:b.col,dir:b.dir});k("iSortCol_"+a,b.col);k("sSortDir_"+
a,b.dir)}),k("iSortingCols",q.length));b=m.ext.legacy.ajax;return null===b?a.sAjaxSource?j:S:b?j:S}function vb(a,b){var c=sa(a,b),d=b.sEcho!==k?b.sEcho:b.draw,e=b.iTotalRecords!==k?b.iTotalRecords:b.recordsTotal,f=b.iTotalDisplayRecords!==k?b.iTotalDisplayRecords:b.recordsFiltered;if(d){if(1*d<a.iDraw)return;a.iDraw=1*d}na(a);a._iRecordsTotal=parseInt(e,10);a._iRecordsDisplay=parseInt(f,10);d=0;for(e=c.length;d<e;d++)N(a,c[d]);a.aiDisplay=a.aiDisplayMaster.slice();a.bAjaxDataGet=!1;O(a);a._bInitComplete||
ta(a,b);a.bAjaxDataGet=!0;C(a,!1)}function sa(a,b){var c=h.isPlainObject(a.ajax)&&a.ajax.dataSrc!==k?a.ajax.dataSrc:a.sAjaxDataProp;return"data"===c?b.aaData||b[c]:""!==c?Q(c)(b):b}function pb(a){var b=a.oClasses,c=a.sTableId,d=a.oLanguage,e=a.oPreviousSearch,f=a.aanFeatures,g='<input type="search" class="'+b.sFilterInput+'"/>',j=d.sSearch,j=j.match(/_INPUT_/)?j.replace("_INPUT_",g):j+g,b=h("<div/>",{id:!f.f?c+"_filter":null,"class":b.sFilter}).append(h("<label/>").append(j)),f=function(){var b=!this.value?
"":this.value;b!=e.sSearch&&(fa(a,{sSearch:b,bRegex:e.bRegex,bSmart:e.bSmart,bCaseInsensitive:e.bCaseInsensitive}),a._iDisplayStart=0,O(a))},g=null!==a.searchDelay?a.searchDelay:"ssp"===y(a)?400:0,i=h("input",b).val(e.sSearch).attr("placeholder",d.sSearchPlaceholder).bind("keyup.DT search.DT input.DT paste.DT cut.DT",g?Oa(f,g):f).bind("keypress.DT",function(a){if(13==a.keyCode)return!1}).attr("aria-controls",c);h(a.nTable).on("search.dt.DT",function(b,c){if(a===c)try{i[0]!==I.activeElement&&i.val(e.sSearch)}catch(d){}});
return b[0]}function fa(a,b,c){var d=a.oPreviousSearch,e=a.aoPreSearchCols,f=function(a){d.sSearch=a.sSearch;d.bRegex=a.bRegex;d.bSmart=a.bSmart;d.bCaseInsensitive=a.bCaseInsensitive};Ga(a);if("ssp"!=y(a)){wb(a,b.sSearch,c,b.bEscapeRegex!==k?!b.bEscapeRegex:b.bRegex,b.bSmart,b.bCaseInsensitive);f(b);for(b=0;b<e.length;b++)xb(a,e[b].sSearch,b,e[b].bEscapeRegex!==k?!e[b].bEscapeRegex:e[b].bRegex,e[b].bSmart,e[b].bCaseInsensitive);yb(a)}else f(b);a.bFiltered=!0;u(a,null,"search",[a])}function yb(a){for(var b=
m.ext.search,c=a.aiDisplay,d,e,f=0,g=b.length;f<g;f++){for(var j=[],i=0,n=c.length;i<n;i++)e=c[i],d=a.aoData[e],b[f](a,d._aFilterData,e,d._aData,i)&&j.push(e);c.length=0;h.merge(c,j)}}function xb(a,b,c,d,e,f){if(""!==b)for(var g=a.aiDisplay,d=Pa(b,d,e,f),e=g.length-1;0<=e;e--)b=a.aoData[g[e]]._aFilterData[c],d.test(b)||g.splice(e,1)}function wb(a,b,c,d,e,f){var d=Pa(b,d,e,f),e=a.oPreviousSearch.sSearch,f=a.aiDisplayMaster,g;0!==m.ext.search.length&&(c=!0);g=zb(a);if(0>=b.length)a.aiDisplay=f.slice();
else{if(g||c||e.length>b.length||0!==b.indexOf(e)||a.bSorted)a.aiDisplay=f.slice();b=a.aiDisplay;for(c=b.length-1;0<=c;c--)d.test(a.aoData[b[c]]._sFilterRow)||b.splice(c,1)}}function Pa(a,b,c,d){a=b?a:Qa(a);c&&(a="^(?=.*?"+h.map(a.match(/"[^"]+"|[^ ]+/g)||[""],function(a){if('"'===a.charAt(0))var b=a.match(/^"(.*)"$/),a=b?b[1]:a;return a.replace('"',"")}).join(")(?=.*?")+").*$");return RegExp(a,d?"i":"")}function zb(a){var b=a.aoColumns,c,d,e,f,g,j,i,h,l=m.ext.type.search;c=!1;d=0;for(f=a.aoData.length;d<
f;d++)if(h=a.aoData[d],!h._aFilterData){j=[];e=0;for(g=b.length;e<g;e++)c=b[e],c.bSearchable?(i=B(a,d,e,"filter"),l[c.sType]&&(i=l[c.sType](i)),null===i&&(i=""),"string"!==typeof i&&i.toString&&(i=i.toString())):i="",i.indexOf&&-1!==i.indexOf("&")&&(ua.innerHTML=i,i=Zb?ua.textContent:ua.innerText),i.replace&&(i=i.replace(/[\r\n]/g,"")),j.push(i);h._aFilterData=j;h._sFilterRow=j.join("  ");c=!0}return c}function Ab(a){return{search:a.sSearch,smart:a.bSmart,regex:a.bRegex,caseInsensitive:a.bCaseInsensitive}}
function Bb(a){return{sSearch:a.search,bSmart:a.smart,bRegex:a.regex,bCaseInsensitive:a.caseInsensitive}}function sb(a){var b=a.sTableId,c=a.aanFeatures.i,d=h("<div/>",{"class":a.oClasses.sInfo,id:!c?b+"_info":null});c||(a.aoDrawCallback.push({fn:Cb,sName:"information"}),d.attr("role","status").attr("aria-live","polite"),h(a.nTable).attr("aria-describedby",b+"_info"));return d[0]}function Cb(a){var b=a.aanFeatures.i;if(0!==b.length){var c=a.oLanguage,d=a._iDisplayStart+1,e=a.fnDisplayEnd(),f=a.fnRecordsTotal(),
g=a.fnRecordsDisplay(),j=g?c.sInfo:c.sInfoEmpty;g!==f&&(j+=" "+c.sInfoFiltered);j+=c.sInfoPostFix;j=Db(a,j);c=c.fnInfoCallback;null!==c&&(j=c.call(a.oInstance,a,d,e,f,g,j));h(b).html(j)}}function Db(a,b){var c=a.fnFormatNumber,d=a._iDisplayStart+1,e=a._iDisplayLength,f=a.fnRecordsDisplay(),g=-1===e;return b.replace(/_START_/g,c.call(a,d)).replace(/_END_/g,c.call(a,a.fnDisplayEnd())).replace(/_MAX_/g,c.call(a,a.fnRecordsTotal())).replace(/_TOTAL_/g,c.call(a,f)).replace(/_PAGE_/g,c.call(a,g?1:Math.ceil(d/
e))).replace(/_PAGES_/g,c.call(a,g?1:Math.ceil(f/e)))}function ga(a){var b,c,d=a.iInitDisplayStart,e=a.aoColumns,f;c=a.oFeatures;var g=a.bDeferLoading;if(a.bInitialised){nb(a);kb(a);ea(a,a.aoHeader);ea(a,a.aoFooter);C(a,!0);c.bAutoWidth&&Fa(a);b=0;for(c=e.length;b<c;b++)f=e[b],f.sWidth&&(f.nTh.style.width=x(f.sWidth));u(a,null,"preInit",[a]);T(a);e=y(a);if("ssp"!=e||g)"ajax"==e?ra(a,[],function(c){var f=sa(a,c);for(b=0;b<f.length;b++)N(a,f[b]);a.iInitDisplayStart=d;T(a);C(a,!1);ta(a,c)},a):(C(a,!1),
ta(a))}else setTimeout(function(){ga(a)},200)}function ta(a,b){a._bInitComplete=!0;(b||a.oInit.aaData)&&Y(a);u(a,null,"plugin-init",[a,b]);u(a,"aoInitComplete","init",[a,b])}function Ra(a,b){var c=parseInt(b,10);a._iDisplayLength=c;Sa(a);u(a,null,"length",[a,c])}function ob(a){for(var b=a.oClasses,c=a.sTableId,d=a.aLengthMenu,e=h.isArray(d[0]),f=e?d[0]:d,d=e?d[1]:d,e=h("<select/>",{name:c+"_length","aria-controls":c,"class":b.sLengthSelect}),g=0,j=f.length;g<j;g++)e[0][g]=new Option(d[g],f[g]);var i=
h("<div><label/></div>").addClass(b.sLength);a.aanFeatures.l||(i[0].id=c+"_length");i.children().append(a.oLanguage.sLengthMenu.replace("_MENU_",e[0].outerHTML));h("select",i).val(a._iDisplayLength).bind("change.DT",function(){Ra(a,h(this).val());O(a)});h(a.nTable).bind("length.dt.DT",function(b,c,d){a===c&&h("select",i).val(d)});return i[0]}function tb(a){var b=a.sPaginationType,c=m.ext.pager[b],d="function"===typeof c,e=function(a){O(a)},b=h("<div/>").addClass(a.oClasses.sPaging+b)[0],f=a.aanFeatures;
d||c.fnInit(a,b,e);f.p||(b.id=a.sTableId+"_paginate",a.aoDrawCallback.push({fn:function(a){if(d){var b=a._iDisplayStart,i=a._iDisplayLength,h=a.fnRecordsDisplay(),l=-1===i,b=l?0:Math.ceil(b/i),i=l?1:Math.ceil(h/i),h=c(b,i),k,l=0;for(k=f.p.length;l<k;l++)Na(a,"pageButton")(a,f.p[l],l,h,b,i)}else c.fnUpdate(a,e)},sName:"pagination"}));return b}function Ta(a,b,c){var d=a._iDisplayStart,e=a._iDisplayLength,f=a.fnRecordsDisplay();0===f||-1===e?d=0:"number"===typeof b?(d=b*e,d>f&&(d=0)):"first"==b?d=0:
"previous"==b?(d=0<=e?d-e:0,0>d&&(d=0)):"next"==b?d+e<f&&(d+=e):"last"==b?d=Math.floor((f-1)/e)*e:L(a,0,"Unknown paging action: "+b,5);b=a._iDisplayStart!==d;a._iDisplayStart=d;b&&(u(a,null,"page",[a]),c&&O(a));return b}function qb(a){return h("<div/>",{id:!a.aanFeatures.r?a.sTableId+"_processing":null,"class":a.oClasses.sProcessing}).html(a.oLanguage.sProcessing).insertBefore(a.nTable)[0]}function C(a,b){a.oFeatures.bProcessing&&h(a.aanFeatures.r).css("display",b?"block":"none");u(a,null,"processing",
[a,b])}function rb(a){var b=h(a.nTable);b.attr("role","grid");var c=a.oScroll;if(""===c.sX&&""===c.sY)return a.nTable;var d=c.sX,e=c.sY,f=a.oClasses,g=b.children("caption"),j=g.length?g[0]._captionSide:null,i=h(b[0].cloneNode(!1)),n=h(b[0].cloneNode(!1)),l=b.children("tfoot");l.length||(l=null);i=h("<div/>",{"class":f.sScrollWrapper}).append(h("<div/>",{"class":f.sScrollHead}).css({overflow:"hidden",position:"relative",border:0,width:d?!d?null:x(d):"100%"}).append(h("<div/>",{"class":f.sScrollHeadInner}).css({"box-sizing":"content-box",
width:c.sXInner||"100%"}).append(i.removeAttr("id").css("margin-left",0).append("top"===j?g:null).append(b.children("thead"))))).append(h("<div/>",{"class":f.sScrollBody}).css({position:"relative",overflow:"auto",width:!d?null:x(d)}).append(b));l&&i.append(h("<div/>",{"class":f.sScrollFoot}).css({overflow:"hidden",border:0,width:d?!d?null:x(d):"100%"}).append(h("<div/>",{"class":f.sScrollFootInner}).append(n.removeAttr("id").css("margin-left",0).append("bottom"===j?g:null).append(b.children("tfoot")))));
var b=i.children(),k=b[0],f=b[1],t=l?b[2]:null;if(d)h(f).on("scroll.DT",function(){var a=this.scrollLeft;k.scrollLeft=a;l&&(t.scrollLeft=a)});h(f).css(e&&c.bCollapse?"max-height":"height",e);a.nScrollHead=k;a.nScrollBody=f;a.nScrollFoot=t;a.aoDrawCallback.push({fn:ka,sName:"scrolling"});return i[0]}function ka(a){var b=a.oScroll,c=b.sX,d=b.sXInner,e=b.sY,b=b.iBarWidth,f=h(a.nScrollHead),g=f[0].style,j=f.children("div"),i=j[0].style,n=j.children("table"),j=a.nScrollBody,l=h(j),q=j.style,t=h(a.nScrollFoot).children("div"),
m=t.children("table"),o=h(a.nTHead),F=h(a.nTable),p=F[0],r=p.style,u=a.nTFoot?h(a.nTFoot):null,Eb=a.oBrowser,Ua=Eb.bScrollOversize,s=G(a.aoColumns,"nTh"),P,v,w,y,z=[],A=[],B=[],C=[],D,E=function(a){a=a.style;a.paddingTop="0";a.paddingBottom="0";a.borderTopWidth="0";a.borderBottomWidth="0";a.height=0};v=j.scrollHeight>j.clientHeight;if(a.scrollBarVis!==v&&a.scrollBarVis!==k)a.scrollBarVis=v,Y(a);else{a.scrollBarVis=v;F.children("thead, tfoot").remove();u&&(w=u.clone().prependTo(F),P=u.find("tr"),w=
w.find("tr"));y=o.clone().prependTo(F);o=o.find("tr");v=y.find("tr");y.find("th, td").removeAttr("tabindex");c||(q.width="100%",f[0].style.width="100%");h.each(qa(a,y),function(b,c){D=Z(a,b);c.style.width=a.aoColumns[D].sWidth});u&&J(function(a){a.style.width=""},w);f=F.outerWidth();if(""===c){r.width="100%";if(Ua&&(F.find("tbody").height()>j.offsetHeight||"scroll"==l.css("overflow-y")))r.width=x(F.outerWidth()-b);f=F.outerWidth()}else""!==d&&(r.width=x(d),f=F.outerWidth());J(E,v);J(function(a){B.push(a.innerHTML);
z.push(x(h(a).css("width")))},v);J(function(a,b){if(h.inArray(a,s)!==-1)a.style.width=z[b]},o);h(v).height(0);u&&(J(E,w),J(function(a){C.push(a.innerHTML);A.push(x(h(a).css("width")))},w),J(function(a,b){a.style.width=A[b]},P),h(w).height(0));J(function(a,b){a.innerHTML='<div class="dataTables_sizing" style="height:0;overflow:hidden;">'+B[b]+"</div>";a.style.width=z[b]},v);u&&J(function(a,b){a.innerHTML='<div class="dataTables_sizing" style="height:0;overflow:hidden;">'+C[b]+"</div>";a.style.width=
A[b]},w);if(F.outerWidth()<f){P=j.scrollHeight>j.offsetHeight||"scroll"==l.css("overflow-y")?f+b:f;if(Ua&&(j.scrollHeight>j.offsetHeight||"scroll"==l.css("overflow-y")))r.width=x(P-b);(""===c||""!==d)&&L(a,1,"Possible column misalignment",6)}else P="100%";q.width=x(P);g.width=x(P);u&&(a.nScrollFoot.style.width=x(P));!e&&Ua&&(q.height=x(p.offsetHeight+b));c=F.outerWidth();n[0].style.width=x(c);i.width=x(c);d=F.height()>j.clientHeight||"scroll"==l.css("overflow-y");e="padding"+(Eb.bScrollbarLeft?"Left":
"Right");i[e]=d?b+"px":"0px";u&&(m[0].style.width=x(c),t[0].style.width=x(c),t[0].style[e]=d?b+"px":"0px");F.children("colgroup").insertBefore(F.children("thead"));l.scroll();if((a.bSorted||a.bFiltered)&&!a._drawHold)j.scrollTop=0}}function J(a,b,c){for(var d=0,e=0,f=b.length,g,j;e<f;){g=b[e].firstChild;for(j=c?c[e].firstChild:null;g;)1===g.nodeType&&(c?a(g,j,d):a(g,d),d++),g=g.nextSibling,j=c?j.nextSibling:null;e++}}function Fa(a){var b=a.nTable,c=a.aoColumns,d=a.oScroll,e=d.sY,f=d.sX,g=d.sXInner,
j=c.length,i=la(a,"bVisible"),n=h("th",a.nTHead),l=b.getAttribute("width"),k=b.parentNode,t=!1,m,o,p=a.oBrowser,d=p.bScrollOversize;(m=b.style.width)&&-1!==m.indexOf("%")&&(l=m);for(m=0;m<i.length;m++)o=c[i[m]],null!==o.sWidth&&(o.sWidth=Fb(o.sWidthOrig,k),t=!0);if(d||!t&&!f&&!e&&j==aa(a)&&j==n.length)for(m=0;m<j;m++)i=Z(a,m),null!==i&&(c[i].sWidth=x(n.eq(m).width()));else{j=h(b).clone().css("visibility","hidden").removeAttr("id");j.find("tbody tr").remove();var r=h("<tr/>").appendTo(j.find("tbody"));
j.find("thead, tfoot").remove();j.append(h(a.nTHead).clone()).append(h(a.nTFoot).clone());j.find("tfoot th, tfoot td").css("width","");n=qa(a,j.find("thead")[0]);for(m=0;m<i.length;m++)o=c[i[m]],n[m].style.width=null!==o.sWidthOrig&&""!==o.sWidthOrig?x(o.sWidthOrig):"",o.sWidthOrig&&f&&h(n[m]).append(h("<div/>").css({width:o.sWidthOrig,margin:0,padding:0,border:0,height:1}));if(a.aoData.length)for(m=0;m<i.length;m++)t=i[m],o=c[t],h(Gb(a,t)).clone(!1).append(o.sContentPadding).appendTo(r);h("[name]",
j).removeAttr("name");o=h("<div/>").css(f||e?{position:"absolute",top:0,left:0,height:1,right:0,overflow:"hidden"}:{}).append(j).appendTo(k);f&&g?j.width(g):f?(j.css("width","auto"),j.removeAttr("width"),j.width()<k.clientWidth&&l&&j.width(k.clientWidth)):e?j.width(k.clientWidth):l&&j.width(l);for(m=e=0;m<i.length;m++)k=h(n[m]),g=k.outerWidth()-k.width(),k=p.bBounding?Math.ceil(n[m].getBoundingClientRect().width):k.outerWidth(),e+=k,c[i[m]].sWidth=x(k-g);b.style.width=x(e);o.remove()}l&&(b.style.width=
x(l));if((l||f)&&!a._reszEvt)b=function(){h(D).bind("resize.DT-"+a.sInstance,Oa(function(){Y(a)}))},d?setTimeout(b,1E3):b(),a._reszEvt=!0}function Fb(a,b){if(!a)return 0;var c=h("<div/>").css("width",x(a)).appendTo(b||I.body),d=c[0].offsetWidth;c.remove();return d}function Gb(a,b){var c=Hb(a,b);if(0>c)return null;var d=a.aoData[c];return!d.nTr?h("<td/>").html(B(a,c,b,"display"))[0]:d.anCells[b]}function Hb(a,b){for(var c,d=-1,e=-1,f=0,g=a.aoData.length;f<g;f++)c=B(a,f,b,"display")+"",c=c.replace($b,
""),c=c.replace(/&nbsp;/g," "),c.length>d&&(d=c.length,e=f);return e}function x(a){return null===a?"0px":"number"==typeof a?0>a?"0px":a+"px":a.match(/\d$/)?a+"px":a}function V(a){var b,c,d=[],e=a.aoColumns,f,g,j,i;b=a.aaSortingFixed;c=h.isPlainObject(b);var n=[];f=function(a){a.length&&!h.isArray(a[0])?n.push(a):h.merge(n,a)};h.isArray(b)&&f(b);c&&b.pre&&f(b.pre);f(a.aaSorting);c&&b.post&&f(b.post);for(a=0;a<n.length;a++){i=n[a][0];f=e[i].aDataSort;b=0;for(c=f.length;b<c;b++)g=f[b],j=e[g].sType||
"string",n[a]._idx===k&&(n[a]._idx=h.inArray(n[a][1],e[g].asSorting)),d.push({src:i,col:g,dir:n[a][1],index:n[a]._idx,type:j,formatter:m.ext.type.order[j+"-pre"]})}return d}function mb(a){var b,c,d=[],e=m.ext.type.order,f=a.aoData,g=0,j,i=a.aiDisplayMaster,h;Ga(a);h=V(a);b=0;for(c=h.length;b<c;b++)j=h[b],j.formatter&&g++,Ib(a,j.col);if("ssp"!=y(a)&&0!==h.length){b=0;for(c=i.length;b<c;b++)d[i[b]]=b;g===h.length?i.sort(function(a,b){var c,e,g,j,i=h.length,k=f[a]._aSortData,m=f[b]._aSortData;for(g=
0;g<i;g++)if(j=h[g],c=k[j.col],e=m[j.col],c=c<e?-1:c>e?1:0,0!==c)return"asc"===j.dir?c:-c;c=d[a];e=d[b];return c<e?-1:c>e?1:0}):i.sort(function(a,b){var c,g,j,i,k=h.length,m=f[a]._aSortData,p=f[b]._aSortData;for(j=0;j<k;j++)if(i=h[j],c=m[i.col],g=p[i.col],i=e[i.type+"-"+i.dir]||e["string-"+i.dir],c=i(c,g),0!==c)return c;c=d[a];g=d[b];return c<g?-1:c>g?1:0})}a.bSorted=!0}function Jb(a){for(var b,c,d=a.aoColumns,e=V(a),a=a.oLanguage.oAria,f=0,g=d.length;f<g;f++){c=d[f];var j=c.asSorting;b=c.sTitle.replace(/<.*?>/g,
"");var i=c.nTh;i.removeAttribute("aria-sort");c.bSortable&&(0<e.length&&e[0].col==f?(i.setAttribute("aria-sort","asc"==e[0].dir?"ascending":"descending"),c=j[e[0].index+1]||j[0]):c=j[0],b+="asc"===c?a.sSortAscending:a.sSortDescending);i.setAttribute("aria-label",b)}}function Va(a,b,c,d){var e=a.aaSorting,f=a.aoColumns[b].asSorting,g=function(a,b){var c=a._idx;c===k&&(c=h.inArray(a[1],f));return c+1<f.length?c+1:b?null:0};"number"===typeof e[0]&&(e=a.aaSorting=[e]);c&&a.oFeatures.bSortMulti?(c=h.inArray(b,
G(e,"0")),-1!==c?(b=g(e[c],!0),null===b&&1===e.length&&(b=0),null===b?e.splice(c,1):(e[c][1]=f[b],e[c]._idx=b)):(e.push([b,f[0],0]),e[e.length-1]._idx=0)):e.length&&e[0][0]==b?(b=g(e[0]),e.length=1,e[0][1]=f[b],e[0]._idx=b):(e.length=0,e.push([b,f[0]]),e[0]._idx=0);T(a);"function"==typeof d&&d(a)}function Ma(a,b,c,d){var e=a.aoColumns[c];Wa(b,{},function(b){!1!==e.bSortable&&(a.oFeatures.bProcessing?(C(a,!0),setTimeout(function(){Va(a,c,b.shiftKey,d);"ssp"!==y(a)&&C(a,!1)},0)):Va(a,c,b.shiftKey,d))})}
function va(a){var b=a.aLastSort,c=a.oClasses.sSortColumn,d=V(a),e=a.oFeatures,f,g;if(e.bSort&&e.bSortClasses){e=0;for(f=b.length;e<f;e++)g=b[e].src,h(G(a.aoData,"anCells",g)).removeClass(c+(2>e?e+1:3));e=0;for(f=d.length;e<f;e++)g=d[e].src,h(G(a.aoData,"anCells",g)).addClass(c+(2>e?e+1:3))}a.aLastSort=d}function Ib(a,b){var c=a.aoColumns[b],d=m.ext.order[c.sSortDataType],e;d&&(e=d.call(a.oInstance,a,b,$(a,b)));for(var f,g=m.ext.type.order[c.sType+"-pre"],j=0,i=a.aoData.length;j<i;j++)if(c=a.aoData[j],
c._aSortData||(c._aSortData=[]),!c._aSortData[b]||d)f=d?e[j]:B(a,j,b,"sort"),c._aSortData[b]=g?g(f):f}function wa(a){if(a.oFeatures.bStateSave&&!a.bDestroying){var b={time:+new Date,start:a._iDisplayStart,length:a._iDisplayLength,order:h.extend(!0,[],a.aaSorting),search:Ab(a.oPreviousSearch),columns:h.map(a.aoColumns,function(b,d){return{visible:b.bVisible,search:Ab(a.aoPreSearchCols[d])}})};u(a,"aoStateSaveParams","stateSaveParams",[a,b]);a.oSavedState=b;a.fnStateSaveCallback.call(a.oInstance,a,
b)}}function Kb(a){var b,c,d=a.aoColumns;if(a.oFeatures.bStateSave){var e=a.fnStateLoadCallback.call(a.oInstance,a);if(e&&e.time&&(b=u(a,"aoStateLoadParams","stateLoadParams",[a,e]),-1===h.inArray(!1,b)&&(b=a.iStateDuration,!(0<b&&e.time<+new Date-1E3*b)&&d.length===e.columns.length))){a.oLoadedState=h.extend(!0,{},e);e.start!==k&&(a._iDisplayStart=e.start,a.iInitDisplayStart=e.start);e.length!==k&&(a._iDisplayLength=e.length);e.order!==k&&(a.aaSorting=[],h.each(e.order,function(b,c){a.aaSorting.push(c[0]>=
d.length?[0,c[1]]:c)}));e.search!==k&&h.extend(a.oPreviousSearch,Bb(e.search));b=0;for(c=e.columns.length;b<c;b++){var f=e.columns[b];f.visible!==k&&(d[b].bVisible=f.visible);f.search!==k&&h.extend(a.aoPreSearchCols[b],Bb(f.search))}u(a,"aoStateLoaded","stateLoaded",[a,e])}}}function xa(a){var b=m.settings,a=h.inArray(a,G(b,"nTable"));return-1!==a?b[a]:null}function L(a,b,c,d){c="DataTables warning: "+(a?"table id="+a.sTableId+" - ":"")+c;d&&(c+=". For more information about this error, please see http://datatables.net/tn/"+
d);if(b)D.console&&console.log&&console.log(c);else if(b=m.ext,b=b.sErrMode||b.errMode,a&&u(a,null,"error",[a,d,c]),"alert"==b)alert(c);else{if("throw"==b)throw Error(c);"function"==typeof b&&b(a,d,c)}}function E(a,b,c,d){h.isArray(c)?h.each(c,function(c,d){h.isArray(d)?E(a,b,d[0],d[1]):E(a,b,d)}):(d===k&&(d=c),b[c]!==k&&(a[d]=b[c]))}function Lb(a,b,c){var d,e;for(e in b)b.hasOwnProperty(e)&&(d=b[e],h.isPlainObject(d)?(h.isPlainObject(a[e])||(a[e]={}),h.extend(!0,a[e],d)):a[e]=c&&"data"!==e&&"aaData"!==
e&&h.isArray(d)?d.slice():d);return a}function Wa(a,b,c){h(a).bind("click.DT",b,function(b){a.blur();c(b)}).bind("keypress.DT",b,function(a){13===a.which&&(a.preventDefault(),c(a))}).bind("selectstart.DT",function(){return!1})}function z(a,b,c,d){c&&a[b].push({fn:c,sName:d})}function u(a,b,c,d){var e=[];b&&(e=h.map(a[b].slice().reverse(),function(b){return b.fn.apply(a.oInstance,d)}));null!==c&&(b=h.Event(c+".dt"),h(a.nTable).trigger(b,d),e.push(b.result));return e}function Sa(a){var b=a._iDisplayStart,
c=a.fnDisplayEnd(),d=a._iDisplayLength;b>=c&&(b=c-d);b-=b%d;if(-1===d||0>b)b=0;a._iDisplayStart=b}function Na(a,b){var c=a.renderer,d=m.ext.renderer[b];return h.isPlainObject(c)&&c[b]?d[c[b]]||d._:"string"===typeof c?d[c]||d._:d._}function y(a){return a.oFeatures.bServerSide?"ssp":a.ajax||a.sAjaxSource?"ajax":"dom"}function ya(a,b){var c=[],c=Mb.numbers_length,d=Math.floor(c/2);b<=c?c=W(0,b):a<=d?(c=W(0,c-2),c.push("ellipsis"),c.push(b-1)):(a>=b-1-d?c=W(b-(c-2),b):(c=W(a-d+2,a+d-1),c.push("ellipsis"),
c.push(b-1)),c.splice(0,0,"ellipsis"),c.splice(0,0,0));c.DT_el="span";return c}function db(a){h.each({num:function(b){return za(b,a)},"num-fmt":function(b){return za(b,a,Xa)},"html-num":function(b){return za(b,a,Aa)},"html-num-fmt":function(b){return za(b,a,Aa,Xa)}},function(b,c){v.type.order[b+a+"-pre"]=c;b.match(/^html\-/)&&(v.type.search[b+a]=v.type.search.html)})}function Nb(a){return function(){var b=[xa(this[m.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));return m.ext.internal[a].apply(this,
b)}}var m=function(a){this.$=function(a,b){return this.api(!0).$(a,b)};this._=function(a,b){return this.api(!0).rows(a,b).data()};this.api=function(a){return a?new r(xa(this[v.iApiIndex])):new r(this)};this.fnAddData=function(a,b){var c=this.api(!0),d=h.isArray(a)&&(h.isArray(a[0])||h.isPlainObject(a[0]))?c.rows.add(a):c.row.add(a);(b===k||b)&&c.draw();return d.flatten().toArray()};this.fnAdjustColumnSizing=function(a){var b=this.api(!0).columns.adjust(),c=b.settings()[0],d=c.oScroll;a===k||a?b.draw(!1):
(""!==d.sX||""!==d.sY)&&ka(c)};this.fnClearTable=function(a){var b=this.api(!0).clear();(a===k||a)&&b.draw()};this.fnClose=function(a){this.api(!0).row(a).child.hide()};this.fnDeleteRow=function(a,b,c){var d=this.api(!0),a=d.rows(a),e=a.settings()[0],h=e.aoData[a[0][0]];a.remove();b&&b.call(this,e,h);(c===k||c)&&d.draw();return h};this.fnDestroy=function(a){this.api(!0).destroy(a)};this.fnDraw=function(a){this.api(!0).draw(a)};this.fnFilter=function(a,b,c,d,e,h){e=this.api(!0);null===b||b===k?e.search(a,
c,d,h):e.column(b).search(a,c,d,h);e.draw()};this.fnGetData=function(a,b){var c=this.api(!0);if(a!==k){var d=a.nodeName?a.nodeName.toLowerCase():"";return b!==k||"td"==d||"th"==d?c.cell(a,b).data():c.row(a).data()||null}return c.data().toArray()};this.fnGetNodes=function(a){var b=this.api(!0);return a!==k?b.row(a).node():b.rows().nodes().flatten().toArray()};this.fnGetPosition=function(a){var b=this.api(!0),c=a.nodeName.toUpperCase();return"TR"==c?b.row(a).index():"TD"==c||"TH"==c?(a=b.cell(a).index(),
[a.row,a.columnVisible,a.column]):null};this.fnIsOpen=function(a){return this.api(!0).row(a).child.isShown()};this.fnOpen=function(a,b,c){return this.api(!0).row(a).child(b,c).show().child()[0]};this.fnPageChange=function(a,b){var c=this.api(!0).page(a);(b===k||b)&&c.draw(!1)};this.fnSetColumnVis=function(a,b,c){a=this.api(!0).column(a).visible(b);(c===k||c)&&a.columns.adjust().draw()};this.fnSettings=function(){return xa(this[v.iApiIndex])};this.fnSort=function(a){this.api(!0).order(a).draw()};this.fnSortListener=
function(a,b,c){this.api(!0).order.listener(a,b,c)};this.fnUpdate=function(a,b,c,d,e){var h=this.api(!0);c===k||null===c?h.row(b).data(a):h.cell(b,c).data(a);(e===k||e)&&h.columns.adjust();(d===k||d)&&h.draw();return 0};this.fnVersionCheck=v.fnVersionCheck;var b=this,c=a===k,d=this.length;c&&(a={});this.oApi=this.internal=v.internal;for(var e in m.ext.internal)e&&(this[e]=Nb(e));this.each(function(){var e={},e=1<d?Lb(e,a,!0):a,g=0,j,i=this.getAttribute("id"),n=!1,l=m.defaults,q=h(this);if("table"!=
this.nodeName.toLowerCase())L(null,0,"Non-table node initialisation ("+this.nodeName+")",2);else{eb(l);fb(l.column);K(l,l,!0);K(l.column,l.column,!0);K(l,h.extend(e,q.data()));var t=m.settings,g=0;for(j=t.length;g<j;g++){var p=t[g];if(p.nTable==this||p.nTHead.parentNode==this||p.nTFoot&&p.nTFoot.parentNode==this){g=e.bRetrieve!==k?e.bRetrieve:l.bRetrieve;if(c||g)return p.oInstance;if(e.bDestroy!==k?e.bDestroy:l.bDestroy){p.oInstance.fnDestroy();break}else{L(p,0,"Cannot reinitialise DataTable",3);
return}}if(p.sTableId==this.id){t.splice(g,1);break}}if(null===i||""===i)this.id=i="DataTables_Table_"+m.ext._unique++;var o=h.extend(!0,{},m.models.oSettings,{sDestroyWidth:q[0].style.width,sInstance:i,sTableId:i});o.nTable=this;o.oApi=b.internal;o.oInit=e;t.push(o);o.oInstance=1===b.length?b:q.dataTable();eb(e);e.oLanguage&&Da(e.oLanguage);e.aLengthMenu&&!e.iDisplayLength&&(e.iDisplayLength=h.isArray(e.aLengthMenu[0])?e.aLengthMenu[0][0]:e.aLengthMenu[0]);e=Lb(h.extend(!0,{},l),e);E(o.oFeatures,
e,"bPaginate bLengthChange bFilter bSort bSortMulti bInfo bProcessing bAutoWidth bSortClasses bServerSide bDeferRender".split(" "));E(o,e,["asStripeClasses","ajax","fnServerData","fnFormatNumber","sServerMethod","aaSorting","aaSortingFixed","aLengthMenu","sPaginationType","sAjaxSource","sAjaxDataProp","iStateDuration","sDom","bSortCellsTop","iTabIndex","fnStateLoadCallback","fnStateSaveCallback","renderer","searchDelay","rowId",["iCookieDuration","iStateDuration"],["oSearch","oPreviousSearch"],["aoSearchCols",
"aoPreSearchCols"],["iDisplayLength","_iDisplayLength"],["bJQueryUI","bJUI"]]);E(o.oScroll,e,[["sScrollX","sX"],["sScrollXInner","sXInner"],["sScrollY","sY"],["bScrollCollapse","bCollapse"]]);E(o.oLanguage,e,"fnInfoCallback");z(o,"aoDrawCallback",e.fnDrawCallback,"user");z(o,"aoServerParams",e.fnServerParams,"user");z(o,"aoStateSaveParams",e.fnStateSaveParams,"user");z(o,"aoStateLoadParams",e.fnStateLoadParams,"user");z(o,"aoStateLoaded",e.fnStateLoaded,"user");z(o,"aoRowCallback",e.fnRowCallback,
"user");z(o,"aoRowCreatedCallback",e.fnCreatedRow,"user");z(o,"aoHeaderCallback",e.fnHeaderCallback,"user");z(o,"aoFooterCallback",e.fnFooterCallback,"user");z(o,"aoInitComplete",e.fnInitComplete,"user");z(o,"aoPreDrawCallback",e.fnPreDrawCallback,"user");o.rowIdFn=Q(e.rowId);gb(o);i=o.oClasses;e.bJQueryUI?(h.extend(i,m.ext.oJUIClasses,e.oClasses),e.sDom===l.sDom&&"lfrtip"===l.sDom&&(o.sDom='<"H"lfr>t<"F"ip>'),o.renderer)?h.isPlainObject(o.renderer)&&!o.renderer.header&&(o.renderer.header="jqueryui"):
o.renderer="jqueryui":h.extend(i,m.ext.classes,e.oClasses);q.addClass(i.sTable);o.iInitDisplayStart===k&&(o.iInitDisplayStart=e.iDisplayStart,o._iDisplayStart=e.iDisplayStart);null!==e.iDeferLoading&&(o.bDeferLoading=!0,g=h.isArray(e.iDeferLoading),o._iRecordsDisplay=g?e.iDeferLoading[0]:e.iDeferLoading,o._iRecordsTotal=g?e.iDeferLoading[1]:e.iDeferLoading);var r=o.oLanguage;h.extend(!0,r,e.oLanguage);""!==r.sUrl&&(h.ajax({dataType:"json",url:r.sUrl,success:function(a){Da(a);K(l.oLanguage,a);h.extend(true,
r,a);ga(o)},error:function(){ga(o)}}),n=!0);null===e.asStripeClasses&&(o.asStripeClasses=[i.sStripeOdd,i.sStripeEven]);var g=o.asStripeClasses,v=q.children("tbody").find("tr").eq(0);-1!==h.inArray(!0,h.map(g,function(a){return v.hasClass(a)}))&&(h("tbody tr",this).removeClass(g.join(" ")),o.asDestroyStripes=g.slice());t=[];g=this.getElementsByTagName("thead");0!==g.length&&(da(o.aoHeader,g[0]),t=qa(o));if(null===e.aoColumns){p=[];g=0;for(j=t.length;g<j;g++)p.push(null)}else p=e.aoColumns;g=0;for(j=
p.length;g<j;g++)Ea(o,t?t[g]:null);ib(o,e.aoColumnDefs,p,function(a,b){ja(o,a,b)});if(v.length){var s=function(a,b){return a.getAttribute("data-"+b)!==null?b:null};h(v[0]).children("th, td").each(function(a,b){var c=o.aoColumns[a];if(c.mData===a){var d=s(b,"sort")||s(b,"order"),e=s(b,"filter")||s(b,"search");if(d!==null||e!==null){c.mData={_:a+".display",sort:d!==null?a+".@data-"+d:k,type:d!==null?a+".@data-"+d:k,filter:e!==null?a+".@data-"+e:k};ja(o,a)}}})}var w=o.oFeatures;e.bStateSave&&(w.bStateSave=
!0,Kb(o,e),z(o,"aoDrawCallback",wa,"state_save"));if(e.aaSorting===k){t=o.aaSorting;g=0;for(j=t.length;g<j;g++)t[g][1]=o.aoColumns[g].asSorting[0]}va(o);w.bSort&&z(o,"aoDrawCallback",function(){if(o.bSorted){var a=V(o),b={};h.each(a,function(a,c){b[c.src]=c.dir});u(o,null,"order",[o,a,b]);Jb(o)}});z(o,"aoDrawCallback",function(){(o.bSorted||y(o)==="ssp"||w.bDeferRender)&&va(o)},"sc");g=q.children("caption").each(function(){this._captionSide=q.css("caption-side")});j=q.children("thead");0===j.length&&
(j=h("<thead/>").appendTo(this));o.nTHead=j[0];j=q.children("tbody");0===j.length&&(j=h("<tbody/>").appendTo(this));o.nTBody=j[0];j=q.children("tfoot");if(0===j.length&&0<g.length&&(""!==o.oScroll.sX||""!==o.oScroll.sY))j=h("<tfoot/>").appendTo(this);0===j.length||0===j.children().length?q.addClass(i.sNoFooter):0<j.length&&(o.nTFoot=j[0],da(o.aoFooter,o.nTFoot));if(e.aaData)for(g=0;g<e.aaData.length;g++)N(o,e.aaData[g]);else(o.bDeferLoading||"dom"==y(o))&&ma(o,h(o.nTBody).children("tr"));o.aiDisplay=
o.aiDisplayMaster.slice();o.bInitialised=!0;!1===n&&ga(o)}});b=null;return this},v,r,p,s,Ya={},Ob=/[\r\n]/g,Aa=/<.*?>/g,ac=/^[\w\+\-]/,bc=/[\w\+\-]$/,cc=RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\|\\$|\\^|\\-)","g"),Xa=/[',$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfk]/gi,M=function(a){return!a||!0===a||"-"===a?!0:!1},Pb=function(a){var b=parseInt(a,10);return!isNaN(b)&&isFinite(a)?b:null},Qb=function(a,b){Ya[b]||(Ya[b]=RegExp(Qa(b),"g"));return"string"===typeof a&&"."!==b?a.replace(/\./g,
"").replace(Ya[b],"."):a},Za=function(a,b,c){var d="string"===typeof a;if(M(a))return!0;b&&d&&(a=Qb(a,b));c&&d&&(a=a.replace(Xa,""));return!isNaN(parseFloat(a))&&isFinite(a)},Rb=function(a,b,c){return M(a)?!0:!(M(a)||"string"===typeof a)?null:Za(a.replace(Aa,""),b,c)?!0:null},G=function(a,b,c){var d=[],e=0,f=a.length;if(c!==k)for(;e<f;e++)a[e]&&a[e][b]&&d.push(a[e][b][c]);else for(;e<f;e++)a[e]&&d.push(a[e][b]);return d},ha=function(a,b,c,d){var e=[],f=0,g=b.length;if(d!==k)for(;f<g;f++)a[b[f]][c]&&
e.push(a[b[f]][c][d]);else for(;f<g;f++)e.push(a[b[f]][c]);return e},W=function(a,b){var c=[],d;b===k?(b=0,d=a):(d=b,b=a);for(var e=b;e<d;e++)c.push(e);return c},Sb=function(a){for(var b=[],c=0,d=a.length;c<d;c++)a[c]&&b.push(a[c]);return b},pa=function(a){var b=[],c,d,e=a.length,f,g=0;d=0;a:for(;d<e;d++){c=a[d];for(f=0;f<g;f++)if(b[f]===c)continue a;b.push(c);g++}return b};m.util={throttle:function(a,b){var c=b!==k?b:200,d,e;return function(){var b=this,g=+new Date,h=arguments;d&&g<d+c?(clearTimeout(e),
e=setTimeout(function(){d=k;a.apply(b,h)},c)):(d=g,a.apply(b,h))}},escapeRegex:function(a){return a.replace(cc,"\\$1")}};var A=function(a,b,c){a[b]!==k&&(a[c]=a[b])},ba=/\[.*?\]$/,U=/\(\)$/,Qa=m.util.escapeRegex,ua=h("<div>")[0],Zb=ua.textContent!==k,$b=/<.*?>/g,Oa=m.util.throttle,Tb=[],w=Array.prototype,dc=function(a){var b,c,d=m.settings,e=h.map(d,function(a){return a.nTable});if(a){if(a.nTable&&a.oApi)return[a];if(a.nodeName&&"table"===a.nodeName.toLowerCase())return b=h.inArray(a,e),-1!==b?[d[b]]:
null;if(a&&"function"===typeof a.settings)return a.settings().toArray();"string"===typeof a?c=h(a):a instanceof h&&(c=a)}else return[];if(c)return c.map(function(){b=h.inArray(this,e);return-1!==b?d[b]:null}).toArray()};r=function(a,b){if(!(this instanceof r))return new r(a,b);var c=[],d=function(a){(a=dc(a))&&(c=c.concat(a))};if(h.isArray(a))for(var e=0,f=a.length;e<f;e++)d(a[e]);else d(a);this.context=pa(c);b&&h.merge(this,b);this.selector={rows:null,cols:null,opts:null};r.extend(this,this,Tb)};
m.Api=r;h.extend(r.prototype,{any:function(){return 0!==this.count()},concat:w.concat,context:[],count:function(){return this.flatten().length},each:function(a){for(var b=0,c=this.length;b<c;b++)a.call(this,this[b],b,this);return this},eq:function(a){var b=this.context;return b.length>a?new r(b[a],this[a]):null},filter:function(a){var b=[];if(w.filter)b=w.filter.call(this,a,this);else for(var c=0,d=this.length;c<d;c++)a.call(this,this[c],c,this)&&b.push(this[c]);return new r(this.context,b)},flatten:function(){var a=
[];return new r(this.context,a.concat.apply(a,this.toArray()))},join:w.join,indexOf:w.indexOf||function(a,b){for(var c=b||0,d=this.length;c<d;c++)if(this[c]===a)return c;return-1},iterator:function(a,b,c,d){var e=[],f,g,h,i,n,l=this.context,m,t,p=this.selector;"string"===typeof a&&(d=c,c=b,b=a,a=!1);g=0;for(h=l.length;g<h;g++){var o=new r(l[g]);if("table"===b)f=c.call(o,l[g],g),f!==k&&e.push(f);else if("columns"===b||"rows"===b)f=c.call(o,l[g],this[g],g),f!==k&&e.push(f);else if("column"===b||"column-rows"===
b||"row"===b||"cell"===b){t=this[g];"column-rows"===b&&(m=Ba(l[g],p.opts));i=0;for(n=t.length;i<n;i++)f=t[i],f="cell"===b?c.call(o,l[g],f.row,f.column,g,i):c.call(o,l[g],f,g,i,m),f!==k&&e.push(f)}}return e.length||d?(a=new r(l,a?e.concat.apply([],e):e),b=a.selector,b.rows=p.rows,b.cols=p.cols,b.opts=p.opts,a):this},lastIndexOf:w.lastIndexOf||function(a,b){return this.indexOf.apply(this.toArray.reverse(),arguments)},length:0,map:function(a){var b=[];if(w.map)b=w.map.call(this,a,this);else for(var c=
0,d=this.length;c<d;c++)b.push(a.call(this,this[c],c));return new r(this.context,b)},pluck:function(a){return this.map(function(b){return b[a]})},pop:w.pop,push:w.push,reduce:w.reduce||function(a,b){return hb(this,a,b,0,this.length,1)},reduceRight:w.reduceRight||function(a,b){return hb(this,a,b,this.length-1,-1,-1)},reverse:w.reverse,selector:null,shift:w.shift,sort:w.sort,splice:w.splice,toArray:function(){return w.slice.call(this)},to$:function(){return h(this)},toJQuery:function(){return h(this)},
unique:function(){return new r(this.context,pa(this))},unshift:w.unshift});r.extend=function(a,b,c){if(c.length&&b&&(b instanceof r||b.__dt_wrapper)){var d,e,f,g=function(a,b,c){return function(){var d=b.apply(a,arguments);r.extend(d,d,c.methodExt);return d}};d=0;for(e=c.length;d<e;d++)f=c[d],b[f.name]="function"===typeof f.val?g(a,f.val,f):h.isPlainObject(f.val)?{}:f.val,b[f.name].__dt_wrapper=!0,r.extend(a,b[f.name],f.propExt)}};r.register=p=function(a,b){if(h.isArray(a))for(var c=0,d=a.length;c<
d;c++)r.register(a[c],b);else for(var e=a.split("."),f=Tb,g,j,c=0,d=e.length;c<d;c++){g=(j=-1!==e[c].indexOf("()"))?e[c].replace("()",""):e[c];var i;a:{i=0;for(var n=f.length;i<n;i++)if(f[i].name===g){i=f[i];break a}i=null}i||(i={name:g,val:{},methodExt:[],propExt:[]},f.push(i));c===d-1?i.val=b:f=j?i.methodExt:i.propExt}};r.registerPlural=s=function(a,b,c){r.register(a,c);r.register(b,function(){var a=c.apply(this,arguments);return a===this?this:a instanceof r?a.length?h.isArray(a[0])?new r(a.context,
a[0]):a[0]:k:a})};p("tables()",function(a){var b;if(a){b=r;var c=this.context;if("number"===typeof a)a=[c[a]];else var d=h.map(c,function(a){return a.nTable}),a=h(d).filter(a).map(function(){var a=h.inArray(this,d);return c[a]}).toArray();b=new b(a)}else b=this;return b});p("table()",function(a){var a=this.tables(a),b=a.context;return b.length?new r(b[0]):a});s("tables().nodes()","table().node()",function(){return this.iterator("table",function(a){return a.nTable},1)});s("tables().body()","table().body()",
function(){return this.iterator("table",function(a){return a.nTBody},1)});s("tables().header()","table().header()",function(){return this.iterator("table",function(a){return a.nTHead},1)});s("tables().footer()","table().footer()",function(){return this.iterator("table",function(a){return a.nTFoot},1)});s("tables().containers()","table().container()",function(){return this.iterator("table",function(a){return a.nTableWrapper},1)});p("draw()",function(a){return this.iterator("table",function(b){"page"===
a?O(b):("string"===typeof a&&(a="full-hold"===a?!1:!0),T(b,!1===a))})});p("page()",function(a){return a===k?this.page.info().page:this.iterator("table",function(b){Ta(b,a)})});p("page.info()",function(){if(0===this.context.length)return k;var a=this.context[0],b=a._iDisplayStart,c=a.oFeatures.bPaginate?a._iDisplayLength:-1,d=a.fnRecordsDisplay(),e=-1===c;return{page:e?0:Math.floor(b/c),pages:e?1:Math.ceil(d/c),start:b,end:a.fnDisplayEnd(),length:c,recordsTotal:a.fnRecordsTotal(),recordsDisplay:d,
serverSide:"ssp"===y(a)}});p("page.len()",function(a){return a===k?0!==this.context.length?this.context[0]._iDisplayLength:k:this.iterator("table",function(b){Ra(b,a)})});var Ub=function(a,b,c){if(c){var d=new r(a);d.one("draw",function(){c(d.ajax.json())})}if("ssp"==y(a))T(a,b);else{C(a,!0);var e=a.jqXHR;e&&4!==e.readyState&&e.abort();ra(a,[],function(c){na(a);for(var c=sa(a,c),d=0,e=c.length;d<e;d++)N(a,c[d]);T(a,b);C(a,!1)})}};p("ajax.json()",function(){var a=this.context;if(0<a.length)return a[0].json});
p("ajax.params()",function(){var a=this.context;if(0<a.length)return a[0].oAjaxData});p("ajax.reload()",function(a,b){return this.iterator("table",function(c){Ub(c,!1===b,a)})});p("ajax.url()",function(a){var b=this.context;if(a===k){if(0===b.length)return k;b=b[0];return b.ajax?h.isPlainObject(b.ajax)?b.ajax.url:b.ajax:b.sAjaxSource}return this.iterator("table",function(b){h.isPlainObject(b.ajax)?b.ajax.url=a:b.ajax=a})});p("ajax.url().load()",function(a,b){return this.iterator("table",function(c){Ub(c,
!1===b,a)})});var $a=function(a,b,c,d,e){var f=[],g,j,i,n,l,m;i=typeof b;if(!b||"string"===i||"function"===i||b.length===k)b=[b];i=0;for(n=b.length;i<n;i++){j=b[i]&&b[i].split?b[i].split(","):[b[i]];l=0;for(m=j.length;l<m;l++)(g=c("string"===typeof j[l]?h.trim(j[l]):j[l]))&&g.length&&(f=f.concat(g))}a=v.selector[a];if(a.length){i=0;for(n=a.length;i<n;i++)f=a[i](d,e,f)}return pa(f)},ab=function(a){a||(a={});a.filter&&a.search===k&&(a.search=a.filter);return h.extend({search:"none",order:"current",
page:"all"},a)},bb=function(a){for(var b=0,c=a.length;b<c;b++)if(0<a[b].length)return a[0]=a[b],a[0].length=1,a.length=1,a.context=[a.context[b]],a;a.length=0;return a},Ba=function(a,b){var c,d,e,f=[],g=a.aiDisplay;c=a.aiDisplayMaster;var j=b.search;d=b.order;e=b.page;if("ssp"==y(a))return"removed"===j?[]:W(0,c.length);if("current"==e){c=a._iDisplayStart;for(d=a.fnDisplayEnd();c<d;c++)f.push(g[c])}else if("current"==d||"applied"==d)f="none"==j?c.slice():"applied"==j?g.slice():h.map(c,function(a){return-1===
h.inArray(a,g)?a:null});else if("index"==d||"original"==d){c=0;for(d=a.aoData.length;c<d;c++)"none"==j?f.push(c):(e=h.inArray(c,g),(-1===e&&"removed"==j||0<=e&&"applied"==j)&&f.push(c))}return f};p("rows()",function(a,b){a===k?a="":h.isPlainObject(a)&&(b=a,a="");var b=ab(b),c=this.iterator("table",function(c){var e=b;return $a("row",a,function(a){var b=Pb(a);if(b!==null&&!e)return[b];var j=Ba(c,e);if(b!==null&&h.inArray(b,j)!==-1)return[b];if(!a)return j;if(typeof a==="function")return h.map(j,function(b){var e=
c.aoData[b];return a(b,e._aData,e.nTr)?b:null});b=Sb(ha(c.aoData,j,"nTr"));if(a.nodeName){if(a._DT_RowIndex!==k)return[a._DT_RowIndex];if(a._DT_CellIndex)return[a._DT_CellIndex.row];b=h(a).closest("*[data-dt-row]");return b.length?[b.data("dt-row")]:[]}if(typeof a==="string"&&a.charAt(0)==="#"){j=c.aIds[a.replace(/^#/,"")];if(j!==k)return[j.idx]}return h(b).filter(a).map(function(){return this._DT_RowIndex}).toArray()},c,e)},1);c.selector.rows=a;c.selector.opts=b;return c});p("rows().nodes()",function(){return this.iterator("row",
function(a,b){return a.aoData[b].nTr||k},1)});p("rows().data()",function(){return this.iterator(!0,"rows",function(a,b){return ha(a.aoData,b,"_aData")},1)});s("rows().cache()","row().cache()",function(a){return this.iterator("row",function(b,c){var d=b.aoData[c];return"search"===a?d._aFilterData:d._aSortData},1)});s("rows().invalidate()","row().invalidate()",function(a){return this.iterator("row",function(b,c){ca(b,c,a)})});s("rows().indexes()","row().index()",function(){return this.iterator("row",
function(a,b){return b},1)});s("rows().ids()","row().id()",function(a){for(var b=[],c=this.context,d=0,e=c.length;d<e;d++)for(var f=0,g=this[d].length;f<g;f++){var h=c[d].rowIdFn(c[d].aoData[this[d][f]]._aData);b.push((!0===a?"#":"")+h)}return new r(c,b)});s("rows().remove()","row().remove()",function(){var a=this;this.iterator("row",function(b,c,d){var e=b.aoData,f=e[c],g,h,i,n,l;e.splice(c,1);g=0;for(h=e.length;g<h;g++)if(i=e[g],l=i.anCells,null!==i.nTr&&(i.nTr._DT_RowIndex=g),null!==l){i=0;for(n=
l.length;i<n;i++)l[i]._DT_CellIndex.row=g}oa(b.aiDisplayMaster,c);oa(b.aiDisplay,c);oa(a[d],c,!1);Sa(b);c=b.rowIdFn(f._aData);c!==k&&delete b.aIds[c]});this.iterator("table",function(a){for(var c=0,d=a.aoData.length;c<d;c++)a.aoData[c].idx=c});return this});p("rows.add()",function(a){var b=this.iterator("table",function(b){var c,f,g,h=[];f=0;for(g=a.length;f<g;f++)c=a[f],c.nodeName&&"TR"===c.nodeName.toUpperCase()?h.push(ma(b,c)[0]):h.push(N(b,c));return h},1),c=this.rows(-1);c.pop();h.merge(c,b);
return c});p("row()",function(a,b){return bb(this.rows(a,b))});p("row().data()",function(a){var b=this.context;if(a===k)return b.length&&this.length?b[0].aoData[this[0]]._aData:k;b[0].aoData[this[0]]._aData=a;ca(b[0],this[0],"data");return this});p("row().node()",function(){var a=this.context;return a.length&&this.length?a[0].aoData[this[0]].nTr||null:null});p("row.add()",function(a){a instanceof h&&a.length&&(a=a[0]);var b=this.iterator("table",function(b){return a.nodeName&&"TR"===a.nodeName.toUpperCase()?
ma(b,a)[0]:N(b,a)});return this.row(b[0])});var cb=function(a,b){var c=a.context;if(c.length&&(c=c[0].aoData[b!==k?b:a[0]])&&c._details)c._details.remove(),c._detailsShow=k,c._details=k},Vb=function(a,b){var c=a.context;if(c.length&&a.length){var d=c[0].aoData[a[0]];if(d._details){(d._detailsShow=b)?d._details.insertAfter(d.nTr):d._details.detach();var e=c[0],f=new r(e),g=e.aoData;f.off("draw.dt.DT_details column-visibility.dt.DT_details destroy.dt.DT_details");0<G(g,"_details").length&&(f.on("draw.dt.DT_details",
function(a,b){e===b&&f.rows({page:"current"}).eq(0).each(function(a){a=g[a];a._detailsShow&&a._details.insertAfter(a.nTr)})}),f.on("column-visibility.dt.DT_details",function(a,b){if(e===b)for(var c,d=aa(b),f=0,h=g.length;f<h;f++)c=g[f],c._details&&c._details.children("td[colspan]").attr("colspan",d)}),f.on("destroy.dt.DT_details",function(a,b){if(e===b)for(var c=0,d=g.length;c<d;c++)g[c]._details&&cb(f,c)}))}}};p("row().child()",function(a,b){var c=this.context;if(a===k)return c.length&&this.length?
c[0].aoData[this[0]]._details:k;if(!0===a)this.child.show();else if(!1===a)cb(this);else if(c.length&&this.length){var d=c[0],c=c[0].aoData[this[0]],e=[],f=function(a,b){if(h.isArray(a)||a instanceof h)for(var c=0,k=a.length;c<k;c++)f(a[c],b);else a.nodeName&&"tr"===a.nodeName.toLowerCase()?e.push(a):(c=h("<tr><td/></tr>").addClass(b),h("td",c).addClass(b).html(a)[0].colSpan=aa(d),e.push(c[0]))};f(a,b);c._details&&c._details.remove();c._details=h(e);c._detailsShow&&c._details.insertAfter(c.nTr)}return this});
p(["row().child.show()","row().child().show()"],function(){Vb(this,!0);return this});p(["row().child.hide()","row().child().hide()"],function(){Vb(this,!1);return this});p(["row().child.remove()","row().child().remove()"],function(){cb(this);return this});p("row().child.isShown()",function(){var a=this.context;return a.length&&this.length?a[0].aoData[this[0]]._detailsShow||!1:!1});var ec=/^(.+):(name|visIdx|visible)$/,Wb=function(a,b,c,d,e){for(var c=[],d=0,f=e.length;d<f;d++)c.push(B(a,e[d],b));
return c};p("columns()",function(a,b){a===k?a="":h.isPlainObject(a)&&(b=a,a="");var b=ab(b),c=this.iterator("table",function(c){var e=a,f=b,g=c.aoColumns,j=G(g,"sName"),i=G(g,"nTh");return $a("column",e,function(a){var b=Pb(a);if(a==="")return W(g.length);if(b!==null)return[b>=0?b:g.length+b];if(typeof a==="function"){var e=Ba(c,f);return h.map(g,function(b,f){return a(f,Wb(c,f,0,0,e),i[f])?f:null})}var k=typeof a==="string"?a.match(ec):"";if(k)switch(k[2]){case "visIdx":case "visible":b=parseInt(k[1],
10);if(b<0){var m=h.map(g,function(a,b){return a.bVisible?b:null});return[m[m.length+b]]}return[Z(c,b)];case "name":return h.map(j,function(a,b){return a===k[1]?b:null});default:return[]}if(a.nodeName&&a._DT_CellIndex)return[a._DT_CellIndex.column];b=h(i).filter(a).map(function(){return h.inArray(this,i)}).toArray();if(b.length||!a.nodeName)return b;b=h(a).closest("*[data-dt-column]");return b.length?[b.data("dt-column")]:[]},c,f)},1);c.selector.cols=a;c.selector.opts=b;return c});s("columns().header()",
"column().header()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].nTh},1)});s("columns().footer()","column().footer()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].nTf},1)});s("columns().data()","column().data()",function(){return this.iterator("column-rows",Wb,1)});s("columns().dataSrc()","column().dataSrc()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].mData},1)});s("columns().cache()","column().cache()",
function(a){return this.iterator("column-rows",function(b,c,d,e,f){return ha(b.aoData,f,"search"===a?"_aFilterData":"_aSortData",c)},1)});s("columns().nodes()","column().nodes()",function(){return this.iterator("column-rows",function(a,b,c,d,e){return ha(a.aoData,e,"anCells",b)},1)});s("columns().visible()","column().visible()",function(a,b){var c=this.iterator("column",function(b,c){if(a===k)return b.aoColumns[c].bVisible;var f=b.aoColumns,g=f[c],j=b.aoData,i,n,l;if(a!==k&&g.bVisible!==a){if(a){var m=
h.inArray(!0,G(f,"bVisible"),c+1);i=0;for(n=j.length;i<n;i++)l=j[i].nTr,f=j[i].anCells,l&&l.insertBefore(f[c],f[m]||null)}else h(G(b.aoData,"anCells",c)).detach();g.bVisible=a;ea(b,b.aoHeader);ea(b,b.aoFooter);wa(b)}});a!==k&&(this.iterator("column",function(c,e){u(c,null,"column-visibility",[c,e,a,b])}),(b===k||b)&&this.columns.adjust());return c});s("columns().indexes()","column().index()",function(a){return this.iterator("column",function(b,c){return"visible"===a?$(b,c):c},1)});p("columns.adjust()",
function(){return this.iterator("table",function(a){Y(a)},1)});p("column.index()",function(a,b){if(0!==this.context.length){var c=this.context[0];if("fromVisible"===a||"toData"===a)return Z(c,b);if("fromData"===a||"toVisible"===a)return $(c,b)}});p("column()",function(a,b){return bb(this.columns(a,b))});p("cells()",function(a,b,c){h.isPlainObject(a)&&(a.row===k?(c=a,a=null):(c=b,b=null));h.isPlainObject(b)&&(c=b,b=null);if(null===b||b===k)return this.iterator("table",function(b){var d=a,e=ab(c),f=
b.aoData,g=Ba(b,e),j=Sb(ha(f,g,"anCells")),i=h([].concat.apply([],j)),l,n=b.aoColumns.length,m,p,r,u,v,s;return $a("cell",d,function(a){var c=typeof a==="function";if(a===null||a===k||c){m=[];p=0;for(r=g.length;p<r;p++){l=g[p];for(u=0;u<n;u++){v={row:l,column:u};if(c){s=f[l];a(v,B(b,l,u),s.anCells?s.anCells[u]:null)&&m.push(v)}else m.push(v)}}return m}if(h.isPlainObject(a))return[a];c=i.filter(a).map(function(a,b){return{row:b._DT_CellIndex.row,column:b._DT_CellIndex.column}}).toArray();if(c.length||
!a.nodeName)return c;s=h(a).closest("*[data-dt-row]");return s.length?[{row:s.data("dt-row"),column:s.data("dt-column")}]:[]},b,e)});var d=this.columns(b,c),e=this.rows(a,c),f,g,j,i,n,l=this.iterator("table",function(a,b){f=[];g=0;for(j=e[b].length;g<j;g++){i=0;for(n=d[b].length;i<n;i++)f.push({row:e[b][g],column:d[b][i]})}return f},1);h.extend(l.selector,{cols:b,rows:a,opts:c});return l});s("cells().nodes()","cell().node()",function(){return this.iterator("cell",function(a,b,c){return(a=a.aoData[b])&&
a.anCells?a.anCells[c]:k},1)});p("cells().data()",function(){return this.iterator("cell",function(a,b,c){return B(a,b,c)},1)});s("cells().cache()","cell().cache()",function(a){a="search"===a?"_aFilterData":"_aSortData";return this.iterator("cell",function(b,c,d){return b.aoData[c][a][d]},1)});s("cells().render()","cell().render()",function(a){return this.iterator("cell",function(b,c,d){return B(b,c,d,a)},1)});s("cells().indexes()","cell().index()",function(){return this.iterator("cell",function(a,
b,c){return{row:b,column:c,columnVisible:$(a,c)}},1)});s("cells().invalidate()","cell().invalidate()",function(a){return this.iterator("cell",function(b,c,d){ca(b,c,a,d)})});p("cell()",function(a,b,c){return bb(this.cells(a,b,c))});p("cell().data()",function(a){var b=this.context,c=this[0];if(a===k)return b.length&&c.length?B(b[0],c[0].row,c[0].column):k;jb(b[0],c[0].row,c[0].column,a);ca(b[0],c[0].row,"data",c[0].column);return this});p("order()",function(a,b){var c=this.context;if(a===k)return 0!==
c.length?c[0].aaSorting:k;"number"===typeof a?a=[[a,b]]:a.length&&!h.isArray(a[0])&&(a=Array.prototype.slice.call(arguments));return this.iterator("table",function(b){b.aaSorting=a.slice()})});p("order.listener()",function(a,b,c){return this.iterator("table",function(d){Ma(d,a,b,c)})});p("order.fixed()",function(a){if(!a){var b=this.context,b=b.length?b[0].aaSortingFixed:k;return h.isArray(b)?{pre:b}:b}return this.iterator("table",function(b){b.aaSortingFixed=h.extend(!0,{},a)})});p(["columns().order()",
"column().order()"],function(a){var b=this;return this.iterator("table",function(c,d){var e=[];h.each(b[d],function(b,c){e.push([c,a])});c.aaSorting=e})});p("search()",function(a,b,c,d){var e=this.context;return a===k?0!==e.length?e[0].oPreviousSearch.sSearch:k:this.iterator("table",function(e){e.oFeatures.bFilter&&fa(e,h.extend({},e.oPreviousSearch,{sSearch:a+"",bRegex:null===b?!1:b,bSmart:null===c?!0:c,bCaseInsensitive:null===d?!0:d}),1)})});s("columns().search()","column().search()",function(a,
b,c,d){return this.iterator("column",function(e,f){var g=e.aoPreSearchCols;if(a===k)return g[f].sSearch;e.oFeatures.bFilter&&(h.extend(g[f],{sSearch:a+"",bRegex:null===b?!1:b,bSmart:null===c?!0:c,bCaseInsensitive:null===d?!0:d}),fa(e,e.oPreviousSearch,1))})});p("state()",function(){return this.context.length?this.context[0].oSavedState:null});p("state.clear()",function(){return this.iterator("table",function(a){a.fnStateSaveCallback.call(a.oInstance,a,{})})});p("state.loaded()",function(){return this.context.length?
this.context[0].oLoadedState:null});p("state.save()",function(){return this.iterator("table",function(a){wa(a)})});m.versionCheck=m.fnVersionCheck=function(a){for(var b=m.version.split("."),a=a.split("."),c,d,e=0,f=a.length;e<f;e++)if(c=parseInt(b[e],10)||0,d=parseInt(a[e],10)||0,c!==d)return c>d;return!0};m.isDataTable=m.fnIsDataTable=function(a){var b=h(a).get(0),c=!1;h.each(m.settings,function(a,e){var f=e.nScrollHead?h("table",e.nScrollHead)[0]:null,g=e.nScrollFoot?h("table",e.nScrollFoot)[0]:
null;if(e.nTable===b||f===b||g===b)c=!0});return c};m.tables=m.fnTables=function(a){var b=!1;h.isPlainObject(a)&&(b=a.api,a=a.visible);var c=h.map(m.settings,function(b){if(!a||a&&h(b.nTable).is(":visible"))return b.nTable});return b?new r(c):c};m.camelToHungarian=K;p("$()",function(a,b){var c=this.rows(b).nodes(),c=h(c);return h([].concat(c.filter(a).toArray(),c.find(a).toArray()))});h.each(["on","one","off"],function(a,b){p(b+"()",function(){var a=Array.prototype.slice.call(arguments);a[0].match(/\.dt\b/)||
(a[0]+=".dt");var d=h(this.tables().nodes());d[b].apply(d,a);return this})});p("clear()",function(){return this.iterator("table",function(a){na(a)})});p("settings()",function(){return new r(this.context,this.context)});p("init()",function(){var a=this.context;return a.length?a[0].oInit:null});p("data()",function(){return this.iterator("table",function(a){return G(a.aoData,"_aData")}).flatten()});p("destroy()",function(a){a=a||!1;return this.iterator("table",function(b){var c=b.nTableWrapper.parentNode,
d=b.oClasses,e=b.nTable,f=b.nTBody,g=b.nTHead,j=b.nTFoot,i=h(e),f=h(f),k=h(b.nTableWrapper),l=h.map(b.aoData,function(a){return a.nTr}),p;b.bDestroying=!0;u(b,"aoDestroyCallback","destroy",[b]);a||(new r(b)).columns().visible(!0);k.unbind(".DT").find(":not(tbody *)").unbind(".DT");h(D).unbind(".DT-"+b.sInstance);e!=g.parentNode&&(i.children("thead").detach(),i.append(g));j&&e!=j.parentNode&&(i.children("tfoot").detach(),i.append(j));b.aaSorting=[];b.aaSortingFixed=[];va(b);h(l).removeClass(b.asStripeClasses.join(" "));
h("th, td",g).removeClass(d.sSortable+" "+d.sSortableAsc+" "+d.sSortableDesc+" "+d.sSortableNone);b.bJUI&&(h("th span."+d.sSortIcon+", td span."+d.sSortIcon,g).detach(),h("th, td",g).each(function(){var a=h("div."+d.sSortJUIWrapper,this);h(this).append(a.contents());a.detach()}));f.children().detach();f.append(l);g=a?"remove":"detach";i[g]();k[g]();!a&&c&&(c.insertBefore(e,b.nTableReinsertBefore),i.css("width",b.sDestroyWidth).removeClass(d.sTable),(p=b.asDestroyStripes.length)&&f.children().each(function(a){h(this).addClass(b.asDestroyStripes[a%
p])}));c=h.inArray(b,m.settings);-1!==c&&m.settings.splice(c,1)})});h.each(["column","row","cell"],function(a,b){p(b+"s().every()",function(a){var d=this.selector.opts,e=this;return this.iterator(b,function(f,g,h,i,n){a.call(e[b](g,"cell"===b?h:d,"cell"===b?d:k),g,h,i,n)})})});p("i18n()",function(a,b,c){var d=this.context[0],a=Q(a)(d.oLanguage);a===k&&(a=b);c!==k&&h.isPlainObject(a)&&(a=a[c]!==k?a[c]:a._);return a.replace("%d",c)});m.version="1.10.12";m.settings=[];m.models={};m.models.oSearch={bCaseInsensitive:!0,
sSearch:"",bRegex:!1,bSmart:!0};m.models.oRow={nTr:null,anCells:null,_aData:[],_aSortData:null,_aFilterData:null,_sFilterRow:null,_sRowStripe:"",src:null,idx:-1};m.models.oColumn={idx:null,aDataSort:null,asSorting:null,bSearchable:null,bSortable:null,bVisible:null,_sManualType:null,_bAttrSrc:!1,fnCreatedCell:null,fnGetData:null,fnSetData:null,mData:null,mRender:null,nTh:null,nTf:null,sClass:null,sContentPadding:null,sDefaultContent:null,sName:null,sSortDataType:"std",sSortingClass:null,sSortingClassJUI:null,
sTitle:null,sType:null,sWidth:null,sWidthOrig:null};m.defaults={aaData:null,aaSorting:[[0,"asc"]],aaSortingFixed:[],ajax:null,aLengthMenu:[10,25,50,100],aoColumns:null,aoColumnDefs:null,aoSearchCols:[],asStripeClasses:null,bAutoWidth:!0,bDeferRender:!1,bDestroy:!1,bFilter:!0,bInfo:!0,bJQueryUI:!1,bLengthChange:!0,bPaginate:!0,bProcessing:!1,bRetrieve:!1,bScrollCollapse:!1,bServerSide:!1,bSort:!0,bSortMulti:!0,bSortCellsTop:!1,bSortClasses:!0,bStateSave:!1,fnCreatedRow:null,fnDrawCallback:null,fnFooterCallback:null,
fnFormatNumber:function(a){return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g,this.oLanguage.sThousands)},fnHeaderCallback:null,fnInfoCallback:null,fnInitComplete:null,fnPreDrawCallback:null,fnRowCallback:null,fnServerData:null,fnServerParams:null,fnStateLoadCallback:function(a){try{return JSON.parse((-1===a.iStateDuration?sessionStorage:localStorage).getItem("DataTables_"+a.sInstance+"_"+location.pathname))}catch(b){}},fnStateLoadParams:null,fnStateLoaded:null,fnStateSaveCallback:function(a,b){try{(-1===
a.iStateDuration?sessionStorage:localStorage).setItem("DataTables_"+a.sInstance+"_"+location.pathname,JSON.stringify(b))}catch(c){}},fnStateSaveParams:null,iStateDuration:7200,iDeferLoading:null,iDisplayLength:10,iDisplayStart:0,iTabIndex:0,oClasses:{},oLanguage:{oAria:{sSortAscending:": activate to sort column ascending",sSortDescending:": activate to sort column descending"},oPaginate:{sFirst:"First",sLast:"Last",sNext:"Next",sPrevious:"Previous"},sEmptyTable:"No data available in table",sInfo:"Showing _START_ to _END_ of _TOTAL_ entries",
sInfoEmpty:"Showing 0 to 0 of 0 entries",sInfoFiltered:"(filtered from _MAX_ total entries)",sInfoPostFix:"",sDecimal:"",sThousands:",",sLengthMenu:"Show _MENU_ entries",sLoadingRecords:"Loading...",sProcessing:"Processing...",sSearch:"Search:",sSearchPlaceholder:"",sUrl:"",sZeroRecords:"No matching records found"},oSearch:h.extend({},m.models.oSearch),sAjaxDataProp:"data",sAjaxSource:null,sDom:"lfrtip",searchDelay:null,sPaginationType:"simple_numbers",sScrollX:"",sScrollXInner:"",sScrollY:"",sServerMethod:"GET",
renderer:null,rowId:"DT_RowId"};X(m.defaults);m.defaults.column={aDataSort:null,iDataSort:-1,asSorting:["asc","desc"],bSearchable:!0,bSortable:!0,bVisible:!0,fnCreatedCell:null,mData:null,mRender:null,sCellType:"td",sClass:"",sContentPadding:"",sDefaultContent:null,sName:"",sSortDataType:"std",sTitle:null,sType:null,sWidth:null};X(m.defaults.column);m.models.oSettings={oFeatures:{bAutoWidth:null,bDeferRender:null,bFilter:null,bInfo:null,bLengthChange:null,bPaginate:null,bProcessing:null,bServerSide:null,
bSort:null,bSortMulti:null,bSortClasses:null,bStateSave:null},oScroll:{bCollapse:null,iBarWidth:0,sX:null,sXInner:null,sY:null},oLanguage:{fnInfoCallback:null},oBrowser:{bScrollOversize:!1,bScrollbarLeft:!1,bBounding:!1,barWidth:0},ajax:null,aanFeatures:[],aoData:[],aiDisplay:[],aiDisplayMaster:[],aIds:{},aoColumns:[],aoHeader:[],aoFooter:[],oPreviousSearch:{},aoPreSearchCols:[],aaSorting:null,aaSortingFixed:[],asStripeClasses:null,asDestroyStripes:[],sDestroyWidth:0,aoRowCallback:[],aoHeaderCallback:[],
aoFooterCallback:[],aoDrawCallback:[],aoRowCreatedCallback:[],aoPreDrawCallback:[],aoInitComplete:[],aoStateSaveParams:[],aoStateLoadParams:[],aoStateLoaded:[],sTableId:"",nTable:null,nTHead:null,nTFoot:null,nTBody:null,nTableWrapper:null,bDeferLoading:!1,bInitialised:!1,aoOpenRows:[],sDom:null,searchDelay:null,sPaginationType:"two_button",iStateDuration:0,aoStateSave:[],aoStateLoad:[],oSavedState:null,oLoadedState:null,sAjaxSource:null,sAjaxDataProp:null,bAjaxDataGet:!0,jqXHR:null,json:k,oAjaxData:k,
fnServerData:null,aoServerParams:[],sServerMethod:null,fnFormatNumber:null,aLengthMenu:null,iDraw:0,bDrawing:!1,iDrawError:-1,_iDisplayLength:10,_iDisplayStart:0,_iRecordsTotal:0,_iRecordsDisplay:0,bJUI:null,oClasses:{},bFiltered:!1,bSorted:!1,bSortCellsTop:null,oInit:null,aoDestroyCallback:[],fnRecordsTotal:function(){return"ssp"==y(this)?1*this._iRecordsTotal:this.aiDisplayMaster.length},fnRecordsDisplay:function(){return"ssp"==y(this)?1*this._iRecordsDisplay:this.aiDisplay.length},fnDisplayEnd:function(){var a=
this._iDisplayLength,b=this._iDisplayStart,c=b+a,d=this.aiDisplay.length,e=this.oFeatures,f=e.bPaginate;return e.bServerSide?!1===f||-1===a?b+d:Math.min(b+a,this._iRecordsDisplay):!f||c>d||-1===a?d:c},oInstance:null,sInstance:null,iTabIndex:0,nScrollHead:null,nScrollFoot:null,aLastSort:[],oPlugins:{},rowIdFn:null,rowId:null};m.ext=v={buttons:{},classes:{},builder:"-source-",errMode:"alert",feature:[],search:[],selector:{cell:[],column:[],row:[]},internal:{},legacy:{ajax:null},pager:{},renderer:{pageButton:{},
header:{}},order:{},type:{detect:[],search:{},order:{}},_unique:0,fnVersionCheck:m.fnVersionCheck,iApiIndex:0,oJUIClasses:{},sVersion:m.version};h.extend(v,{afnFiltering:v.search,aTypes:v.type.detect,ofnSearch:v.type.search,oSort:v.type.order,afnSortData:v.order,aoFeatures:v.feature,oApi:v.internal,oStdClasses:v.classes,oPagination:v.pager});h.extend(m.ext.classes,{sTable:"dataTable",sNoFooter:"no-footer",sPageButton:"paginate_button",sPageButtonActive:"current",sPageButtonDisabled:"disabled",sStripeOdd:"odd",
sStripeEven:"even",sRowEmpty:"dataTables_empty",sWrapper:"dataTables_wrapper",sFilter:"dataTables_filter",sInfo:"dataTables_info",sPaging:"dataTables_paginate paging_",sLength:"dataTables_length",sProcessing:"dataTables_processing",sSortAsc:"sorting_asc",sSortDesc:"sorting_desc",sSortable:"sorting",sSortableAsc:"sorting_asc_disabled",sSortableDesc:"sorting_desc_disabled",sSortableNone:"sorting_disabled",sSortColumn:"sorting_",sFilterInput:"",sLengthSelect:"",sScrollWrapper:"dataTables_scroll",sScrollHead:"dataTables_scrollHead",
sScrollHeadInner:"dataTables_scrollHeadInner",sScrollBody:"dataTables_scrollBody",sScrollFoot:"dataTables_scrollFoot",sScrollFootInner:"dataTables_scrollFootInner",sHeaderTH:"",sFooterTH:"",sSortJUIAsc:"",sSortJUIDesc:"",sSortJUI:"",sSortJUIAscAllowed:"",sSortJUIDescAllowed:"",sSortJUIWrapper:"",sSortIcon:"",sJUIHeader:"",sJUIFooter:""});var Ca="",Ca="",H=Ca+"ui-state-default",ia=Ca+"css_right ui-icon ui-icon-",Xb=Ca+"fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix";h.extend(m.ext.oJUIClasses,
m.ext.classes,{sPageButton:"fg-button ui-button "+H,sPageButtonActive:"ui-state-disabled",sPageButtonDisabled:"ui-state-disabled",sPaging:"dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_",sSortAsc:H+" sorting_asc",sSortDesc:H+" sorting_desc",sSortable:H+" sorting",sSortableAsc:H+" sorting_asc_disabled",sSortableDesc:H+" sorting_desc_disabled",sSortableNone:H+" sorting_disabled",sSortJUIAsc:ia+"triangle-1-n",sSortJUIDesc:ia+"triangle-1-s",sSortJUI:ia+"carat-2-n-s",
sSortJUIAscAllowed:ia+"carat-1-n",sSortJUIDescAllowed:ia+"carat-1-s",sSortJUIWrapper:"DataTables_sort_wrapper",sSortIcon:"DataTables_sort_icon",sScrollHead:"dataTables_scrollHead "+H,sScrollFoot:"dataTables_scrollFoot "+H,sHeaderTH:H,sFooterTH:H,sJUIHeader:Xb+" ui-corner-tl ui-corner-tr",sJUIFooter:Xb+" ui-corner-bl ui-corner-br"});var Mb=m.ext.pager;h.extend(Mb,{simple:function(){return["previous","next"]},full:function(){return["first","previous","next","last"]},numbers:function(a,b){return[ya(a,
b)]},simple_numbers:function(a,b){return["previous",ya(a,b),"next"]},full_numbers:function(a,b){return["first","previous",ya(a,b),"next","last"]},_numbers:ya,numbers_length:7});h.extend(!0,m.ext.renderer,{pageButton:{_:function(a,b,c,d,e,f){var g=a.oClasses,j=a.oLanguage.oPaginate,i=a.oLanguage.oAria.paginate||{},k,l,m=0,p=function(b,d){var o,r,u,s,v=function(b){Ta(a,b.data.action,true)};o=0;for(r=d.length;o<r;o++){s=d[o];if(h.isArray(s)){u=h("<"+(s.DT_el||"div")+"/>").appendTo(b);p(u,s)}else{k=null;
l="";switch(s){case "ellipsis":b.append('<span class="ellipsis">&#x2026;</span>');break;case "first":k=j.sFirst;l=s+(e>0?"":" "+g.sPageButtonDisabled);break;case "previous":k=j.sPrevious;l=s+(e>0?"":" "+g.sPageButtonDisabled);break;case "next":k=j.sNext;l=s+(e<f-1?"":" "+g.sPageButtonDisabled);break;case "last":k=j.sLast;l=s+(e<f-1?"":" "+g.sPageButtonDisabled);break;default:k=s+1;l=e===s?g.sPageButtonActive:""}if(k!==null){u=h("<a>",{"class":g.sPageButton+" "+l,"aria-controls":a.sTableId,"aria-label":i[s],
"data-dt-idx":m,tabindex:a.iTabIndex,id:c===0&&typeof s==="string"?a.sTableId+"_"+s:null}).html(k).appendTo(b);Wa(u,{action:s},v);m++}}}},r;try{r=h(b).find(I.activeElement).data("dt-idx")}catch(o){}p(h(b).empty(),d);r&&h(b).find("[data-dt-idx="+r+"]").focus()}}});h.extend(m.ext.type.detect,[function(a,b){var c=b.oLanguage.sDecimal;return Za(a,c)?"num"+c:null},function(a){if(a&&!(a instanceof Date)&&(!ac.test(a)||!bc.test(a)))return null;var b=Date.parse(a);return null!==b&&!isNaN(b)||M(a)?"date":
null},function(a,b){var c=b.oLanguage.sDecimal;return Za(a,c,!0)?"num-fmt"+c:null},function(a,b){var c=b.oLanguage.sDecimal;return Rb(a,c)?"html-num"+c:null},function(a,b){var c=b.oLanguage.sDecimal;return Rb(a,c,!0)?"html-num-fmt"+c:null},function(a){return M(a)||"string"===typeof a&&-1!==a.indexOf("<")?"html":null}]);h.extend(m.ext.type.search,{html:function(a){return M(a)?a:"string"===typeof a?a.replace(Ob," ").replace(Aa,""):""},string:function(a){return M(a)?a:"string"===typeof a?a.replace(Ob,
" "):a}});var za=function(a,b,c,d){if(0!==a&&(!a||"-"===a))return-Infinity;b&&(a=Qb(a,b));a.replace&&(c&&(a=a.replace(c,"")),d&&(a=a.replace(d,"")));return 1*a};h.extend(v.type.order,{"date-pre":function(a){return Date.parse(a)||0},"html-pre":function(a){return M(a)?"":a.replace?a.replace(/<.*?>/g,"").toLowerCase():a+""},"string-pre":function(a){return M(a)?"":"string"===typeof a?a.toLowerCase():!a.toString?"":a.toString()},"string-asc":function(a,b){return a<b?-1:a>b?1:0},"string-desc":function(a,
b){return a<b?1:a>b?-1:0}});db("");h.extend(!0,m.ext.renderer,{header:{_:function(a,b,c,d){h(a.nTable).on("order.dt.DT",function(e,f,g,h){if(a===f){e=c.idx;b.removeClass(c.sSortingClass+" "+d.sSortAsc+" "+d.sSortDesc).addClass(h[e]=="asc"?d.sSortAsc:h[e]=="desc"?d.sSortDesc:c.sSortingClass)}})},jqueryui:function(a,b,c,d){h("<div/>").addClass(d.sSortJUIWrapper).append(b.contents()).append(h("<span/>").addClass(d.sSortIcon+" "+c.sSortingClassJUI)).appendTo(b);h(a.nTable).on("order.dt.DT",function(e,
f,g,h){if(a===f){e=c.idx;b.removeClass(d.sSortAsc+" "+d.sSortDesc).addClass(h[e]=="asc"?d.sSortAsc:h[e]=="desc"?d.sSortDesc:c.sSortingClass);b.find("span."+d.sSortIcon).removeClass(d.sSortJUIAsc+" "+d.sSortJUIDesc+" "+d.sSortJUI+" "+d.sSortJUIAscAllowed+" "+d.sSortJUIDescAllowed).addClass(h[e]=="asc"?d.sSortJUIAsc:h[e]=="desc"?d.sSortJUIDesc:c.sSortingClassJUI)}})}}});var Yb=function(a){return"string"===typeof a?a.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"):a};m.render={number:function(a,
b,c,d,e){return{display:function(f){if("number"!==typeof f&&"string"!==typeof f)return f;var g=0>f?"-":"",h=parseFloat(f);if(isNaN(h))return Yb(f);f=Math.abs(h);h=parseInt(f,10);f=c?b+(f-h).toFixed(c).substring(2):"";return g+(d||"")+h.toString().replace(/\B(?=(\d{3})+(?!\d))/g,a)+f+(e||"")}}},text:function(){return{display:Yb}}};h.extend(m.ext.internal,{_fnExternApiFunc:Nb,_fnBuildAjax:ra,_fnAjaxUpdate:lb,_fnAjaxParameters:ub,_fnAjaxUpdateDraw:vb,_fnAjaxDataSrc:sa,_fnAddColumn:Ea,_fnColumnOptions:ja,
_fnAdjustColumnSizing:Y,_fnVisibleToColumnIndex:Z,_fnColumnIndexToVisible:$,_fnVisbleColumns:aa,_fnGetColumns:la,_fnColumnTypes:Ga,_fnApplyColumnDefs:ib,_fnHungarianMap:X,_fnCamelToHungarian:K,_fnLanguageCompat:Da,_fnBrowserDetect:gb,_fnAddData:N,_fnAddTr:ma,_fnNodeToDataIndex:function(a,b){return b._DT_RowIndex!==k?b._DT_RowIndex:null},_fnNodeToColumnIndex:function(a,b,c){return h.inArray(c,a.aoData[b].anCells)},_fnGetCellData:B,_fnSetCellData:jb,_fnSplitObjNotation:Ja,_fnGetObjectDataFn:Q,_fnSetObjectDataFn:R,
_fnGetDataMaster:Ka,_fnClearTable:na,_fnDeleteIndex:oa,_fnInvalidate:ca,_fnGetRowElements:Ia,_fnCreateTr:Ha,_fnBuildHead:kb,_fnDrawHead:ea,_fnDraw:O,_fnReDraw:T,_fnAddOptionsHtml:nb,_fnDetectHeader:da,_fnGetUniqueThs:qa,_fnFeatureHtmlFilter:pb,_fnFilterComplete:fa,_fnFilterCustom:yb,_fnFilterColumn:xb,_fnFilter:wb,_fnFilterCreateSearch:Pa,_fnEscapeRegex:Qa,_fnFilterData:zb,_fnFeatureHtmlInfo:sb,_fnUpdateInfo:Cb,_fnInfoMacros:Db,_fnInitialise:ga,_fnInitComplete:ta,_fnLengthChange:Ra,_fnFeatureHtmlLength:ob,
_fnFeatureHtmlPaginate:tb,_fnPageChange:Ta,_fnFeatureHtmlProcessing:qb,_fnProcessingDisplay:C,_fnFeatureHtmlTable:rb,_fnScrollDraw:ka,_fnApplyToChildren:J,_fnCalculateColumnWidths:Fa,_fnThrottle:Oa,_fnConvertToWidth:Fb,_fnGetWidestNode:Gb,_fnGetMaxLenString:Hb,_fnStringToCss:x,_fnSortFlatten:V,_fnSort:mb,_fnSortAria:Jb,_fnSortListener:Va,_fnSortAttachListener:Ma,_fnSortingClasses:va,_fnSortData:Ib,_fnSaveState:wa,_fnLoadState:Kb,_fnSettingsFromNode:xa,_fnLog:L,_fnMap:E,_fnBindAction:Wa,_fnCallbackReg:z,
_fnCallbackFire:u,_fnLengthOverflow:Sa,_fnRenderer:Na,_fnDataSource:y,_fnRowAttributes:La,_fnCalculateEnd:function(){}});h.fn.dataTable=m;m.$=h;h.fn.dataTableSettings=m.settings;h.fn.dataTableExt=m.ext;h.fn.DataTable=function(a){return h(this).dataTable(a).api()};h.each(m,function(a,b){h.fn.DataTable[a]=b});return h.fn.dataTable});

/*!
 DataTables Bootstrap 3 integration
 ©2011-2015 SpryMedia Ltd - datatables.net/license
*/
(function(b){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(a){return b(a,window,document)}):"object"===typeof exports?module.exports=function(a,d){a||(a=window);if(!d||!d.fn.dataTable)d=require("datatables.net")(a,d).$;return b(d,a,a.document)}:b(jQuery,window,document)})(function(b,a,d){var f=b.fn.dataTable;b.extend(!0,f.defaults,{dom:"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",renderer:"bootstrap"});b.extend(f.ext.classes,
{sWrapper:"dataTables_wrapper form-inline dt-bootstrap",sFilterInput:"form-control input-sm",sLengthSelect:"form-control input-sm",sProcessing:"dataTables_processing panel panel-default"});f.ext.renderer.pageButton.bootstrap=function(a,h,r,m,j,n){var o=new f.Api(a),s=a.oClasses,k=a.oLanguage.oPaginate,t=a.oLanguage.oAria.paginate||{},e,g,p=0,q=function(d,f){var l,h,i,c,m=function(a){a.preventDefault();!b(a.currentTarget).hasClass("disabled")&&o.page()!=a.data.action&&o.page(a.data.action).draw("page")};
l=0;for(h=f.length;l<h;l++)if(c=f[l],b.isArray(c))q(d,c);else{g=e="";switch(c){case "ellipsis":e="&#x2026;";g="disabled";break;case "first":e=k.sFirst;g=c+(0<j?"":" disabled");break;case "previous":e=k.sPrevious;g=c+(0<j?"":" disabled");break;case "next":e=k.sNext;g=c+(j<n-1?"":" disabled");break;case "last":e=k.sLast;g=c+(j<n-1?"":" disabled");break;default:e=c+1,g=j===c?"active":""}e&&(i=b("<li>",{"class":s.sPageButton+" "+g,id:0===r&&"string"===typeof c?a.sTableId+"_"+c:null}).append(b("<a>",{href:"#",
"aria-controls":a.sTableId,"aria-label":t[c],"data-dt-idx":p,tabindex:a.iTabIndex}).html(e)).appendTo(d),a.oApi._fnBindAction(i,{action:c},m),p++)}},i;try{i=b(h).find(d.activeElement).data("dt-idx")}catch(u){}q(b(h).empty().html('<ul class="pagination"/>').children("ul"),m);i&&b(h).find("[data-dt-idx="+i+"]").focus()};return f});

/*! ColResize 0.0.11
 */

/**
 * @summary     ColResize
 * @description Provide the ability to resize columns in a DataTable
 * @version     0.0.11
 * @file        dataTables.colResize.js
 * @author      Silvacom Ltd.
 *
 * For details please refer to: http://www.datatables.net
 *
 * Special thank to everyone who has contributed to this plug in
 * - dykstrad
 * - tdillan (for 0.0.3 and 0.0.5 bug fixes)
 * - kylealonius (for 0.0.8 bug fix)
 * - the86freak (for 0.0.9 bug fix)
 */

(function (window, document, undefined) {

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * DataTables plug-in API functions test
     *
     * This are required by ColResize in order to perform the tasks required, and also keep this
     * code portable, to be used for other column resize projects with DataTables, if needed.
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    var factory = function ($, DataTable) {
        "use strict";

        /**
         * Plug-in for DataTables which will resize the columns depending on the handle clicked
         *  @method  $.fn.dataTableExt.oApi.fnColResize
         *  @param   object oSettings DataTables settings object - automatically added by DataTables!
         *  @param   int iCol Take the column to be resized
         *  @returns void
         */
        $.fn.dataTableExt.oApi.fnColResize = function (oSettings, iCol) {
            var v110 = $.fn.dataTable.Api ? true : false;

            /*
             * Update DataTables' event handlers
             */

            /* Fire an event so other plug-ins can update */
            $(oSettings.oInstance).trigger('column-resize', [oSettings, {
                "iCol": iCol
            }]);
        };

        /**
         * ColResize provides column resize control for DataTables
         * @class ColResize
         * @constructor
         * @param {object} dt DataTables settings object
         * @param {object} opts ColResize options
         */
        var ColResize = function (dt, opts) {
            var oDTSettings;

            if ($.fn.dataTable.Api) {
                oDTSettings = new $.fn.dataTable.Api(dt).settings()[0];
            }
                // 1.9 compatibility
            else if (dt.fnSettings) {
                // DataTables object, convert to the settings object
                oDTSettings = dt.fnSettings();
            }
            else if (typeof dt === 'string') {
                // jQuery selector
                if ($.fn.dataTable.fnIsDataTable($(dt)[0])) {
                    oDTSettings = $(dt).eq(0).dataTable().fnSettings();
                }
            }
            else if (dt.nodeName && dt.nodeName.toLowerCase() === 'table') {
                // Table node
                if ($.fn.dataTable.fnIsDataTable(dt.nodeName)) {
                    oDTSettings = $(dt.nodeName).dataTable().fnSettings();
                }
            }
            else if (dt instanceof jQuery) {
                // jQuery object
                if ($.fn.dataTable.fnIsDataTable(dt[0])) {
                    oDTSettings = dt.eq(0).dataTable().fnSettings();
                }
            }
            else {
                // DataTables settings object
                oDTSettings = dt;
            }

            // Convert from camelCase to Hungarian, just as DataTables does
            if ($.fn.dataTable.camelToHungarian) {
                $.fn.dataTable.camelToHungarian(ColResize.defaults, opts || {});
            }


            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Public class variables
             * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

            /**
             * @namespace Settings object which contains customizable information for ColResize instance
             */
            this.s = {
                /**
                 * DataTables settings object
                 *  @property dt
                 *  @type     Object
                 *  @default  null
                 */
                "dt": null,

                /**
                 * Initialisation object used for this instance
                 *  @property init
                 *  @type     object
                 *  @default  {}
                 */
                "init": $.extend(true, {}, ColResize.defaults, opts),

                /**
                 * @namespace Information used for the mouse drag
                 */
                "mouse": {
                    "startX": -1,
                    "startY": -1,
                    "targetIndex": -1,
                    "targetColumn": -1,
                    "neighbourIndex": -1,
                    "neighbourColumn": -1
                },

                /**
                 * Status variable keeping track of mouse down status
                 *  @property isMousedown
                 *  @type     boolean
                 *  @default  false
                 */
                "isMousedown": false
            };


            /**
             * @namespace Common and useful DOM elements for the class instance
             */
            this.dom = {
                /**
                 * Resizing element (the one the mouse is resizing)
                 *  @property resize
                 *  @type     element
                 *  @default  null
                 */
                "resizeCol": null,

                /**
                 * Resizing element neighbour (the column next to the one the mouse is resizing)
                 * This is for fixed table resizing.
                 *  @property resize
                 *  @type     element
                 *  @default  null
                 */
                "resizeColNeighbour": null,

                /**
                 *  Array of events to be restored, used for overriding existing events from other plugins for a time.
                 *  @property restoreEvents
                 *  @type     array
                 *  @default  []
                 */
                "restoreEvents": []
            };


            /* Constructor logic */
            this.s.dt = oDTSettings.oInstance.fnSettings();
            this.s.dt._colResize = this;
            this._fnConstruct();

            /* Add destroy callback */
            oDTSettings.oApi._fnCallbackReg(oDTSettings, 'aoDestroyCallback', $.proxy(this._fnDestroy, this), 'ColResize');

            return this;
        };


        ColResize.prototype = {
            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Public methods
             * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

            /**
             * Reset the column widths to the original widths that was detected on
             * start up.
             *  @return {this} Returns `this` for chaining.
             *
             *  @example
             *    // DataTables initialisation with ColResize
             *    var table = $('#example').dataTable( {
             *        "sDom": 'Zlfrtip'
             *    } );
             *
             *    // Add click event to a button to reset the ordering
             *    $('#resetOrdering').click( function (e) {
             *        e.preventDefault();
             *        $.fn.dataTable.ColResize( table ).fnReset();
             *    } );
             */
            "fnReset": function () {
                var a = [];
                for (var i = 0, iLen = this.s.dt.aoColumns.length; i < iLen; i++) {
                    this.s.dt.aoColumns[i].width = this.s.dt.aoColumns[i]._ColResize_iOrigWidth;
                }

                this.s.dt.adjust().draw();

                return this;
            },


            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Private methods (they are of course public in JS, but recommended as private)
             * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

            /**
             * Constructor logic
             *  @method  _fnConstruct
             *  @returns void
             *  @private
             */
            "_fnConstruct": function () {
                var that = this;
                var iLen = that.s.dt.aoColumns.length;
                var i;

                that._fnSetupMouseListeners();

                /* Add event handlers for the resize handles */
                for (i = 0; i < iLen; i++) {
                    /* Mark the original column width for later reference */
                    this.s.dt.aoColumns[i]._ColResize_iOrigWidth = this.s.dt.aoColumns[i].width;
                }

                this._fnSetColumnIndexes();

                /* State saving */
                this.s.dt.oApi._fnCallbackReg(this.s.dt, 'aoStateSaveParams', function (oS, oData) {
                    that._fnStateSave.call(that, oData);
                }, "ColResize_State");

                // State loading
                this._fnStateLoad();
            },

            /**
             * @method  _fnStateSave
             * @param   object oState DataTables state
             * @private
             */
            "_fnStateSave": function (oState) {
                this.s.dt.aoColumns.forEach(function (col, index) {
                    oState.columns[index].width = col.sWidthOrig;
                });
            },

            /**
             * If state has been loaded, apply the saved widths to the columns
             * @method  _fnStateLoad
             * @private
             */
            "_fnStateLoad": function () {
                var that = this,
                    loadedState = this.s.dt.oLoadedState;
                if (loadedState && loadedState.columns) {
                    var colStates = loadedState.columns,
                        currCols = this.s.dt.aoColumns;
                    // Only apply the saved widths if the number of columns is the same.
                    // Otherwise, we don't know if we're applying the width to the correct column.
                    if (colStates.length > 0 && colStates.length === currCols.length) {
                        colStates.forEach(function (state, index) {
                            var col = that.s.dt.aoColumns[index];
                            if (state.width) {
                                col.sWidthOrig = col.sWidth = state.width;
                            }
                        });
                    }
                }
            },

            /**
             * Remove events of type from obj add it to restoreEvents array to be restored at a later time
             * @param until string flag when to restore the event
             * @param obj Object to remove events from
             * @param type type of event to remove
             * @param namespace namespace of the event being removed
             */
            "_fnDelayEvents": function (until, obj, type, namespace) {
                var that = this;
                //Get the events for the object
                var events = $._data($(obj).get(0), 'events');
                $.each(events, function (i, o) {
                    //If the event type matches
                    if (i == type) {
                        //Loop through the possible many events with that type
                        $.each(o, function (k, v) {
                            //Somehow it is possible for the event to be undefined make sure it is defined first
                            if (v) {
                                if (namespace) {
                                    //Add the event to the array of events to be restored later
                                    that.dom.restoreEvents.push({ "until": until, "obj": obj, "type": v.type, "namespace": v.namespace, "handler": v.handler });
                                    //If the namespace matches
                                    if (v.namespace == namespace) {
                                        //Turn off/unbind the event
                                        $(obj).off(type + "." + namespace);
                                    }
                                } else {
                                    //Add the event to the array of events to be restored later
                                    that.dom.restoreEvents.push({ "until": until, "obj": obj, "type": v.type, "namespace": null, "handler": v.handler });
                                    //Turn off/unbind the event
                                    $(obj).off(type);
                                }
                            }
                        });
                    }
                });
            },

            /**
             * Loop through restoreEvents array and restore the events on the elements provided
             */
            "_fnRestoreEvents": function (until) {
                var that = this;
                //Loop through the events to be restored
                var i;
                for (i = that.dom.restoreEvents.length; i--;) {
                    if (that.dom.restoreEvents[i].until == undefined || that.dom.restoreEvents[i].until == null || that.dom.restoreEvents[i].until == until) {
                        if (that.dom.restoreEvents[i].namespace) {
                            //Turn on the event for the object provided
                            $(that.dom.restoreEvents[i].obj).off(that.dom.restoreEvents[i].type + "." + that.dom.restoreEvents[i].namespace).on(that.dom.restoreEvents[i].type + "." + that.dom.restoreEvents[i].namespace, that.dom.restoreEvents[i].handler);
                            that.dom.restoreEvents.splice(i, 1);
                        } else {
                            //Turn on the event for the object provided
                            $(that.dom.restoreEvents[i].obj).off(that.dom.restoreEvents[i].type).on(that.dom.restoreEvents[i].type, that.dom.restoreEvents[i].handler);
                            that.dom.restoreEvents.splice(i, 1);
                        }
                    }
                }
            },

            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Mouse drop and drag
             */

            "_fnSetupMouseListeners": function () {
                var that = this;
                $(that.s.dt.nTableWrapper).off("mouseenter.ColResize").on("mouseenter.ColResize", "th", function (e) {
                    e.preventDefault();
                    that._fnMouseEnter.call(that, e, this);
                });
                $(that.s.dt.nTableWrapper).off("mouseleave.ColResize").on("mouseleave.ColResize", "th", function (e) {
                    e.preventDefault();
                    that._fnMouseLeave.call(that, e, this);
                });
            },

            /**
             * Add mouse listeners to the resize handle on TH element
             *  @method  _fnMouseListener
             *  @param   i Column index
             *  @param   nTh TH resize handle element clicked on
             *  @returns void
             *  @private
             */
            "_fnMouseListener": function (i, nTh) {
                var that = this;
                $(nTh).off('mouseenter.ColResize').on('mouseenter.ColResize', function (e) {
                    e.preventDefault();
                    that._fnMouseEnter.call(that, e, nTh);
                });
                $(nTh).off('mouseleave.ColResize').on('mouseleave.ColResize', function (e) {
                    e.preventDefault();
                    that._fnMouseLeave.call(that, e, nTh);
                });
            },

            /**
             *
             * @param e Mouse event
             * @param nTh TH element that the mouse is over
             */
            "_fnMouseEnter": function (e, nTh) {
                var that = this;
                if (!that.s.isMousedown) {
                    //Once the mouse has entered the cell add mouse move event to see if the mouse is over resize handle
                    $(nTh).off('mousemove.ColResizeHandle').on('mousemove.ColResizeHandle', function (e) {
                        e.preventDefault();
                        that._fnResizeHandleCheck.call(that, e, nTh);
                    });
                }
            },

            /**
             * Clear mouse events when the mouse has left the th
             * @param e Mouse event
             * @param nTh TH element that the mouse has just left
             */
            "_fnMouseLeave": function (e, nTh) {
                //Once the mouse has left the TH make suure to remove the mouse move listener
                $(nTh).off('mousemove.ColResizeHandle');
            },

            /**
             * Mouse down on a TH element in the table header
             *  @method  _fnMouseDown
             *  @param   event e Mouse event
             *  @param   element nTh TH element to be resized
             *  @returns void
             *  @private
             */
            "_fnMouseDown": function (e, nTh) {
                var that = this;

                that.s.isMousedown = true;

                /* Store information about the mouse position */
                var target = $(e.target).closest('th, td');
                var offset = target.offset();

                /* Store information about the mouse position for resize calculations in mouse move function */
                this.s.mouse.startX = e.pageX;
                this.s.mouse.startY = e.pageY;

                //Store the indexes of the columns the mouse is down on
                var idx = parseInt(that.dom.resizeCol.attr("data-column-index"));
                
                // the last column has no 'right-side' neighbour
                // with fixed this can make the table smaller
                if (that.dom.resizeColNeighbour[0] === undefined) {
                    var idxNeighbour = 0;
                } else {
                    var idxNeighbour = parseInt(that.dom.resizeColNeighbour.attr("data-column-index"));
                }

                if (idx === undefined) {
                    return;
                }

                this.s.mouse.targetIndex = idx;
                this.s.mouse.targetColumn = this.s.dt.aoColumns[idx];

                this.s.mouse.neighbourIndex = idxNeighbour;
                this.s.mouse.neighbourColumn = this.s.dt.aoColumns[idxNeighbour];

                /* Add event handlers to the document */
                $(document)
                    .off('mousemove.ColResize').on('mousemove.ColResize', function (e) {
                        that._fnMouseMove.call(that, e);
                    })
                    .off('mouseup.ColResize').on('mouseup.ColResize', function (e) {
                        that._fnMouseUp.call(that, e);
                    });
            },

            /**
             * Deal with a mouse move event while dragging to resize a column
             *  @method  _fnMouseMove
             *  @param   e Mouse event
             *  @returns void
             *  @private
             */
            "_fnMouseMove": function (e) {
                var that = this;

                var offset = $(that.s.mouse.targetColumn.nTh).offset();
                var relativeX = (e.pageX - offset.left);
                var distFromLeft = relativeX;
                var distFromRight = $(that.s.mouse.targetColumn.nTh).outerWidth() - relativeX - 1;

                //Change in mouse x position
                var dx = e.pageX - that.s.mouse.startX;
                //Get the minimum width of the column (default minimum 10px)
                var minColumnWidth = Math.max(parseInt($(that.s.mouse.targetColumn.nTh).css('min-width')), 10);
                //Store the previous width of the column
                var prevWidth = $(that.s.mouse.targetColumn.nTh).width();
                //As long as the cursor is past the handle, resize the columns
                if ((dx > 0 && distFromRight <= 0) || (dx < 0 && distFromRight >= 0)) {
                    if (!that.s.init.tableWidthFixed) {
                        //As long as the width is larger than the minimum
                        var newColWidth = Math.max(minColumnWidth, prevWidth + dx);
                        //Get the width difference (take into account the columns minimum width)
                        var widthDiff = newColWidth - prevWidth;
                        var colResizeIdx = parseInt(that.dom.resizeCol.attr("data-column-index"));
                        //Set datatable column widths
                        that.s.mouse.targetColumn.sWidthOrig = that.s.mouse.targetColumn.sWidth = that.s.mouse.targetColumn.width = newColWidth + "px";
                        var domCols = $(that.s.dt.nTableWrapper).find("th[data-column-index='" + colResizeIdx + "']");
                        //For each table expand the width by the same amount as the column
                        //This accounts for other datatable plugins like FixedColumns
                        domCols.parents("table").each(function () {
                            if (!$(this).parent().hasClass("DTFC_LeftBodyLiner")) {
                                var newWidth = $(this).width() + widthDiff;
                                $(this).width(newWidth);
                            } else {
                                var newWidth = $(that.s.dt.nTableWrapper).find(".DTFC_LeftHeadWrapper").children("table").width();
                                $(this).parents(".DTFC_LeftWrapper").width(newWidth);
                                $(this).parent().width(newWidth + 15);
                                $(this).width(newWidth);
                            }
                        });
                        //Apply the new width to the columns after the table has been resized
                        domCols.width(that.s.mouse.targetColumn.width);
                    } else {
                        //A neighbour column must exist in order to resize a column in a table with a fixed width
                        if (that.s.mouse.neighbourColumn) {
                            //Get the minimum width of the neighbor column (default minimum 10px)
                            var minColumnNeighbourWidth = Math.max(parseInt($(that.s.mouse.neighbourColumn.nTh).css('min-width')), 10);
                            //Store the previous width of the neighbour column
                            var prevNeighbourWidth = $(that.s.mouse.neighbourColumn.nTh).width();
                            //As long as the width is larger than the minimum
                            var newColWidth = Math.max(minColumnWidth, prevWidth + dx);
                            var newColNeighbourWidth = Math.max(minColumnNeighbourWidth, prevNeighbourWidth - dx);
                            //Get the width difference (take into account the columns minimum width)
                            var widthDiff = newColWidth - prevWidth;
                            var widthDiffNeighbour = newColNeighbourWidth - prevNeighbourWidth;
                            //Get the column index for the column being changed
                            var colResizeIdx = parseInt(that.dom.resizeCol.attr("data-column-index"));
                            var neighbourColResizeIdx = parseInt(that.dom.resizeColNeighbour.attr("data-column-index"));
                            //Set datatable column widths
                            that.s.mouse.neighbourColumn.sWidthOrig = that.s.mouse.neighbourColumn.sWidth = that.s.mouse.neighbourColumn.width = newColNeighbourWidth + "px";
                            that.s.mouse.targetColumn.sWidthOrig = that.s.mouse.targetColumn.sWidth = that.s.mouse.targetColumn.width = newColWidth + "px";
                            //Get list of columns based on column index in all affected tables tables. This accounts for other plugins like FixedColumns
                            var domNeighbourCols = $(that.s.dt.nTableWrapper).find("th[data-column-index='" + neighbourColResizeIdx + "']");
                            var domCols = $(that.s.dt.nTableWrapper).find("th[data-column-index='" + colResizeIdx + "']");
                            //If dx if positive (the width is getting larger) shrink the neighbour columns first
                            if (dx > 0) {
                                domNeighbourCols.width(that.s.mouse.neighbourColumn.width);
                                domCols.width(that.s.mouse.targetColumn.width);
                            } else {
                                //Apply the new width to the columns then to the neighbour columns
                                domCols.width(that.s.mouse.targetColumn.width);
                                domNeighbourCols.width(that.s.mouse.neighbourColumn.width);
                            }
                        }
                    }
                }
                that.s.mouse.startX = e.pageX;
            },

            /**
             * Check to see if the mouse is over the resize handle area
             * @param e
             * @param nTh
             */
            "_fnResizeHandleCheck": function (e, nTh) {
                var that = this;

                var offset = $(nTh).offset();
                var relativeX = (e.pageX - offset.left);
                var relativeY = (e.pageY - offset.top);
                var distFromLeft = relativeX;
                var distFromRight = $(nTh).outerWidth() - relativeX - 1;

                var handleBuffer = this.s.init.handleWidth / 2;
                var leftHandleOn = distFromLeft < handleBuffer;
                var rightHandleOn = distFromRight < handleBuffer;

                //If this is the first table cell
                if ($(nTh).prev("th").length == 0) {
                    if (this.s.init.rtl)
                        rightHandleOn = false;
                    else
                        leftHandleOn = false;
                }
                //If this is the last cell and the table is fixed width don't let them expand the last cell directly
                if ($(nTh).next("th").length == 0 && this.s.init.tableWidthFixed) {
                    if (this.s.init.rtl)
                        leftHandleOn = false;
                    else
                        rightHandleOn = false;
                }

                var resizeAvailable = leftHandleOn || rightHandleOn;

                //If table is in right to left mode flip which TH is being resized
                if (that.s.init.rtl) {
                    //Handle is to the left
                    if (leftHandleOn) {
                        that.dom.resizeCol = $(nTh);
                        that.dom.resizeColNeighbour = $(nTh).next();
                    } else if (rightHandleOn) {
                        that.dom.resizeCol = $(nTh).prev();
                        that.dom.resizeColNeighbour = $(nTh);
                    }
                } else {
                    //Handle is to the right
                    if (rightHandleOn) {
                        that.dom.resizeCol = $(nTh);
                        that.dom.resizeColNeighbour = $(nTh).next();
                    } else if (leftHandleOn) {
                        that.dom.resizeCol = $(nTh).prev();
                        that.dom.resizeColNeighbour = $(nTh);
                    }
                }

                //If table width is fixed make sure both columns are resizable else just check the one.
                if (this.s.init.tableWidthFixed)
                    resizeAvailable &= this.s.init.exclude.indexOf(parseInt($(that.dom.resizeCol).attr("data-column-index"))) == -1 && this.s.init.exclude.indexOf(parseInt($(that.dom.resizeColNeighbour).attr("data-column-index"))) == -1;
                else
                    resizeAvailable &= this.s.init.exclude.indexOf(parseInt($(that.dom.resizeCol).attr("data-column-index"))) == -1;

                $(nTh).off('mousedown.ColResize');
                if (resizeAvailable) {
                    $(nTh).css("cursor", "ew-resize");

                    //Delay other mousedown events from the Reorder plugin
                    that._fnDelayEvents(null, nTh, "mousedown", "ColReorder");
                    that._fnDelayEvents("click", nTh, "click", "DT");

                    $(nTh).off('mousedown.ColResize').on('mousedown.ColResize', function (e) {
                        e.preventDefault();
                        that._fnMouseDown.call(that, e, nTh);
                    })
                        .off('click.ColResize').on('click.ColResize', function (e) {
                            that._fnClick.call(that, e);
                        });
                } else {
                    $(nTh).css("cursor", "pointer");
                    $(nTh).off('mousedown.ColResize click.ColResize');
                    //Restore any events that were removed
                    that._fnRestoreEvents();
                    //This is to restore column sorting on click functionality
                    if (!that.s.isMousedown)
                        //Restore click event if mouse is not down
                        this._fnRestoreEvents("click");
                }
            },

            "_fnClick": function (e) {
                var that = this;
                that.s.isMousedown = false;
                e.stopImmediatePropagation();
            },

            /**
             * Finish off the mouse drag
             *  @method  _fnMouseUp
             *  @param   e Mouse event
             *  @returns void
             *  @private
             */
            "_fnMouseUp": function (e) {
                var that = this;
                that.s.isMousedown = false;

                //Fix width of column to be the size the dom is limited to (for when user sets min-width on a column)
                that.s.mouse.targetColumn.width = that.dom.resizeCol.width();

                $(document).off('mousemove.ColResize mouseup.ColResize');
                // this.s.dt.oInstance.fnAdjustColumnSizing();
                //Table width fix, prevents extra gaps between tables
                var LeftWrapper = $(that.s.dt.nTableWrapper).find(".DTFC_LeftWrapper");
                var DTFC_LeftWidth = LeftWrapper.width();
                LeftWrapper.children(".DTFC_LeftHeadWrapper").children("table").width(DTFC_LeftWidth);

                if (that.s.init.resizeCallback) {
                    that.s.init.resizeCallback.call(that, that.s.mouse.targetColumn);
                }
            },

            /**
             * Clean up ColResize memory references and event handlers
             *  @method  _fnDestroy
             *  @returns void
             *  @private
             */
            "_fnDestroy": function () {
                var i, iLen;

                for (i = 0, iLen = this.s.dt.aoDrawCallback.length; i < iLen; i++) {
                    if (this.s.dt.aoDrawCallback[i].sName === 'ColResize_Pre') {
                        this.s.dt.aoDrawCallback.splice(i, 1);
                        break;
                    }
                }

                $(this.s.dt.nTHead).find('*').off('.ColResize');

                $.each(this.s.dt.aoColumns, function (i, column) {
                    $(column.nTh).removeAttr('data-column-index');
                });

                this.s.dt._colResize = null;
                this.s = null;
            },


            /**
             * Add a data attribute to the column headers, so we know the index of
             * the row to be reordered. This allows fast detection of the index, and
             * for this plug-in to work with FixedHeader which clones the nodes.
             *  @private
             */
            "_fnSetColumnIndexes": function () {
                $.each(this.s.dt.aoColumns, function (i, column) {
                    $(column.nTh).attr('data-column-index', i);
                });
            }
        };


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Static parameters
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


        /**
         * ColResize default settings for initialisation
         *  @namespace
         *  @static
         */
        ColResize.defaults = {
            /**
             * Callback function that is fired when columns are resized
             *  @type function():void
             *  @default null
             *  @static
             */
            "resizeCallback": null,

            /**
             * Exclude array for columns that are not resizable
             *  @property exclude
             *  @type     array of indexes that are excluded from resizing
             *  @default  []
             */
            "exclude": [],

            /**
             * Check to see if user is using a fixed table width or dynamic
             * if true:
             *      -Columns will resize themselves and their neighbour
             *      -If neighbour is excluded resize will not occur
             * if false:
             *      -Columns will resize themselves and increase or decrease the width of the table accordingly
             */
            "tableWidthFixed": true,

            /**
             * Width of the resize handle in pixels
             *  @property handleWidth
             *  @type     int (pixels)
             *  @default  10
             */
            "handleWidth": 10,

            /**
             * Right to left support, when true flips which column they are resizing on mouse down
             *  @property rtl
             *  @type     bool
             *  @default  false
             */
            "rtl": false
        };


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Constants
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        /**
         * ColResize version
         *  @constant  version
         *  @type      String
         *  @default   As code
         */
        ColResize.version = "0.0.11";


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * DataTables interfaces
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Expose
        $.fn.dataTable.ColResize = ColResize;
        $.fn.DataTable.ColResize = ColResize;


        // Register a new feature with DataTables
        if (typeof $.fn.dataTable == "function" &&
            typeof $.fn.dataTableExt.fnVersionCheck == "function" &&
            $.fn.dataTableExt.fnVersionCheck('1.9.3')) {
            $.fn.dataTableExt.aoFeatures.push({
                "fnInit": function (settings) {
                    var table = settings.oInstance;

                    if (!settings._colResize) {
                        var dtInit = settings.oInit;
                        var opts = dtInit.colResize || dtInit.oColResize || {};

                        new ColResize(settings, opts);
                    }
                    else {
                        table.oApi._fnLog(settings, 1, "ColResize attempted to initialise twice. Ignoring second");
                    }

                    return null;
                    /* No node for DataTables to insert */
                },
                "cFeature": "Z",
                "sFeature": "ColResize"
            });
        } else {
            alert("Warning: ColResize requires DataTables 1.9.3 or greater - www.datatables.net/download");
        }


        // API augmentation
        if ($.fn.dataTable.Api) {
            $.fn.dataTable.Api.register('colResize.reset()', function () {
                return this.iterator('table', function (ctx) {
                    ctx._colResize.fnReset();
                });
            });
        }

        return ColResize;
    }; // /factory


    // Define as an AMD module if possible
    if (typeof define === 'function' && define.amd) {
        define(['jquery', 'datatables'], factory);
    }
    else if (typeof exports === 'object') {
        // Node/CommonJS
        factory(require('jquery'), require('datatables'));
    }
    else if (jQuery && !jQuery.fn.dataTable.ColResize) {
        // Otherwise simply initialise as normal, stopping multiple evaluation
        factory(jQuery, jQuery.fn.dataTable);
    }


})(window, document);

/*!
 * jQuery Form Plugin
 * version: 3.51.0-2014.06.20
 * Requires jQuery v1.5 or later
 * Copyright (c) 2014 M. Alsup
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Project repository: https://github.com/malsup/form
 * Dual licensed under the MIT and GPL licenses.
 * https://github.com/malsup/form#copyright-and-license
 */
/*global ActiveXObject */

// AMD support
(function (factory) {
    "use strict";
    if (typeof define === 'function' && define.amd) {
        // using AMD; register as anon module
        define(['jquery'], factory);
    } else {
        // no AMD; invoke directly
        factory( (typeof(jQuery) != 'undefined') ? jQuery : window.Zepto );
    }
}

(function($) {
"use strict";

/*
    Usage Note:
    -----------
    Do not use both ajaxSubmit and ajaxForm on the same form.  These
    functions are mutually exclusive.  Use ajaxSubmit if you want
    to bind your own submit handler to the form.  For example,

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // <-- important
            $(this).ajaxSubmit({
                target: '#output'
            });
        });
    });

    Use ajaxForm when you want the plugin to manage all the event binding
    for you.  For example,

    $(document).ready(function() {
        $('#myForm').ajaxForm({
            target: '#output'
        });
    });

    You can also use ajaxForm with delegation (requires jQuery v1.7+), so the
    form does not have to exist when you invoke ajaxForm:

    $('#myForm').ajaxForm({
        delegation: true,
        target: '#output'
    });

    When using ajaxForm, the ajaxSubmit function will be invoked for you
    at the appropriate time.
*/

/**
 * Feature detection
 */
var feature = {};
feature.fileapi = $("<input type='file'/>").get(0).files !== undefined;
feature.formdata = window.FormData !== undefined;

var hasProp = !!$.fn.prop;

// attr2 uses prop when it can but checks the return type for
// an expected string.  this accounts for the case where a form 
// contains inputs with names like "action" or "method"; in those
// cases "prop" returns the element
$.fn.attr2 = function() {
    if ( ! hasProp ) {
        return this.attr.apply(this, arguments);
    }
    var val = this.prop.apply(this, arguments);
    if ( ( val && val.jquery ) || typeof val === 'string' ) {
        return val;
    }
    return this.attr.apply(this, arguments);
};

/**
 * ajaxSubmit() provides a mechanism for immediately submitting
 * an HTML form using AJAX.
 */
$.fn.ajaxSubmit = function(options) {
    /*jshint scripturl:true */

    // fast fail if nothing selected (http://dev.jquery.com/ticket/2752)
    if (!this.length) {
        log('ajaxSubmit: skipping submit process - no element selected');
        return this;
    }

    var method, action, url, $form = this;

    if (typeof options == 'function') {
        options = { success: options };
    }
    else if ( options === undefined ) {
        options = {};
    }

    method = options.type || this.attr2('method');
    action = options.url  || this.attr2('action');

    url = (typeof action === 'string') ? $.trim(action) : '';
    url = url || window.location.href || '';
    if (url) {
        // clean url (don't include hash vaue)
        url = (url.match(/^([^#]+)/)||[])[1];
    }

    options = $.extend(true, {
        url:  url,
        success: $.ajaxSettings.success,
        type: method || $.ajaxSettings.type,
        iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank'
    }, options);

    // hook for manipulating the form data before it is extracted;
    // convenient for use with rich editors like tinyMCE or FCKEditor
    var veto = {};
    this.trigger('form-pre-serialize', [this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
        return this;
    }

    // provide opportunity to alter form data before it is serialized
    if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSerialize callback');
        return this;
    }

    var traditional = options.traditional;
    if ( traditional === undefined ) {
        traditional = $.ajaxSettings.traditional;
    }

    var elements = [];
    var qx, a = this.formToArray(options.semantic, elements);
    if (options.data) {
        options.extraData = options.data;
        qx = $.param(options.data, traditional);
    }

    // give pre-submit callback an opportunity to abort the submit
    if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSubmit callback');
        return this;
    }

    // fire vetoable 'validate' event
    this.trigger('form-submit-validate', [a, this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
        return this;
    }

    var q = $.param(a, traditional);
    if (qx) {
        q = ( q ? (q + '&' + qx) : qx );
    }
    if (options.type.toUpperCase() == 'GET') {
        options.url += (options.url.indexOf('?') >= 0 ? '&' : '?') + q;
        options.data = null;  // data is null for 'get'
    }
    else {
        options.data = q; // data is the query string for 'post'
    }

    var callbacks = [];
    if (options.resetForm) {
        callbacks.push(function() { $form.resetForm(); });
    }
    if (options.clearForm) {
        callbacks.push(function() { $form.clearForm(options.includeHidden); });
    }

    // perform a load on the target only if dataType is not provided
    if (!options.dataType && options.target) {
        var oldSuccess = options.success || function(){};
        callbacks.push(function(data) {
            var fn = options.replaceTarget ? 'replaceWith' : 'html';
            $(options.target)[fn](data).each(oldSuccess, arguments);
        });
    }
    else if (options.success) {
        callbacks.push(options.success);
    }

    options.success = function(data, status, xhr) { // jQuery 1.4+ passes xhr as 3rd arg
        var context = options.context || this ;    // jQuery 1.4+ supports scope context
        for (var i=0, max=callbacks.length; i < max; i++) {
            callbacks[i].apply(context, [data, status, xhr || $form, $form]);
        }
    };

    if (options.error) {
        var oldError = options.error;
        options.error = function(xhr, status, error) {
            var context = options.context || this;
            oldError.apply(context, [xhr, status, error, $form]);
        };
    }

     if (options.complete) {
        var oldComplete = options.complete;
        options.complete = function(xhr, status) {
            var context = options.context || this;
            oldComplete.apply(context, [xhr, status, $form]);
        };
    }

    // are there files to upload?

    // [value] (issue #113), also see comment:
    // https://github.com/malsup/form/commit/588306aedba1de01388032d5f42a60159eea9228#commitcomment-2180219
    var fileInputs = $('input[type=file]:enabled', this).filter(function() { return $(this).val() !== ''; });

    var hasFileInputs = fileInputs.length > 0;
    var mp = 'multipart/form-data';
    var multipart = ($form.attr('enctype') == mp || $form.attr('encoding') == mp);

    var fileAPI = feature.fileapi && feature.formdata;
    log("fileAPI :" + fileAPI);
    var shouldUseFrame = (hasFileInputs || multipart) && !fileAPI;

    var jqxhr;

    // options.iframe allows user to force iframe mode
    // 06-NOV-09: now defaulting to iframe mode if file input is detected
    if (options.iframe !== false && (options.iframe || shouldUseFrame)) {
        // hack to fix Safari hang (thanks to Tim Molendijk for this)
        // see:  http://groups.google.com/group/jquery-dev/browse_thread/thread/36395b7ab510dd5d
        if (options.closeKeepAlive) {
            $.get(options.closeKeepAlive, function() {
                jqxhr = fileUploadIframe(a);
            });
        }
        else {
            jqxhr = fileUploadIframe(a);
        }
    }
    else if ((hasFileInputs || multipart) && fileAPI) {
        jqxhr = fileUploadXhr(a);
    }
    else {
        jqxhr = $.ajax(options);
    }

    $form.removeData('jqxhr').data('jqxhr', jqxhr);

    // clear element array
    for (var k=0; k < elements.length; k++) {
        elements[k] = null;
    }

    // fire 'notify' event
    this.trigger('form-submit-notify', [this, options]);
    return this;

    // utility fn for deep serialization
    function deepSerialize(extraData){
        var serialized = $.param(extraData, options.traditional).split('&');
        var len = serialized.length;
        var result = [];
        var i, part;
        for (i=0; i < len; i++) {
            // #252; undo param space replacement
            serialized[i] = serialized[i].replace(/\+/g,' ');
            part = serialized[i].split('=');
            // #278; use array instead of object storage, favoring array serializations
            result.push([decodeURIComponent(part[0]), decodeURIComponent(part[1])]);
        }
        return result;
    }

     // XMLHttpRequest Level 2 file uploads (big hat tip to francois2metz)
    function fileUploadXhr(a) {
        var formdata = new FormData();

        for (var i=0; i < a.length; i++) {
            formdata.append(a[i].name, a[i].value);
        }

        if (options.extraData) {
            var serializedData = deepSerialize(options.extraData);
            for (i=0; i < serializedData.length; i++) {
                if (serializedData[i]) {
                    formdata.append(serializedData[i][0], serializedData[i][1]);
                }
            }
        }

        options.data = null;

        var s = $.extend(true, {}, $.ajaxSettings, options, {
            contentType: false,
            processData: false,
            cache: false,
            type: method || 'POST'
        });

        if (options.uploadProgress) {
            // workaround because jqXHR does not expose upload property
            s.xhr = function() {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position; /*event.position is deprecated*/
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        options.uploadProgress(event, position, total, percent);
                    }, false);
                }
                return xhr;
            };
        }

        s.data = null;
        var beforeSend = s.beforeSend;
        s.beforeSend = function(xhr, o) {
            //Send FormData() provided by user
            if (options.formData) {
                o.data = options.formData;
            }
            else {
                o.data = formdata;
            }
            if(beforeSend) {
                beforeSend.call(this, xhr, o);
            }
        };
        return $.ajax(s);
    }

    // private function for handling file uploads (hat tip to YAHOO!)
    function fileUploadIframe(a) {
        var form = $form[0], el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle;
        var deferred = $.Deferred();

        // #341
        deferred.abort = function(status) {
            xhr.abort(status);
        };

        if (a) {
            // ensure that every serialized input is still enabled
            for (i=0; i < elements.length; i++) {
                el = $(elements[i]);
                if ( hasProp ) {
                    el.prop('disabled', false);
                }
                else {
                    el.removeAttr('disabled');
                }
            }
        }

        s = $.extend(true, {}, $.ajaxSettings, options);
        s.context = s.context || s;
        id = 'jqFormIO' + (new Date().getTime());
        if (s.iframeTarget) {
            $io = $(s.iframeTarget);
            n = $io.attr2('name');
            if (!n) {
                $io.attr2('name', id);
            }
            else {
                id = n;
            }
        }
        else {
            $io = $('<iframe name="' + id + '" src="'+ s.iframeSrc +'" />');
            $io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
        }
        io = $io[0];


        xhr = { // mock object
            aborted: 0,
            responseText: null,
            responseXML: null,
            status: 0,
            statusText: 'n/a',
            getAllResponseHeaders: function() {},
            getResponseHeader: function() {},
            setRequestHeader: function() {},
            abort: function(status) {
                var e = (status === 'timeout' ? 'timeout' : 'aborted');
                log('aborting upload... ' + e);
                this.aborted = 1;

                try { // #214, #257
                    if (io.contentWindow.document.execCommand) {
                        io.contentWindow.document.execCommand('Stop');
                    }
                }
                catch(ignore) {}

                $io.attr('src', s.iframeSrc); // abort op in progress
                xhr.error = e;
                if (s.error) {
                    s.error.call(s.context, xhr, e, status);
                }
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, e]);
                }
                if (s.complete) {
                    s.complete.call(s.context, xhr, e);
                }
            }
        };

        g = s.global;
        // trigger ajax global events so that activity/block indicators work like normal
        if (g && 0 === $.active++) {
            $.event.trigger("ajaxStart");
        }
        if (g) {
            $.event.trigger("ajaxSend", [xhr, s]);
        }

        if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) {
            if (s.global) {
                $.active--;
            }
            deferred.reject();
            return deferred;
        }
        if (xhr.aborted) {
            deferred.reject();
            return deferred;
        }

        // add submitting element to data if we know it
        sub = form.clk;
        if (sub) {
            n = sub.name;
            if (n && !sub.disabled) {
                s.extraData = s.extraData || {};
                s.extraData[n] = sub.value;
                if (sub.type == "image") {
                    s.extraData[n+'.x'] = form.clk_x;
                    s.extraData[n+'.y'] = form.clk_y;
                }
            }
        }

        var CLIENT_TIMEOUT_ABORT = 1;
        var SERVER_ABORT = 2;
                
        function getDoc(frame) {
            /* it looks like contentWindow or contentDocument do not
             * carry the protocol property in ie8, when running under ssl
             * frame.document is the only valid response document, since
             * the protocol is know but not on the other two objects. strange?
             * "Same origin policy" http://en.wikipedia.org/wiki/Same_origin_policy
             */
            
            var doc = null;
            
            // IE8 cascading access check
            try {
                if (frame.contentWindow) {
                    doc = frame.contentWindow.document;
                }
            } catch(err) {
                // IE8 access denied under ssl & missing protocol
                log('cannot get iframe.contentWindow document: ' + err);
            }

            if (doc) { // successful getting content
                return doc;
            }

            try { // simply checking may throw in ie8 under ssl or mismatched protocol
                doc = frame.contentDocument ? frame.contentDocument : frame.document;
            } catch(err) {
                // last attempt
                log('cannot get iframe.contentDocument: ' + err);
                doc = frame.document;
            }
            return doc;
        }

        // Rails CSRF hack (thanks to Yvan Barthelemy)
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        var csrf_param = $('meta[name=csrf-param]').attr('content');
        if (csrf_param && csrf_token) {
            s.extraData = s.extraData || {};
            s.extraData[csrf_param] = csrf_token;
        }

        // take a breath so that pending repaints get some cpu time before the upload starts
        function doSubmit() {
            // make sure form attrs are set
            var t = $form.attr2('target'), 
                a = $form.attr2('action'), 
                mp = 'multipart/form-data',
                et = $form.attr('enctype') || $form.attr('encoding') || mp;

            // update form attrs in IE friendly way
            form.setAttribute('target',id);
            if (!method || /post/i.test(method) ) {
                form.setAttribute('method', 'POST');
            }
            if (a != s.url) {
                form.setAttribute('action', s.url);
            }

            // ie borks in some cases when setting encoding
            if (! s.skipEncodingOverride && (!method || /post/i.test(method))) {
                $form.attr({
                    encoding: 'multipart/form-data',
                    enctype:  'multipart/form-data'
                });
            }

            // support timout
            if (s.timeout) {
                timeoutHandle = setTimeout(function() { timedOut = true; cb(CLIENT_TIMEOUT_ABORT); }, s.timeout);
            }

            // look for server aborts
            function checkState() {
                try {
                    var state = getDoc(io).readyState;
                    log('state = ' + state);
                    if (state && state.toLowerCase() == 'uninitialized') {
                        setTimeout(checkState,50);
                    }
                }
                catch(e) {
                    log('Server abort: ' , e, ' (', e.name, ')');
                    cb(SERVER_ABORT);
                    if (timeoutHandle) {
                        clearTimeout(timeoutHandle);
                    }
                    timeoutHandle = undefined;
                }
            }

            // add "extra" data to form if provided in options
            var extraInputs = [];
            try {
                if (s.extraData) {
                    for (var n in s.extraData) {
                        if (s.extraData.hasOwnProperty(n)) {
                           // if using the $.param format that allows for multiple values with the same name
                           if($.isPlainObject(s.extraData[n]) && s.extraData[n].hasOwnProperty('name') && s.extraData[n].hasOwnProperty('value')) {
                               extraInputs.push(
                               $('<input type="hidden" name="'+s.extraData[n].name+'">').val(s.extraData[n].value)
                                   .appendTo(form)[0]);
                           } else {
                               extraInputs.push(
                               $('<input type="hidden" name="'+n+'">').val(s.extraData[n])
                                   .appendTo(form)[0]);
                           }
                        }
                    }
                }

                if (!s.iframeTarget) {
                    // add iframe to doc and submit the form
                    $io.appendTo('body');
                }
                if (io.attachEvent) {
                    io.attachEvent('onload', cb);
                }
                else {
                    io.addEventListener('load', cb, false);
                }
                setTimeout(checkState,15);

                try {
                    form.submit();
                } catch(err) {
                    // just in case form has element with name/id of 'submit'
                    var submitFn = document.createElement('form').submit;
                    submitFn.apply(form);
                }
            }
            finally {
                // reset attrs and remove "extra" input elements
                form.setAttribute('action',a);
                form.setAttribute('enctype', et); // #380
                if(t) {
                    form.setAttribute('target', t);
                } else {
                    $form.removeAttr('target');
                }
                $(extraInputs).remove();
            }
        }

        if (s.forceSync) {
            doSubmit();
        }
        else {
            setTimeout(doSubmit, 10); // this lets dom updates render
        }

        var data, doc, domCheckCount = 50, callbackProcessed;

        function cb(e) {
            if (xhr.aborted || callbackProcessed) {
                return;
            }
            
            doc = getDoc(io);
            if(!doc) {
                log('cannot access response document');
                e = SERVER_ABORT;
            }
            if (e === CLIENT_TIMEOUT_ABORT && xhr) {
                xhr.abort('timeout');
                deferred.reject(xhr, 'timeout');
                return;
            }
            else if (e == SERVER_ABORT && xhr) {
                xhr.abort('server abort');
                deferred.reject(xhr, 'error', 'server abort');
                return;
            }

            if (!doc || doc.location.href == s.iframeSrc) {
                // response not received yet
                if (!timedOut) {
                    return;
                }
            }
            if (io.detachEvent) {
                io.detachEvent('onload', cb);
            }
            else {
                io.removeEventListener('load', cb, false);
            }

            var status = 'success', errMsg;
            try {
                if (timedOut) {
                    throw 'timeout';
                }

                var isXml = s.dataType == 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
                log('isXml='+isXml);
                if (!isXml && window.opera && (doc.body === null || !doc.body.innerHTML)) {
                    if (--domCheckCount) {
                        // in some browsers (Opera) the iframe DOM is not always traversable when
                        // the onload callback fires, so we loop a bit to accommodate
                        log('requeing onLoad callback, DOM not available');
                        setTimeout(cb, 250);
                        return;
                    }
                    // let this fall through because server response could be an empty document
                    //log('Could not access iframe DOM after mutiple tries.');
                    //throw 'DOMException: not available';
                }

                //log('response detected');
                var docRoot = doc.body ? doc.body : doc.documentElement;
                xhr.responseText = docRoot ? docRoot.innerHTML : null;
                xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                if (isXml) {
                    s.dataType = 'xml';
                }
                xhr.getResponseHeader = function(header){
                    var headers = {'content-type': s.dataType};
                    return headers[header.toLowerCase()];
                };
                // support for XHR 'status' & 'statusText' emulation :
                if (docRoot) {
                    xhr.status = Number( docRoot.getAttribute('status') ) || xhr.status;
                    xhr.statusText = docRoot.getAttribute('statusText') || xhr.statusText;
                }

                var dt = (s.dataType || '').toLowerCase();
                var scr = /(json|script|text)/.test(dt);
                if (scr || s.textarea) {
                    // see if user embedded response in textarea
                    var ta = doc.getElementsByTagName('textarea')[0];
                    if (ta) {
                        xhr.responseText = ta.value;
                        // support for XHR 'status' & 'statusText' emulation :
                        xhr.status = Number( ta.getAttribute('status') ) || xhr.status;
                        xhr.statusText = ta.getAttribute('statusText') || xhr.statusText;
                    }
                    else if (scr) {
                        // account for browsers injecting pre around json response
                        var pre = doc.getElementsByTagName('pre')[0];
                        var b = doc.getElementsByTagName('body')[0];
                        if (pre) {
                            xhr.responseText = pre.textContent ? pre.textContent : pre.innerText;
                        }
                        else if (b) {
                            xhr.responseText = b.textContent ? b.textContent : b.innerText;
                        }
                    }
                }
                else if (dt == 'xml' && !xhr.responseXML && xhr.responseText) {
                    xhr.responseXML = toXml(xhr.responseText);
                }

                try {
                    data = httpData(xhr, dt, s);
                }
                catch (err) {
                    status = 'parsererror';
                    xhr.error = errMsg = (err || status);
                }
            }
            catch (err) {
                log('error caught: ',err);
                status = 'error';
                xhr.error = errMsg = (err || status);
            }

            if (xhr.aborted) {
                log('upload aborted');
                status = null;
            }

            if (xhr.status) { // we've set xhr.status
                status = (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) ? 'success' : 'error';
            }

            // ordering of these callbacks/triggers is odd, but that's how $.ajax does it
            if (status === 'success') {
                if (s.success) {
                    s.success.call(s.context, data, 'success', xhr);
                }
                deferred.resolve(xhr.responseText, 'success', xhr);
                if (g) {
                    $.event.trigger("ajaxSuccess", [xhr, s]);
                }
            }
            else if (status) {
                if (errMsg === undefined) {
                    errMsg = xhr.statusText;
                }
                if (s.error) {
                    s.error.call(s.context, xhr, status, errMsg);
                }
                deferred.reject(xhr, 'error', errMsg);
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, errMsg]);
                }
            }

            if (g) {
                $.event.trigger("ajaxComplete", [xhr, s]);
            }

            if (g && ! --$.active) {
                $.event.trigger("ajaxStop");
            }

            if (s.complete) {
                s.complete.call(s.context, xhr, status);
            }

            callbackProcessed = true;
            if (s.timeout) {
                clearTimeout(timeoutHandle);
            }

            // clean up
            setTimeout(function() {
                if (!s.iframeTarget) {
                    $io.remove();
                }
                else { //adding else to clean up existing iframe response.
                    $io.attr('src', s.iframeSrc);
                }
                xhr.responseXML = null;
            }, 100);
        }

        var toXml = $.parseXML || function(s, doc) { // use parseXML if available (jQuery 1.5+)
            if (window.ActiveXObject) {
                doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.async = 'false';
                doc.loadXML(s);
            }
            else {
                doc = (new DOMParser()).parseFromString(s, 'text/xml');
            }
            return (doc && doc.documentElement && doc.documentElement.nodeName != 'parsererror') ? doc : null;
        };
        var parseJSON = $.parseJSON || function(s) {
            /*jslint evil:true */
            return window['eval']('(' + s + ')');
        };

        var httpData = function( xhr, type, s ) { // mostly lifted from jq1.4.4

            var ct = xhr.getResponseHeader('content-type') || '',
                xml = type === 'xml' || !type && ct.indexOf('xml') >= 0,
                data = xml ? xhr.responseXML : xhr.responseText;

            if (xml && data.documentElement.nodeName === 'parsererror') {
                if ($.error) {
                    $.error('parsererror');
                }
            }
            if (s && s.dataFilter) {
                data = s.dataFilter(data, type);
            }
            if (typeof data === 'string') {
                if (type === 'json' || !type && ct.indexOf('json') >= 0) {
                    data = parseJSON(data);
                } else if (type === "script" || !type && ct.indexOf("javascript") >= 0) {
                    $.globalEval(data);
                }
            }
            return data;
        };

        return deferred;
    }
};

/**
 * ajaxForm() provides a mechanism for fully automating form submission.
 *
 * The advantages of using this method instead of ajaxSubmit() are:
 *
 * 1: This method will include coordinates for <input type="image" /> elements (if the element
 *    is used to submit the form).
 * 2. This method will include the submit element's name/value data (for the element that was
 *    used to submit the form).
 * 3. This method binds the submit() method to the form for you.
 *
 * The options argument for ajaxForm works exactly as it does for ajaxSubmit.  ajaxForm merely
 * passes the options argument along after properly binding events for submit elements and
 * the form itself.
 */
$.fn.ajaxForm = function(options) {
    options = options || {};
    options.delegation = options.delegation && $.isFunction($.fn.on);

    // in jQuery 1.3+ we can fix mistakes with the ready state
    if (!options.delegation && this.length === 0) {
        var o = { s: this.selector, c: this.context };
        if (!$.isReady && o.s) {
            log('DOM not ready, queuing ajaxForm');
            $(function() {
                $(o.s,o.c).ajaxForm(options);
            });
            return this;
        }
        // is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
        log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
        return this;
    }

    if ( options.delegation ) {
        $(document)
            .off('submit.form-plugin', this.selector, doAjaxSubmit)
            .off('click.form-plugin', this.selector, captureSubmittingElement)
            .on('submit.form-plugin', this.selector, options, doAjaxSubmit)
            .on('click.form-plugin', this.selector, options, captureSubmittingElement);
        return this;
    }

    return this.ajaxFormUnbind()
        .bind('submit.form-plugin', options, doAjaxSubmit)
        .bind('click.form-plugin', options, captureSubmittingElement);
};

// private event handlers
function doAjaxSubmit(e) {
    /*jshint validthis:true */
    var options = e.data;
    if (!e.isDefaultPrevented()) { // if event has been canceled, don't proceed
        e.preventDefault();
        $(e.target).ajaxSubmit(options); // #365
    }
}

function captureSubmittingElement(e) {
    /*jshint validthis:true */
    var target = e.target;
    var $el = $(target);
    if (!($el.is("[type=submit],[type=image]"))) {
        // is this a child element of the submit el?  (ex: a span within a button)
        var t = $el.closest('[type=submit]');
        if (t.length === 0) {
            return;
        }
        target = t[0];
    }
    var form = this;
    form.clk = target;
    if (target.type == 'image') {
        if (e.offsetX !== undefined) {
            form.clk_x = e.offsetX;
            form.clk_y = e.offsetY;
        } else if (typeof $.fn.offset == 'function') {
            var offset = $el.offset();
            form.clk_x = e.pageX - offset.left;
            form.clk_y = e.pageY - offset.top;
        } else {
            form.clk_x = e.pageX - target.offsetLeft;
            form.clk_y = e.pageY - target.offsetTop;
        }
    }
    // clear form vars
    setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 100);
}


// ajaxFormUnbind unbinds the event handlers that were bound by ajaxForm
$.fn.ajaxFormUnbind = function() {
    return this.unbind('submit.form-plugin click.form-plugin');
};

/**
 * formToArray() gathers form element data into an array of objects that can
 * be passed to any of the following ajax functions: $.get, $.post, or load.
 * Each object in the array has both a 'name' and 'value' property.  An example of
 * an array for a simple login form might be:
 *
 * [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]
 *
 * It is this array that is passed to pre-submit callback functions provided to the
 * ajaxSubmit() and ajaxForm() methods.
 */
$.fn.formToArray = function(semantic, elements) {
    var a = [];
    if (this.length === 0) {
        return a;
    }

    var form = this[0];
    var formId = this.attr('id');
    var els = semantic ? form.getElementsByTagName('*') : form.elements;
    var els2;

    if (els && !/MSIE [678]/.test(navigator.userAgent)) { // #390
        els = $(els).get();  // convert to standard array
    }

    // #386; account for inputs outside the form which use the 'form' attribute
    if ( formId ) {
        els2 = $(':input[form="' + formId + '"]').get(); // hat tip @thet
        if ( els2.length ) {
            els = (els || []).concat(els2);
        }
    }

    if (!els || !els.length) {
        return a;
    }

    var i,j,n,v,el,max,jmax;
    for(i=0, max=els.length; i < max; i++) {
        el = els[i];
        n = el.name;
        if (!n || el.disabled) {
            continue;
        }

        if (semantic && form.clk && el.type == "image") {
            // handle image inputs on the fly when semantic == true
            if(form.clk == el) {
                a.push({name: n, value: $(el).val(), type: el.type });
                a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
            }
            continue;
        }

        v = $.fieldValue(el, true);
        if (v && v.constructor == Array) {
            if (elements) {
                elements.push(el);
            }
            for(j=0, jmax=v.length; j < jmax; j++) {
                a.push({name: n, value: v[j]});
            }
        }
        else if (feature.fileapi && el.type == 'file') {
            if (elements) {
                elements.push(el);
            }
            var files = el.files;
            if (files.length) {
                for (j=0; j < files.length; j++) {
                    a.push({name: n, value: files[j], type: el.type});
                }
            }
            else {
                // #180
                a.push({ name: n, value: '', type: el.type });
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            if (elements) {
                elements.push(el);
            }
            a.push({name: n, value: v, type: el.type, required: el.required});
        }
    }

    if (!semantic && form.clk) {
        // input type=='image' are not found in elements array! handle it here
        var $input = $(form.clk), input = $input[0];
        n = input.name;
        if (n && !input.disabled && input.type == 'image') {
            a.push({name: n, value: $input.val()});
            a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
        }
    }
    return a;
};

/**
 * Serializes form data into a 'submittable' string. This method will return a string
 * in the format: name1=value1&amp;name2=value2
 */
$.fn.formSerialize = function(semantic) {
    //hand off to jQuery.param for proper encoding
    return $.param(this.formToArray(semantic));
};

/**
 * Serializes all field elements in the jQuery object into a query string.
 * This method will return a string in the format: name1=value1&amp;name2=value2
 */
$.fn.fieldSerialize = function(successful) {
    var a = [];
    this.each(function() {
        var n = this.name;
        if (!n) {
            return;
        }
        var v = $.fieldValue(this, successful);
        if (v && v.constructor == Array) {
            for (var i=0,max=v.length; i < max; i++) {
                a.push({name: n, value: v[i]});
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            a.push({name: this.name, value: v});
        }
    });
    //hand off to jQuery.param for proper encoding
    return $.param(a);
};

/**
 * Returns the value(s) of the element in the matched set.  For example, consider the following form:
 *
 *  <form><fieldset>
 *      <input name="A" type="text" />
 *      <input name="A" type="text" />
 *      <input name="B" type="checkbox" value="B1" />
 *      <input name="B" type="checkbox" value="B2"/>
 *      <input name="C" type="radio" value="C1" />
 *      <input name="C" type="radio" value="C2" />
 *  </fieldset></form>
 *
 *  var v = $('input[type=text]').fieldValue();
 *  // if no values are entered into the text inputs
 *  v == ['','']
 *  // if values entered into the text inputs are 'foo' and 'bar'
 *  v == ['foo','bar']
 *
 *  var v = $('input[type=checkbox]').fieldValue();
 *  // if neither checkbox is checked
 *  v === undefined
 *  // if both checkboxes are checked
 *  v == ['B1', 'B2']
 *
 *  var v = $('input[type=radio]').fieldValue();
 *  // if neither radio is checked
 *  v === undefined
 *  // if first radio is checked
 *  v == ['C1']
 *
 * The successful argument controls whether or not the field element must be 'successful'
 * (per http://www.w3.org/TR/html4/interact/forms.html#successful-controls).
 * The default value of the successful argument is true.  If this value is false the value(s)
 * for each element is returned.
 *
 * Note: This method *always* returns an array.  If no valid value can be determined the
 *    array will be empty, otherwise it will contain one or more values.
 */
$.fn.fieldValue = function(successful) {
    for (var val=[], i=0, max=this.length; i < max; i++) {
        var el = this[i];
        var v = $.fieldValue(el, successful);
        if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) {
            continue;
        }
        if (v.constructor == Array) {
            $.merge(val, v);
        }
        else {
            val.push(v);
        }
    }
    return val;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
    var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
    if (successful === undefined) {
        successful = true;
    }

    if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
        (t == 'checkbox' || t == 'radio') && !el.checked ||
        (t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
        tag == 'select' && el.selectedIndex == -1)) {
            return null;
    }

    if (tag == 'select') {
        var index = el.selectedIndex;
        if (index < 0) {
            return null;
        }
        var a = [], ops = el.options;
        var one = (t == 'select-one');
        var max = (one ? index+1 : ops.length);
        for(var i=(one ? index : 0); i < max; i++) {
            var op = ops[i];
            if (op.selected) {
                var v = op.value;
                if (!v) { // extra pain for IE...
                    v = (op.attributes && op.attributes.value && !(op.attributes.value.specified)) ? op.text : op.value;
                }
                if (one) {
                    return v;
                }
                a.push(v);
            }
        }
        return a;
    }
    return $(el).val();
};

/**
 * Clears the form data.  Takes the following actions on the form's input fields:
 *  - input text fields will have their 'value' property set to the empty string
 *  - select elements will have their 'selectedIndex' property set to -1
 *  - checkbox and radio inputs will have their 'checked' property set to false
 *  - inputs of type submit, button, reset, and hidden will *not* be effected
 *  - button elements will *not* be effected
 */
$.fn.clearForm = function(includeHidden) {
    return this.each(function() {
        $('input,select,textarea', this).clearFields(includeHidden);
    });
};

/**
 * Clears the selected form elements.
 */
$.fn.clearFields = $.fn.clearInputs = function(includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
    return this.each(function() {
        var t = this.type, tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
        else if (t == "file") {
            if (/MSIE/.test(navigator.userAgent)) {
                $(this).replaceWith($(this).clone(true));
            } else {
                $(this).val('');
            }
        }
        else if (includeHidden) {
            // includeHidden can be the value true, or it can be a selector string
            // indicating a special test; for example:
            //  $('#myForm').clearForm('.special:hidden')
            // the above would clean hidden inputs that have the class of 'special'
            if ( (includeHidden === true && /hidden/.test(t)) ||
                 (typeof includeHidden == 'string' && $(this).is(includeHidden)) ) {
                this.value = '';
            }
        }
    });
};

/**
 * Resets the form data.  Causes all form elements to be reset to their original value.
 */
$.fn.resetForm = function() {
    return this.each(function() {
        // guard against an input with the name of 'reset'
        // note that IE reports the reset function as an 'object'
        if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
            this.reset();
        }
    });
};

/**
 * Enables or disables any matching elements.
 */
$.fn.enable = function(b) {
    if (b === undefined) {
        b = true;
    }
    return this.each(function() {
        this.disabled = !b;
    });
};

/**
 * Checks/unchecks any matching checkboxes or radio buttons and
 * selects/deselects and matching option elements.
 */
$.fn.selected = function(select) {
    if (select === undefined) {
        select = true;
    }
    return this.each(function() {
        var t = this.type;
        if (t == 'checkbox' || t == 'radio') {
            this.checked = select;
        }
        else if (this.tagName.toLowerCase() == 'option') {
            var $sel = $(this).parent('select');
            if (select && $sel[0] && $sel[0].type == 'select-one') {
                // deselect all other options
                $sel.find('option').selected(false);
            }
            this.selected = select;
        }
    });
};

// expose debug var
$.fn.ajaxSubmit.debug = false;

// helper fn for console logging
function log() {
    if (!$.fn.ajaxSubmit.debug) {
        return;
    }
    var msg = '[jquery.form] ' + Array.prototype.join.call(arguments,'');
    if (window.console && window.console.log) {
        window.console.log(msg);
    }
    else if (window.opera && window.opera.postError) {
        window.opera.postError(msg);
    }
}

}));

/*!
 * Bootstrap-select v1.9.4 (http://silviomoreto.github.io/bootstrap-select)
 *
 * Copyright 2013-2016 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(this,function(a){!function(a){"use strict";function b(b){var c=[{re:/[\xC0-\xC6]/g,ch:"A"},{re:/[\xE0-\xE6]/g,ch:"a"},{re:/[\xC8-\xCB]/g,ch:"E"},{re:/[\xE8-\xEB]/g,ch:"e"},{re:/[\xCC-\xCF]/g,ch:"I"},{re:/[\xEC-\xEF]/g,ch:"i"},{re:/[\xD2-\xD6]/g,ch:"O"},{re:/[\xF2-\xF6]/g,ch:"o"},{re:/[\xD9-\xDC]/g,ch:"U"},{re:/[\xF9-\xFC]/g,ch:"u"},{re:/[\xC7-\xE7]/g,ch:"c"},{re:/[\xD1]/g,ch:"N"},{re:/[\xF1]/g,ch:"n"}];return a.each(c,function(){b=b.replace(this.re,this.ch)}),b}function c(a){var b={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},c="(?:"+Object.keys(b).join("|")+")",d=new RegExp(c),e=new RegExp(c,"g"),f=null==a?"":""+a;return d.test(f)?f.replace(e,function(a){return b[a]}):f}function d(b,c){var d=arguments,f=b,g=c;[].shift.apply(d);var h,i=this.each(function(){var b=a(this);if(b.is("select")){var c=b.data("selectpicker"),i="object"==typeof f&&f;if(c){if(i)for(var j in i)i.hasOwnProperty(j)&&(c.options[j]=i[j])}else{var k=a.extend({},e.DEFAULTS,a.fn.selectpicker.defaults||{},b.data(),i);k.template=a.extend({},e.DEFAULTS.template,a.fn.selectpicker.defaults?a.fn.selectpicker.defaults.template:{},b.data().template,i.template),b.data("selectpicker",c=new e(this,k,g))}"string"==typeof f&&(h=c[f]instanceof Function?c[f].apply(c,d):c.options[f])}});return"undefined"!=typeof h?h:i}String.prototype.includes||!function(){var a={}.toString,b=function(){try{var a={},b=Object.defineProperty,c=b(a,a,a)&&b}catch(d){}return c}(),c="".indexOf,d=function(b){if(null==this)throw new TypeError;var d=String(this);if(b&&"[object RegExp]"==a.call(b))throw new TypeError;var e=d.length,f=String(b),g=f.length,h=arguments.length>1?arguments[1]:void 0,i=h?Number(h):0;i!=i&&(i=0);var j=Math.min(Math.max(i,0),e);return g+j>e?!1:-1!=c.call(d,f,i)};b?b(String.prototype,"includes",{value:d,configurable:!0,writable:!0}):String.prototype.includes=d}(),String.prototype.startsWith||!function(){var a=function(){try{var a={},b=Object.defineProperty,c=b(a,a,a)&&b}catch(d){}return c}(),b={}.toString,c=function(a){if(null==this)throw new TypeError;var c=String(this);if(a&&"[object RegExp]"==b.call(a))throw new TypeError;var d=c.length,e=String(a),f=e.length,g=arguments.length>1?arguments[1]:void 0,h=g?Number(g):0;h!=h&&(h=0);var i=Math.min(Math.max(h,0),d);if(f+i>d)return!1;for(var j=-1;++j<f;)if(c.charCodeAt(i+j)!=e.charCodeAt(j))return!1;return!0};a?a(String.prototype,"startsWith",{value:c,configurable:!0,writable:!0}):String.prototype.startsWith=c}(),Object.keys||(Object.keys=function(a,b,c){c=[];for(b in a)c.hasOwnProperty.call(a,b)&&c.push(b);return c}),a.fn.triggerNative=function(a){var b,c=this[0];c.dispatchEvent?("function"==typeof Event?b=new Event(a,{bubbles:!0}):(b=document.createEvent("Event"),b.initEvent(a,!0,!1)),c.dispatchEvent(b)):(c.fireEvent&&(b=document.createEventObject(),b.eventType=a,c.fireEvent("on"+a,b)),this.trigger(a))},a.expr[":"].icontains=function(b,c,d){var e=a(b),f=(e.data("tokens")||e.text()).toUpperCase();return f.includes(d[3].toUpperCase())},a.expr[":"].ibegins=function(b,c,d){var e=a(b),f=(e.data("tokens")||e.text()).toUpperCase();return f.startsWith(d[3].toUpperCase())},a.expr[":"].aicontains=function(b,c,d){var e=a(b),f=(e.data("tokens")||e.data("normalizedText")||e.text()).toUpperCase();return f.includes(d[3].toUpperCase())},a.expr[":"].aibegins=function(b,c,d){var e=a(b),f=(e.data("tokens")||e.data("normalizedText")||e.text()).toUpperCase();return f.startsWith(d[3].toUpperCase())};var e=function(b,c,d){d&&(d.stopPropagation(),d.preventDefault()),this.$element=a(b),this.$newElement=null,this.$button=null,this.$menu=null,this.$lis=null,this.options=c,null===this.options.title&&(this.options.title=this.$element.attr("title")),this.val=e.prototype.val,this.render=e.prototype.render,this.refresh=e.prototype.refresh,this.setStyle=e.prototype.setStyle,this.selectAll=e.prototype.selectAll,this.deselectAll=e.prototype.deselectAll,this.destroy=e.prototype.destroy,this.remove=e.prototype.remove,this.show=e.prototype.show,this.hide=e.prototype.hide,this.init()};e.VERSION="1.9.4",e.DEFAULTS={noneSelectedText:"Nothing selected",noneResultsText:"No results matched {0}",countSelectedText:function(a,b){return 1==a?"{0} item selected":"{0} items selected"},maxOptionsText:function(a,b){return[1==a?"Limit reached ({n} item max)":"Limit reached ({n} items max)",1==b?"Group limit reached ({n} item max)":"Group limit reached ({n} items max)"]},selectAllText:"Select All",deselectAllText:"Deselect All",doneButton:!1,doneButtonText:"Close",multipleSeparator:", ",styleBase:"btn",style:"btn-default",size:"auto",title:null,selectedTextFormat:"values",width:!1,container:!1,hideDisabled:!1,showSubtext:!1,showIcon:!0,showContent:!0,dropupAuto:!0,header:!1,liveSearch:!1,liveSearchPlaceholder:null,liveSearchNormalize:!1,liveSearchStyle:"contains",actionsBox:!1,iconBase:"glyphicon",tickIcon:"glyphicon-ok",template:{caret:'<span class="caret"></span>'},maxOptions:!1,mobile:!1,selectOnTab:!1,dropdownAlignRight:!1},e.prototype={constructor:e,init:function(){var b=this,c=this.$element.attr("id");this.liObj={},this.multiple=this.$element.prop("multiple"),this.autofocus=this.$element.prop("autofocus"),this.$newElement=this.createView(),this.$element.after(this.$newElement).appendTo(this.$newElement),this.$button=this.$newElement.children("button"),this.$menu=this.$newElement.children(".dropdown-menu"),this.$menuInner=this.$menu.children(".inner"),this.$searchbox=this.$menu.find("input"),this.options.dropdownAlignRight&&this.$menu.addClass("dropdown-menu-right"),"undefined"!=typeof c&&(this.$button.attr("data-id",c),a('label[for="'+c+'"]').click(function(a){a.preventDefault(),b.$button.focus()})),this.checkDisabled(),this.clickListener(),this.options.liveSearch&&this.liveSearchListener(),this.render(),this.setStyle(),this.setWidth(),this.options.container&&this.selectPosition(),this.$menu.data("this",this),this.$newElement.data("this",this),this.options.mobile&&this.mobile(),this.$newElement.on({"hide.bs.dropdown":function(a){b.$element.trigger("hide.bs.select",a)},"hidden.bs.dropdown":function(a){b.$element.trigger("hidden.bs.select",a)},"show.bs.dropdown":function(a){b.$element.trigger("show.bs.select",a)},"shown.bs.dropdown":function(a){b.$element.trigger("shown.bs.select",a)}}),b.$element[0].hasAttribute("required")&&this.$element.on("invalid",function(){b.$button.addClass("bs-invalid").focus(),b.$element.on({"focus.bs.select":function(){b.$button.focus(),b.$element.off("focus.bs.select")},"shown.bs.select":function(){b.$element.val(b.$element.val()).off("shown.bs.select")},"rendered.bs.select":function(){this.validity.valid&&b.$button.removeClass("bs-invalid"),b.$element.off("rendered.bs.select")}})}),setTimeout(function(){b.$element.trigger("loaded.bs.select")})},createDropdown:function(){var b=this.multiple?" show-tick":"",d=this.$element.parent().hasClass("input-group")?" input-group-btn":"",e=this.autofocus?" autofocus":"",f=this.options.header?'<div class="popover-title"><button type="button" class="close" aria-hidden="true">&times;</button>'+this.options.header+"</div>":"",g=this.options.liveSearch?'<div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"'+(null===this.options.liveSearchPlaceholder?"":' placeholder="'+c(this.options.liveSearchPlaceholder)+'"')+"></div>":"",h=this.multiple&&this.options.actionsBox?'<div class="bs-actionsbox"><div class="btn-group btn-group-sm btn-block"><button type="button" class="actions-btn bs-select-all btn btn-default">'+this.options.selectAllText+'</button><button type="button" class="actions-btn bs-deselect-all btn btn-default">'+this.options.deselectAllText+"</button></div></div>":"",i=this.multiple&&this.options.doneButton?'<div class="bs-donebutton"><div class="btn-group btn-block"><button type="button" class="btn btn-sm btn-default">'+this.options.doneButtonText+"</button></div></div>":"",j='<div class="btn-group bootstrap-select'+b+d+'"><button type="button" class="'+this.options.styleBase+' dropdown-toggle" data-toggle="dropdown"'+e+'><span class="filter-option pull-left"></span>&nbsp;<span class="bs-caret">'+this.options.template.caret+'</span></button><div class="dropdown-menu open">'+f+g+h+'<ul class="dropdown-menu inner" role="menu"></ul>'+i+"</div></div>";return a(j)},createView:function(){var a=this.createDropdown(),b=this.createLi();return a.find("ul")[0].innerHTML=b,a},reloadLi:function(){this.destroyLi();var a=this.createLi();this.$menuInner[0].innerHTML=a},destroyLi:function(){this.$menu.find("li").remove()},createLi:function(){var d=this,e=[],f=0,g=document.createElement("option"),h=-1,i=function(a,b,c,d){return"<li"+("undefined"!=typeof c&""!==c?' class="'+c+'"':"")+("undefined"!=typeof b&null!==b?' data-original-index="'+b+'"':"")+("undefined"!=typeof d&null!==d?'data-optgroup="'+d+'"':"")+">"+a+"</li>"},j=function(a,e,f,g){return'<a tabindex="0"'+("undefined"!=typeof e?' class="'+e+'"':"")+("undefined"!=typeof f?' style="'+f+'"':"")+(d.options.liveSearchNormalize?' data-normalized-text="'+b(c(a))+'"':"")+("undefined"!=typeof g||null!==g?' data-tokens="'+g+'"':"")+">"+a+'<span class="'+d.options.iconBase+" "+d.options.tickIcon+' check-mark"></span></a>'};if(this.options.title&&!this.multiple&&(h--,!this.$element.find(".bs-title-option").length)){var k=this.$element[0];g.className="bs-title-option",g.appendChild(document.createTextNode(this.options.title)),g.value="",k.insertBefore(g,k.firstChild),void 0===a(k.options[k.selectedIndex]).attr("selected")&&(g.selected=!0)}return this.$element.find("option").each(function(b){var c=a(this);if(h++,!c.hasClass("bs-title-option")){var g=this.className||"",k=this.style.cssText,l=c.data("content")?c.data("content"):c.html(),m=c.data("tokens")?c.data("tokens"):null,n="undefined"!=typeof c.data("subtext")?'<small class="text-muted">'+c.data("subtext")+"</small>":"",o="undefined"!=typeof c.data("icon")?'<span class="'+d.options.iconBase+" "+c.data("icon")+'"></span> ':"",p="OPTGROUP"===this.parentNode.tagName,q=this.disabled||p&&this.parentNode.disabled;if(""!==o&&q&&(o="<span>"+o+"</span>"),d.options.hideDisabled&&q&&!p)return void h--;if(c.data("content")||(l=o+'<span class="text">'+l+n+"</span>"),p&&c.data("divider")!==!0){var r=" "+this.parentNode.className||"";if(0===c.index()){f+=1;var s=this.parentNode.label,t="undefined"!=typeof c.parent().data("subtext")?'<small class="text-muted">'+c.parent().data("subtext")+"</small>":"",u=c.parent().data("icon")?'<span class="'+d.options.iconBase+" "+c.parent().data("icon")+'"></span> ':"";s=u+'<span class="text">'+s+t+"</span>",0!==b&&e.length>0&&(h++,e.push(i("",null,"divider",f+"div"))),h++,e.push(i(s,null,"dropdown-header"+r,f))}if(d.options.hideDisabled&&q)return void h--;e.push(i(j(l,"opt "+g+r,k,m),b,"",f))}else c.data("divider")===!0?e.push(i("",b,"divider")):c.data("hidden")===!0?e.push(i(j(l,g,k,m),b,"hidden is-hidden")):(this.previousElementSibling&&"OPTGROUP"===this.previousElementSibling.tagName&&(h++,e.push(i("",null,"divider",f+"div"))),e.push(i(j(l,g,k,m),b)));d.liObj[b]=h}}),this.multiple||0!==this.$element.find("option:selected").length||this.options.title||this.$element.find("option").eq(0).prop("selected",!0).attr("selected","selected"),e.join("")},findLis:function(){return null==this.$lis&&(this.$lis=this.$menu.find("li")),this.$lis},render:function(b){var c,d=this;b!==!1&&this.$element.find("option").each(function(a){var b=d.findLis().eq(d.liObj[a]);d.setDisabled(a,this.disabled||"OPTGROUP"===this.parentNode.tagName&&this.parentNode.disabled,b),d.setSelected(a,this.selected,b)}),this.tabIndex();var e=this.$element.find("option").map(function(){if(this.selected){if(d.options.hideDisabled&&(this.disabled||"OPTGROUP"===this.parentNode.tagName&&this.parentNode.disabled))return;var b,c=a(this),e=c.data("icon")&&d.options.showIcon?'<i class="'+d.options.iconBase+" "+c.data("icon")+'"></i> ':"";return b=d.options.showSubtext&&c.data("subtext")&&!d.multiple?' <small class="text-muted">'+c.data("subtext")+"</small>":"","undefined"!=typeof c.attr("title")?c.attr("title"):c.data("content")&&d.options.showContent?c.data("content"):e+c.html()+b}}).toArray(),f=this.multiple?e.join(this.options.multipleSeparator):e[0];if(this.multiple&&this.options.selectedTextFormat.indexOf("count")>-1){var g=this.options.selectedTextFormat.split(">");if(g.length>1&&e.length>g[1]||1==g.length&&e.length>=2){c=this.options.hideDisabled?", [disabled]":"";var h=this.$element.find("option").not('[data-divider="true"], [data-hidden="true"]'+c).length,i="function"==typeof this.options.countSelectedText?this.options.countSelectedText(e.length,h):this.options.countSelectedText;f=i.replace("{0}",e.length.toString()).replace("{1}",h.toString())}}void 0==this.options.title&&(this.options.title=this.$element.attr("title")),"static"==this.options.selectedTextFormat&&(f=this.options.title),f||(f="undefined"!=typeof this.options.title?this.options.title:this.options.noneSelectedText),this.$button.attr("title",a.trim(f.replace(/<[^>]*>?/g,""))),this.$button.children(".filter-option").html(f),this.$element.trigger("rendered.bs.select")},setStyle:function(a,b){this.$element.attr("class")&&this.$newElement.addClass(this.$element.attr("class").replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi,""));var c=a?a:this.options.style;"add"==b?this.$button.addClass(c):"remove"==b?this.$button.removeClass(c):(this.$button.removeClass(this.options.style),this.$button.addClass(c))},liHeight:function(b){if(b||this.options.size!==!1&&!this.sizeInfo){var c=document.createElement("div"),d=document.createElement("div"),e=document.createElement("ul"),f=document.createElement("li"),g=document.createElement("li"),h=document.createElement("a"),i=document.createElement("span"),j=this.options.header&&this.$menu.find(".popover-title").length>0?this.$menu.find(".popover-title")[0].cloneNode(!0):null,k=this.options.liveSearch?document.createElement("div"):null,l=this.options.actionsBox&&this.multiple&&this.$menu.find(".bs-actionsbox").length>0?this.$menu.find(".bs-actionsbox")[0].cloneNode(!0):null,m=this.options.doneButton&&this.multiple&&this.$menu.find(".bs-donebutton").length>0?this.$menu.find(".bs-donebutton")[0].cloneNode(!0):null;if(i.className="text",c.className=this.$menu[0].parentNode.className+" open",d.className="dropdown-menu open",e.className="dropdown-menu inner",f.className="divider",i.appendChild(document.createTextNode("Inner text")),h.appendChild(i),g.appendChild(h),e.appendChild(g),e.appendChild(f),j&&d.appendChild(j),k){var n=document.createElement("span");k.className="bs-searchbox",n.className="form-control",k.appendChild(n),d.appendChild(k)}l&&d.appendChild(l),d.appendChild(e),m&&d.appendChild(m),c.appendChild(d),document.body.appendChild(c);var o=h.offsetHeight,p=j?j.offsetHeight:0,q=k?k.offsetHeight:0,r=l?l.offsetHeight:0,s=m?m.offsetHeight:0,t=a(f).outerHeight(!0),u="function"==typeof getComputedStyle?getComputedStyle(d):!1,v=u?null:a(d),w=parseInt(u?u.paddingTop:v.css("paddingTop"))+parseInt(u?u.paddingBottom:v.css("paddingBottom"))+parseInt(u?u.borderTopWidth:v.css("borderTopWidth"))+parseInt(u?u.borderBottomWidth:v.css("borderBottomWidth")),x=w+parseInt(u?u.marginTop:v.css("marginTop"))+parseInt(u?u.marginBottom:v.css("marginBottom"))+2;document.body.removeChild(c),this.sizeInfo={liHeight:o,headerHeight:p,searchHeight:q,actionsHeight:r,doneButtonHeight:s,dividerHeight:t,menuPadding:w,menuExtras:x}}},setSize:function(){if(this.findLis(),this.liHeight(),this.options.header&&this.$menu.css("padding-top",0),this.options.size!==!1){var b,c,d,e,f=this,g=this.$menu,h=this.$menuInner,i=a(window),j=this.$newElement[0].offsetHeight,k=this.sizeInfo.liHeight,l=this.sizeInfo.headerHeight,m=this.sizeInfo.searchHeight,n=this.sizeInfo.actionsHeight,o=this.sizeInfo.doneButtonHeight,p=this.sizeInfo.dividerHeight,q=this.sizeInfo.menuPadding,r=this.sizeInfo.menuExtras,s=this.options.hideDisabled?".disabled":"",t=function(){d=f.$newElement.offset().top-i.scrollTop(),e=i.height()-d-j};if(t(),"auto"===this.options.size){var u=function(){var i,j=function(b,c){return function(d){return c?d.classList?d.classList.contains(b):a(d).hasClass(b):!(d.classList?d.classList.contains(b):a(d).hasClass(b))}},p=f.$menuInner[0].getElementsByTagName("li"),s=Array.prototype.filter?Array.prototype.filter.call(p,j("hidden",!1)):f.$lis.not(".hidden"),u=Array.prototype.filter?Array.prototype.filter.call(s,j("dropdown-header",!0)):s.filter(".dropdown-header");t(),b=e-r,f.options.container?(g.data("height")||g.data("height",g.height()),c=g.data("height")):c=g.height(),f.options.dropupAuto&&f.$newElement.toggleClass("dropup",d>e&&c>b-r),f.$newElement.hasClass("dropup")&&(b=d-r),i=s.length+u.length>3?3*k+r-2:0,g.css({"max-height":b+"px",overflow:"hidden","min-height":i+l+m+n+o+"px"}),h.css({"max-height":b-l-m-n-o-q+"px","overflow-y":"auto","min-height":Math.max(i-q,0)+"px"})};u(),this.$searchbox.off("input.getSize propertychange.getSize").on("input.getSize propertychange.getSize",u),i.off("resize.getSize scroll.getSize").on("resize.getSize scroll.getSize",u)}else if(this.options.size&&"auto"!=this.options.size&&this.$lis.not(s).length>this.options.size){var v=this.$lis.not(".divider").not(s).children().slice(0,this.options.size).last().parent().index(),w=this.$lis.slice(0,v+1).filter(".divider").length;b=k*this.options.size+w*p+q,f.options.container?(g.data("height")||g.data("height",g.height()),c=g.data("height")):c=g.height(),f.options.dropupAuto&&this.$newElement.toggleClass("dropup",d>e&&c>b-r),g.css({"max-height":b+l+m+n+o+"px",overflow:"hidden","min-height":""}),h.css({"max-height":b-q+"px","overflow-y":"auto","min-height":""})}}},setWidth:function(){if("auto"===this.options.width){this.$menu.css("min-width","0");var a=this.$menu.parent().clone().appendTo("body"),b=this.options.container?this.$newElement.clone().appendTo("body"):a,c=a.children(".dropdown-menu").outerWidth(),d=b.css("width","auto").children("button").outerWidth();a.remove(),b.remove(),this.$newElement.css("width",Math.max(c,d)+"px")}else"fit"===this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width","").addClass("fit-width")):this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width",this.options.width)):(this.$menu.css("min-width",""),this.$newElement.css("width",""));this.$newElement.hasClass("fit-width")&&"fit"!==this.options.width&&this.$newElement.removeClass("fit-width")},selectPosition:function(){this.$bsContainer=a('<div class="bs-container" />');var b,c,d=this,e=function(a){d.$bsContainer.addClass(a.attr("class").replace(/form-control|fit-width/gi,"")).toggleClass("dropup",a.hasClass("dropup")),b=a.offset(),c=a.hasClass("dropup")?0:a[0].offsetHeight,d.$bsContainer.css({top:b.top+c,left:b.left,width:a[0].offsetWidth})};this.$button.on("click",function(){var b=a(this);d.isDisabled()||(e(d.$newElement),d.$bsContainer.appendTo(d.options.container).toggleClass("open",!b.hasClass("open")).append(d.$menu))}),a(window).on("resize scroll",function(){e(d.$newElement)}),this.$element.on("hide.bs.select",function(){d.$menu.data("height",d.$menu.height()),d.$bsContainer.detach()})},setSelected:function(a,b,c){c||(c=this.findLis().eq(this.liObj[a])),c.toggleClass("selected",b)},setDisabled:function(a,b,c){c||(c=this.findLis().eq(this.liObj[a])),b?c.addClass("disabled").children("a").attr("href","#").attr("tabindex",-1):c.removeClass("disabled").children("a").removeAttr("href").attr("tabindex",0)},isDisabled:function(){return this.$element[0].disabled},checkDisabled:function(){var a=this;this.isDisabled()?(this.$newElement.addClass("disabled"),this.$button.addClass("disabled").attr("tabindex",-1)):(this.$button.hasClass("disabled")&&(this.$newElement.removeClass("disabled"),this.$button.removeClass("disabled")),-1!=this.$button.attr("tabindex")||this.$element.data("tabindex")||this.$button.removeAttr("tabindex")),this.$button.click(function(){return!a.isDisabled()})},tabIndex:function(){this.$element.data("tabindex")!==this.$element.attr("tabindex")&&-98!==this.$element.attr("tabindex")&&"-98"!==this.$element.attr("tabindex")&&(this.$element.data("tabindex",this.$element.attr("tabindex")),this.$button.attr("tabindex",this.$element.data("tabindex"))),this.$element.attr("tabindex",-98)},clickListener:function(){var b=this,c=a(document);this.$newElement.on("touchstart.dropdown",".dropdown-menu",function(a){a.stopPropagation()}),c.data("spaceSelect",!1),this.$button.on("keyup",function(a){/(32)/.test(a.keyCode.toString(10))&&c.data("spaceSelect")&&(a.preventDefault(),c.data("spaceSelect",!1))}),this.$button.on("click",function(){b.setSize(),b.$element.on("shown.bs.select",function(){if(b.options.liveSearch||b.multiple){if(!b.multiple){var a=b.liObj[b.$element[0].selectedIndex];if("number"!=typeof a||b.options.size===!1)return;var c=b.$lis.eq(a)[0].offsetTop-b.$menuInner[0].offsetTop;c=c-b.$menuInner[0].offsetHeight/2+b.sizeInfo.liHeight/2,b.$menuInner[0].scrollTop=c}}else b.$menuInner.find(".selected a").focus()})}),this.$menuInner.on("click","li a",function(c){var d=a(this),e=d.parent().data("originalIndex"),f=b.$element.val(),g=b.$element.prop("selectedIndex");if(b.multiple&&c.stopPropagation(),c.preventDefault(),!b.isDisabled()&&!d.parent().hasClass("disabled")){var h=b.$element.find("option"),i=h.eq(e),j=i.prop("selected"),k=i.parent("optgroup"),l=b.options.maxOptions,m=k.data("maxOptions")||!1;if(b.multiple){if(i.prop("selected",!j),b.setSelected(e,!j),d.blur(),l!==!1||m!==!1){var n=l<h.filter(":selected").length,o=m<k.find("option:selected").length;if(l&&n||m&&o)if(l&&1==l)h.prop("selected",!1),i.prop("selected",!0),b.$menuInner.find(".selected").removeClass("selected"),b.setSelected(e,!0);else if(m&&1==m){k.find("option:selected").prop("selected",!1),i.prop("selected",!0);var p=d.parent().data("optgroup");b.$menuInner.find('[data-optgroup="'+p+'"]').removeClass("selected"),b.setSelected(e,!0)}else{var q="function"==typeof b.options.maxOptionsText?b.options.maxOptionsText(l,m):b.options.maxOptionsText,r=q[0].replace("{n}",l),s=q[1].replace("{n}",m),t=a('<div class="notify"></div>');q[2]&&(r=r.replace("{var}",q[2][l>1?0:1]),s=s.replace("{var}",q[2][m>1?0:1])),i.prop("selected",!1),b.$menu.append(t),l&&n&&(t.append(a("<div>"+r+"</div>")),b.$element.trigger("maxReached.bs.select")),m&&o&&(t.append(a("<div>"+s+"</div>")),b.$element.trigger("maxReachedGrp.bs.select")),setTimeout(function(){b.setSelected(e,!1)},10),t.delay(750).fadeOut(300,function(){a(this).remove()})}}}else h.prop("selected",!1),i.prop("selected",!0),b.$menuInner.find(".selected").removeClass("selected"),b.setSelected(e,!0);b.multiple?b.options.liveSearch&&b.$searchbox.focus():b.$button.focus(),(f!=b.$element.val()&&b.multiple||g!=b.$element.prop("selectedIndex")&&!b.multiple)&&(b.$element.triggerNative("change"),b.$element.trigger("changed.bs.select",[e,i.prop("selected"),j]))}}),this.$menu.on("click","li.disabled a, .popover-title, .popover-title :not(.close)",function(c){c.currentTarget==this&&(c.preventDefault(),c.stopPropagation(),b.options.liveSearch&&!a(c.target).hasClass("close")?b.$searchbox.focus():b.$button.focus())}),this.$menuInner.on("click",".divider, .dropdown-header",function(a){a.preventDefault(),a.stopPropagation(),b.options.liveSearch?b.$searchbox.focus():b.$button.focus()}),this.$menu.on("click",".popover-title .close",function(){b.$button.click()}),this.$searchbox.on("click",function(a){a.stopPropagation()}),this.$menu.on("click",".actions-btn",function(c){b.options.liveSearch?b.$searchbox.focus():b.$button.focus(),c.preventDefault(),c.stopPropagation(),a(this).hasClass("bs-select-all")?b.selectAll():b.deselectAll(),b.$element.triggerNative("change")}),this.$element.change(function(){b.render(!1)})},liveSearchListener:function(){var d=this,e=a('<li class="no-results"></li>');this.$button.on("click.dropdown.data-api touchstart.dropdown.data-api",function(){d.$menuInner.find(".active").removeClass("active"),d.$searchbox.val()&&(d.$searchbox.val(""),d.$lis.not(".is-hidden").removeClass("hidden"),e.parent().length&&e.remove()),d.multiple||d.$menuInner.find(".selected").addClass("active"),setTimeout(function(){d.$searchbox.focus()},10)}),this.$searchbox.on("click.dropdown.data-api focus.dropdown.data-api touchend.dropdown.data-api",function(a){a.stopPropagation()}),this.$searchbox.on("input propertychange",function(){if(d.$searchbox.val()){var f=d.$lis.not(".is-hidden").removeClass("hidden").children("a");f=d.options.liveSearchNormalize?f.not(":a"+d._searchStyle()+'("'+b(d.$searchbox.val())+'")'):f.not(":"+d._searchStyle()+'("'+d.$searchbox.val()+'")'),f.parent().addClass("hidden"),d.$lis.filter(".dropdown-header").each(function(){var b=a(this),c=b.data("optgroup");0===d.$lis.filter("[data-optgroup="+c+"]").not(b).not(".hidden").length&&(b.addClass("hidden"),d.$lis.filter("[data-optgroup="+c+"div]").addClass("hidden"))});var g=d.$lis.not(".hidden");g.each(function(b){var c=a(this);c.hasClass("divider")&&(c.index()===g.first().index()||c.index()===g.last().index()||g.eq(b+1).hasClass("divider"))&&c.addClass("hidden")}),d.$lis.not(".hidden, .no-results").length?e.parent().length&&e.remove():(e.parent().length&&e.remove(),e.html(d.options.noneResultsText.replace("{0}",'"'+c(d.$searchbox.val())+'"')).show(),d.$menuInner.append(e))}else d.$lis.not(".is-hidden").removeClass("hidden"),e.parent().length&&e.remove();d.$lis.filter(".active").removeClass("active"),d.$searchbox.val()&&d.$lis.not(".hidden, .divider, .dropdown-header").eq(0).addClass("active").children("a").focus(),a(this).focus()})},_searchStyle:function(){var a={begins:"ibegins",startsWith:"ibegins"};return a[this.options.liveSearchStyle]||"icontains"},val:function(a){return"undefined"!=typeof a?(this.$element.val(a),this.render(),this.$element):this.$element.val()},changeAll:function(b){"undefined"==typeof b&&(b=!0),this.findLis();for(var c=this.$element.find("option"),d=this.$lis.not(".divider, .dropdown-header, .disabled, .hidden").toggleClass("selected",b),e=d.length,f=[],g=0;e>g;g++){var h=d[g].getAttribute("data-original-index");f[f.length]=c.eq(h)[0]}a(f).prop("selected",b),this.render(!1)},selectAll:function(){return this.changeAll(!0)},deselectAll:function(){return this.changeAll(!1)},keydown:function(c){var d,e,f,g,h,i,j,k,l,m=a(this),n=m.is("input")?m.parent().parent():m.parent(),o=n.data("this"),p=":not(.disabled, .hidden, .dropdown-header, .divider)",q={32:" ",48:"0",49:"1",50:"2",51:"3",52:"4",53:"5",54:"6",55:"7",56:"8",57:"9",59:";",65:"a",66:"b",67:"c",68:"d",69:"e",70:"f",71:"g",72:"h",73:"i",74:"j",75:"k",76:"l",77:"m",78:"n",79:"o",80:"p",81:"q",82:"r",83:"s",84:"t",85:"u",86:"v",87:"w",88:"x",89:"y",90:"z",96:"0",97:"1",98:"2",99:"3",100:"4",101:"5",102:"6",103:"7",104:"8",105:"9"};if(o.options.liveSearch&&(n=m.parent().parent()),o.options.container&&(n=o.$menu),d=a("[role=menu] li",n),l=o.$newElement.hasClass("open"),!l&&(c.keyCode>=48&&c.keyCode<=57||c.keyCode>=96&&c.keyCode<=105||c.keyCode>=65&&c.keyCode<=90)&&(o.options.container?o.$button.trigger("click"):(o.setSize(),o.$menu.parent().addClass("open"),l=!0),o.$searchbox.focus()),o.options.liveSearch&&(/(^9$|27)/.test(c.keyCode.toString(10))&&l&&0===o.$menu.find(".active").length&&(c.preventDefault(),o.$menu.parent().removeClass("open"),o.options.container&&o.$newElement.removeClass("open"),o.$button.focus()),d=a("[role=menu] li"+p,n),m.val()||/(38|40)/.test(c.keyCode.toString(10))||0===d.filter(".active").length&&(d=o.$menuInner.find("li"),d=o.options.liveSearchNormalize?d.filter(":a"+o._searchStyle()+"("+b(q[c.keyCode])+")"):d.filter(":"+o._searchStyle()+"("+q[c.keyCode]+")"))),d.length){if(/(38|40)/.test(c.keyCode.toString(10)))e=d.index(d.find("a").filter(":focus").parent()),g=d.filter(p).first().index(),h=d.filter(p).last().index(),f=d.eq(e).nextAll(p).eq(0).index(),i=d.eq(e).prevAll(p).eq(0).index(),j=d.eq(f).prevAll(p).eq(0).index(),o.options.liveSearch&&(d.each(function(b){a(this).hasClass("disabled")||a(this).data("index",b)}),e=d.index(d.filter(".active")),g=d.first().data("index"),h=d.last().data("index"),f=d.eq(e).nextAll().eq(0).data("index"),i=d.eq(e).prevAll().eq(0).data("index"),j=d.eq(f).prevAll().eq(0).data("index")),k=m.data("prevIndex"),38==c.keyCode?(o.options.liveSearch&&e--,e!=j&&e>i&&(e=i),g>e&&(e=g),e==k&&(e=h)):40==c.keyCode&&(o.options.liveSearch&&e++,-1==e&&(e=0),e!=j&&f>e&&(e=f),e>h&&(e=h),e==k&&(e=g)),m.data("prevIndex",e),o.options.liveSearch?(c.preventDefault(),m.hasClass("dropdown-toggle")||(d.removeClass("active").eq(e).addClass("active").children("a").focus(),m.focus())):d.eq(e).children("a").focus();else if(!m.is("input")){var r,s,t=[];d.each(function(){a(this).hasClass("disabled")||a.trim(a(this).children("a").text().toLowerCase()).substring(0,1)==q[c.keyCode]&&t.push(a(this).index())}),r=a(document).data("keycount"),r++,a(document).data("keycount",r),s=a.trim(a(":focus").text().toLowerCase()).substring(0,1),s!=q[c.keyCode]?(r=1,a(document).data("keycount",r)):r>=t.length&&(a(document).data("keycount",0),r>t.length&&(r=1)),d.eq(t[r-1]).children("a").focus()}if((/(13|32)/.test(c.keyCode.toString(10))||/(^9$)/.test(c.keyCode.toString(10))&&o.options.selectOnTab)&&l){if(/(32)/.test(c.keyCode.toString(10))||c.preventDefault(),o.options.liveSearch)/(32)/.test(c.keyCode.toString(10))||(o.$menuInner.find(".active a").click(),m.focus());else{var u=a(":focus");u.click(),u.focus(),c.preventDefault(),a(document).data("spaceSelect",!0)}a(document).data("keycount",0)}(/(^9$|27)/.test(c.keyCode.toString(10))&&l&&(o.multiple||o.options.liveSearch)||/(27)/.test(c.keyCode.toString(10))&&!l)&&(o.$menu.parent().removeClass("open"),o.options.container&&o.$newElement.removeClass("open"),o.$button.focus())}},mobile:function(){this.$element.addClass("mobile-device")},refresh:function(){this.$lis=null,this.liObj={},this.reloadLi(),this.render(),this.checkDisabled(),this.liHeight(!0),this.setStyle(),this.setWidth(),this.$lis&&this.$searchbox.trigger("propertychange"),this.$element.trigger("refreshed.bs.select")},hide:function(){this.$newElement.hide()},show:function(){this.$newElement.show()},remove:function(){this.$newElement.remove(),this.$element.remove()},destroy:function(){this.$newElement.before(this.$element).remove(),this.$bsContainer?this.$bsContainer.remove():this.$menu.remove(),this.$element.off(".bs.select").removeData("selectpicker").removeClass("bs-select-hidden selectpicker")}};var f=a.fn.selectpicker;a.fn.selectpicker=d,a.fn.selectpicker.Constructor=e,a.fn.selectpicker.noConflict=function(){return a.fn.selectpicker=f,this},a(document).data("keycount",0).on("keydown.bs.select",'.bootstrap-select [data-toggle=dropdown], .bootstrap-select [role="menu"], .bs-searchbox input',e.prototype.keydown).on("focusin.modal",'.bootstrap-select [data-toggle=dropdown], .bootstrap-select [role="menu"], .bs-searchbox input',function(a){a.stopPropagation()}),a(window).on("load.bs.select.data-api",function(){a(".selectpicker").each(function(){var b=a(this);d.call(b,b.data())})})}(a)});
//# sourceMappingURL=bootstrap-select.js.map
/*!
 * Fuel UX v3.15.0 
 * Copyright 2012-2016 ExactTarget
 * Licensed under the BSD-3-Clause license (https://github.com/ExactTarget/fuelux/blob/master/LICENSE)
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery","bootstrap"],a):a(jQuery)}(function(a){if("undefined"==typeof a)throw new Error("Fuel UX's JavaScript requires jQuery");if("undefined"==typeof a.fn.dropdown||"undefined"==typeof a.fn.collapse)throw new Error("Fuel UX's JavaScript requires Bootstrap");!function(a){var b=a.fn.checkbox,c=function(b,c){if(this.options=a.extend({},a.fn.checkbox.defaults,c),"label"===b.tagName.toLowerCase()){this.$label=a(b),this.$chk=this.$label.find('input[type="checkbox"]'),this.$container=a(b).parent(".checkbox");var d=this.$chk.attr("data-toggle");this.$toggleContainer=a(d),this.$chk.on("change",a.proxy(this.itemchecked,this)),this.setInitialState()}};c.prototype={constructor:c,setInitialState:function(){var a=this.$chk,b=(this.$label,a.prop("checked")),c=a.prop("disabled");this.setCheckedState(a,b),this.setDisabledState(a,c)},setCheckedState:function(a,b){var c=a,d=this.$label,e=(this.$container,this.$toggleContainer);b?(c.prop("checked",!0),d.addClass("checked"),e.removeClass("hide hidden"),d.trigger("checked.fu.checkbox")):(c.prop("checked",!1),d.removeClass("checked"),e.addClass("hidden"),d.trigger("unchecked.fu.checkbox")),d.trigger("changed.fu.checkbox",b)},setDisabledState:function(a,b){var c=this.$label;b?(this.$chk.prop("disabled",!0),c.addClass("disabled"),c.trigger("disabled.fu.checkbox")):(this.$chk.prop("disabled",!1),c.removeClass("disabled"),c.trigger("enabled.fu.checkbox"))},itemchecked:function(b){var c=a(b.target),d=c.prop("checked");this.setCheckedState(c,d)},toggle:function(){var a=this.isChecked();a?this.uncheck():this.check()},check:function(){this.setCheckedState(this.$chk,!0)},uncheck:function(){this.setCheckedState(this.$chk,!1)},isChecked:function(){var a=this.$chk.prop("checked");return a},enable:function(){this.setDisabledState(this.$chk,!1)},disable:function(){this.setDisabledState(this.$chk,!0)},destroy:function(){return this.$label.remove(),this.$label[0].outerHTML}},c.prototype.getValue=c.prototype.isChecked,a.fn.checkbox=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.checkbox"),h="object"==typeof b&&b;g||f.data("fu.checkbox",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.checkbox.defaults={},a.fn.checkbox.Constructor=c,a.fn.checkbox.noConflict=function(){return a.fn.checkbox=b,this},a(document).on("mouseover.fu.checkbox.data-api","[data-initialize=checkbox]",function(b){var c=a(b.target);c.data("fu.checkbox")||c.checkbox(c.data())}),a(function(){a("[data-initialize=checkbox]").each(function(){var b=a(this);b.data("fu.checkbox")||b.checkbox(b.data())})})}(a),function(a){var b=a.fn.combobox,c=function(b,c){this.$element=a(b),this.options=a.extend({},a.fn.combobox.defaults,c),this.$dropMenu=this.$element.find(".dropdown-menu"),this.$input=this.$element.find("input"),this.$button=this.$element.find(".btn"),this.$inputGroupBtn=this.$element.find(".input-group-btn"),this.$element.on("click.fu.combobox","a",a.proxy(this.itemclicked,this)),this.$element.on("change.fu.combobox","input",a.proxy(this.inputchanged,this)),this.$element.on("shown.bs.dropdown",a.proxy(this.menuShown,this)),this.$input.on("keyup.fu.combobox",a.proxy(this.keypress,this)),this.setDefaultSelection();var d=this.$dropMenu.children("li");0===d.length&&this.$button.addClass("disabled"),this.options.filterOnKeypress&&this.options.filter(this.$dropMenu.find("li"),this.$input.val(),this)};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$element[0].outerHTML},doSelect:function(a){"undefined"!=typeof a[0]?(a.addClass("selected"),this.$selectedItem=a,this.$input.val(this.$selectedItem.text().trim())):this.$selectedItem=null},clearSelection:function(){this.$selectedItem=null,this.$input.val(""),this.$dropMenu.find("li").removeClass("selected")},menuShown:function(){this.options.autoResizeMenu&&this.resizeMenu()},resizeMenu:function(){var a=this.$element.outerWidth();this.$dropMenu.outerWidth(a)},selectedItem:function(){var b=this.$selectedItem,c={};if(b){var d=this.$selectedItem.text().trim();c=a.extend({text:d},this.$selectedItem.data())}else c={text:this.$input.val().trim()};return c},selectByText:function(b){var c=a([]);this.$element.find("li").each(function(){return(this.textContent||this.innerText||a(this).text()||"").trim().toLowerCase()===(b||"").trim().toLowerCase()?(c=a(this),!1):void 0}),this.doSelect(c)},selectByValue:function(a){var b='li[data-value="'+a+'"]';this.selectBySelector(b)},selectByIndex:function(a){var b="li:eq("+a+")";this.selectBySelector(b)},selectBySelector:function(a){var b=this.$element.find(a);this.doSelect(b)},setDefaultSelection:function(){var a="li[data-selected=true]:first",b=this.$element.find(a);b.length>0&&(this.selectBySelector(a),b.removeData("selected"),b.removeAttr("data-selected"))},enable:function(){this.$element.removeClass("disabled"),this.$input.removeAttr("disabled"),this.$button.removeClass("disabled")},disable:function(){this.$element.addClass("disabled"),this.$input.attr("disabled",!0),this.$button.addClass("disabled")},itemclicked:function(b){this.$selectedItem=a(b.target).parent(),this.$input.val(this.$selectedItem.text().trim()).trigger("change",{synthetic:!0});var c=this.selectedItem();this.$element.trigger("changed.fu.combobox",c),b.preventDefault(),this.$element.find(".dropdown-toggle").focus()},keypress:function(a){var b=13,c=27,d=37,e=38,f=39,g=40,h=a.which===e||a.which===g||a.which===d||a.which===f;if(this.options.showOptionsOnKeypress&&!this.$inputGroupBtn.hasClass("open")&&(this.$button.dropdown("toggle"),this.$input.focus()),a.which===b){a.preventDefault();var i=this.$dropMenu.find("li.selected").text().trim();i.length>0?this.selectByText(i):this.selectByText(this.$input.val()),this.$inputGroupBtn.removeClass("open"),this.inputchanged(a)}else if(a.which===c)a.preventDefault(),this.clearSelection(),this.$inputGroupBtn.removeClass("open");else if(this.options.showOptionsOnKeypress&&(a.which===g||a.which===e)){a.preventDefault();var j=this.$dropMenu.find("li.selected");j.length>0&&(j=a.which===g?j.next(":not(.hidden)"):j.prev(":not(.hidden)")),0===j.length&&(j=a.which===g?this.$dropMenu.find("li:not(.hidden):first"):this.$dropMenu.find("li:not(.hidden):last")),this.$dropMenu.find("li").removeClass("selected"),j.addClass("selected")}this.options.filterOnKeypress&&!h&&this.options.filter(this.$dropMenu.find("li"),this.$input.val(),this),this.previousKeyPress=a.which},inputchanged:function(b,c){if(!c||!c.synthetic){var d=a(b.target).val();this.selectByText(d);var e=this.selectedItem();0===e.text.length&&(e={text:d}),this.$element.trigger("changed.fu.combobox",e)}}},c.prototype.getValue=c.prototype.selectedItem,a.fn.combobox=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.combobox"),h="object"==typeof b&&b;g||f.data("fu.combobox",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.combobox.defaults={autoResizeMenu:!0,filterOnKeypress:!1,showOptionsOnKeypress:!1,filter:function(b,c,d){var e=0;d.$dropMenu.find(".empty-indicator").remove(),b.each(function(b){var d=a(this),f=a(this).text().trim();d.removeClass(),f===c?(d.addClass("text-success"),e++):f.substr(0,c.length)===c?(d.addClass("text-info"),e++):d.addClass("hidden")}),0===e&&d.$dropMenu.append('<li class="empty-indicator text-muted"><em>No Matches</em></li>')}},a.fn.combobox.Constructor=c,a.fn.combobox.noConflict=function(){return a.fn.combobox=b,this},a(document).on("mousedown.fu.combobox.data-api","[data-initialize=combobox]",function(b){var c=a(b.target).closest(".combobox");c.data("fu.combobox")||c.combobox(c.data())}),a(function(){a("[data-initialize=combobox]").each(function(){var b=a(this);b.data("fu.combobox")||b.combobox(b.data())})})}(a),function(a){var b="Invalid Date",c="moment.js is not available so you cannot use this function",d=[],e=!1,f=a.fn.datepicker,g=!1,h=function(){var a,b;for(g=!0,a=0,b=d.length;b>a;a++)d[a].init.call(d[a].scope);d=[]};"function"==typeof define&&define.amd?require(["moment"],function(a){e=a,h()},function(a){var b=a.requireModules&&a.requireModules[0];"moment"===b&&h()}):h();var i=function(b,c){this.$element=a(b),this.options=a.extend(!0,{},a.fn.datepicker.defaults,c),this.$calendar=this.$element.find(".datepicker-calendar"),this.$days=this.$calendar.find(".datepicker-calendar-days"),this.$header=this.$calendar.find(".datepicker-calendar-header"),this.$headerTitle=this.$header.find(".title"),this.$input=this.$element.find("input"),this.$inputGroupBtn=this.$element.find(".input-group-btn"),this.$wheels=this.$element.find(".datepicker-wheels"),this.$wheelsMonth=this.$element.find(".datepicker-wheels-month"),this.$wheelsYear=this.$element.find(".datepicker-wheels-year"),this.artificialScrolling=!1,this.formatDate=this.options.formatDate||this.formatDate,this.inputValue=null,this.moment=!1,this.momentFormat=null,this.parseDate=this.options.parseDate||this.parseDate,this.preventBlurHide=!1,this.restricted=this.options.restricted||[],this.restrictedParsed=[],this.restrictedText=this.options.restrictedText,this.sameYearOnly=this.options.sameYearOnly,this.selectedDate=null,this.yearRestriction=null,this.$calendar.find(".datepicker-today").on("click.fu.datepicker",a.proxy(this.todayClicked,this)),this.$days.on("click.fu.datepicker","tr td button",a.proxy(this.dateClicked,this)),this.$header.find(".next").on("click.fu.datepicker",a.proxy(this.next,this)),this.$header.find(".prev").on("click.fu.datepicker",a.proxy(this.prev,this)),this.$headerTitle.on("click.fu.datepicker",a.proxy(this.titleClicked,this)),this.$input.on("change.fu.datepicker",a.proxy(this.inputChanged,this)),this.$input.on("mousedown.fu.datepicker",a.proxy(this.showDropdown,this)),this.$inputGroupBtn.on("hidden.bs.dropdown",a.proxy(this.hide,this)),this.$inputGroupBtn.on("shown.bs.dropdown",a.proxy(this.show,this)),this.$wheels.find(".datepicker-wheels-back").on("click.fu.datepicker",a.proxy(this.backClicked,this)),this.$wheels.find(".datepicker-wheels-select").on("click.fu.datepicker",a.proxy(this.selectClicked,this)),this.$wheelsMonth.on("click.fu.datepicker","ul button",a.proxy(this.monthClicked,this)),this.$wheelsYear.on("click.fu.datepicker","ul button",a.proxy(this.yearClicked,this)),this.$wheelsYear.find("ul").on("scroll.fu.datepicker",a.proxy(this.onYearScroll,this));var f=function(){this.checkForMomentJS()&&(e=e||window.moment,this.moment=!0,this.momentFormat=this.options.momentConfig.format,this.setCulture(this.options.momentConfig.culture),e.locale=e.locale||e.lang),this.setRestrictedDates(this.restricted),this.setDate(this.options.date)||(this.$input.val(""),this.inputValue=this.$input.val()),this.sameYearOnly&&(this.yearRestriction=this.selectedDate?this.selectedDate.getFullYear():(new Date).getFullYear())};g?f.call(this):d.push({init:f,scope:this})};i.prototype={constructor:i,backClicked:function(){this.changeView("calendar")},changeView:function(a,b){"wheels"===a?(this.$calendar.hide().attr("aria-hidden","true"),this.$wheels.show().removeAttr("aria-hidden",""),b&&this.renderWheel(b)):(this.$wheels.hide().attr("aria-hidden","true"),this.$calendar.show().removeAttr("aria-hidden",""),b&&this.renderMonth(b))},checkForMomentJS:function(){return!(!(a.isFunction(window.moment)||"undefined"!=typeof e&&a.isFunction(e))||!a.isPlainObject(this.options.momentConfig)||"string"!=typeof this.options.momentConfig.culture||"string"!=typeof this.options.momentConfig.format)},dateClicked:function(b){var c,d=a(b.currentTarget).parents("td:first");d.hasClass("restricted")||(this.$days.find("td.selected").removeClass("selected"),d.addClass("selected"),c=new Date(d.attr("data-year"),d.attr("data-month"),d.attr("data-date")),this.selectedDate=c,this.$input.val(this.formatDate(c)),this.inputValue=this.$input.val(),this.hide(),this.$input.focus(),this.$element.trigger("dateClicked.fu.datepicker",c))},destroy:function(){return this.$element.remove(),this.$days.find("tbody").empty(),this.$wheelsYear.find("ul").empty(),this.$element[0].outerHTML},disable:function(){this.$element.addClass("disabled"),this.$element.find("input, button").attr("disabled","disabled"),this.$inputGroupBtn.removeClass("open")},enable:function(){this.$element.removeClass("disabled"),this.$element.find("input, button").removeAttr("disabled")},formatDate:function(a){var b=function(a){var b="0"+a;return b.substr(b.length-2)};return this.moment?e(a).format(this.momentFormat):b(a.getMonth()+1)+"/"+b(a.getDate())+"/"+a.getFullYear()},getCulture:function(){if(this.moment)return e.locale();throw c},getDate:function(){return this.selectedDate?this.selectedDate:new Date(NaN)},getFormat:function(){if(this.moment)return this.momentFormat;throw c},getFormattedDate:function(){return this.selectedDate?this.formatDate(this.selectedDate):b},getRestrictedDates:function(){return this.restricted},inputChanged:function(){var a,b=this.$input.val();b!==this.inputValue&&(a=this.setDate(b),null===a?this.$element.trigger("inputParsingFailed.fu.datepicker",b):a===!1?this.$element.trigger("inputRestrictedDate.fu.datepicker",a):this.$element.trigger("changed.fu.datepicker",a))},show:function(){var a=this.selectedDate?this.selectedDate:new Date;this.changeView("calendar",a),this.$inputGroupBtn.addClass("open"),this.$element.trigger("shown.fu.datepicker")},showDropdown:function(a){this.$input.is(":focus")||this.$inputGroupBtn.hasClass("open")||this.show()},hide:function(){this.$inputGroupBtn.removeClass("open"),this.$element.trigger("hidden.fu.datepicker")},hideDropdown:function(){this.hide()},isInvalidDate:function(a){var c=a.toString();return c===b||"NaN"===c},isRestricted:function(a,b,c){var d,e,f,g,h=this.restrictedParsed;if(this.sameYearOnly&&null!==this.yearRestriction&&c!==this.yearRestriction)return!0;for(d=0,f=h.length;f>d;d++)if(e=h[d].from,g=h[d].to,(c>e.year||c===e.year&&b>e.month||c===e.year&&b===e.month&&a>=e.date)&&(c<g.year||c===g.year&&b<g.month||c===g.year&&b===g.month&&a<=g.date))return!0;return!1},monthClicked:function(b){this.$wheelsMonth.find(".selected").removeClass("selected"),a(b.currentTarget).parent().addClass("selected")},next:function(){var a=this.$headerTitle.attr("data-month"),b=this.$headerTitle.attr("data-year");if(a++,a>11){if(this.sameYearOnly)return;a=0,b++}this.renderMonth(new Date(b,a,1))},onYearScroll:function(b){if(!this.artificialScrolling){var c,d,e=a(b.currentTarget),f="border-box"===e.css("box-sizing")?e.outerHeight():e.height(),g=e.get(0).scrollHeight,h=e.scrollTop(),i=f/(g-h)*100,j=h/g*100;if(5>j){for(d=parseInt(e.find("li:first").attr("data-year"),10),c=d-1;c>d-11;c--)e.prepend('<li data-year="'+c+'"><button type="button">'+c+"</button></li>");this.artificialScrolling=!0,e.scrollTop(e.get(0).scrollHeight-g+h),this.artificialScrolling=!1}else if(i>90)for(d=parseInt(e.find("li:last").attr("data-year"),10),c=d+1;d+11>c;c++)e.append('<li data-year="'+c+'"><button type="button">'+c+"</button></li>")}},parseDate:function(a){var b,c,d,f,g,h,i,j=this,k=new Date(NaN);if(a){if(this.moment)return f=function(a){var b=e(a,j.momentFormat);return!0===b.isValid()?b.toDate():k},d=function(a){var b=e(new Date(a));return!0===b.isValid()?b.toDate():k},g=function(a,b,c){var d=b(a);return j.isInvalidDate(d)?(d=c(d),j.isInvalidDate(d)?k:d):d},"string"==typeof a?g(a,f,d):g(a,d,f);if("string"==typeof a){if(b=new Date(Date.parse(a)),!this.isInvalidDate(b))return b;if(a=a.split("T")[0],c=/^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,i=c.exec(a),i&&(h=parseInt(i[2],10),b=new Date(i[1],h-1,i[3]),h===b.getMonth()+1))return b}else if(b=new Date(a),!this.isInvalidDate(b))return b}return new Date(NaN)},prev:function(){var a=this.$headerTitle.attr("data-month"),b=this.$headerTitle.attr("data-year");if(a--,0>a){if(this.sameYearOnly)return;a=11,b--}this.renderMonth(new Date(b,a,1))},renderMonth:function(b){b=b||new Date;var c,d,e,f,g,h,i,j,k,l,m,n=new Date(b.getFullYear(),b.getMonth(),1).getDay(),o=new Date(b.getFullYear(),b.getMonth()+1,0).getDate(),p=new Date(b.getFullYear(),b.getMonth(),0).getDate(),q=this.$headerTitle.find(".month"),r=b.getMonth(),s=new Date,t=s.getDate(),u=s.getMonth(),v=s.getFullYear(),w=this.selectedDate,x=this.$days.find("tbody"),y=b.getFullYear();for(w&&(w={date:w.getDate(),month:w.getMonth(),year:w.getFullYear()}),q.find(".current").removeClass("current"),q.find('span[data-month="'+r+'"]').addClass("current"),this.$headerTitle.find(".year").text(y),this.$headerTitle.attr({"data-month":r,"data-year":y}),x.empty(),0!==n?(c=p-n+1,i=-1):(c=1,i=0),h=35-n>=o?5:6,f=0;h>f;f++){for(m=a("<tr></tr>"),g=0;7>g;g++)l=a("<td></td>"),-1===i?(l.addClass("last-month"),j!==i&&l.addClass("first")):1===i&&(l.addClass("next-month"),j!==i&&l.addClass("first")),d=r+i,e=y,0>d?(d=11,e--):d>11&&(d=0,e++),l.attr({"data-date":c,"data-month":d,"data-year":e}),e===v&&d===u&&c===t?l.addClass("current-day"):(v>e||e===v&&u>d||e===v&&d===u&&t>c)&&(l.addClass("past"),this.options.allowPastDates||l.addClass("restricted").attr("title",this.restrictedText)),this.isRestricted(c,d,e)&&l.addClass("restricted").attr("title",this.restrictedText),w&&e===w.year&&d===w.month&&c===w.date&&l.addClass("selected"),l.hasClass("restricted")?l.html('<span><b class="datepicker-date">'+c+"</b></span>"):l.html('<span><button type="button" class="datepicker-date">'+c+"</button></span>"),c++,k=j,j=i,-1===i&&c>p?(c=1,i=0,k!==i&&l.addClass("last")):0===i&&c>o&&(c=1,i=1,k!==i&&l.addClass("last")),f===h-1&&6===g&&l.addClass("last"),m.append(l);x.append(m)}},renderWheel:function(a){var b,c,d,e=a.getMonth(),f=this.$wheelsMonth.find("ul"),g=a.getFullYear(),h=this.$wheelsYear.find("ul");for(this.sameYearOnly?(this.$wheelsMonth.addClass("full"),this.$wheelsYear.addClass("hidden")):(this.$wheelsMonth.removeClass("full"),this.$wheelsYear.removeClass("hide hidden")),f.find(".selected").removeClass("selected"),c=f.find('li[data-month="'+e+'"]'),c.addClass("selected"),f.scrollTop(f.scrollTop()+(c.position().top-f.outerHeight()/2-c.outerHeight(!0)/2)),h.empty(),b=g-10;g+11>b;b++)h.append('<li data-year="'+b+'"><button type="button">'+b+"</button></li>");d=h.find('li[data-year="'+g+'"]'),d.addClass("selected"),this.artificialScrolling=!0,h.scrollTop(h.scrollTop()+(d.position().top-h.outerHeight()/2-d.outerHeight(!0)/2)),this.artificialScrolling=!1,c.find("button").focus()},selectClicked:function(){var a=this.$wheelsMonth.find(".selected").attr("data-month"),b=this.$wheelsYear.find(".selected").attr("data-year");this.changeView("calendar",new Date(b,a,1))},setCulture:function(a){if(!a)return!1;if(!this.moment)throw c;e.locale(a)},setDate:function(a){var b=this.parseDate(a);return this.isInvalidDate(b)?(this.selectedDate=null,this.renderMonth()):this.isRestricted(b.getDate(),b.getMonth(),b.getFullYear())?(this.selectedDate=!1,this.renderMonth()):(this.selectedDate=b,this.renderMonth(b),this.$input.val(this.formatDate(b))),this.inputValue=this.$input.val(),this.selectedDate},setFormat:function(a){if(!a)return!1;if(!this.moment)throw c;this.momentFormat=a},setRestrictedDates:function(a){var b,c,d=[],e=this,f=function(a){return a===-(1/0)?{date:-(1/0),month:-(1/0),year:-(1/0)}:a===1/0?{date:1/0,month:1/0,year:1/0}:(a=e.parseDate(a),{date:a.getDate(),month:a.getMonth(),year:a.getFullYear()})};for(this.restricted=a,b=0,c=a.length;c>b;b++)d.push({from:f(a[b].from),to:f(a[b].to)});this.restrictedParsed=d},titleClicked:function(a){this.changeView("wheels",new Date(this.$headerTitle.attr("data-year"),this.$headerTitle.attr("data-month"),1))},todayClicked:function(a){var b=new Date;b.getMonth()+""===this.$headerTitle.attr("data-month")&&b.getFullYear()+""===this.$headerTitle.attr("data-year")||this.renderMonth(b)},yearClicked:function(b){this.$wheelsYear.find(".selected").removeClass("selected"),a(b.currentTarget).parent().addClass("selected")}},i.prototype.getValue=i.prototype.getDate,a.fn.datepicker=function(b){var c,d=Array.prototype.slice.call(arguments,1),e=this.each(function(){var e=a(this),f=e.data("fu.datepicker"),g="object"==typeof b&&b;f||e.data("fu.datepicker",f=new i(this,g)),"string"==typeof b&&(c=f[b].apply(f,d))});return void 0===c?e:c},a.fn.datepicker.defaults={allowPastDates:!1,date:new Date,formatDate:null,momentConfig:{culture:"en",format:"L"},parseDate:null,restricted:[],restrictedText:"Restricted",sameYearOnly:!1},a.fn.datepicker.Constructor=i,a.fn.datepicker.noConflict=function(){return a.fn.datepicker=f,this},a(document).on("mousedown.fu.datepicker.data-api","[data-initialize=datepicker]",function(b){var c=a(b.target).closest(".datepicker");c.data("datepicker")||c.datepicker(c.data())}),a(document).on("click.fu.datepicker.data-api",".datepicker .dropdown-menu",function(b){var c=a(b.target);c.is(".datepicker-date")&&!c.closest(".restricted").length||b.stopPropagation()}),a(document).on("click.fu.datepicker.data-api",".datepicker input",function(a){a.stopPropagation()}),a(function(){a("[data-initialize=datepicker]").each(function(){var b=a(this);b.data("datepicker")||b.datepicker(b.data())})})}(a),function(a){function b(b){a(b).css({visibility:"hidden"}),c(b)?b.parent().addClass("dropup"):b.parent().removeClass("dropup"),a(b).css({visibility:"visible"})}function c(a){var b=d(a),c={};return c.parentHeight=a.parent().outerHeight(),c.parentOffsetTop=a.parent().offset().top,c.dropdownHeight=a.outerHeight(),c.containerHeight=b.overflowElement.outerHeight(),c.containerOffsetTop=b.isWindow?b.overflowElement.scrollTop():b.overflowElement.offset().top,c.fromTop=c.parentOffsetTop-c.containerOffsetTop,c.fromBottom=c.containerHeight-c.parentHeight-(c.parentOffsetTop-c.containerOffsetTop),c.dropdownHeight<c.fromBottom?!1:c.dropdownHeight<c.fromTop?!0:c.dropdownHeight>=c.fromTop&&c.dropdownHeight>=c.fromBottom?c.fromTop>=c.fromBottom:void 0}function d(b){var c,d=b.attr("data-target"),e=!0;return d?"window"!==d&&(c=a(d),e=!1):a.each(b.parents(),function(b,d){return"visible"!==a(d).css("overflow")?(c=d,e=!1,!1):void 0}),e&&(c=window),{overflowElement:a(c),isWindow:e}}a(document.body).on("click.fu.dropdown-autoflip","[data-toggle=dropdown][data-flip]",function(c){"auto"===a(this).data().flip&&b(a(this).next(".dropdown-menu"))}),a(document.body).on("suggested.fu.pillbox",function(c,d){b(a(d)),a(d).parent().addClass("open")}),a.fn.dropdownautoflip=function(){}}(a),function(a){var b=a.fn.loader,c=function(b,c){this.$element=a(b),this.options=a.extend({},a.fn.loader.defaults,c),this.begin=this.$element.is("[data-begin]")?parseInt(this.$element.attr("data-begin"),10):1,this.delay=this.$element.is("[data-delay]")?parseFloat(this.$element.attr("data-delay")):150,this.end=this.$element.is("[data-end]")?parseInt(this.$element.attr("data-end"),10):8,this.frame=this.$element.is("[data-frame]")?parseInt(this.$element.attr("data-frame"),10):this.begin,this.isIElt9=!1,this.timeout={};var d=this.msieVersion();d!==!1&&9>d&&(this.$element.addClass("iefix"),this.isIElt9=!0),this.$element.attr("data-frame",this.frame+""),this.play()};c.prototype={constructor:c,destroy:function(){return this.pause(),this.$element.remove(),this.$element[0].outerHTML},ieRepaint:function(){this.isIElt9&&this.$element.addClass("iefix_repaint").removeClass("iefix_repaint")},msieVersion:function(){var a=window.navigator.userAgent,b=a.indexOf("MSIE ");return b>0?parseInt(a.substring(b+5,a.indexOf(".",b)),10):!1},next:function(){this.frame++,this.frame>this.end&&(this.frame=this.begin),this.$element.attr("data-frame",this.frame+""),this.ieRepaint()},pause:function(){clearTimeout(this.timeout)},play:function(){var a=this;clearTimeout(this.timeout),this.timeout=setTimeout(function(){a.next(),a.play()},this.delay)},previous:function(){this.frame--,this.frame<this.begin&&(this.frame=this.end),this.$element.attr("data-frame",this.frame+""),this.ieRepaint()},reset:function(){this.frame=this.begin,this.$element.attr("data-frame",this.frame+""),this.ieRepaint()}},a.fn.loader=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.loader"),h="object"==typeof b&&b;g||f.data("fu.loader",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.loader.defaults={},a.fn.loader.Constructor=c,a.fn.loader.noConflict=function(){return a.fn.loader=b,this},a(function(){a("[data-initialize=loader]").each(function(){var b=a(this);b.data("fu.loader")||b.loader(b.data())})})}(a),function(a){var b=a.fn.placard,c={accepted:"onAccept",cancelled:"onCancel"},d=function(b,c){var d=this;this.$element=a(b),this.options=a.extend({},a.fn.placard.defaults,c),"true"===this.$element.attr("data-ellipsis")&&(this.options.applyEllipsis=!0),this.$accept=this.$element.find(".placard-accept"),this.$cancel=this.$element.find(".placard-cancel"),this.$field=this.$element.find(".placard-field"),this.$footer=this.$element.find(".placard-footer"),this.$header=this.$element.find(".placard-header"),this.$popup=this.$element.find(".placard-popup"),this.actualValue=null,this.clickStamp="_",this.previousValue="",-1===this.options.revertOnCancel&&(this.options.revertOnCancel=this.$accept.length>0),this.isContentEditableDiv=this.$field.is("div"),this.isInput=this.$field.is("input"),this.divInTextareaMode=this.isContentEditableDiv&&"true"===this.$field.attr("data-textarea"),this.$field.on("focus.fu.placard",a.proxy(this.show,this)),this.$field.on("keydown.fu.placard",a.proxy(this.keyComplete,this)),this.$element.on("close.fu.placard",a.proxy(this.hide,this)),this.$accept.on("click.fu.placard",a.proxy(this.complete,this,"accepted")),this.$cancel.on("click.fu.placard",function(a){a.preventDefault(),d.complete("cancelled")}),this.applyEllipsis()},e=function(a){return a.$element.hasClass("showing")},f=function(){var b;if(b=a(document).find(".placard.showing"),b.length>0){if(b.data("fu.placard")&&b.data("fu.placard").options.explicit)return!1;b.placard("externalClickListener",{},!0)}return!0};d.prototype={constructor:d,complete:function(a){var b=this.options[c[a]],d={previousValue:this.previousValue,value:this.getValue()};b?(b(d),this.$element.trigger(a+".fu.placard",d)):("cancelled"===a&&this.options.revertOnCancel&&this.setValue(this.previousValue,!0),this.$element.trigger(a+".fu.placard",d),this.hide())},keyComplete:function(a){(this.isContentEditableDiv&&!this.divInTextareaMode||this.isInput)&&13===a.keyCode?(this.complete("accepted"),this.$field.blur()):27===a.keyCode&&(this.complete("cancelled"),this.$field.blur())},destroy:function(){return this.$element.remove(),a(document).off("click.fu.placard.externalClick."+this.clickStamp),this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$element[0].outerHTML},disable:function(){this.$element.addClass("disabled"),this.$field.attr("disabled","disabled"),this.isContentEditableDiv&&this.$field.removeAttr("contenteditable"),this.hide()},applyEllipsis:function(){var a,b,c;if(this.options.applyEllipsis)if(a=this.$field.get(0),this.isContentEditableDiv&&!this.divInTextareaMode||this.isInput)a.scrollLeft=0;else if(a.scrollTop=0,a.clientHeight<a.scrollHeight){for(this.actualValue=this.getValue(),this.setValue("",!0),c="",b=0;a.clientHeight>=a.scrollHeight;)c+=this.actualValue[b],this.setValue(c+"...",!0),b++;c=c.length>0?c.substring(0,c.length-1):"",this.setValue(c+"...",!0)}},enable:function(){this.$element.removeClass("disabled"),this.$field.removeAttr("disabled"),this.isContentEditableDiv&&this.$field.attr("contenteditable","true")},externalClickListener:function(a,b){(b===!0||this.isExternalClick(a))&&this.complete(this.options.externalClickAction)},getValue:function(){return null!==this.actualValue?this.actualValue:this.isContentEditableDiv?this.$field.html():this.$field.val()},hide:function(){this.$element.hasClass("showing")&&(this.$element.removeClass("showing"),this.applyEllipsis(),a(document).off("click.fu.placard.externalClick."+this.clickStamp),this.$element.trigger("hidden.fu.placard"))},isExternalClick:function(b){var c,d,e=this.$element.get(0),f=this.options.externalClickExceptions||[],g=a(b.target);if(b.target===e||g.parents(".placard:first").get(0)===e)return!1;for(c=0,d=f.length;d>c;c++)if(g.is(f[c])||g.parents(f[c]).length>0)return!1;return!0},setValue:function(a,b){return"undefined"==typeof b&&(b=!this.options.applyEllipsis),this.isContentEditableDiv?this.$field.empty().append(a):this.$field.val(a),b||e(this)||this.applyEllipsis(),this.$field},show:function(){e(this)||f()&&(this.previousValue=this.isContentEditableDiv?this.$field.html():this.$field.val(),null!==this.actualValue&&(this.setValue(this.actualValue,!0),this.actualValue=null),this.showPlacard())},showPlacard:function(){this.$element.addClass("showing"),this.$header.length>0&&this.$popup.css("top","-"+this.$header.outerHeight(!0)+"px"),this.$footer.length>0&&this.$popup.css("bottom","-"+this.$footer.outerHeight(!0)+"px"),this.$element.trigger("shown.fu.placard"),this.clickStamp=(new Date).getTime()+(Math.floor(100*Math.random())+1),this.options.explicit||a(document).on("click.fu.placard.externalClick."+this.clickStamp,a.proxy(this.externalClickListener,this))}},a.fn.placard=function(b){var c,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.placard"),h="object"==typeof b&&b;g||f.data("fu.placard",g=new d(this,h)),"string"==typeof b&&(c=g[b].apply(g,e))});return void 0===c?f:c},a.fn.placard.defaults={onAccept:void 0,onCancel:void 0,externalClickAction:"cancelled",externalClickExceptions:[],explicit:!1,revertOnCancel:-1,applyEllipsis:!1},a.fn.placard.Constructor=d,a.fn.placard.noConflict=function(){return a.fn.placard=b,this},a(document).on("focus.fu.placard.data-api","[data-initialize=placard]",function(b){var c=a(b.target).closest(".placard");c.data("fu.placard")||c.placard(c.data())}),a(function(){a("[data-initialize=placard]").each(function(){var b=a(this);b.data("fu.placard")||b.placard(b.data())})})}(a),function(a){var b=a.fn.radio,c=function(b,c){if(this.options=a.extend({},a.fn.radio.defaults,c),"label"===b.tagName.toLowerCase()){this.$label=a(b),this.$radio=this.$label.find('input[type="radio"]'),this.groupName=this.$radio.attr("name");var d=this.$radio.attr("data-toggle");this.$toggleContainer=a(d),this.$radio.on("change",a.proxy(this.itemchecked,this)),this.setInitialState()}};c.prototype={constructor:c,setInitialState:function(){var a=this.$radio,b=(this.$label,a.prop("checked")),c=a.prop("disabled");this.setCheckedState(a,b),this.setDisabledState(a,c)},resetGroup:function(){var b=a('input[name="'+this.groupName+'"]');b.each(function(b,c){var d=a(c),e=d.parent(),f=d.attr("data-toggle"),g=a(f);e.removeClass("checked"),g.addClass("hidden")})},setCheckedState:function(b,c){var d=b,e=d.parent(),f=d.attr("data-toggle"),g=a(f);c?(this.resetGroup(),d.prop("checked",!0),e.addClass("checked"),g.removeClass("hide hidden"),e.trigger("checked.fu.radio")):(d.prop("checked",!1),e.removeClass("checked"),g.addClass("hidden"),e.trigger("unchecked.fu.radio")),e.trigger("changed.fu.radio",c)},setDisabledState:function(a,b){var c=this.$label;b?(this.$radio.prop("disabled",!0),c.addClass("disabled"),c.trigger("disabled.fu.radio")):(this.$radio.prop("disabled",!1),c.removeClass("disabled"),c.trigger("enabled.fu.radio"))},itemchecked:function(b){var c=a(b.target);this.setCheckedState(c,!0)},check:function(){this.setCheckedState(this.$radio,!0)},uncheck:function(){this.setCheckedState(this.$radio,!1)},isChecked:function(){var a=this.$radio.prop("checked");return a},enable:function(){this.setDisabledState(this.$radio,!1)},disable:function(){this.setDisabledState(this.$radio,!0)},destroy:function(){return this.$label.remove(),this.$label[0].outerHTML}},c.prototype.getValue=c.prototype.isChecked,a.fn.radio=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.radio"),h="object"==typeof b&&b;g||f.data("fu.radio",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e));
});return void 0===d?f:d},a.fn.radio.defaults={},a.fn.radio.Constructor=c,a.fn.radio.noConflict=function(){return a.fn.radio=b,this},a(document).on("mouseover.fu.radio.data-api","[data-initialize=radio]",function(b){var c=a(b.target);c.data("fu.radio")||c.radio(c.data())}),a(function(){a("[data-initialize=radio]").each(function(){var b=a(this);b.data("fu.radio")||b.radio(b.data())})})}(a),function(a){var b=a.fn.search,c=function(b,c){this.$element=a(b),this.$repeater=a(b).closest(".repeater"),this.options=a.extend({},a.fn.search.defaults,c),"true"===this.$element.attr("data-searchOnKeyPress")&&(this.options.searchOnKeyPress=!0),this.$button=this.$element.find("button"),this.$input=this.$element.find("input"),this.$icon=this.$element.find(".glyphicon"),this.$button.on("click.fu.search",a.proxy(this.buttonclicked,this)),this.$input.on("keyup.fu.search",a.proxy(this.keypress,this)),this.$repeater.length>0&&this.$repeater.on("rendered.fu.repeater",a.proxy(this.clearPending,this)),this.activeSearch=""};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$element[0].outerHTML},search:function(a){this.$icon.hasClass("glyphicon")&&this.$icon.removeClass("glyphicon-search").addClass("glyphicon-remove"),this.activeSearch=a,this.$element.addClass("searched pending"),this.$element.trigger("searched.fu.search",a)},clear:function(){this.$icon.hasClass("glyphicon")&&this.$icon.removeClass("glyphicon-remove").addClass("glyphicon-search"),this.$element.hasClass("pending")&&this.$element.trigger("canceled.fu.search"),this.activeSearch="",this.$input.val(""),this.$element.trigger("cleared.fu.search"),this.$element.removeClass("searched pending")},clearPending:function(){this.$element.removeClass("pending")},action:function(){var a=this.$input.val();a&&a.length>0?this.search(a):this.clear()},buttonclicked:function(b){b.preventDefault(),a(b.currentTarget).is(".disabled, :disabled")||(this.$element.hasClass("pending")||this.$element.hasClass("searched")?this.clear():this.action())},keypress:function(a){var b=13,c=9,d=27;a.which===b?(a.preventDefault(),this.action()):a.which===c?a.preventDefault():a.which===d?(a.preventDefault(),this.clear()):this.options.searchOnKeyPress&&this.action()},disable:function(){this.$element.addClass("disabled"),this.$input.attr("disabled","disabled"),this.options.allowCancel||this.$button.addClass("disabled")},enable:function(){this.$element.removeClass("disabled"),this.$input.removeAttr("disabled"),this.$button.removeClass("disabled")}},a.fn.search=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.search"),h="object"==typeof b&&b;g||f.data("fu.search",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.search.defaults={clearOnEmpty:!1,searchOnKeyPress:!1,allowCancel:!1},a.fn.search.Constructor=c,a.fn.search.noConflict=function(){return a.fn.search=b,this},a(document).on("mousedown.fu.search.data-api","[data-initialize=search]",function(b){var c=a(b.target).closest(".search");c.data("fu.search")||c.search(c.data())}),a(function(){a("[data-initialize=search]").each(function(){var b=a(this);b.data("fu.search")||b.search(b.data())})})}(a),function(a){var b=a.fn.selectlist,c=function(b,c){this.$element=a(b),this.options=a.extend({},a.fn.selectlist.defaults,c),this.$button=this.$element.find(".btn.dropdown-toggle"),this.$hiddenField=this.$element.find(".hidden-field"),this.$label=this.$element.find(".selected-label"),this.$dropdownMenu=this.$element.find(".dropdown-menu"),this.$element.on("click.fu.selectlist",".dropdown-menu a",a.proxy(this.itemClicked,this)),this.setDefaultSelection(),"auto"!==c.resize&&"auto"!==this.$element.attr("data-resize")||this.resize();var d=this.$dropdownMenu.children("li");0===d.length&&(this.disable(),this.doSelect(a(this.options.emptyLabelHTML))),this.$element.on("shown.bs.dropdown",function(){var b=a(this);a(document).on("keypress.fu.selectlist",function(c){var d=String.fromCharCode(c.which);b.find("li").each(function(b,c){return a(c).text().charAt(0).toLowerCase()===d?(a(c).children("a").focus(),!1):void 0})})}),this.$element.on("hide.bs.dropdown",function(){a(document).off("keypress.fu.selectlist")})};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element[0].outerHTML},doSelect:function(b){var c;this.$selectedItem=c=b,this.$hiddenField.val(this.$selectedItem.attr("data-value")),this.$label.html(a(this.$selectedItem.children()[0]).html()),this.$element.find("li").each(function(){c.is(a(this))?a(this).attr("data-selected",!0):a(this).removeData("selected").removeAttr("data-selected")})},itemClicked:function(b){this.$element.trigger("clicked.fu.selectlist",this.$selectedItem),b.preventDefault(),a(b.currentTarget).parent("li").is(".disabled, :disabled")||(a(b.target).parent().is(this.$selectedItem)||this.itemChanged(b),this.$element.find(".dropdown-toggle").focus())},itemChanged:function(b){this.doSelect(a(b.target).closest("li"));var c=this.selectedItem();this.$element.trigger("changed.fu.selectlist",c)},resize:function(){var b=0,c=0,d=a("<div/>").addClass("selectlist-sizer");Boolean(a(document).find("html").hasClass("fuelux"))?a(document.body).append(d):a(".fuelux:first").append(d),d.append(this.$element.clone()),this.$element.find("a").each(function(){d.find(".selected-label").text(a(this).text()),c=d.find(".selectlist").outerWidth(),c+=d.find(".sr-only").outerWidth(),c>b&&(b=c)}),1>=b||(this.$button.css("width",b),this.$dropdownMenu.css("width",b),d.remove())},selectedItem:function(){var b=this.$selectedItem.text();return a.extend({text:b},this.$selectedItem.data())},selectByText:function(b){var c=a([]);this.$element.find("li").each(function(){return(this.textContent||this.innerText||a(this).text()||"").toLowerCase()===(b||"").toLowerCase()?(c=a(this),!1):void 0}),this.doSelect(c)},selectByValue:function(a){var b='li[data-value="'+a+'"]';this.selectBySelector(b)},selectByIndex:function(a){var b="li:eq("+a+")";this.selectBySelector(b)},selectBySelector:function(a){var b=this.$element.find(a);this.doSelect(b)},setDefaultSelection:function(){var a=this.$element.find("li[data-selected=true]").eq(0);0===a.length&&(a=this.$element.find("li").has("a").eq(0)),this.doSelect(a)},enable:function(){this.$element.removeClass("disabled"),this.$button.removeClass("disabled")},disable:function(){this.$element.addClass("disabled"),this.$button.addClass("disabled")}},c.prototype.getValue=c.prototype.selectedItem,a.fn.selectlist=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.selectlist"),h="object"==typeof b&&b;g||f.data("fu.selectlist",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.selectlist.defaults={emptyLabelHTML:'<li data-value=""><a href="#">No items</a></li>'},a.fn.selectlist.Constructor=c,a.fn.selectlist.noConflict=function(){return a.fn.selectlist=b,this},a(document).on("mousedown.fu.selectlist.data-api","[data-initialize=selectlist]",function(b){var c=a(b.target).closest(".selectlist");c.data("fu.selectlist")||c.selectlist(c.data())}),a(function(){a("[data-initialize=selectlist]").each(function(){var b=a(this);b.data("fu.selectlist")||b.selectlist(b.data())})})}(a),function(a){var b=a.fn.spinbox,c=function(b,c){this.$element=a(b),this.$element.find(".btn").on("click",function(a){a.preventDefault()}),this.options=a.extend({},a.fn.spinbox.defaults,c),this.options.step=this.$element.data("step")||this.options.step,this.options.value<this.options.min?this.options.value=this.options.min:this.options.max<this.options.value&&(this.options.value=this.options.max),this.$input=this.$element.find(".spinbox-input"),this.$input.on("focusout.fu.spinbox",this.$input,a.proxy(this.change,this)),this.$element.on("keydown.fu.spinbox",this.$input,a.proxy(this.keydown,this)),this.$element.on("keyup.fu.spinbox",this.$input,a.proxy(this.keyup,this)),this.bindMousewheelListeners(),this.mousewheelTimeout={},this.options.hold?(this.$element.on("mousedown.fu.spinbox",".spinbox-up",a.proxy(function(){this.startSpin(!0)},this)),this.$element.on("mouseup.fu.spinbox",".spinbox-up, .spinbox-down",a.proxy(this.stopSpin,this)),this.$element.on("mouseout.fu.spinbox",".spinbox-up, .spinbox-down",a.proxy(this.stopSpin,this)),this.$element.on("mousedown.fu.spinbox",".spinbox-down",a.proxy(function(){this.startSpin(!1)},this))):(this.$element.on("click.fu.spinbox",".spinbox-up",a.proxy(function(){this.step(!0)},this)),this.$element.on("click.fu.spinbox",".spinbox-down",a.proxy(function(){this.step(!1)},this))),this.switches={count:1,enabled:!0},"medium"===this.options.speed?this.switches.speed=300:"fast"===this.options.speed?this.switches.speed=100:this.switches.speed=500,this.options.defaultUnit=e(this.options.defaultUnit,this.options.units)?this.options.defaultUnit:"",this.unit=this.options.defaultUnit,this.lastValue=this.options.value,this.render(),this.options.disabled&&this.disable()},d=function(a,b){return Math.round(a/b)*b},e=function(b,c){var d=!1,e=b.toLowerCase();return a.each(c,function(a,b){return b=b.toLowerCase(),e===b?(d=!0,!1):void 0}),d},f=function(a){return isNaN(parseFloat(a))?a:(a>this.options.max?a=this.options.cycle?this.options.min:this.options.max:a<this.options.min&&(a=this.options.cycle?this.options.max:this.options.min),this.options.limitToStep&&this.options.step&&(a=d(a,this.options.step),a>this.options.max?a-=this.options.step:a<this.options.min&&(a+=this.options.step)),a)};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$element[0].outerHTML},render:function(){this.setValue(this.getDisplayValue())},change:function(){this.setValue(this.getDisplayValue()),this.triggerChangedEvent()},stopSpin:function(){void 0!==this.switches.timeout&&(clearTimeout(this.switches.timeout),this.switches.count=1,this.triggerChangedEvent())},triggerChangedEvent:function(){var a=this.getValue();a!==this.lastValue&&(this.lastValue=a,this.$element.trigger("changed.fu.spinbox",a))},startSpin:function(b){if(!this.options.disabled){var c=this.switches.count;1===c?(this.step(b),c=1):c=3>c?1.5:8>c?2.5:4,this.switches.timeout=setTimeout(a.proxy(function(){this.iterate(b)},this),this.switches.speed/c),this.switches.count++}},iterate:function(a){this.step(a),this.startSpin(a)},step:function(a){this.setValue(this.getDisplayValue());var b;b=a?this.options.value+this.options.step:this.options.value-this.options.step,b=b.toFixed(5),this.setValue(b+this.unit)},getDisplayValue:function(){var a=this.parseInput(this.$input.val()),b=a?a:this.options.value;return b},setDisplayValue:function(a){this.$input.val(a)},getValue:function(){var a=this.options.value;return"."!==this.options.decimalMark&&(a=(a+"").split(".").join(this.options.decimalMark)),a+this.unit},setValue:function(a){if("."!==this.options.decimalMark&&(a=this.parseInput(a)),"number"!=typeof a){var b=a.replace(/[0-9.-]/g,"");this.unit=e(b,this.options.units)?b:this.options.defaultUnit}var c=this.getIntValue(a);return isNaN(c)&&!isFinite(c)?this.setValue(this.options.value):(c=f.call(this,c),this.options.value=c,a=c+this.unit,"."!==this.options.decimalMark&&(a=(a+"").split(".").join(this.options.decimalMark)),this.setDisplayValue(a),this)},value:function(a){return a||0===a?this.setValue(a):this.getValue()},parseInput:function(a){return a=(a+"").split(this.options.decimalMark).join(".")},getIntValue:function(a){return a="undefined"==typeof a?this.getValue():a,"undefined"!=typeof a?("string"==typeof a&&(a=this.parseInput(a)),a=parseFloat(a,10)):void 0},disable:function(){this.options.disabled=!0,this.$element.addClass("disabled"),this.$input.attr("disabled",""),this.$element.find("button").addClass("disabled")},enable:function(){this.options.disabled=!1,this.$element.removeClass("disabled"),this.$input.removeAttr("disabled"),this.$element.find("button").removeClass("disabled")},keydown:function(a){var b=a.keyCode;38===b?this.step(!0):40===b?this.step(!1):13===b&&this.change()},keyup:function(a){var b=a.keyCode;38!==b&&40!==b||this.triggerChangedEvent()},bindMousewheelListeners:function(){var b=this.$input.get(0);b.addEventListener?(b.addEventListener("mousewheel",a.proxy(this.mousewheelHandler,this),!1),b.addEventListener("DOMMouseScroll",a.proxy(this.mousewheelHandler,this),!1)):b.attachEvent("onmousewheel",a.proxy(this.mousewheelHandler,this))},mousewheelHandler:function(a){if(!this.options.disabled){var b=window.event||a,c=Math.max(-1,Math.min(1,b.wheelDelta||-b.detail)),d=this;return clearTimeout(this.mousewheelTimeout),this.mousewheelTimeout=setTimeout(function(){d.triggerChangedEvent()},300),0>c?this.step(!0):this.step(!1),b.preventDefault?b.preventDefault():b.returnValue=!1,!1}}},a.fn.spinbox=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.spinbox"),h="object"==typeof b&&b;g||f.data("fu.spinbox",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.spinbox.defaults={value:0,min:0,max:999,step:1,hold:!0,speed:"medium",disabled:!1,cycle:!1,units:[],decimalMark:".",defaultUnit:"",limitToStep:!1},a.fn.spinbox.Constructor=c,a.fn.spinbox.noConflict=function(){return a.fn.spinbox=b,this},a(document).on("mousedown.fu.spinbox.data-api","[data-initialize=spinbox]",function(b){var c=a(b.target).closest(".spinbox");c.data("fu.spinbox")||c.spinbox(c.data())}),a(function(){a("[data-initialize=spinbox]").each(function(){var b=a(this);b.data("fu.spinbox")||b.spinbox(b.data())})})}(a),function(a){function b(a,b){a.addClass("tree-selected"),"item"===a.data("type")&&b.hasClass("fueluxicon-bullet")&&b.removeClass("fueluxicon-bullet").addClass("glyphicon-ok")}function c(a,b){a.removeClass("tree-selected"),"item"===a.data("type")&&b.hasClass("glyphicon-ok")&&b.removeClass("glyphicon-ok").addClass("fueluxicon-bullet")}function d(d,e,f){a.each(f.$elements,function(b,c){var d=a(c);d[0]!==e.$element[0]&&f.dataForEvent.push(a(d).data())}),e.$element.hasClass("tree-selected")?(c(e.$element,e.$icon),f.eventType="deselected"):(b(e.$element,e.$icon),f.eventType="selected",f.dataForEvent.push(e.elementData))}function e(a,d,e){if(e.$elements[0]!==d.$element[0]){a.deselectAll(a.$element);b(d.$element,d.$icon),e.eventType="selected",e.dataForEvent=[d.elementData]}else c(d.$element,d.$icon),e.eventType="deselected",e.dataForEvent=[]}var f=a.fn.tree,g=function(b,c){this.$element=a(b),this.options=a.extend({},a.fn.tree.defaults,c),this.options.itemSelect&&this.$element.on("click.fu.tree",".tree-item",a.proxy(function(a){this.selectItem(a.currentTarget)},this)),this.$element.on("click.fu.tree",".tree-branch-name",a.proxy(function(a){this.toggleFolder(a.currentTarget)},this)),this.$element.on("click.fu.tree",".tree-overflow",a.proxy(function(b){this.populate(a(b.currentTarget))},this)),this.options.folderSelect&&(this.$element.addClass("tree-folder-select"),this.$element.off("click.fu.tree",".tree-branch-name"),this.$element.on("click.fu.tree",".icon-caret",a.proxy(function(b){this.toggleFolder(a(b.currentTarget).parent())},this)),this.$element.on("click.fu.tree",".tree-branch-name",a.proxy(function(b){this.selectFolder(a(b.currentTarget))},this))),this.render()};g.prototype={constructor:g,deselectAll:function(b){b=b||this.$element;var d=a(b).find(".tree-selected");return d.each(function(b,d){c(a(d),a(d).find(".glyphicon"))}),d},destroy:function(){return this.$element.find("li:not([data-template])").remove(),this.$element.remove(),this.$element[0].outerHTML},render:function(){this.populate(this.$element)},populate:function(b,c){var d=this,e=b.hasClass("tree-overflow"),f=b.hasClass("tree")?b:b.parent(),g=f.hasClass("tree");e&&!g&&(f=f.parent());var h=f.data();e&&(h.overflow=b.data()),c=c||!1,e&&(g?b.replaceWith(f.find("> .tree-loader").remove()):b.remove());var i=f.find(".tree-loader:last");c===!1&&i.removeClass("hide hidden"),this.options.dataSource(h?h:{},function(b){a.each(b.data,function(b,c){var e;"folder"===c.type?(e=d.$element.find("[data-template=treebranch]:eq(0)").clone().removeClass("hide hidden").removeData("template").removeAttr("data-template"),e.data(c),e.find(".tree-branch-name > .tree-label").html(c.text||c.name)):"item"===c.type?(e=d.$element.find("[data-template=treeitem]:eq(0)").clone().removeClass("hide hidden").removeData("template").removeAttr("data-template"),e.find(".tree-item-name > .tree-label").html(c.text||c.name),e.data(c)):"overflow"===c.type&&(e=d.$element.find("[data-template=treeoverflow]:eq(0)").clone().removeClass("hide hidden").removeData("template").removeAttr("data-template"),e.find(".tree-overflow-name > .tree-label").html(c.text||c.name),e.data(c));var h=c.attr||c.dataAttributes||[];a.each(h,function(a,b){switch(a){case"cssClass":case"class":case"className":e.addClass(b);break;case"data-icon":e.find(".icon-item").removeClass().addClass("icon-item "+b),e.attr(a,b);break;case"id":e.attr(a,b),e.attr("aria-labelledby",b+"-label"),e.find(".tree-branch-name > .tree-label").attr("id",b+"-label");break;default:e.attr(a,b)}}),g?f.append(e):f.find(".tree-branch-children:eq(0)").append(e)}),f.find(".tree-loader").addClass("hidden"),d.$element.trigger("loaded.fu.tree",f)})},selectTreeNode:function(b,c){var f={};f.$element=a(b);var g={};g.$elements=this.$element.find(".tree-selected"),g.dataForEvent=[],"folder"===c?(f.$element=f.$element.closest(".tree-branch"),f.$icon=f.$element.find(".icon-folder")):f.$icon=f.$element.find(".icon-item"),f.elementData=f.$element.data(),this.options.multiSelect?d(this,f,g):e(this,f,g),this.$element.trigger(g.eventType+".fu.tree",{target:f.elementData,selected:g.dataForEvent}),f.$element.trigger("updated.fu.tree",{selected:g.dataForEvent,item:f.$element,eventType:g.eventType})},discloseFolder:function(b){var c=a(b),d=c.closest(".tree-branch"),e=d.find(".tree-branch-children"),f=e.eq(0);d.addClass("tree-open"),d.attr("aria-expanded","true"),f.removeClass("hide hidden"),d.find("> .tree-branch-header .icon-folder").eq(0).removeClass("glyphicon-folder-close").addClass("glyphicon-folder-open"),e.children().length||this.populate(e),this.$element.trigger("disclosedFolder.fu.tree",d.data())},closeFolder:function(b){var c=a(b),d=c.closest(".tree-branch"),e=d.find(".tree-branch-children"),f=e.eq(0);d.removeClass("tree-open"),d.attr("aria-expanded","false"),f.addClass("hidden"),d.find("> .tree-branch-header .icon-folder").eq(0).removeClass("glyphicon-folder-open").addClass("glyphicon-folder-close"),this.options.cacheItems||f.empty(),this.$element.trigger("closed.fu.tree",d.data())},toggleFolder:function(b){var c=a(b);c.find(".glyphicon-folder-close").length?this.discloseFolder(b):c.find(".glyphicon-folder-open").length&&this.closeFolder(b)},selectFolder:function(a){this.options.folderSelect&&this.selectTreeNode(a,"folder")},selectItem:function(a){this.options.itemSelect&&this.selectTreeNode(a,"item")},selectedItems:function(){var b=this.$element.find(".tree-selected"),c=[];return a.each(b,function(b,d){c.push(a(d).data())}),c},collapse:function(){var a=this,b=[],c=function d(c,e){b.push(e),0===a.$element.find(".tree-branch.tree-open:not('.hidden, .hide')").length&&(a.$element.trigger("closedAll.fu.tree",{tree:a.$element,reportedClosed:b}),a.$element.off("loaded.fu.tree",a.$element,d))};a.$element.on("closed.fu.tree",c),a.$element.find(".tree-branch.tree-open:not('.hidden, .hide')").each(function(){a.closeFolder(this)})},discloseVisible:function(){var b=this,c=b.$element.find(".tree-branch:not('.tree-open, .hidden, .hide')"),d=[],e=function f(a,e){d.push(e),d.length===c.length&&(b.$element.trigger("disclosedVisible.fu.tree",{tree:b.$element,reportedOpened:d}),b.$element.off("loaded.fu.tree",b.$element,f))};b.$element.on("loaded.fu.tree",e),b.$element.find(".tree-branch:not('.tree-open, .hidden, .hide')").each(function(){b.discloseFolder(a(this).find(".tree-branch-header"))})},discloseAll:function(){var a=this;"undefined"==typeof a.$element.data("disclosures")&&a.$element.data("disclosures",0);var b=a.options.disclosuresUpperLimit>=1&&a.$element.data("disclosures")>=a.options.disclosuresUpperLimit,c=0===a.$element.find(".tree-branch:not('.tree-open, .hidden, .hide')").length;if(c)a.$element.trigger("disclosedAll.fu.tree",{tree:a.$element,disclosures:a.$element.data("disclosures")}),a.options.cacheItems||a.$element.one("closeAll.fu.tree",function(){a.$element.data("disclosures",0)});else{if(b&&(a.$element.trigger("exceededDisclosuresLimit.fu.tree",{tree:a.$element,disclosures:a.$element.data("disclosures")}),!a.$element.data("ignore-disclosures-limit")))return;a.$element.data("disclosures",a.$element.data("disclosures")+1),a.$element.one("disclosedVisible.fu.tree",function(){a.discloseAll()}),a.discloseVisible()}},refreshFolder:function(a){var b=a.closest(".tree-branch"),c=b.find(".tree-branch-children");c.eq(0).empty(),b.hasClass("tree-open")?this.populate(c,!1):this.populate(c,!0),this.$element.trigger("refreshedFolder.fu.tree",b.data())}},g.prototype.closeAll=g.prototype.collapse,g.prototype.openFolder=g.prototype.discloseFolder,g.prototype.getValue=g.prototype.selectedItems,a.fn.tree=function(b){var c,d=Array.prototype.slice.call(arguments,1),e=this.each(function(){var e=a(this),f=e.data("fu.tree"),h="object"==typeof b&&b;f||e.data("fu.tree",f=new g(this,h)),"string"==typeof b&&(c=f[b].apply(f,d))});return void 0===c?e:c},a.fn.tree.defaults={dataSource:function(a,b){},multiSelect:!1,cacheItems:!0,folderSelect:!0,itemSelect:!0,disclosuresUpperLimit:0},a.fn.tree.Constructor=g,a.fn.tree.noConflict=function(){return a.fn.tree=f,this}}(a),function(a){var b=a.fn.wizard,c=function(b,c){var d;this.$element=a(b),this.options=a.extend({},a.fn.wizard.defaults,c),this.options.disablePreviousStep="previous"===this.$element.attr("data-restrict")?!0:this.options.disablePreviousStep,this.currentStep=this.options.selectedItem.step,this.numSteps=this.$element.find(".steps li").length,this.$prevBtn=this.$element.find("button.btn-prev"),this.$nextBtn=this.$element.find("button.btn-next"),0===this.$element.children(".steps-container").length&&(this.$element.addClass("no-steps-container"),window&&window.console&&window.console.warn&&window.console.warn('please update your wizard markup to include ".steps-container" as seen in http://getfuelux.com/javascript.html#wizard-usage-markup')),d=this.$nextBtn.children().detach(),this.nextText=a.trim(this.$nextBtn.text()),this.$nextBtn.append(d),this.$prevBtn.on("click.fu.wizard",a.proxy(this.previous,this)),this.$nextBtn.on("click.fu.wizard",a.proxy(this.next,this)),this.$element.on("click.fu.wizard","li.complete",a.proxy(this.stepclicked,this)),this.selectedItem(this.options.selectedItem),this.options.disablePreviousStep&&(this.$prevBtn.attr("disabled",!0),this.$element.find(".steps").addClass("previous-disabled"))};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element[0].outerHTML},addSteps:function(b){var c,d,e,f,g,h,i=[].slice.call(arguments).slice(1),j=this.$element.find(".steps"),k=this.$element.find(".step-content");for(b=-1===b||b>this.numSteps+1?this.numSteps+1:b,i[0]instanceof Array&&(i=i[0]),g=j.find("li:nth-child("+b+")"),f=k.find(".step-pane:nth-child("+b+")"),g.length<1&&(g=null),c=0,d=i.length;d>c;c++)h=a('<li data-step="'+b+'"><span class="badge badge-info"></span></li>'),h.append(i[c].label||"").append('<span class="chevron"></span>'),h.find(".badge").append(i[c].badge||b),e=a('<div class="step-pane" data-step="'+b+'"></div>'),e.append(i[c].pane||""),g?(g.before(h),f.before(e)):(j.append(h),k.append(e)),b++;this.syncSteps(),this.numSteps=j.find("li").length,this.setState()},removeSteps:function(b,c){var d,e="nextAll",f=0,g=this.$element.find(".steps"),h=this.$element.find(".step-content");c=void 0!==c?c:1,b>g.find("li").length?d=g.find("li:last"):(d=g.find("li:nth-child("+b+")").prev(),d.length<1&&(e="children",d=g)),d[e]().each(function(){var b=a(this),d=b.attr("data-step");return c>f?(b.remove(),h.find('.step-pane[data-step="'+d+'"]:first').remove(),void f++):!1}),this.syncSteps(),this.numSteps=g.find("li").length,this.setState()},setState:function(){var b=this.currentStep>1,c=1===this.currentStep,d=this.currentStep===this.numSteps;this.options.disablePreviousStep||this.$prevBtn.attr("disabled",c===!0||b===!1);var e=this.$nextBtn.attr("data-last");if(e){this.lastText=e;var f=this.nextText;d===!0?(f=this.lastText,this.$element.addClass("complete")):this.$element.removeClass("complete");var g=this.$nextBtn.children().detach();this.$nextBtn.text(f).append(g)}var h=this.$element.find(".steps li");h.removeClass("active").removeClass("complete"),h.find("span.badge").removeClass("badge-info").removeClass("badge-success");var i=".steps li:lt("+(this.currentStep-1)+")",j=this.$element.find(i);j.addClass("complete"),j.find("span.badge").addClass("badge-success");var k=".steps li:eq("+(this.currentStep-1)+")",l=this.$element.find(k);l.addClass("active"),l.find("span.badge").addClass("badge-info");var m=this.$element.find(".step-content"),n=l.attr("data-step");m.find(".step-pane").removeClass("active"),m.find('.step-pane[data-step="'+n+'"]:first').addClass("active"),this.$element.find(".steps").first().attr("style","margin-left: 0");var o=0;this.$element.find(".steps > li").each(function(){o+=a(this).outerWidth()});var p=0;if(p=this.$element.find(".actions").length?this.$element.width()-this.$element.find(".actions").first().outerWidth():this.$element.width(),o>p){var q=o-p;this.$element.find(".steps").first().attr("style","margin-left: -"+q+"px"),this.$element.find("li.active").first().position().left<200&&(q+=this.$element.find("li.active").first().position().left-200,1>q?this.$element.find(".steps").first().attr("style","margin-left: 0"):this.$element.find(".steps").first().attr("style","margin-left: -"+q+"px"))}if("undefined"!=typeof this.initialized){var r=a.Event("changed.fu.wizard");this.$element.trigger(r,{step:this.currentStep})}this.initialized=!0},stepclicked:function(b){var c=a(b.currentTarget),d=this.$element.find(".steps li").index(c);if(!(d<this.currentStep&&this.options.disablePreviousStep)){var e=a.Event("stepclicked.fu.wizard");this.$element.trigger(e,{step:d+1}),e.isDefaultPrevented()||(this.currentStep=d+1,this.setState())}},syncSteps:function(){var b=1,c=this.$element.find(".steps"),d=this.$element.find(".step-content");c.children().each(function(){var c=a(this),e=c.find(".badge"),f=c.attr("data-step");isNaN(parseInt(e.html(),10))||e.html(b),c.attr("data-step",b),d.find('.step-pane[data-step="'+f+'"]:last').attr("data-step",b),b++})},previous:function(){if(!this.options.disablePreviousStep&&1!==this.currentStep){var b=a.Event("actionclicked.fu.wizard");if(this.$element.trigger(b,{step:this.currentStep,direction:"previous"}),!b.isDefaultPrevented()&&(this.currentStep-=1,this.setState(),this.$prevBtn.is(":focus"))){var c=this.$element.find(".active").find("input, select, textarea")[0];"undefined"!=typeof c?a(c).focus():0===this.$element.find(".active input:first").length&&this.$prevBtn.is(":disabled")&&this.$nextBtn.focus()}}},next:function(){var b=a.Event("actionclicked.fu.wizard");if(this.$element.trigger(b,{step:this.currentStep,direction:"next"}),!b.isDefaultPrevented()&&(this.currentStep<this.numSteps?(this.currentStep+=1,this.setState()):this.$element.trigger("finished.fu.wizard"),this.$nextBtn.is(":focus"))){var c=this.$element.find(".active").find("input, select, textarea")[0];"undefined"!=typeof c?a(c).focus():0===this.$element.find(".active input:first").length&&this.$nextBtn.is(":disabled")&&this.$prevBtn.focus()}},selectedItem:function(a){var b,c;return a?(c=a.step||-1,c=Number(this.$element.find('.steps li[data-name="'+c+'"]').first().attr("data-step"))||Number(c),c>=1&&c<=this.numSteps?(this.currentStep=c,this.setState()):(c=this.$element.find(".steps li.active:first").attr("data-step"),isNaN(c)||(this.currentStep=parseInt(c,10),this.setState())),b=this):(b={step:this.currentStep},this.$element.find(".steps li.active:first[data-name]").length&&(b.stepname=this.$element.find(".steps li.active:first").attr("data-name"))),b}},a.fn.wizard=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.wizard"),h="object"==typeof b&&b;g||f.data("fu.wizard",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.wizard.defaults={disablePreviousStep:!1,selectedItem:{step:-1}},a.fn.wizard.Constructor=c,a.fn.wizard.noConflict=function(){return a.fn.wizard=b,this},a(document).on("mouseover.fu.wizard.data-api","[data-initialize=wizard]",function(b){var c=a(b.target).closest(".wizard");c.data("fu.wizard")||c.wizard(c.data())}),a(function(){a("[data-initialize=wizard]").each(function(){var b=a(this);b.data("fu.wizard")||b.wizard(b.data())})})}(a),function(a){var b=a.fn.infinitescroll,c=function(b,c){this.$element=a(b),this.$element.addClass("infinitescroll"),this.options=a.extend({},a.fn.infinitescroll.defaults,c),this.curScrollTop=this.$element.scrollTop(),this.curPercentage=this.getPercentage(),this.fetchingData=!1,this.$element.on("scroll.fu.infinitescroll",a.proxy(this.onScroll,this)),this.onScroll()};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element.empty(),this.$element[0].outerHTML},disable:function(){this.$element.off("scroll.fu.infinitescroll")},enable:function(){this.$element.on("scroll.fu.infinitescroll",a.proxy(this.onScroll,this))},end:function(b){var c=a('<div class="infinitescroll-end"></div>');b?c.append(b):c.append("---------"),this.$element.append(c),this.disable()},getPercentage:function(){var a="border-box"===this.$element.css("box-sizing")?this.$element.outerHeight():this.$element.height(),b=this.$element.get(0).scrollHeight;return b>a?a/(b-this.curScrollTop)*100:0},fetchData:function(b){var c,d=a('<div class="infinitescroll-load"></div>'),e=this,f=function(){var b={percentage:e.curPercentage,scrollTop:e.curScrollTop},c=a('<div class="loader"></div>');d.append(c),c.loader(),e.options.dataSource&&e.options.dataSource(b,function(a){var b;d.remove(),a.content&&e.$element.append(a.content),a.end&&(b=a.end!==!0?a.end:void 0,e.end(b)),e.fetchingData=!1})};this.fetchingData=!0,this.$element.append(d),this.options.hybrid&&b!==!0?(c=a('<button type="button" class="btn btn-primary"></button>'),"object"==typeof this.options.hybrid?c.append(this.options.hybrid.label):c.append('<span class="glyphicon glyphicon-repeat"></span>'),c.on("click.fu.infinitescroll",function(){c.remove(),f()}),d.append(c)):f()},onScroll:function(a){this.curScrollTop=this.$element.scrollTop(),this.curPercentage=this.getPercentage(),!this.fetchingData&&this.curPercentage>=this.options.percentage&&this.fetchData()}},a.fn.infinitescroll=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.infinitescroll"),h="object"==typeof b&&b;g||f.data("fu.infinitescroll",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.infinitescroll.defaults={dataSource:null,hybrid:!1,percentage:95},a.fn.infinitescroll.Constructor=c,a.fn.infinitescroll.noConflict=function(){return a.fn.infinitescroll=b,this}}(a),function(a){var b=a.fn.pillbox,c=function(b,c){this.$element=a(b),this.$moreCount=this.$element.find(".pillbox-more-count"),this.$pillGroup=this.$element.find(".pill-group"),this.$addItem=this.$element.find(".pillbox-add-item"),this.$addItemWrap=this.$addItem.parent(),this.$suggest=this.$element.find(".suggest"),this.$pillHTML='<li class="btn btn-default pill">	<span></span>	<span class="glyphicon glyphicon-close">		<span class="sr-only">Remove</span>	</span></li>',this.options=a.extend({},a.fn.pillbox.defaults,c),-1===this.options.readonly?void 0!==this.$element.attr("data-readonly")&&this.readonly(!0):this.options.readonly&&this.readonly(!0),
this.acceptKeyCodes=this._generateObject(this.options.acceptKeyCodes),this.$element.on("click.fu.pillbox",".pill-group > .pill",a.proxy(this.itemClicked,this)),this.$element.on("click.fu.pillbox",a.proxy(this.inputFocus,this)),this.$element.on("keydown.fu.pillbox",".pillbox-add-item",a.proxy(this.inputEvent,this)),this.options.onKeyDown&&this.$element.on("mousedown.fu.pillbox",".suggest > li",a.proxy(this.suggestionClick,this)),this.options.edit&&(this.$element.addClass("pills-editable"),this.$element.on("blur.fu.pillbox",".pillbox-add-item",a.proxy(this.cancelEdit,this)))};c.prototype={constructor:c,destroy:function(){return this.$element.remove(),this.$element[0].outerHTML},items:function(){var b=this;return this.$pillGroup.children(".pill").map(function(){return b.getItemData(a(this))}).get()},itemClicked:function(b){var c,d=a(b.target);if(b.preventDefault(),b.stopPropagation(),this._closeSuggestions(),d.hasClass("pill"))c=d;else if(c=d.parent(),void 0===this.$element.attr("data-readonly")){if(d.hasClass("glyphicon-close"))return this.options.onRemove?this.options.onRemove(this.getItemData(c,{el:c}),a.proxy(this._removeElement,this)):this._removeElement(this.getItemData(c,{el:c})),!1;if(this.options.edit){if(c.find(".pillbox-list-edit").length)return!1;this.openEdit(c)}}this.$element.trigger("clicked.fu.pillbox",this.getItemData(c))},readonly:function(a){a?this.$element.attr("data-readonly","readonly"):this.$element.removeAttr("data-readonly"),this.options.truncate&&this.truncate(a)},suggestionClick:function(b){var c=a(b.currentTarget),d={text:c.html(),value:c.data("value")};b.preventDefault(),this.$addItem.val(""),c.data("attr")&&(d.attr=JSON.parse(c.data("attr"))),d.data=c.data("data"),this.addItems(d,!0),this._closeSuggestions()},itemCount:function(){return this.$pillGroup.children(".pill").length},addItems:function(){var b,c,d,e=this;!isFinite(String(arguments[0]))||arguments[0]instanceof Array?(b=[].slice.call(arguments).slice(0),d=b[1]&&!b[1].text):(b=[].slice.call(arguments).slice(1),c=arguments[0]),b[0]instanceof Array&&(b=b[0]),b.length&&(a.each(b,function(a,c){var d={text:c.text,value:c.value?c.value:c.text,el:e.$pillHTML};c.attr&&(d.attr=c.attr),c.data&&(d.data=c.data),b[a]=d}),this.options.edit&&this.currentEdit&&(b[0].el=this.currentEdit.wrap("<div></div>").parent().html()),d&&b.pop(1),e.options.onAdd&&d?this.options.edit&&this.currentEdit?e.options.onAdd(b[0],a.proxy(e.saveEdit,this)):e.options.onAdd(b[0],a.proxy(e.placeItems,this)):this.options.edit&&this.currentEdit?e.saveEdit(b):c?e.placeItems(c,b):e.placeItems(b,d))},removeItems:function(a,b){var c,d,e=this;if(a)for(b=b?b:1,c=0;b>c&&(d=e.$pillGroup.find("> .pill:nth-child("+a+")"),d);c++)d.remove();else this.$pillGroup.find(".pill").remove(),this._removePillTrigger({method:"removeAll"})},placeItems:function(){var b,c,d,e,f=[];!isFinite(String(arguments[0]))||arguments[0]instanceof Array?(b=[].slice.call(arguments).slice(0),e=b[1]&&!b[1].text):(b=[].slice.call(arguments).slice(1),c=arguments[0]),b[0]instanceof Array&&(b=b[0]),b.length&&(a.each(b,function(b,c){var d=a(c.el);d.attr("data-value",c.value),d.find("span:first").html(c.text),c.attr&&a.each(c.attr,function(a,b){"cssClass"===a||"class"===a?d.addClass(b):d.attr(a,b)}),c.data&&d.data("data",c.data),f.push(d)}),this.$pillGroup.children(".pill").length>0?c?(d=this.$pillGroup.find(".pill:nth-child("+c+")"),d.length?d.before(f):this.$pillGroup.children(".pill:last").after(f)):this.$pillGroup.children(".pill:last").after(f):this.$pillGroup.prepend(f),e&&this.$element.trigger("added.fu.pillbox",{text:b[0].text,value:b[0].value}))},inputEvent:function(a){var b,c,d,e,f=this,g=this.$addItem.val();if(this.acceptKeyCodes[a.keyCode])return this.options.onKeyDown&&this._isSuggestionsOpen()&&(e=this.$suggest.find(".pillbox-suggest-sel"),e.length&&(g=e.html(),b=e.data("value"),c=e.data("attr"))),(g.replace(/[ ]*\,[ ]*/,"").match(/\S/)||this.options.allowEmptyPills&&g.length)&&(this._closeSuggestions(),this.$addItem.hide(),c?this.addItems({text:g,value:b,attr:JSON.parse(c)},!0):this.addItems({text:g,value:b},!0),setTimeout(function(){f.$addItem.show().val("").attr({size:10})},0)),a.preventDefault(),!0;if(8===a.keyCode||46===a.keyCode){if(!g.length)return a.preventDefault(),this.options.edit&&this.currentEdit?(this.cancelEdit(),!0):(this._closeSuggestions(),d=this.$pillGroup.children(".pill:last"),d.hasClass("pillbox-highlight")?this._removeElement(this.getItemData(d,{el:d})):d.addClass("pillbox-highlight"),!0)}else g.length>10&&this.$addItem.width()<this.$pillGroup.width()-6&&this.$addItem.attr({size:g.length+3});if(this.$pillGroup.find(".pill").removeClass("pillbox-highlight"),this.options.onKeyDown){if(9===a.keyCode||38===a.keyCode||40===a.keyCode)return this._isSuggestionsOpen()&&this._keySuggestions(a),!0;this.callbackId=a.timeStamp,this.options.onKeyDown({event:a,value:g},function(b){f._openSuggestions(a,b)})}},openEdit:function(a){var b=a.index()+1,c=this.$addItemWrap.detach().hide();this.$pillGroup.find(".pill:nth-child("+b+")").before(c),this.currentEdit=a.detach(),c.addClass("editing"),this.$addItem.val(a.find("span:first").html()),c.show(),this.$addItem.focus().select()},cancelEdit:function(a){var b;return this.currentEdit?(this._closeSuggestions(),a&&this.$addItemWrap.before(this.currentEdit),this.currentEdit=!1,b=this.$addItemWrap.detach(),b.removeClass("editing"),this.$addItem.val(""),void this.$pillGroup.append(b)):!1},saveEdit:function(){var b=arguments[0][0]?arguments[0][0]:arguments[0];this.currentEdit=a(b.el),this.currentEdit.data("value",b.value),this.currentEdit.find("span:first").html(b.text),this.$addItemWrap.hide(),this.$addItemWrap.before(this.currentEdit),this.currentEdit=!1,this.$addItem.val(""),this.$addItemWrap.removeClass("editing"),this.$pillGroup.append(this.$addItemWrap.detach().show()),this.$element.trigger("edited.fu.pillbox",{value:b.value,text:b.text})},removeBySelector:function(){var b=[].slice.call(arguments).slice(0),c=this;a.each(b,function(a,b){c.$pillGroup.find(b).remove()}),this._removePillTrigger({method:"removeBySelector",removedSelectors:b})},removeByValue:function(){var b=[].slice.call(arguments).slice(0),c=this;a.each(b,function(a,b){c.$pillGroup.find('> .pill[data-value="'+b+'"]').remove()}),this._removePillTrigger({method:"removeByValue",removedValues:b})},removeByText:function(){var b=[].slice.call(arguments).slice(0),c=this;a.each(b,function(a,b){c.$pillGroup.find('> .pill:contains("'+b+'")').remove()}),this._removePillTrigger({method:"removeByText",removedText:b})},truncate:function(b){var c,d,e,f,g,h=this;this.$element.removeClass("truncate"),this.$addItemWrap.removeClass("truncated"),this.$pillGroup.find(".pill").removeClass("truncated"),b&&(this.$element.addClass("truncate"),c=this.$element.width(),d=!1,e=0,f=this.$pillGroup.find(".pill").length,g=0,this.$pillGroup.find(".pill").each(function(){var b=a(this);d?b.addClass("truncated"):(e++,h.$moreCount.text(f-e),g+b.outerWidth(!0)+h.$addItemWrap.outerWidth(!0)<=c?g+=b.outerWidth(!0):(h.$moreCount.text(f-e+1),b.addClass("truncated"),d=!0))}),e===f&&this.$addItemWrap.addClass("truncated"))},inputFocus:function(a){this.$element.find(".pillbox-add-item").focus()},getItemData:function(b,c){return a.extend({text:b.find("span:first").html()},b.data(),c)},_removeElement:function(a){a.el.remove(),delete a.el,this.$element.trigger("removed.fu.pillbox",a)},_removePillTrigger:function(a){this.$element.trigger("removed.fu.pillbox",a)},_generateObject:function(b){var c={};return a.each(b,function(a,b){c[b]=!0}),c},_openSuggestions:function(b,c){var d=a("<ul>");return this.callbackId!==b.timeStamp?!1:void(c.data&&c.data.length&&(a.each(c.data,function(b,c){var e=c.value?c.value:c.text,f=a('<li data-value="'+e+'">'+c.text+"</li>");c.attr&&f.data("attr",JSON.stringify(c.attr)),c.data&&f.data("data",c.data),d.append(f)}),this.$suggest.html("").append(d.children()),a(document.body).trigger("suggested.fu.pillbox",this.$suggest)))},_closeSuggestions:function(){this.$suggest.html("").parent().removeClass("open")},_isSuggestionsOpen:function(){return this.$suggest.parent().hasClass("open")},_keySuggestions:function(a){var b,c=this.$suggest.find("li.pillbox-suggest-sel"),d=38===a.keyCode;a.preventDefault(),c.length?(b=d?c.prev():c.next(),b.length||(b=d?this.$suggest.find("li:last"):this.$suggest.find("li:first")),b&&(b.addClass("pillbox-suggest-sel"),c.removeClass("pillbox-suggest-sel"))):(c=this.$suggest.find("li:first"),c.addClass("pillbox-suggest-sel"))}},c.prototype.getValue=c.prototype.items,a.fn.pillbox=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.pillbox"),h="object"==typeof b&&b;g||f.data("fu.pillbox",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.pillbox.defaults={onAdd:void 0,onRemove:void 0,onKeyDown:void 0,edit:!1,readonly:-1,truncate:!1,acceptKeyCodes:[13,188],allowEmptyPills:!1},a.fn.pillbox.Constructor=c,a.fn.pillbox.noConflict=function(){return a.fn.pillbox=b,this},a(document).on("mousedown.fu.pillbox.data-api","[data-initialize=pillbox]",function(b){var c=a(b.target).closest(".pillbox");c.data("fu.pillbox")||c.pillbox(c.data())}),a(function(){a("[data-initialize=pillbox]").each(function(){var b=a(this);b.data("fu.pillbox")||b.pillbox(b.data())})})}(a),function(a){var b=a.fn.repeater,c=function(b,c){var d,e,f=this;this.$element=a(b),this.$canvas=this.$element.find(".repeater-canvas"),this.$count=this.$element.find(".repeater-count"),this.$end=this.$element.find(".repeater-end"),this.$filters=this.$element.find(".repeater-filters"),this.$loader=this.$element.find(".repeater-loader"),this.$pageSize=this.$element.find(".repeater-itemization .selectlist"),this.$nextBtn=this.$element.find(".repeater-next"),this.$pages=this.$element.find(".repeater-pages"),this.$prevBtn=this.$element.find(".repeater-prev"),this.$primaryPaging=this.$element.find(".repeater-primaryPaging"),this.$search=this.$element.find(".repeater-search").find(".search"),this.$secondaryPaging=this.$element.find(".repeater-secondaryPaging"),this.$start=this.$element.find(".repeater-start"),this.$viewport=this.$element.find(".repeater-viewport"),this.$views=this.$element.find(".repeater-views"),this.currentPage=0,this.currentView=null,this.isDisabled=!1,this.infiniteScrollingCallback=function(){},this.infiniteScrollingCont=null,this.infiniteScrollingEnabled=!1,this.infiniteScrollingEnd=null,this.infiniteScrollingOptions={},this.lastPageInput=0,this.options=a.extend({},a.fn.repeater.defaults,c),this.pageIncrement=0,this.resizeTimeout={},this.stamp=(new Date).getTime()+(Math.floor(100*Math.random())+1),this.storedDataSourceOpts=null,this.syncingViewButtonState=!1,this.viewOptions={},this.viewType=null,this.$filters.selectlist(),this.$pageSize.selectlist(),this.$primaryPaging.find(".combobox").combobox(),this.$search.search({searchOnKeyPress:this.options.searchOnKeyPress,allowCancel:this.options.allowCancel}),this.$filters.on("changed.fu.selectlist",function(a,b){f.$element.trigger("filtered.fu.repeater",b),f.render({clearInfinite:!0,pageIncrement:null})}),this.$nextBtn.on("click.fu.repeater",a.proxy(this.next,this)),this.$pageSize.on("changed.fu.selectlist",function(a,b){f.$element.trigger("pageSizeChanged.fu.repeater",b),f.render({pageIncrement:null})}),this.$prevBtn.on("click.fu.repeater",a.proxy(this.previous,this)),this.$primaryPaging.find(".combobox").on("changed.fu.combobox",function(a,b){f.$element.trigger("pageChanged.fu.repeater",[b.text,b]),f.pageInputChange(b.text)}),this.$search.on("searched.fu.search cleared.fu.search",function(a,b){f.$element.trigger("searchChanged.fu.repeater",b),f.render({clearInfinite:!0,pageIncrement:null})}),this.$search.on("canceled.fu.search",function(a,b){f.$element.trigger("canceled.fu.repeater",b),f.render({clearInfinite:!0,pageIncrement:null})}),this.$secondaryPaging.on("blur.fu.repeater",function(a){f.pageInputChange(f.$secondaryPaging.val())}),this.$secondaryPaging.on("keyup",function(a){13===a.keyCode&&f.pageInputChange(f.$secondaryPaging.val())}),this.$views.find("input").on("change.fu.repeater",a.proxy(this.viewChanged,this)),a(window).on("resize.fu.repeater."+this.stamp,function(a){clearTimeout(f.resizeTimeout),f.resizeTimeout=setTimeout(function(){f.resize(),f.$element.trigger("resized.fu.repeater")},75)}),this.$loader.loader(),this.$loader.loader("pause"),-1!==this.options.defaultView?e=this.options.defaultView:(d=this.$views.find("label.active input"),e=d.length>0?d.val():"list"),this.setViewOptions(e),this.initViewTypes(function(){f.resize(),f.$element.trigger("resized.fu.repeater"),f.render({changeView:e})})};c.prototype={constructor:c,clear:function(b){function c(b){var d=[];b.children().each(function(){var b=a(this),e=b.attr("data-preserve");"deep"===e?(b.detach(),d.push(b)):"shallow"===e&&(c(b),b.detach(),d.push(b))}),b.empty(),b.append(d)}var d,e;b=b||{},b.preserve?this.infiniteScrollingEnabled&&!b.clearInfinite||c(this.$canvas):this.$canvas.empty(),d=void 0!==b.viewChanged?b.viewChanged:!1,e=a.fn.repeater.viewTypes[this.viewType]||{},!d&&e.cleared&&e.cleared.call(this,{options:b})},clearPreservedDataSourceOptions:function(){this.storedDataSourceOpts=null},destroy:function(){var b;return this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$canvas.empty(),b=this.$element[0].outerHTML,this.$element.find(".combobox").combobox("destroy"),this.$element.find(".selectlist").selectlist("destroy"),this.$element.find(".search").search("destroy"),this.infiniteScrollingEnabled&&a(this.infiniteScrollingCont).infinitescroll("destroy"),this.$element.remove(),a(window).off("resize.fu.repeater."+this.stamp),b},disable:function(){var b="disable",c="disabled",d=a.fn.repeater.viewTypes[this.viewType]||{};this.$search.search(b),this.$filters.selectlist(b),this.$views.find("label, input").addClass(c).attr(c,c),this.$pageSize.selectlist(b),this.$primaryPaging.find(".combobox").combobox(b),this.$secondaryPaging.attr(c,c),this.$prevBtn.attr(c,c),this.$nextBtn.attr(c,c),d.enabled&&d.enabled.call(this,{status:!1}),this.isDisabled=!0,this.$element.addClass("disabled"),this.$element.trigger("disabled.fu.repeater")},enable:function(){var b="disabled",c="enable",d="page-end",e=a.fn.repeater.viewTypes[this.viewType]||{};this.$search.search(c),this.$filters.selectlist(c),this.$views.find("label, input").removeClass(b).removeAttr(b),this.$pageSize.selectlist("enable"),this.$primaryPaging.find(".combobox").combobox(c),this.$secondaryPaging.removeAttr(b),this.$prevBtn.hasClass(d)||this.$prevBtn.removeAttr(b),this.$nextBtn.hasClass(d)||this.$nextBtn.removeAttr(b),this.$prevBtn.hasClass(d)&&this.$nextBtn.hasClass(d)&&this.$primaryPaging.combobox("disable"),0!==parseInt(this.$count.html())?this.$pageSize.selectlist("enable"):this.$pageSize.selectlist("disable"),e.enabled&&e.enabled.call(this,{status:!0}),this.isDisabled=!1,this.$element.removeClass("disabled"),this.$element.trigger("enabled.fu.repeater")},getDataOptions:function(b){var c,d,e={},f={};return b=b||{},f.filter=this.$filters.length>0?this.$filters.selectlist("selectedItem"):{text:"All",value:"all"},f.view=this.currentView,this.infiniteScrollingEnabled||(f.pageSize=this.$pageSize.length>0?parseInt(this.$pageSize.selectlist("selectedItem").value,10):25),void 0!==b.pageIncrement&&(null===b.pageIncrement?this.currentPage=0:this.currentPage+=b.pageIncrement),f.pageIndex=this.currentPage,c=this.$search.length>0?this.$search.find("input").val():"",""!==c&&(f.search=c),b.dataSourceOptions&&(e=b.dataSourceOptions,b.preserveDataSourceOptions&&(this.storedDataSourceOpts=this.storedDataSourceOpts?a.extend(this.storedDataSourceOpts,e):e)),this.storedDataSourceOpts&&(e=a.extend(this.storedDataSourceOpts,e)),d=a.fn.repeater.viewTypes[this.viewType]||{},d=d.dataOptions,d?(d=d.call(this,f),f=a.extend(d,e)):f=a.extend(f,e),f},infiniteScrolling:function(a,b){var c,d,e=this.$element.find(".repeater-footer"),f=this.$element.find(".repeater-viewport");b=b||{},a?(this.infiniteScrollingEnabled=!0,this.infiniteScrollingEnd=b.end,delete b.dataSource,delete b.end,this.infiniteScrollingOptions=b,f.css({height:f.height()+e.outerHeight()}),e.hide()):(c=this.infiniteScrollingCont,d=c.data(),delete d.infinitescroll,c.off("scroll"),c.removeClass("infinitescroll"),this.infiniteScrollingCont=null,this.infiniteScrollingEnabled=!1,this.infiniteScrollingEnd=null,this.infiniteScrollingOptions={},f.css({height:f.height()-e.outerHeight()}),e.show())},infiniteScrollPaging:function(a,b){var c=this.infiniteScrollingEnd!==!0?this.infiniteScrollingEnd:void 0,d=a.page,e=a.pages;this.currentPage=void 0!==d?d:NaN,(a.end===!0||this.currentPage+1>=e)&&this.infiniteScrollingCont.infinitescroll("end",c)},initInfiniteScrolling:function(){var b,c,d=this.$canvas.find('[data-infinite="true"]:first');d=d.length<1?this.$canvas:d,d.data("fu.infinitescroll")?d.infinitescroll("enable"):(c=this,b=a.extend({},this.infiniteScrollingOptions),b.dataSource=function(a,b){c.infiniteScrollingCallback=b,c.render({pageIncrement:1})},d.infinitescroll(b),this.infiniteScrollingCont=d)},initViewTypes:function(b){function c(a){function d(){a++,e>a?c(a):b()}g[a].initialize?g[a].initialize.call(f,{},function(){d()}):d()}var d,e,f=this,g=[];for(d in a.fn.repeater.viewTypes)g.push(a.fn.repeater.viewTypes[d]);e=g.length,e>0?c(0):b()},itemization:function(a){this.$count.html(void 0!==a.count?a.count:"?"),this.$end.html(void 0!==a.end?a.end:"?"),this.$start.html(void 0!==a.start?a.start:"?")},next:function(a){var b="disabled";this.$nextBtn.attr(b,b),this.$prevBtn.attr(b,b),this.pageIncrement=1,this.$element.trigger("nextClicked.fu.repeater"),this.render({pageIncrement:this.pageIncrement})},pageInputChange:function(a){var b;a!==this.lastPageInput&&(this.lastPageInput=a,a=parseInt(a,10)-1,b=a-this.currentPage,this.$element.trigger("pageChanged.fu.repeater",a),this.render({pageIncrement:b}))},pagination:function(a){var b,c,d,e,f="active",g="disabled",h=a.page,i="page-end",j=a.pages;if(this.currentPage=void 0!==h?h:NaN,this.$primaryPaging.removeClass(f),this.$secondaryPaging.removeClass(f),e=0===j?0:this.currentPage+1,j<=this.viewOptions.dropPagingCap){for(this.$primaryPaging.addClass(f),b=this.$primaryPaging.find(".dropdown-menu"),b.empty(),c=0;j>c;c++)d=c+1,b.append('<li data-value="'+d+'"><a href="#">'+d+"</a></li>");this.$primaryPaging.find("input.form-control").val(e)}else this.$secondaryPaging.addClass(f),this.$secondaryPaging.val(e);this.lastPageInput=this.currentPage+1+"",this.$pages.html(""+j),this.currentPage+1<j?(this.$nextBtn.removeAttr(g),this.$nextBtn.removeClass(i)):(this.$nextBtn.attr(g,g),this.$nextBtn.addClass(i)),this.currentPage-1>=0?(this.$prevBtn.removeAttr(g),this.$prevBtn.removeClass(i)):(this.$prevBtn.attr(g,g),this.$prevBtn.addClass(i)),0!==this.pageIncrement&&(this.pageIncrement>0?this.$nextBtn.is(":disabled")?this.$prevBtn.focus():this.$nextBtn.focus():this.$prevBtn.is(":disabled")?this.$nextBtn.focus():this.$prevBtn.focus())},previous:function(){var a="disabled";this.$nextBtn.attr(a,a),this.$prevBtn.attr(a,a),this.pageIncrement=-1,this.$element.trigger("previousClicked.fu.repeater"),this.render({pageIncrement:this.pageIncrement})},render:function(b){var c,d,e=this,f=!1,g=a.fn.repeater.viewTypes[this.viewType]||{};b=b||{},this.disable(),b.changeView&&this.currentView!==b.changeView&&(d=this.currentView,this.currentView=b.changeView,this.viewType=this.currentView.split(".")[0],this.setViewOptions(this.currentView),this.$element.attr("data-currentview",this.currentView),this.$element.attr("data-viewtype",this.viewType),f=!0,b.viewChanged=f,this.$element.trigger("viewChanged.fu.repeater",this.currentView),this.infiniteScrollingEnabled&&e.infiniteScrolling(!1),g=a.fn.repeater.viewTypes[this.viewType]||{},g.selected&&g.selected.call(this,{prevView:d})),this.syncViewButtonState(),b.preserve=void 0!==b.preserve?b.preserve:!f,this.clear(b),(!this.infiniteScrollingEnabled||this.infiniteScrollingEnabled&&f)&&this.$loader.show().loader("play"),c=this.getDataOptions(b),this.viewOptions.dataSource(c,function(a){a=a||{},e.infiniteScrollingEnabled?e.infiniteScrollingCallback({}):(e.itemization(a),e.pagination(a)),e.runRenderer(g,a,function(){e.infiniteScrollingEnabled&&((f||b.clearInfinite)&&e.initInfiniteScrolling(),e.infiniteScrollPaging(a,b)),e.$loader.hide().loader("pause"),e.enable(),e.$search.trigger("rendered.fu.repeater"),e.$element.trigger("rendered.fu.repeater",{data:a,options:c,renderOptions:b}),e.$element.trigger("loaded.fu.repeater",c)})})},resize:function(){var b,c,d=-1===this.viewOptions.staticHeight?this.$element.attr("data-staticheight"):this.viewOptions.staticHeight,e={};if(this.viewType&&(e=a.fn.repeater.viewTypes[this.viewType]||{}),void 0!==d&&d!==!1&&"false"!==d){this.$canvas.addClass("scrolling"),c={bottom:this.$viewport.css("margin-bottom"),top:this.$viewport.css("margin-top")};var f="true"===d||d===!0?this.$element.height():parseInt(d,10),g=this.$element.find(".repeater-header").outerHeight(),h=this.$element.find(".repeater-footer").outerHeight(),i="auto"===c.bottom?0:parseInt(c.bottom,10),j="auto"===c.top?0:parseInt(c.top,10);b=f-g-h-i-j,this.$viewport.outerHeight(b)}else this.$canvas.removeClass("scrolling");e.resize&&e.resize.call(this,{height:this.$element.outerHeight(),width:this.$element.outerWidth()})},runRenderer:function(b,c,d){function e(b,c){var d;c&&(d=c.action?c.action:"append","none"!==d&&void 0!==c.item&&(b=void 0!==c.container?a(c.container):b,b[d](c.item)))}var f,g,h,i,j,k;if(b.render)b.render.call(this,{container:this.$canvas,data:c},function(){d()});else{if(b.before&&(i=b.before.call(this,{container:this.$canvas,data:c}),e(this.$canvas,i)),f=this.$canvas.find('[data-container="true"]:last'),f=f.length>0?f:this.$canvas,b.renderItem){for(j=b.repeat||"data.items",j=j.split("."),"data"===j[0]||"this"===j[0]?(k="this"===j[0]?this:c,j.shift()):(j=[],k=[],window.console&&window.console.warn&&window.console.warn('WARNING: Repeater plugin "repeat" value must start with either "data" or "this"')),g=0,h=j.length;h>g;g++){if(void 0===k[j[g]]){k=[],window.console&&window.console.warn&&window.console.warn("WARNING: Repeater unable to find property to iterate renderItem on.");break}k=k[j[g]]}for(g=0,h=k.length;h>g;g++)i=b.renderItem.call(this,{container:f,data:c,index:g,subset:k}),e(f,i)}b.after&&(i=b.after.call(this,{container:this.$canvas,data:c}),e(this.$canvas,i)),d()}},setViewOptions:function(b){var c={},d=b.split(".")[1];c=this.options.views?this.options.views[d]||this.options.views[b]||{}:{},this.viewOptions=a.extend({},this.options,c)},viewChanged:function(b){var c=a(b.target),d=c.val();this.syncingViewButtonState||(this.isDisabled||c.parents("label:first").hasClass("disabled")?this.syncViewButtonState():this.render({changeView:d,pageIncrement:null}))},syncViewButtonState:function(){var a=this.$views.find('input[value="'+this.currentView+'"]');this.syncingViewButtonState=!0,this.$views.find("input").prop("checked",!1),this.$views.find("label.active").removeClass("active"),a.length>0&&(a.prop("checked",!0),a.parents("label:first").addClass("active")),this.syncingViewButtonState=!1}},a.fn.repeater=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.repeater"),h="object"==typeof b&&b;g||f.data("fu.repeater",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.repeater.defaults={dataSource:function(a,b){b({count:0,end:0,items:[],page:0,pages:1,start:0})},defaultView:-1,dropPagingCap:10,staticHeight:-1,views:null,searchOnKeyPress:!1,allowCancel:!0},a.fn.repeater.viewTypes={},a.fn.repeater.Constructor=c,a.fn.repeater.noConflict=function(){return a.fn.repeater=b,this}}(a),function(a){function b(a,b){if(!b)return!1;if(!a||b.length!==a.length)return!0;for(var c=0;c<b.length;c++){if(!a[c])return!0;for(var d in b[c])if(a[c][d]!==b[c][d])return!0}return!1}function c(b,c,d,e,f){var g=e[f].className,h=c[d][e[f].property],i=a("<td></td>"),j=e[f]._auto_width,k=e[f].property;if(this.viewOptions.list_actions!==!1&&"@_ACTIONS_@"===k&&(h='<div class="repeater-list-actions-placeholder" style="width: '+this.list_actions_width+'px"></div>'),h=void 0!==h?h:"",i.addClass(void 0!==g?g:"").append(h),void 0!==j&&i.outerWidth(j),b.append(i),"multi"===this.viewOptions.list_selectable&&"@_CHECKBOX_@"===e[f].property){var l='<label data-row="'+d+'" class="checkbox-custom checkbox-inline body-checkbox repeater-select-checkbox"><input class="sr-only" type="checkbox"></label>';i.html(l)}"@_CHECKBOX_@"!==e[f].property&&"@_ACTIONS_@"!==e[f].property&&this.viewOptions.list_columnRendered&&this.viewOptions.list_columnRendered({container:b,columnAttr:e[f].property,item:i,rowData:c[d]},function(){})}function d(b,c,d){var e,f,g,h,i,j="glyphicon-chevron-down",k=".glyphicon.rlc:first",l="glyphicon-chevron-up",m=a('<div class="repeater-list-heading"><span class="glyphicon rlc"></span></div>'),n='<div class="repeater-list-heading header-checkbox"><label class="checkbox-custom checkbox-inline repeater-select-checkbox"><input class="sr-only" type="checkbox"></label><div class="clearfix"></div></div>',o=a("<th></th>"),p=this;if(m.data("fu_item_index",d),m.prepend(c[d].label),o.html(m.html()).find("[id]").removeAttr("id"),"@_CHECKBOX_@"!==c[d].property?o.append(m):o.append(n),e=o.add(m),h=m.find(k),i=h.add(o.find(k)),this.viewOptions.list_actions&&"@_ACTIONS_@"===c[d].property){var q=this.list_actions_width;o.css("width",q),m.css("width",q)}f=c[d].className,void 0!==f&&e.addClass(f),g=c[d].sortable,g&&(e.addClass("sortable"),m.on("click.fu.repeaterList",function(){p.isDisabled||(p.list_sortProperty="string"==typeof g?g:c[d].property,m.hasClass("sorted")?h.hasClass(l)?(i.removeClass(l).addClass(j),p.list_sortDirection="desc"):p.viewOptions.list_sortClearing?(e.removeClass("sorted"),i.removeClass(j),p.list_sortDirection=null,p.list_sortProperty=null):(i.removeClass(j).addClass(l),p.list_sortDirection="asc"):(b.find("th, .repeater-list-heading").removeClass("sorted"),i.removeClass(j).addClass(l),p.list_sortDirection="asc",e.addClass("sorted")),p.render({clearInfinite:!0,pageIncrement:null}))})),"asc"!==c[d].sortDirection&&"desc"!==c[d].sortDirection||(b.find("th, .repeater-list-heading").removeClass("sorted"),e.addClass("sortable sorted"),"asc"===c[d].sortDirection?(i.addClass(l),this.list_sortDirection="asc"):(i.addClass(j),this.list_sortDirection="desc"),this.list_sortProperty="string"==typeof g?g:c[d].property),b.append(o)}function e(b,d,e){var f,g,h=a("<tr></tr>"),i=this,k="multi"===this.viewOptions.list_selectable,l=this.viewOptions.list_actions;for(this.viewOptions.list_selectable&&(h.data("item_data",d[e]),"action"!==this.viewOptions.list_selectable&&(h.addClass("selectable"),h.attr("tabindex",0),h.on("click.fu.repeaterList",function(){if(!i.isDisabled){var b=a(this),c=a(this).index();c+=1;var d=i.$element.find(".frozen-column-wrapper tr:nth-child("+c+")"),e=i.$element.find(".actions-column-wrapper tr:nth-child("+c+")"),f=i.$element.find(".frozen-column-wrapper tr:nth-child("+c+") .checkbox-inline");b.is(".selected")?(b.removeClass("selected"),k?(f.checkbox("uncheck"),d.removeClass("selected"),l&&e.removeClass("selected")):b.find(".repeater-list-check").remove(),i.$element.trigger("deselected.fu.repeaterList",b)):(k?(f.checkbox("check"),b.addClass("selected"),d.addClass("selected"),l&&e.addClass("selected")):(i.$canvas.find(".repeater-list-check").remove(),i.$canvas.find(".repeater-list tbody tr.selected").each(function(){a(this).removeClass("selected"),i.$element.trigger("deselected.fu.repeaterList",a(this))}),b.find("td:first").prepend('<div class="repeater-list-check"><span class="glyphicon glyphicon-ok"></span></div>'),b.addClass("selected"),d.addClass("selected")),i.$element.trigger("selected.fu.repeaterList",b)),j.call(i)}}),h.keyup(function(a){13===a.keyCode&&h.trigger("click.fu.repeaterList")}))),this.viewOptions.list_actions&&!this.viewOptions.list_selectable&&h.data("item_data",d[e]),b.append(h),f=0,g=this.list_columns.length;g>f;f++)c.call(this,h,d,e,this.list_columns,f);this.viewOptions.list_rowRendered&&this.viewOptions.list_rowRendered({container:b,item:h,rowData:d[e]},function(){})}function f(b,c){var d,e=b.find("tbody");e.length<1&&(e=a('<tbody data-container="true"></tbody>'),b.append(e)),"string"==typeof c.error&&c.error.length>0?(d=a('<tr class="empty text-danger"><td colspan="'+this.list_columns.length+'"></td></tr>'),d.find("td").append(c.error),e.append(d)):c.items&&c.items.length<1&&(d=a('<tr class="empty"><td colspan="'+this.list_columns.length+'"></td></tr>'),d.find("td").append(this.viewOptions.list_noItemsHTML),e.append(d))}function g(c,e){var f,g,i,j=e.columns||[],k=c.find("thead");if(this.list_firstRender||b(this.list_columns,j)||0===k.length){if(k.remove(),e.count<1&&(this.list_noItems=!0),"multi"===this.viewOptions.list_selectable&&!this.list_noItems){var l={label:"c",property:"@_CHECKBOX_@",sortable:!1};j.splice(0,0,l)}if(this.list_columns=j,this.list_firstRender=!1,this.$loader.removeClass("noHeader"),this.viewOptions.list_actions&&!this.list_noItems){var m={label:this.viewOptions.list_actions.label||'<span class="actions-hidden">a</span>',property:"@_ACTIONS_@",sortable:!1,width:this.list_actions_width};j.push(m)}for(k=a('<thead data-preserve="deep"><tr></tr></thead>'),i=k.find("tr"),f=0,g=j.length;g>f;f++)d.call(this,i,j,f);if(c.prepend(k),"multi"===this.viewOptions.list_selectable&&!this.list_noItems){var n=this.$element.find(".repeater-list-wrapper .header-checkbox").outerWidth(),o=a.grep(j,function(a){return"@_CHECKBOX_@"===a.property})[0];o.width=n}h.call(this,i)}}function h(b){var c,d,e,f,g=[],h=this;if(this.viewOptions.list_columnSizing&&(c=0,f=0,b.find("th").each(function(){var b,d=a(this);if(void 0!==h.list_columns[c].width)b=h.list_columns[c].width,d.outerWidth(b),f+=d.outerWidth(),h.list_columns[c]._auto_width=b;else{var e=d.find(".repeater-list-heading").outerWidth();g.push({col:d,index:c,minWidth:e})}c++}),d=g.length,d>0)){var i=this.$canvas.find(".repeater-list-wrapper").outerWidth();for(e=Math.floor((i-f)/d),c=0;d>c;c++)g[c].minWidth>e&&(e=g[c].minWidth),g[c].col.outerWidth(e),this.list_columns[g[c].index]._auto_width=e}}function i(){var a=window.navigator.userAgent,b=a.indexOf("MSIE "),c=a.indexOf("Firefox");return b>0?"ie-"+parseInt(a.substring(b+5,a.indexOf(".",b))):c>0?"firefox":""}function j(){var a,b=".repeater-list-wrapper > table .selected",c=this.$element.find(".table-actions");"action"===this.viewOptions.list_selectable&&(b=".repeater-list-wrapper > table tr"),a=this.$canvas.find(b),a.length>0?c.find("thead .btn").removeAttr("disabled"):c.find("thead .btn").attr("disabled","disabled")}a.fn.repeater&&(a.fn.repeater.Constructor.prototype.list_clearSelectedItems=function(){this.$canvas.find(".repeater-list-check").remove(),this.$canvas.find(".repeater-list table tbody tr.selected").removeClass("selected")},a.fn.repeater.Constructor.prototype.list_highlightColumn=function(b,c){var d=this.$canvas.find(".repeater-list-wrapper > table tbody");(this.viewOptions.list_highlightSortedColumn||c)&&(d.find("td.sorted").removeClass("sorted"),d.find("tr").each(function(){var c=a(this).find("td:nth-child("+(b+1)+")").filter(function(){return!a(this).parent().hasClass("empty")});c.addClass("sorted")}))},a.fn.repeater.Constructor.prototype.list_getSelectedItems=function(){var b=[];return this.$canvas.find(".repeater-list .repeater-list-wrapper > table tbody tr.selected").each(function(){var c=a(this);b.push({data:c.data("item_data"),element:c})}),b},a.fn.repeater.Constructor.prototype.getValue=a.fn.repeater.Constructor.prototype.list_getSelectedItems,a.fn.repeater.Constructor.prototype.list_positionHeadings=function(){var b=this.$element.find(".repeater-list-wrapper"),c=b.offset().left,d=b.scrollLeft();d>0?b.find(".repeater-list-heading").each(function(){var b=a(this),d=b.parents("th:first").offset().left-c+"px";b.addClass("shifted").css("left",d)}):b.find(".repeater-list-heading").each(function(){
a(this).removeClass("shifted").css("left","")})},a.fn.repeater.Constructor.prototype.list_setSelectedItems=function(b,c){function d(c){h=a(this),f=h.data("item_data")||{},f[b[g].property]===b[g].value&&e(h,b[g].selected,c)}function e(a,b,d){var e;b=void 0!==b?b:!0,b?(c||"multi"===j||k.list_clearSelectedItems(),a.hasClass("selected")||(a.addClass("selected"),(k.viewOptions.list_frozenColumns||"multi"===k.viewOptions.list_selectable)&&(e=k.$element.find(".frozen-column-wrapper tr:nth-child("+(d+1)+")"),e.addClass("selected"),e.find(".repeater-select-checkbox").addClass("checked")),k.viewOptions.list_actions&&k.$element.find(".actions-column-wrapper tr:nth-child("+(d+1)+")").addClass("selected"),a.find("td:first").prepend('<div class="repeater-list-check"><span class="glyphicon glyphicon-ok"></span></div>'))):(k.viewOptions.list_frozenColumns&&(e=k.$element.find(".frozen-column-wrapper tr:nth-child("+(d+1)+")"),e.addClass("selected"),e.find(".repeater-select-checkbox").removeClass("checked")),k.viewOptions.list_actions&&k.$element.find(".actions-column-wrapper tr:nth-child("+(d+1)+")").removeClass("selected"),a.find(".repeater-list-check").remove(),a.removeClass("selected"))}var f,g,h,i,j=this.viewOptions.list_selectable,k=this;for(a.isArray(b)||(b=[b]),i=c===!0||"multi"===j?b.length:j&&b.length>0?1:0,g=0;i>g;g++)void 0!==b[g].index?(h=this.$canvas.find(".repeater-list .repeater-list-wrapper > table tbody tr:nth-child("+(b[g].index+1)+")"),h.length>0&&e(h,b[g].selected,b[g].index)):void 0!==b[g].property&&void 0!==b[g].value&&this.$canvas.find(".repeater-list .repeater-list-wrapper > table tbody tr").each(d)},a.fn.repeater.Constructor.prototype.list_sizeHeadings=function(){var b=this.$element.find(".repeater-list table");b.find("thead th").each(function(){var b=a(this),c=b.find(".repeater-list-heading");c.css({height:b.outerHeight()}),c.outerWidth(c.data("forced-width")||b.outerWidth())})},a.fn.repeater.Constructor.prototype.list_setFrozenColumns=function(){var b=this.$canvas.find(".table-frozen"),c=this.$element.find(".repeater-canvas"),d=this.$element.find(".repeater-list .repeater-list-wrapper > table"),e=this.$element.find(".repeater-list"),f=this.viewOptions.list_frozenColumns,g=this;if("multi"===this.viewOptions.list_selectable&&(f+=1,c.addClass("multi-select-enabled")),b.length<1){var h=a('<div class="frozen-column-wrapper"></div>').insertBefore(d),i=d.clone().addClass("table-frozen");i.find("th:not(:lt("+f+"))").remove(),i.find("td:not(:nth-child(n+0):nth-child(-n+"+f+"))").remove();var j=i.clone().removeClass("table-frozen");j.find("tbody").remove();var k=a('<div class="frozen-thead-wrapper"></div>').append(j);h.append(i),e.append(k),this.$canvas.addClass("frozen-enabled")}this.list_sizeFrozenColumns(),a(".frozen-thead-wrapper .repeater-list-heading").on("click",function(){var b=a(this).parent("th").index();b+=1,g.$element.find(".repeater-list-wrapper > table thead th:nth-child("+b+") .repeater-list-heading")[0].click()})},a.fn.repeater.Constructor.prototype.list_positionColumns=function(){var a=this.$element.find(".repeater-canvas"),b=a.scrollTop(),c=a.scrollLeft(),d=this.viewOptions.list_frozenColumns||"multi"===this.viewOptions.list_selectable,e=this.viewOptions.list_actions,f=this.$element.find(".repeater-canvas").outerWidth(),g=this.$element.find(".repeater-list .repeater-list-wrapper > table").outerWidth(),h=this.$element.find(".table-actions")?this.$element.find(".table-actions").outerWidth():0,i=g-(f-h)>=c;b>0?a.find(".repeater-list-heading").css("top",b):a.find(".repeater-list-heading").css("top","0"),c>0?(d&&(a.find(".frozen-thead-wrapper").css("left",c),a.find(".frozen-column-wrapper").css("left",c)),e&&i&&(a.find(".actions-thead-wrapper").css("right",-c),a.find(".actions-column-wrapper").css("right",-c))):(d&&(a.find(".frozen-thead-wrapper").css("left","0"),a.find(".frozen-column-wrapper").css("left","0")),e&&(a.find(".actions-thead-wrapper").css("right","0"),a.find(".actions-column-wrapper").css("right","0")))},a.fn.repeater.Constructor.prototype.list_createItemActions=function(){var b,c,d="",e=this,f=this.$element.find(".repeater-list .repeater-list-wrapper > table"),g=this.$canvas.find(".table-actions");for(b=0,c=this.viewOptions.list_actions.items.length;c>b;b++){var h=this.viewOptions.list_actions.items[b],i=h.html;d+='<li><a href="#" data-action="'+h.name+'" class="action-item"> '+i+"</a></li>"}var j='<div class="btn-group"><button type="button" class="btn btn-xs btn-default dropdown-toggle repeater-actions-button" data-toggle="dropdown" data-flip="auto" aria-expanded="false"><span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right" role="menu">'+d+"</ul></div>";if(g.length<1){var k=a('<div class="actions-column-wrapper" style="width: '+this.list_actions_width+'px"></div>').insertBefore(f),l=f.clone().addClass("table-actions");if(l.find("th:not(:last-child)").remove(),l.find("tr td:not(:last-child)").remove(),"multi"===this.viewOptions.list_selectable||"action"===this.viewOptions.list_selectable)l.find("thead tr").html('<th><div class="repeater-list-heading">'+j+"</div></th>"),"action"!==this.viewOptions.list_selectable&&l.find("thead .btn").attr("disabled","disabled");else{var m=this.viewOptions.list_actions.label||'<span class="actions-hidden">a</span>';l.find("thead tr").addClass("empty-heading").html("<th>"+m+'<div class="repeater-list-heading">'+m+"</div></th>")}var n=l.find("td");n.each(function(b){a(this).html(j),a(this).find("a").attr("data-row",parseInt([b])+1)}),k.append(l),this.$canvas.addClass("actions-enabled")}this.list_sizeActionsTable(),this.$element.find(".table-actions tbody .action-item").on("click",function(b){if(!e.isDisabled){var c=a(this).data("action"),d=a(this).data("row"),f={actionName:c,rows:[d]};e.list_getActionItems(f,b)}}),this.$element.find(".table-actions thead .action-item").on("click",function(b){if(!e.isDisabled){var c=a(this).data("action"),d={actionName:c,rows:[]},f=".repeater-list-wrapper > table .selected";"action"===e.viewOptions.list_selectable&&(f=".repeater-list-wrapper > table tr"),e.$element.find(f).each(function(){var b=a(this).index();b+=1,d.rows.push(b)}),e.list_getActionItems(d,b)}})},a.fn.repeater.Constructor.prototype.list_getActionItems=function(b,c){var d,e=[],f=a.grep(this.viewOptions.list_actions.items,function(a){return a.name===b.actionName})[0];for(d=0;d<b.rows.length;d++){var g=this.$canvas.find(".repeater-list-wrapper > table tbody tr:nth-child("+b.rows[d]+")");e.push({item:g,rowData:g.data("item_data")})}if(1===e.length&&(e=e[0]),f.clickAction){var h=function(){};f.clickAction(e,h,c)}},a.fn.repeater.Constructor.prototype.list_sizeActionsTable=function(){var b=this.$element.find(".repeater-list table.table-actions"),c=b.find("thead tr th"),d=this.$element.find(".repeater-list-wrapper > table");c.outerHeight(d.find("thead tr th").outerHeight()),c.find(".repeater-list-heading").outerHeight(c.outerHeight()),b.find("tbody tr td:first-child").each(function(b,c){a(this).outerHeight(d.find("tbody tr:eq("+b+") td").outerHeight())})},a.fn.repeater.Constructor.prototype.list_sizeFrozenColumns=function(){var b=this.$element.find(".repeater-list .repeater-list-wrapper > table");this.$element.find(".repeater-list table.table-frozen tr").each(function(c){a(this).height(b.find("tr:eq("+c+")").height())});var c=b.find("td:eq(0)").outerWidth();this.$element.find(".frozen-column-wrapper, .frozen-thead-wrapper").width(c)},a.fn.repeater.Constructor.prototype.list_frozenOptionsInitialize=function(){function b(a){e.list_revertingCheckbox=!0,a.checkbox("toggle"),delete e.list_revertingCheckbox}var c=this.$element.find(".frozen-column-wrapper .checkbox-inline"),d=this.$element.find(".repeater-list table"),e=this;this.$element.find("tr.selectable").on("mouseover mouseleave",function(b){var c=a(this).index();c+=1,"mouseover"===b.type?d.find("tbody tr:nth-child("+c+")").addClass("hovered"):d.find("tbody tr:nth-child("+c+")").removeClass("hovered")}),c.checkbox(),this.$element.find(".table-frozen tbody .checkbox-inline").on("change",function(c){if(c.preventDefault(),!e.list_revertingCheckbox)if(e.isDisabled)b(a(c.currentTarget));else{var d=a(this).attr("data-row");d=parseInt(d)+1,e.$element.find(".repeater-list-wrapper > table tbody tr:nth-child("+d+")").click()}}),this.$element.find(".frozen-thead-wrapper thead .checkbox-inline").on("change",function(d){e.list_revertingCheckbox||(e.isDisabled?b(a(d.currentTarget)):a(this).checkbox("isChecked")?(e.$element.find(".repeater-list-wrapper > table tbody tr:not(.selected)").click(),e.$element.trigger("selected.fu.repeaterList",c)):(e.$element.find(".repeater-list-wrapper > table tbody tr.selected").click(),e.$element.trigger("deselected.fu.repeaterList",c)))})},a.fn.repeater.defaults=a.extend({},a.fn.repeater.defaults,{list_columnRendered:null,list_columnSizing:!0,list_columnSyncing:!0,list_highlightSortedColumn:!0,list_infiniteScroll:!1,list_noItemsHTML:"no items found",list_selectable:!1,list_sortClearing:!1,list_rowRendered:null,list_frozenColumns:0,list_actions:!1}),a.fn.repeater.viewTypes.list={cleared:function(){this.viewOptions.list_columnSyncing&&this.list_sizeHeadings()},dataOptions:function(a){return this.list_sortDirection&&(a.sortDirection=this.list_sortDirection),this.list_sortProperty&&(a.sortProperty=this.list_sortProperty),a},enabled:function(a){this.viewOptions.list_actions&&(a.status?(this.$canvas.find(".repeater-actions-button").removeAttr("disabled"),j.call(this)):this.$canvas.find(".repeater-actions-button").attr("disabled","disabled"))},initialize:function(a,b){this.list_sortDirection=null,this.list_sortProperty=null,this.list_specialBrowserClass=i(),this.list_actions_width=void 0!==this.viewOptions.list_actions.width?this.viewOptions.list_actions.width:37,this.list_noItems=!1,b()},resize:function(){h.call(this,this.$element.find(".repeater-list-wrapper > table thead tr")),this.viewOptions.list_actions&&this.list_sizeActionsTable(),(this.viewOptions.list_frozenColumns||"multi"===this.viewOptions.list_selectable)&&this.list_sizeFrozenColumns(),this.viewOptions.list_columnSyncing&&this.list_sizeHeadings()},selected:function(){var a,b=this.viewOptions.list_infiniteScroll;this.list_firstRender=!0,this.$loader.addClass("noHeader"),b&&(a="object"==typeof b?b:{},this.infiniteScrolling(!0,a))},before:function(b){var c,d=b.container.find(".repeater-list"),e=this;return d.length<1&&(d=a('<div class="repeater-list '+this.list_specialBrowserClass+'" data-preserve="shallow"><div class="repeater-list-wrapper" data-infinite="true" data-preserve="shallow"><table aria-readonly="true" class="table" data-preserve="shallow" role="grid"></table></div></div>'),d.find(".repeater-list-wrapper").on("scroll.fu.repeaterList",function(){e.viewOptions.list_columnSyncing&&e.list_positionHeadings()}),(e.viewOptions.list_frozenColumns||e.viewOptions.list_actions||"multi"===e.viewOptions.list_selectable)&&b.container.on("scroll.fu.repeaterList",function(){e.list_positionColumns()}),b.container.append(d)),b.container.removeClass("actions-enabled actions-enabled multi-select-enabled"),c=d.find("table"),g.call(this,c,b.data),f.call(this,c,b.data),!1},renderItem:function(a){return e.call(this,a.container,a.subset,a.index),!1},after:function(){var a;return!this.viewOptions.list_frozenColumns&&"multi"!==this.viewOptions.list_selectable||this.list_noItems||this.list_setFrozenColumns(),this.viewOptions.list_actions&&!this.list_noItems&&(this.list_createItemActions(),this.list_sizeActionsTable()),!this.viewOptions.list_frozenColumns&&!this.viewOptions.list_actions&&"multi"!==this.viewOptions.list_selectable||this.list_noItems||(this.list_positionColumns(),this.list_frozenOptionsInitialize()),this.viewOptions.list_columnSyncing&&(this.list_sizeHeadings(),this.list_positionHeadings()),a=this.$canvas.find(".repeater-list-wrapper > table .repeater-list-heading.sorted"),a.length>0&&this.list_highlightColumn(a.data("fu_item_index")),!1}})}(a),function(a){function b(b,c){function d(){var d,f,g;f=c.indexOf("{{"),d=c.indexOf("}}",f+2),f>-1&&d>-1?(g=a.trim(c.substring(f+2,d)),g=void 0!==b[g]?b[g]:"",c=c.substring(0,f)+g+c.substring(d+2)):e=!0}for(var e=!1;!e&&c.search("{{")>=0;)d(c);return c}a.fn.repeater&&(a.fn.repeater.Constructor.prototype.thumbnail_clearSelectedItems=function(){this.$canvas.find(".repeater-thumbnail-cont .selectable.selected").removeClass("selected")},a.fn.repeater.Constructor.prototype.thumbnail_getSelectedItems=function(){var b=[];return this.$canvas.find(".repeater-thumbnail-cont .selectable.selected").each(function(){b.push(a(this))}),b},a.fn.repeater.Constructor.prototype.thumbnail_setSelectedItems=function(b,c){function d(){return j===b[g].index?(h=a(this),!1):void j++}function e(){h=a(this),h.is(b[g].selector)&&f(h,b[g].selected)}function f(a,b){b=void 0!==b?b:!0,b?(c||"multi"===k||l.thumbnail_clearSelectedItems(),a.addClass("selected")):a.removeClass("selected")}var g,h,i,j,k=this.viewOptions.thumbnail_selectable,l=this;for(a.isArray(b)||(b=[b]),i=c===!0||"multi"===k?b.length:k&&b.length>0?1:0,g=0;i>g;g++)void 0!==b[g].index?(h=a(),j=0,this.$canvas.find(".repeater-thumbnail-cont .selectable").each(d),h.length>0&&f(h,b[g].selected)):b[g].selector&&this.$canvas.find(".repeater-thumbnail-cont .selectable").each(e)},a.fn.repeater.defaults=a.extend({},a.fn.repeater.defaults,{thumbnail_alignment:"left",thumbnail_infiniteScroll:!1,thumbnail_itemRendered:null,thumbnail_noItemsHTML:"no items found",thumbnail_selectable:!1,thumbnail_template:'<div class="thumbnail repeater-thumbnail"><img height="75" src="{{src}}" width="65"><span>{{name}}</span></div>'}),a.fn.repeater.viewTypes.thumbnail={selected:function(){var a,b=this.viewOptions.thumbnail_infiniteScroll;b&&(a="object"==typeof b?b:{},this.infiniteScrolling(!0,a))},before:function(b){var c,d,e=this.viewOptions.thumbnail_alignment,f=this.$canvas.find(".repeater-thumbnail-cont"),g=b.data,h={};return f.length<1?(f=a('<div class="clearfix repeater-thumbnail-cont" data-container="true" data-infinite="true" data-preserve="shallow"></div>'),e&&"none"!==e?(d={center:1,justify:1,left:1,right:1},e=d[e]?e:"justify",f.addClass("align-"+e),this.thumbnail_injectSpacers=!0):this.thumbnail_injectSpacers=!1,h.item=f):h.action="none",g.items&&g.items.length<1?(c=a('<div class="empty"></div>'),c.append(this.viewOptions.thumbnail_noItemsHTML),f.append(c)):f.find(".empty:first").remove(),h},renderItem:function(c){var d=this.viewOptions.thumbnail_selectable,e="selected",f=this,g=a(b(c.subset[c.index],this.viewOptions.thumbnail_template));return g.data("item_data",c.data.items[c.index]),d&&(g.addClass("selectable"),g.on("click",function(){f.isDisabled||(g.hasClass(e)?(g.removeClass(e),f.$element.trigger("deselected.fu.repeaterThumbnail",g)):("multi"!==d&&f.$canvas.find(".repeater-thumbnail-cont .selectable.selected").each(function(){var b=a(this);b.removeClass(e),f.$element.trigger("deselected.fu.repeaterThumbnail",b)}),g.addClass(e),f.$element.trigger("selected.fu.repeaterThumbnail",g)))})),c.container.append(g),this.thumbnail_injectSpacers&&g.after('<span class="spacer">&nbsp;</span>'),this.viewOptions.thumbnail_itemRendered&&this.viewOptions.thumbnail_itemRendered({container:c.container,item:g,itemData:c.subset[c.index]},function(){}),!1}})}(a),function(a){var b=a.fn.scheduler,c=function(b,c){var d=this;this.$element=a(b),this.options=a.extend({},a.fn.scheduler.defaults,c),this.$startDate=this.$element.find(".start-datetime .start-date"),this.$startTime=this.$element.find(".start-datetime .start-time"),this.$timeZone=this.$element.find(".timezone-container .timezone"),this.$repeatIntervalPanel=this.$element.find(".repeat-every-panel"),this.$repeatIntervalSelect=this.$element.find(".repeat-options"),this.$repeatIntervalSpinbox=this.$element.find(".repeat-every"),this.$repeatIntervalTxt=this.$element.find(".repeat-every-text"),this.$end=this.$element.find(".repeat-end"),this.$endSelect=this.$end.find(".end-options"),this.$endAfter=this.$end.find(".end-after"),this.$endDate=this.$end.find(".end-on-date"),this.$recurrencePanels=this.$element.find(".repeat-panel"),this.$repeatIntervalSelect.selectlist(),this.$element.find(".selectlist").selectlist(),this.$startDate.datepicker(this.options.startDateOptions);var e="function"==typeof this.options.startDateChanged?this.options.startDateChanged:this._guessEndDate;this.$startDate.on("change changed.fu.datepicker dateClicked.fu.datepicker",a.proxy(e,this)),this.$startTime.combobox(),""===this.$startTime.find("input").val()&&this.$startTime.combobox("selectByIndex",0),"0"===this.$repeatIntervalSpinbox.find("input").val()?this.$repeatIntervalSpinbox.spinbox({value:1,min:1,limitToStep:!0}):this.$repeatIntervalSpinbox.spinbox({min:1,limitToStep:!0}),this.$endAfter.spinbox({value:1,min:1,limitToStep:!0}),this.$endDate.datepicker(this.options.endDateOptions),this.$element.find(".radio-custom").radio(),this.$repeatIntervalSelect.on("changed.fu.selectlist",a.proxy(this.repeatIntervalSelectChanged,this)),this.$endSelect.on("changed.fu.selectlist",a.proxy(this.endSelectChanged,this)),this.$element.find(".repeat-days-of-the-week .btn-group .btn").on("change.fu.scheduler",function(a,b){d.changed(a,b,!0)}),this.$element.find(".combobox").on("changed.fu.combobox",a.proxy(this.changed,this)),this.$element.find(".datepicker").on("changed.fu.datepicker",a.proxy(this.changed,this)),this.$element.find(".datepicker").on("dateClicked.fu.datepicker",a.proxy(this.changed,this)),this.$element.find(".selectlist").on("changed.fu.selectlist",a.proxy(this.changed,this)),this.$element.find(".spinbox").on("changed.fu.spinbox",a.proxy(this.changed,this)),this.$element.find(".repeat-monthly .radio-custom, .repeat-yearly .radio-custom").on("change.fu.scheduler",a.proxy(this.changed,this))},d=function(a,b){var c,d="";return d+=a.getFullYear(),d+=b,c=a.getMonth()+1,d+=10>c?"0"+c:c,d+=b,c=a.getDate(),d+=10>c?"0"+c:c},e=1e3,f=60*e,g=60*f,h=24*g,i=7*h,j=5*i,k=52*i,l={secondly:e,minutely:f,hourly:g,daily:h,weekly:i,monthly:j,yearly:k},m=function(a,b,c,d){return new Date(a.getTime()+l[c]*d)};c.prototype={constructor:c,destroy:function(){var b;return this.$element.find("input").each(function(){a(this).attr("value",a(this).val())}),this.$element.find(".datepicker .calendar").empty(),b=this.$element[0].outerHTML,this.$element.find(".combobox").combobox("destroy"),this.$element.find(".datepicker").datepicker("destroy"),this.$element.find(".selectlist").selectlist("destroy"),this.$element.find(".spinbox").spinbox("destroy"),this.$element.find(".radio-custom").radio("destroy"),this.$element.remove(),b},changed:function(b,c,d){d||b.stopPropagation(),this.$element.trigger("changed.fu.scheduler",{data:void 0!==c?c:a(b.currentTarget).data(),originalEvent:b,value:this.getValue()})},disable:function(){this.toggleState("disable")},enable:function(){this.toggleState("enable")},setUtcTime:function(a,b,c){var d=a.split("-"),e=b.split(":"),f=new Date(Date.UTC(d[0],d[1]-1,d[2],e[0],e[1],e[2]?e[2]:0));if("Z"===c)f.setUTCHours(f.getUTCHours()+0);else{var g=[];g[0]="(.)",g[1]=".*?",g[2]="\\d",g[3]=".*?",g[4]="(\\d)";var h=new RegExp(g.join(""),["i"]),i=h.exec(c);if(null!==i){var j=i[1],k=i[2],l="+"===j?1:-1;f.setUTCHours(f.getUTCHours()+l*parseInt(k,10))}}var m=f.getTimezoneOffset();return f.setMinutes(m),f},endSelectChanged:function(a,b){var c,d;b?d=b.value:(c=this.$endSelect.selectlist("selectedItem"),d=c.value),this.$endAfter.parent().addClass("hidden"),this.$endAfter.parent().attr("aria-hidden","true"),this.$endDate.parent().addClass("hidden"),this.$endDate.parent().attr("aria-hidden","true"),"after"===d?(this.$endAfter.parent().removeClass("hide hidden"),this.$endAfter.parent().attr("aria-hidden","false")):"date"===d&&(this.$endDate.parent().removeClass("hide hidden"),this.$endDate.parent().attr("aria-hidden","false"))},_guessEndDate:function(){var a=this.$repeatIntervalSelect.selectlist("selectedItem").value,b=new Date(this.$endDate.datepicker("getDate")),c=new Date(this.$startDate.datepicker("getDate")),d=this.$repeatIntervalSpinbox.find("input").val();"none"!==a&&c>=b&&(this.$repeatIntervalSpinbox.is(":visible")||(d=1),"weekdays"===a&&(d=1,a="weekly"),b=m(c,b,a,d),this.$endDate.datepicker("setDate",b))},getValue:function(){var b,c=this.$repeatIntervalSpinbox.spinbox("value"),e="",f=this.$repeatIntervalSelect.selectlist("selectedItem").value;this.$startTime.combobox("selectedItem").value?(b=this.$startTime.combobox("selectedItem").value,b=b.toLowerCase()):b=this.$startTime.combobox("selectedItem").text.toLowerCase();var g,h,i,j,k,l,m,n,o=this.$timeZone.selectlist("selectedItem");m=""+d(this.$startDate.datepicker("getDate"),"-"),m+="T",i=b.search("am")>=0,j=b.search("pm")>=0,b=a.trim(b.replace(/am/g,"").replace(/pm/g,"")).split(":"),b[0]=parseInt(b[0],10),b[1]=parseInt(b[1],10),i&&b[0]>11?b[0]=0:j&&b[0]<12&&(b[0]+=12),m+=b[0]<10?"0"+b[0]:b[0],m+=":",m+=b[1]<10?"0"+b[1]:b[1],m+="+00:00"===o.offset?"Z":o.offset,"none"===f?e="FREQ=DAILY;INTERVAL=1;COUNT=1;":"secondly"===f?(e="FREQ=SECONDLY;",e+="INTERVAL="+c+";"):"minutely"===f?(e="FREQ=MINUTELY;",e+="INTERVAL="+c+";"):"hourly"===f?(e="FREQ=HOURLY;",e+="INTERVAL="+c+";"):"daily"===f?(e+="FREQ=DAILY;",e+="INTERVAL="+c+";"):"weekdays"===f?(e+="FREQ=WEEKLY;",e+="BYDAY=MO,TU,WE,TH,FR;",e+="INTERVAL=1;"):"weekly"===f?(h=[],this.$element.find(".repeat-days-of-the-week .btn-group input:checked").each(function(){h.push(a(this).data().value)}),e+="FREQ=WEEKLY;",e+="BYDAY="+h.join(",")+";",e+="INTERVAL="+c+";"):"monthly"===f?(e+="FREQ=MONTHLY;",e+="INTERVAL="+c+";",n=this.$element.find("input[name=repeat-monthly]:checked").val(),"bymonthday"===n?(g=parseInt(this.$element.find(".repeat-monthly-date .selectlist").selectlist("selectedItem").text,10),e+="BYMONTHDAY="+g+";"):"bysetpos"===n&&(h=this.$element.find(".repeat-monthly-day .month-days").selectlist("selectedItem").value,l=this.$element.find(".repeat-monthly-day .month-day-pos").selectlist("selectedItem").value,e+="BYDAY="+h+";",e+="BYSETPOS="+l+";")):"yearly"===f&&(e+="FREQ=YEARLY;",n=this.$element.find("input[name=repeat-yearly]:checked").val(),"bymonthday"===n?(k=this.$element.find(".repeat-yearly-date .year-month").selectlist("selectedItem").value,g=this.$element.find(".repeat-yearly-date .year-month-day").selectlist("selectedItem").text,e+="BYMONTH="+k+";",e+="BYMONTHDAY="+g+";"):"bysetpos"===n&&(h=this.$element.find(".repeat-yearly-day .year-month-days").selectlist("selectedItem").value,l=this.$element.find(".repeat-yearly-day .year-month-day-pos").selectlist("selectedItem").value,k=this.$element.find(".repeat-yearly-day .year-month").selectlist("selectedItem").value,e+="BYDAY="+h+";",e+="BYSETPOS="+l+";",e+="BYMONTH="+k+";"));var p=this.$endSelect.selectlist("selectedItem").value,q="";"none"!==f&&("after"===p?q="COUNT="+this.$endAfter.spinbox("value")+";":"date"===p&&(q="UNTIL="+d(this.$endDate.datepicker("getDate"),"")+";")),e+=q,e=";"===e.substring(e.length-1)?e.substring(0,e.length-1):e;var r={startDateTime:m,timeZone:o,recurrencePattern:e};return r},repeatIntervalSelectChanged:function(a,b){var c,d,e;switch(b?(d=b.value,e=b.text):(c=this.$repeatIntervalSelect.selectlist("selectedItem"),d=c.value||"",e=c.text||""),this.$repeatIntervalTxt.text(e),d.toLowerCase()){case"hourly":case"daily":case"weekly":case"monthly":this.$repeatIntervalPanel.removeClass("hide hidden"),this.$repeatIntervalPanel.attr("aria-hidden","false");break;default:this.$repeatIntervalPanel.addClass("hidden"),this.$repeatIntervalPanel.attr("aria-hidden","true")}this.$recurrencePanels.addClass("hidden"),this.$recurrencePanels.attr("aria-hidden","true"),this.$element.find(".repeat-"+d).removeClass("hide hidden"),this.$element.find(".repeat-"+d).attr("aria-hidden","false"),"none"===d?(this.$end.addClass("hidden"),this.$end.attr("aria-hidden","true")):(this.$end.removeClass("hide hidden"),this.$end.attr("aria-hidden","false")),this._guessEndDate()},_parseAndSetRecurrencePattern:function(a,b){var c,d,e,f,g={},h=0,i="",j=a.toUpperCase().split(";");for(h=0;h<j.length;h++)""!==j[h]&&(i=j[h].split("="),g[i[0]]=i[1]);if("DAILY"===g.FREQ)i="MO,TU,WE,TH,FR"===g.BYDAY?"weekdays":"1"===g.INTERVAL&&"1"===g.COUNT?"none":"daily";else if("SECONDLY"===g.FREQ)i="secondly";else if("MINUTELY"===g.FREQ)i="minutely";else if("HOURLY"===g.FREQ)i="hourly";else if("WEEKLY"===g.FREQ){if(i="weekly",g.BYDAY)if("MO,TU,WE,TH,FR"===g.BYDAY)i="weekdays";else{var k=this.$element.find(".repeat-days-of-the-week .btn-group");for(k.find("label").removeClass("active"),c=g.BYDAY.split(","),h=0;h<c.length;h++)k.find('input[data-value="'+c[h]+'"]').prop("checked",!0).parent().addClass("active")}}else if("MONTHLY"===g.FREQ){if(this.$element.find(".repeat-monthly input").removeAttr("checked").removeClass("checked"),this.$element.find(".repeat-monthly label.radio-custom").removeClass("checked"),g.BYMONTHDAY)d=this.$element.find(".repeat-monthly-date"),d.find("input").addClass("checked").prop("checked",!0),d.find("label.radio-custom").addClass("checked"),d.find(".selectlist").selectlist("selectByValue",g.BYMONTHDAY);else if(g.BYDAY){var l=this.$element.find(".repeat-monthly-day");l.find("input").addClass("checked").prop("checked",!0),l.find("label.radio-custom").addClass("checked"),g.BYSETPOS&&l.find(".month-day-pos").selectlist("selectByValue",g.BYSETPOS),l.find(".month-days").selectlist("selectByValue",g.BYDAY)}i="monthly"}else"YEARLY"===g.FREQ?(this.$element.find(".repeat-yearly input").removeAttr("checked").removeClass("checked"),this.$element.find(".repeat-yearly label.radio-custom").removeClass("checked"),g.BYMONTHDAY?(e=this.$element.find(".repeat-yearly-date"),e.find("input").addClass("checked").prop("checked",!0),e.find("label.radio-custom").addClass("checked"),g.BYMONTH&&e.find(".year-month").selectlist("selectByValue",g.BYMONTH),e.find(".year-month-day").selectlist("selectByValue",g.BYMONTHDAY)):g.BYSETPOS&&(f=this.$element.find(".repeat-yearly-day"),f.find("input").addClass("checked").prop("checked",!0),f.find("label.radio-custom").addClass("checked"),f.find(".year-month-day-pos").selectlist("selectByValue",g.BYSETPOS),g.BYDAY&&f.find(".year-month-days").selectlist("selectByValue",g.BYDAY),g.BYMONTH&&f.find(".year-month").selectlist("selectByValue",g.BYMONTH)),i="yearly"):i="none";if(g.COUNT)this.$endAfter.spinbox("value",parseInt(g.COUNT,10)),this.$endSelect.selectlist("selectByValue","after");else if(g.UNTIL){var m,n;8===g.UNTIL.length&&(m=g.UNTIL.split(""),m.splice(4,0,"-"),m.splice(7,0,"-"),n=m.join(""));var o=this.$timeZone.selectlist("selectedItem"),p="+00:00"===o.offset?"Z":o.offset,q=this.setUtcTime(n,b.time24HourFormat,p);this.$endDate.datepicker("setDate",q),this.$endSelect.selectlist("selectByValue","date")}else this.$endSelect.selectlist("selectByValue","never");this.endSelectChanged(),g.INTERVAL&&this.$repeatIntervalSpinbox.spinbox("value",parseInt(g.INTERVAL,10)),this.$repeatIntervalSelect.selectlist("selectByValue",i),this.repeatIntervalSelectChanged()},_parseStartDateTime:function(b){var c,d,e,f={};return f.time24HourFormat=b.split("+")[0].split("-")[0],b.search(/\+/)>-1?f.timeZoneOffset="+"+a.trim(b.split("+")[1]):b.search(/\-/)>-1?f.timeZoneOffset="-"+a.trim(b.split("-")[1]):f.timeZoneOffset="+00:00",f.time24HourFormatSplit=f.time24HourFormat.split(":"),c=parseInt(f.time24HourFormatSplit[0],10),d=f.time24HourFormatSplit[1]?parseInt(f.time24HourFormatSplit[1].split("+")[0].split("-")[0].split("Z")[0],10):0,e=12>c?"AM":"PM",0===c?c=12:c>12&&(c-=12),d=10>d?"0"+d:d,f.time12HourFormat=c+":"+d,f.time12HourFormatWithPeriod=c+":"+d+" "+e,f},_parseTimeZone:function(b,c){return c.timeZoneQuerySelector="",b.timeZone?("string"==typeof b.timeZone?c.timeZoneQuerySelector+='li[data-name="'+b.timeZone+'"]':a.each(b.timeZone,function(a,b){c.timeZoneQuerySelector+="li[data-"+a+'="'+b+'"]'}),c.timeZoneOffset=b.timeZone.offset):b.startDateTime?(c.timeZoneOffset="+00:00"===c.timeZoneOffset?"Z":c.timeZoneOffset,c.timeZoneQuerySelector+='li[data-offset="'+c.timeZoneOffset+'"]'):c.timeZoneOffset="Z",c.timeZoneOffset},_setTimeUI:function(a){this.$startTime.find("input").val(a),this.$startTime.combobox("selectByText",a)},_setTimeZoneUI:function(a){this.$timeZone.selectlist("selectBySelector",a)},setValue:function(a){var b,c,d,e,f={};if(a.startDateTime)b=a.startDateTime.split("T"),c=b[0],d=b[1],d?(f=this._parseStartDateTime(d),this._setTimeUI(f.time12HourFormatWithPeriod)):(f.time12HourFormat="00:00",f.time24HourFormat="00:00");else{f.time12HourFormat="00:00",f.time24HourFormat="00:00";var g=this.$startDate.datepicker("getDate");c=g.getFullYear()+"-"+g.getMonth()+"-"+g.getDate()}this._parseTimeZone(a,f),f.timeZoneQuerySelector&&this._setTimeZoneUI(f.timeZoneQuerySelector),a.recurrencePattern&&this._parseAndSetRecurrencePattern(a.recurrencePattern,f),e=this.setUtcTime(c,f.time24HourFormat,f.timeZoneOffset),this.$startDate.datepicker("setDate",e)},toggleState:function(a){this.$element.find(".combobox").combobox(a),this.$element.find(".datepicker").datepicker(a),this.$element.find(".selectlist").selectlist(a),this.$element.find(".spinbox").spinbox(a),this.$element.find(".radio-custom").radio(a),a="disable"===a?"addClass":"removeClass",this.$element.find(".repeat-days-of-the-week .btn-group")[a]("disabled")},value:function(a){return a?this.setValue(a):this.getValue()}},a.fn.scheduler=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.scheduler"),h="object"==typeof b&&b;g||f.data("fu.scheduler",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.scheduler.defaults={},a.fn.scheduler.Constructor=c,a.fn.scheduler.noConflict=function(){return a.fn.scheduler=b,this},a(document).on("mousedown.fu.scheduler.data-api","[data-initialize=scheduler]",function(b){var c=a(b.target).closest(".scheduler");c.data("fu.scheduler")||c.scheduler(c.data())}),a(function(){a("[data-initialize=scheduler]").each(function(){var b=a(this);b.data("scheduler")||b.scheduler(b.data())})})}(a),function(a){var b=a.fn.picker,c=function(b,c){var d=this;this.$element=a(b),this.options=a.extend({},a.fn.picker.defaults,c),this.$accept=this.$element.find(".picker-accept"),this.$cancel=this.$element.find(".picker-cancel"),this.$trigger=this.$element.find(".picker-trigger"),this.$footer=this.$element.find(".picker-footer"),this.$header=this.$element.find(".picker-header"),this.$popup=this.$element.find(".picker-popup"),this.$body=this.$element.find(".picker-body"),this.clickStamp="_",this.isInput=this.$trigger.is("input"),this.$trigger.on("keydown.fu.picker",a.proxy(this.keyComplete,this)),this.$trigger.on("focus.fu.picker",a.proxy(function(b){("undefined"==typeof b||a(b.target).is("input[type=text]"))&&a.proxy(this.show(),this)},this)),this.$trigger.on("click.fu.picker",a.proxy(function(b){a(b.target).is("input[type=text]")?a.proxy(this.show(),this):a.proxy(this.toggle(),this)},this)),this.$accept.on("click.fu.picker",a.proxy(this.complete,this,"accepted")),this.$cancel.on("click.fu.picker",function(a){a.preventDefault(),d.complete("cancelled")})},d=function(b){var c=Math.max(document.documentElement.clientHeight,window.innerHeight||0),d=a(document).scrollTop(),e=b.$popup.offset(),f=e.top+b.$popup.outerHeight(!0);return f>c+d||e.top<d},e=function(a){a.$popup.css("visibility","hidden"),g(a),d(a)&&(f(a),d(a)&&g(a)),a.$popup.css("visibility","visible")},f=function(a){a.$popup.css("top",-a.$popup.outerHeight(!0)+"px")},g=function(a){a.$popup.css("top",a.$trigger.outerHeight(!0)+"px")};c.prototype={constructor:c,complete:function(a){var b={accepted:"onAccept",cancelled:"onCancel",exited:"onExit"},c=this.options[b[a]],d={contents:this.$body};c?(c(d),this.$element.trigger(a+".fu.picker",d)):(this.$element.trigger(a+".fu.picker",d),this.hide())},keyComplete:function(a){this.isInput&&13===a.keyCode?(this.complete("accepted"),this.$trigger.blur()):27===a.keyCode&&(this.complete("exited"),this.$trigger.blur())},destroy:function(){return this.$element.remove(),a(document).off("click.fu.picker.externalClick."+this.clickStamp),
this.$element[0].outerHTML},disable:function(){this.$element.addClass("disabled"),this.$trigger.attr("disabled","disabled")},enable:function(){this.$element.removeClass("disabled"),this.$trigger.removeAttr("disabled")},toggle:function(){this.$element.hasClass("showing")?this.hide():this.show()},hide:function(){this.$element.hasClass("showing")&&(this.$element.removeClass("showing"),a(document).off("click.fu.picker.externalClick."+this.clickStamp),this.$element.trigger("hidden.fu.picker"))},externalClickListener:function(a,b){(b===!0||this.isExternalClick(a))&&this.complete("exited")},isExternalClick:function(b){var c,d,e=this.$element.get(0),f=this.options.externalClickExceptions||[],g=a(b.target);if(b.target===e||g.parents(".picker:first").get(0)===e)return!1;for(c=0,d=f.length;d>c;c++)if(g.is(f[c])||g.parents(f[c]).length>0)return!1;return!0},show:function(){var b;if(b=a(document).find(".picker.showing"),b.length>0){if(b.data("fu.picker")&&b.data("fu.picker").options.explicit)return;b.picker("externalClickListener",{},!0)}this.$element.addClass("showing"),e(this),this.$element.trigger("shown.fu.picker"),this.clickStamp=(new Date).getTime()+(Math.floor(100*Math.random())+1),this.options.explicit||a(document).on("click.fu.picker.externalClick."+this.clickStamp,a.proxy(this.externalClickListener,this))}},a.fn.picker=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.picker"),h="object"==typeof b&&b;g||f.data("fu.picker",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.picker.defaults={onAccept:void 0,onCancel:void 0,onExit:void 0,externalClickExceptions:[],explicit:!1},a.fn.picker.Constructor=c,a.fn.picker.noConflict=function(){return a.fn.picker=b,this},a(document).on("focus.fu.picker.data-api","[data-initialize=picker]",function(b){var c=a(b.target).closest(".picker");c.data("fu.picker")||c.picker(c.data())}),a(function(){a("[data-initialize=picker]").each(function(){var b=a(this);b.data("fu.picker")||b.picker(b.data())})})}(a)});
/*!

 handlebars v3.0.3

Copyright (C) 2011-2014 by Yehuda Katz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

@license
*/
!function(a,b){"object"==typeof exports&&"object"==typeof module?module.exports=b():"function"==typeof define&&define.amd?define(b):"object"==typeof exports?exports.Handlebars=b():a.Handlebars=b()}(this,function(){return function(a){function b(d){if(c[d])return c[d].exports;var e=c[d]={exports:{},id:d,loaded:!1};return a[d].call(e.exports,e,e.exports,b),e.loaded=!0,e.exports}var c={};return b.m=a,b.c=c,b.p="",b(0)}([function(a,b,c){"use strict";function d(){var a=new g.HandlebarsEnvironment;return m.extend(a,g),a.SafeString=i["default"],a.Exception=k["default"],a.Utils=m,a.escapeExpression=m.escapeExpression,a.VM=o,a.template=function(b){return o.template(b,a)},a}var e=c(7)["default"];b.__esModule=!0;var f=c(1),g=e(f),h=c(2),i=e(h),j=c(3),k=e(j),l=c(4),m=e(l),n=c(5),o=e(n),p=c(6),q=e(p),r=d();r.create=d,q["default"](r),r["default"]=r,b["default"]=r,a.exports=b["default"]},function(a,b,c){"use strict";function d(a,b){this.helpers=a||{},this.partials=b||{},e(this)}function e(a){a.registerHelper("helperMissing",function(){if(1===arguments.length)return void 0;throw new k["default"]('Missing helper: "'+arguments[arguments.length-1].name+'"')}),a.registerHelper("blockHelperMissing",function(b,c){var d=c.inverse,e=c.fn;if(b===!0)return e(this);if(b===!1||null==b)return d(this);if(o(b))return b.length>0?(c.ids&&(c.ids=[c.name]),a.helpers.each(b,c)):d(this);if(c.data&&c.ids){var g=f(c.data);g.contextPath=i.appendContextPath(c.data.contextPath,c.name),c={data:g}}return e(b,c)}),a.registerHelper("each",function(a,b){function c(b,c,e){j&&(j.key=b,j.index=c,j.first=0===c,j.last=!!e,l&&(j.contextPath=l+b)),h+=d(a[b],{data:j,blockParams:i.blockParams([a[b],b],[l+b,null])})}if(!b)throw new k["default"]("Must pass iterator to #each");var d=b.fn,e=b.inverse,g=0,h="",j=void 0,l=void 0;if(b.data&&b.ids&&(l=i.appendContextPath(b.data.contextPath,b.ids[0])+"."),p(a)&&(a=a.call(this)),b.data&&(j=f(b.data)),a&&"object"==typeof a)if(o(a))for(var m=a.length;m>g;g++)c(g,g,g===a.length-1);else{var n=void 0;for(var q in a)a.hasOwnProperty(q)&&(n&&c(n,g-1),n=q,g++);n&&c(n,g-1,!0)}return 0===g&&(h=e(this)),h}),a.registerHelper("if",function(a,b){return p(a)&&(a=a.call(this)),!b.hash.includeZero&&!a||i.isEmpty(a)?b.inverse(this):b.fn(this)}),a.registerHelper("unless",function(b,c){return a.helpers["if"].call(this,b,{fn:c.inverse,inverse:c.fn,hash:c.hash})}),a.registerHelper("with",function(a,b){p(a)&&(a=a.call(this));var c=b.fn;if(i.isEmpty(a))return b.inverse(this);if(b.data&&b.ids){var d=f(b.data);d.contextPath=i.appendContextPath(b.data.contextPath,b.ids[0]),b={data:d}}return c(a,b)}),a.registerHelper("log",function(b,c){var d=c.data&&null!=c.data.level?parseInt(c.data.level,10):1;a.log(d,b)}),a.registerHelper("lookup",function(a,b){return a&&a[b]})}function f(a){var b=i.extend({},a);return b._parent=a,b}var g=c(7)["default"];b.__esModule=!0,b.HandlebarsEnvironment=d,b.createFrame=f;var h=c(4),i=g(h),j=c(3),k=g(j),l="3.0.1";b.VERSION=l;var m=6;b.COMPILER_REVISION=m;var n={1:"<= 1.0.rc.2",2:"== 1.0.0-rc.3",3:"== 1.0.0-rc.4",4:"== 1.x.x",5:"== 2.0.0-alpha.x",6:">= 2.0.0-beta.1"};b.REVISION_CHANGES=n;var o=i.isArray,p=i.isFunction,q=i.toString,r="[object Object]";d.prototype={constructor:d,logger:s,log:t,registerHelper:function(a,b){if(q.call(a)===r){if(b)throw new k["default"]("Arg not supported with multiple helpers");i.extend(this.helpers,a)}else this.helpers[a]=b},unregisterHelper:function(a){delete this.helpers[a]},registerPartial:function(a,b){if(q.call(a)===r)i.extend(this.partials,a);else{if("undefined"==typeof b)throw new k["default"]("Attempting to register a partial as undefined");this.partials[a]=b}},unregisterPartial:function(a){delete this.partials[a]}};var s={methodMap:{0:"debug",1:"info",2:"warn",3:"error"},DEBUG:0,INFO:1,WARN:2,ERROR:3,level:1,log:function(a,b){if("undefined"!=typeof console&&s.level<=a){var c=s.methodMap[a];(console[c]||console.log).call(console,b)}}};b.logger=s;var t=s.log;b.log=t},function(a,b){"use strict";function c(a){this.string=a}b.__esModule=!0,c.prototype.toString=c.prototype.toHTML=function(){return""+this.string},b["default"]=c,a.exports=b["default"]},function(a,b){"use strict";function c(a,b){var e=b&&b.loc,f=void 0,g=void 0;e&&(f=e.start.line,g=e.start.column,a+=" - "+f+":"+g);for(var h=Error.prototype.constructor.call(this,a),i=0;i<d.length;i++)this[d[i]]=h[d[i]];Error.captureStackTrace&&Error.captureStackTrace(this,c),e&&(this.lineNumber=f,this.column=g)}b.__esModule=!0;var d=["description","fileName","lineNumber","message","name","number","stack"];c.prototype=new Error,b["default"]=c,a.exports=b["default"]},function(a,b){"use strict";function c(a){return j[a]}function d(a){for(var b=1;b<arguments.length;b++)for(var c in arguments[b])Object.prototype.hasOwnProperty.call(arguments[b],c)&&(a[c]=arguments[b][c]);return a}function e(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1}function f(a){if("string"!=typeof a){if(a&&a.toHTML)return a.toHTML();if(null==a)return"";if(!a)return a+"";a=""+a}return l.test(a)?a.replace(k,c):a}function g(a){return a||0===a?o(a)&&0===a.length?!0:!1:!0}function h(a,b){return a.path=b,a}function i(a,b){return(a?a+".":"")+b}b.__esModule=!0,b.extend=d,b.indexOf=e,b.escapeExpression=f,b.isEmpty=g,b.blockParams=h,b.appendContextPath=i;var j={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},k=/[&<>"'`]/g,l=/[&<>"'`]/,m=Object.prototype.toString;b.toString=m;var n=function(a){return"function"==typeof a};n(/x/)&&(b.isFunction=n=function(a){return"function"==typeof a&&"[object Function]"===m.call(a)});var n;b.isFunction=n;var o=Array.isArray||function(a){return a&&"object"==typeof a?"[object Array]"===m.call(a):!1};b.isArray=o},function(a,b,c){"use strict";function d(a){var b=a&&a[0]||1,c=p.COMPILER_REVISION;if(b!==c){if(c>b){var d=p.REVISION_CHANGES[c],e=p.REVISION_CHANGES[b];throw new o["default"]("Template was precompiled with an older version of Handlebars than the current runtime. Please update your precompiler to a newer version ("+d+") or downgrade your runtime to an older version ("+e+").")}throw new o["default"]("Template was precompiled with a newer version of Handlebars than the current runtime. Please update your runtime to a newer version ("+a[1]+").")}}function e(a,b){function c(c,d,e){e.hash&&(d=m.extend({},d,e.hash)),c=b.VM.resolvePartial.call(this,c,d,e);var f=b.VM.invokePartial.call(this,c,d,e);if(null==f&&b.compile&&(e.partials[e.name]=b.compile(c,a.compilerOptions,b),f=e.partials[e.name](d,e)),null!=f){if(e.indent){for(var g=f.split("\n"),h=0,i=g.length;i>h&&(g[h]||h+1!==i);h++)g[h]=e.indent+g[h];f=g.join("\n")}return f}throw new o["default"]("The partial "+e.name+" could not be compiled when running in runtime-only mode")}function d(b){var c=void 0===arguments[1]?{}:arguments[1],f=c.data;d._setup(c),!c.partial&&a.useData&&(f=j(b,f));var g=void 0,h=a.useBlockParams?[]:void 0;return a.useDepths&&(g=c.depths?[b].concat(c.depths):[b]),a.main.call(e,b,e.helpers,e.partials,f,h,g)}if(!b)throw new o["default"]("No environment passed to template");if(!a||!a.main)throw new o["default"]("Unknown template object: "+typeof a);b.VM.checkRevision(a.compiler);var e={strict:function(a,b){if(!(b in a))throw new o["default"]('"'+b+'" not defined in '+a);return a[b]},lookup:function(a,b){for(var c=a.length,d=0;c>d;d++)if(a[d]&&null!=a[d][b])return a[d][b]},lambda:function(a,b){return"function"==typeof a?a.call(b):a},escapeExpression:m.escapeExpression,invokePartial:c,fn:function(b){return a[b]},programs:[],program:function(a,b,c,d,e){var g=this.programs[a],h=this.fn(a);return b||e||d||c?g=f(this,a,h,b,c,d,e):g||(g=this.programs[a]=f(this,a,h)),g},data:function(a,b){for(;a&&b--;)a=a._parent;return a},merge:function(a,b){var c=a||b;return a&&b&&a!==b&&(c=m.extend({},b,a)),c},noop:b.VM.noop,compilerInfo:a.compiler};return d.isTop=!0,d._setup=function(c){c.partial?(e.helpers=c.helpers,e.partials=c.partials):(e.helpers=e.merge(c.helpers,b.helpers),a.usePartial&&(e.partials=e.merge(c.partials,b.partials)))},d._child=function(b,c,d,g){if(a.useBlockParams&&!d)throw new o["default"]("must pass block params");if(a.useDepths&&!g)throw new o["default"]("must pass parent depths");return f(e,b,a[b],c,0,d,g)},d}function f(a,b,c,d,e,f,g){function h(b){var e=void 0===arguments[1]?{}:arguments[1];return c.call(a,b,a.helpers,a.partials,e.data||d,f&&[e.blockParams].concat(f),g&&[b].concat(g))}return h.program=b,h.depth=g?g.length:0,h.blockParams=e||0,h}function g(a,b,c){return a?a.call||c.name||(c.name=a,a=c.partials[a]):a=c.partials[c.name],a}function h(a,b,c){if(c.partial=!0,void 0===a)throw new o["default"]("The partial "+c.name+" could not be found");return a instanceof Function?a(b,c):void 0}function i(){return""}function j(a,b){return b&&"root"in b||(b=b?p.createFrame(b):{},b.root=a),b}var k=c(7)["default"];b.__esModule=!0,b.checkRevision=d,b.template=e,b.wrapProgram=f,b.resolvePartial=g,b.invokePartial=h,b.noop=i;var l=c(4),m=k(l),n=c(3),o=k(n),p=c(1)},function(a,b){(function(c){"use strict";b.__esModule=!0,b["default"]=function(a){var b="undefined"!=typeof c?c:window,d=b.Handlebars;a.noConflict=function(){b.Handlebars===a&&(b.Handlebars=d)}},a.exports=b["default"]}).call(b,function(){return this}())},function(a,b){"use strict";b["default"]=function(a){return a&&a.__esModule?a:{"default":a}},b.__esModule=!0}])});
!function(t,e){if("function"==typeof define&&define.amd)define(["module","exports"],e);else if("undefined"!=typeof exports)e(module,exports);else{var s={exports:{}};e(s,s.exports),t.Hashids=s.exports}}(this,function(t,e){"use strict";function s(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(e,"__esModule",{value:!0});var h=function(){function t(t,e){for(var s=0;s<e.length;s++){var h=e[s];h.enumerable=h.enumerable||!1,h.configurable=!0,"value"in h&&(h.writable=!0),Object.defineProperty(t,h.key,h)}}return function(e,s,h){return s&&t(e.prototype,s),h&&t(e,h),e}}(),r=function(){function t(){var e=arguments.length<=0||void 0===arguments[0]?"":arguments[0],h=arguments.length<=1||void 0===arguments[1]?0:arguments[1],r=arguments.length<=2||void 0===arguments[2]?"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890":arguments[2];s(this,t);var a=16,n=3.5,i=12,l="error: alphabet must contain at least X unique characters",u="error: alphabet cannot contain spaces",p="",o=void 0,f=void 0;this.escapeRegExp=function(t){return t.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")},this.parseInt=function(t,e){return/^(\-|\+)?([0-9]+|Infinity)$/.test(t)?parseInt(t,e):NaN},this.seps="cfhistuCFHISTU",this.minLength=parseInt(h,10)>0?h:0,this.salt="string"==typeof e?e:"","string"==typeof r&&(this.alphabet=r);for(var g=0;g!==this.alphabet.length;g++)p.indexOf(this.alphabet.charAt(g))===-1&&(p+=this.alphabet.charAt(g));if(this.alphabet=p,this.alphabet.length<a)throw l.replace("X",a);if(this.alphabet.search(" ")!==-1)throw u;for(var c=0;c!==this.seps.length;c++){var b=this.alphabet.indexOf(this.seps.charAt(c));b===-1?this.seps=this.seps.substr(0,c)+" "+this.seps.substr(c+1):this.alphabet=this.alphabet.substr(0,b)+" "+this.alphabet.substr(b+1)}this.alphabet=this.alphabet.replace(/ /g,""),this.seps=this.seps.replace(/ /g,""),this.seps=this._shuffle(this.seps,this.salt),(!this.seps.length||this.alphabet.length/this.seps.length>n)&&(o=Math.ceil(this.alphabet.length/n),o>this.seps.length&&(f=o-this.seps.length,this.seps+=this.alphabet.substr(0,f),this.alphabet=this.alphabet.substr(f))),this.alphabet=this._shuffle(this.alphabet,this.salt);var d=Math.ceil(this.alphabet.length/i);this.alphabet.length<3?(this.guards=this.seps.substr(0,d),this.seps=this.seps.substr(d)):(this.guards=this.alphabet.substr(0,d),this.alphabet=this.alphabet.substr(d))}return h(t,[{key:"encode",value:function(){for(var t=arguments.length,e=Array(t),s=0;s<t;s++)e[s]=arguments[s];var h="";if(!e.length)return h;if(e[0]&&e[0].constructor===Array&&(e=e[0],!e.length))return h;for(var r=0;r!==e.length;r++)if(e[r]=this.parseInt(e[r],10),!(e[r]>=0))return h;return this._encode(e)}},{key:"decode",value:function(t){var e=[];return t&&t.length&&"string"==typeof t?this._decode(t,this.alphabet):e}},{key:"encodeHex",value:function(t){if(t=t.toString(),!/^[0-9a-fA-F]+$/.test(t))return"";for(var e=t.match(/[\w\W]{1,12}/g),s=0;s!==e.length;s++)e[s]=parseInt("1"+e[s],16);return this.encode.apply(this,e)}},{key:"decodeHex",value:function(t){for(var e=[],s=this.decode(t),h=0;h!==s.length;h++)e+=s[h].toString(16).substr(1);return e}},{key:"_encode",value:function(t){for(var e=void 0,s=this.alphabet,h=0,r=0;r!==t.length;r++)h+=t[r]%(r+100);e=s.charAt(h%s.length);for(var a=e,n=0;n!==t.length;n++){var i=t[n],l=a+this.salt+s;s=this._shuffle(s,l.substr(0,s.length));var u=this._toAlphabet(i,s);if(e+=u,n+1<t.length){i%=u.charCodeAt(0)+n;var p=i%this.seps.length;e+=this.seps.charAt(p)}}if(e.length<this.minLength){var o=(h+e[0].charCodeAt(0))%this.guards.length,f=this.guards[o];e=f+e,e.length<this.minLength&&(o=(h+e[2].charCodeAt(0))%this.guards.length,f=this.guards[o],e+=f)}for(var g=parseInt(s.length/2,10);e.length<this.minLength;){s=this._shuffle(s,s),e=s.substr(g)+e+s.substr(0,g);var c=e.length-this.minLength;c>0&&(e=e.substr(c/2,this.minLength))}return e}},{key:"_decode",value:function(t,e){var s=[],h=0,r=new RegExp("["+this.escapeRegExp(this.guards)+"]","g"),a=t.replace(r," "),n=a.split(" ");if(3!==n.length&&2!==n.length||(h=1),a=n[h],"undefined"!=typeof a[0]){var i=a[0];a=a.substr(1),r=new RegExp("["+this.escapeRegExp(this.seps)+"]","g"),a=a.replace(r," "),n=a.split(" ");for(var l=0;l!==n.length;l++){var u=n[l],p=i+this.salt+e;e=this._shuffle(e,p.substr(0,e.length)),s.push(this._fromAlphabet(u,e))}this._encode(s)!==t&&(s=[])}return s}},{key:"_shuffle",value:function(t,e){var s=void 0;if(!e.length)return t;for(var h=t.length-1,r=0,a=0,n=0;h>0;h--,r++){r%=e.length,a+=s=e.charAt(r).charCodeAt(0),n=(s+r+a)%h;var i=t[n];t=t.substr(0,n)+t.charAt(h)+t.substr(n+1),t=t.substr(0,h)+i+t.substr(h+1)}return t}},{key:"_toAlphabet",value:function(t,e){var s="";do s=e.charAt(t%e.length)+s,t=parseInt(t/e.length,10);while(t);return s}},{key:"_fromAlphabet",value:function(t,e){for(var s=0,h=0;h<t.length;h++){var r=e.indexOf(t[h]);s+=r*Math.pow(e.length,t.length-h-1)}return s}}]),t}();e.default=r,t.exports=e.default});
//# sourceMappingURL=dist/hashids.min.map
// LOADING
$(document).ajaxStop(function() {
    $('#loading').hide();
});
// END LOADING

// Berguna untuk loading multiple request
var MyRequestsCompleted = (function() {
    var numRequestToComplete, requestsCompleted, callBacks, singleCallBack;

    return function(options) {
        if (!options) options = {};

        numRequestToComplete = options.numRequest || 0;
        requestsCompleted = options.requestsCompleted || 0;
        callBacks = [];
        var fireCallbacks = function() {
            // alert("we're all complete");
            for (var i = 0; i < callBacks.length; i++) callBacks[i]();
        };
        if (options.singleCallback) callBacks.push(options.singleCallback);

        this.addCallbackToQueue = function(isComplete, callback) {
            if (isComplete) requestsCompleted++;
            if (callback) callBacks.push(callback);
            if (requestsCompleted == numRequestToComplete) fireCallbacks();
        };
        this.requestComplete = function(isComplete) {
            if (isComplete) requestsCompleted++;
            if (requestsCompleted == numRequestToComplete) fireCallbacks();
        };
        this.setCallback = function(callback) {
            callBacks.push(callBack);
        };
    };
})();

// Cek apakan masih login apa ngga ketika request ajax 
$(document).ajaxError(function(event, jqxhr, settings, exception) {

    if (exception == 'Unauthorized') {

        // Prompt user if they'd like to be redirected to the login page
        bootbox.confirm("You're session has expired. Would you like to be redirected to the login page?", function(result) {
            if (result) {
                window.location = '/login';
            }
        });

    }
});

// CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Logout from apllication
$(document).on('click', '#logout_link', function() {
    $.ajax({
        type: 'POST',
        url: 'logout',
        error: function(){
            window.location = '/login';
        }
    });
});

// Go to Accounts page
$(document).on('click', '#accounts_link', function() {
    $.ajax({
        type: 'POST',
        url: 'accounts',
        error: function(){
            window.location = '/accounts';
        }
    });
});

// Waiting when ajax ajaxStart
$('<div id="waiting"></div>').insertBefore('#loading');
$(document).ajaxStart(function () {
    $('#waiting').show();
});
$(document).ajaxStop(function () {
    $('#waiting').hide();
});

// FUNCTION FOR COMPARE TWO ARRAY
// Warn if overriding existing method
if(Array.prototype.equals)
    console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");
// attach the .equals method to Array's prototype to call it on any array
Array.prototype.equals = function (array) {
    // if the other array is a falsy value, return
    if (!array)
        return false;

    // compare lengths - can save a lot of time 
    if (this.length != array.length)
        return false;

    for (var i = 0, l=this.length; i < l; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].equals(array[i]))
                return false;       
        }           
        else if (this[i] != array[i]) { 
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;   
        }           
    }       
    return true;
}
// Hide method from for-in loops
Object.defineProperty(Array.prototype, "equals", {enumerable: false});
// END FUNCTION FOR COMPARE TWO ARRAY

// fix helper for jQuery UI sortable
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}
// end fix helper for jQuery UI sortable

// Hashids
var hashids = new Hashids('LOps/e3mRwOl4Hw9hGW9CmAQBZa8wOzkaFw7zws5EeI=g', 7, 'abcdefghijklmnopqrstuvwxyz');

// get current user data
currentUser();
function currentUser(){
    $.ajax({
        url: 'current-user',
        type: 'GET',
        success: function(data) {
            $('.user-name').text(data.name);
        },
    });  
}

// converter
function hexToString(hex) {
    var hex = hex.toString();//force conversion
    var str = '';
    for (var i = 0; i < hex.length; i += 2)
        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}

function stringToHex(str) {
    var hex = '';
    for(var i=0;i<str.length;i++) {
        hex += ''+str.charCodeAt(i).toString(16);
    }
    return hex;
}

function convertToNumber(str){
  var number = "";
  for (var i=0; i<str.length; i++){
    charCode = ('000' + str[i].charCodeAt(0)).substr(-3);
    number += charCode;
  }
  return number;
}
// console.log(convertToNumber("HOLD1NA6"));
function convertToString(numbers){
  origString = "";
  numbers = numbers.match(/.{3}/g);
  for(var i=0; i < numbers.length; i++){
    origString += String.fromCharCode(numbers[i]);
  }
  return origString;
}
// console.log(convertToString("072079076068049078065054"));

// get scrollbar width
function getScrollBarWidth() {
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);

    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;

    if (w1 == w2) {
        w2 = outer.clientWidth;
    }

    document.body.removeChild(outer);

    return (w1 - w2);
}

// prevent navbar fixed top to right when modal open
var scrollw = getScrollBarWidth();
$(document).on("shown.bs.modal", function (event) {
    $('.modal-open .navbar-fixed-top').css({paddingRight: scrollw+'px'});
    $('.modal-open .navbar-fixed-bottom').css({paddingRight: scrollw+'px'});
});

$(document).on("hide.bs.modal", function (event) {
    $('.modal-open .navbar-fixed-top').removeAttr('style');
    $('.modal-open .navbar-fixed-bottom').removeAttr('style');
});
Handlebars.registerPartial("ontent", Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"container2\">\n  <div class=\"page-header\">\n    <h2>TOOLS <small>IMPORT & EXPORT</small></h2>\n  </div>\n\n  <ul class=\"nav nav-tabs\" id=\"toolsTab\">\n    <li class=\"active\"><a href=\"#import\">IMPORT</a></li>\n    <li><a href=\"#export\" id=\"#\">EXPORT</a></li>\n  </ul>\n\n  <div class=\"tab-content\">\n    <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"import\">\n      <div class=\"col-xs-6\">\n        \n        <form action=\"tools/upload\" class=\"form-horizontal\" method=\"post\" enctype=\"multipart/form-data\">\n          <div class=\"form-group\">\n            <div class=\"col-sm-8\">\n              <input type=\"file\" class=\"filestyle\" data-buttonBefore=\"true\" name=\"document\" data-icon=\"false\" data-buttonText=\"SELECT SPREADSHEET FILE\" data-buttonName=\"btn-primary\" data-size=\"sm\" id=\"file_upload\">\n            </div>\n            <div class=\"col-sm-4\" id=\"save-btn-area\"></div>\n          </div>\n        </form>\n\n      </div>\n\n      <div class=\"col-xs-6\">\n        <span class=\"text-danger\"><b>DEFAULT</b> PO TEXT STYLE NOT DEFINED,<br/> PLEASE CONTACT YOUR ADMINISTRATOR</span>\n      </div>\n\n      <div class=\"col-xs-12\">\n        <span id=\"status\" style=\"text-transform: uppercase;\"></span>\n        <span id=\"display_uploaded_table\"></span>\n      </div>\n    </div>\n\n    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"export\">      \n      <div class=\"col-xs-3\">\n        <select id=\"#\" class=\"form-control\">\n          <option value=\"\" selected disabled>Select a table before EXPORT</option>\n          <option value=\"1\">Item 1</option>\n          <option value=\"2\">Item 2</option>\n        </select>\n      </div>\n    </div>    \n  </div>\n</div>";
},"useData":true}));
this["Tools"] = this["Tools"] || {};
this["Tools"]["templates"] = this["Tools"]["templates"] || {};
this["Tools"]["templates"]["content"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"container2\">\n  <div class=\"page-header\">\n    <h2>TOOLS <small>IMPORT & EXPORT</small></h2>\n  </div>\n\n  <ul class=\"nav nav-tabs\" id=\"toolsTab\">\n    <li class=\"active\"><a href=\"#import\">IMPORT</a></li>\n    <li><a href=\"#export\" id=\"#\">EXPORT</a></li>\n  </ul>\n\n  <div class=\"tab-content\">\n    <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"import\">\n      <div class=\"col-xs-6\">\n        \n        <form action=\"tools/upload\" class=\"form-horizontal\" method=\"post\" enctype=\"multipart/form-data\">\n          <div class=\"form-group\">\n            <div class=\"col-sm-8\">\n              <input type=\"file\" class=\"filestyle\" data-buttonBefore=\"true\" name=\"document\" data-icon=\"false\" data-buttonText=\"SELECT SPREADSHEET FILE\" data-buttonName=\"btn-primary\" data-size=\"sm\" id=\"file_upload\">\n            </div>\n            <div class=\"col-sm-4\" id=\"save-btn-area\"></div>\n          </div>\n        </form>\n\n      </div>\n\n      <div class=\"col-xs-6\">\n        <span class=\"text-danger\"><b>DEFAULT</b> PO TEXT STYLE NOT DEFINED,<br/> PLEASE CONTACT YOUR ADMINISTRATOR</span>\n      </div>\n\n      <div class=\"col-xs-12\">\n        <span id=\"status\" style=\"text-transform: uppercase;\"></span>\n        <span id=\"display_uploaded_table\"></span>\n      </div>\n    </div>\n\n    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"export\">      \n      <div class=\"col-xs-3\">\n        <select id=\"#\" class=\"form-control\">\n          <option value=\"\" selected disabled>Select a table before EXPORT</option>\n          <option value=\"1\">Item 1</option>\n          <option value=\"2\">Item 2</option>\n        </select>\n      </div>\n    </div>    \n  </div>\n</div>";
},"useData":true});
Handlebars.registerPartial("avbar", Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<nav class=\"navbar navbar-default navbar-fixed-top\">\n    <div class=\"container-fluid\">\n        <div class=\"navbar-header\">\n            <a class=\"navbar-brand\" href=\"/\"><strong>CATALOG Web App</strong></a>\n        </div>\n        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">\n            <ul class=\"nav navbar-nav\">\n                <li class=\"dropdown\">\n                    <a href=\"/dictionary\">DICTIONARY</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/settings\">SETTINGS</a>\n                </li>\n                <li class=\"dropdown active\">\n                    <a href=\"/tools\">TOOLS</a>\n                </li>\n            </ul>\n            <ul class=\"nav navbar-nav navbar-right\">\n                <input type=\"hidden\" value=\"5\" id=\"logged_in_user\">\n                <li class=\"dropdown\">\n                    <a class=\"user-name pointer uppercase dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\"> <span class=\"caret\"></span></a>\n                    <ul class=\"dropdown-menu\" role=\"menu\">\n                        <li><a class=\"uppercase pointer\" id=\"profile_link\">Profile</a></li>\n                        <li><a class=\"uppercase pointer\" id=\"accounts_link\">Accounts</a></li>\n                        <li><a class=\"uppercase pointer\" id=\"logout_link\">Logout</a></li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n    </div>\n</nav>";
},"useData":true}));
this["Tools"]["templates"]["navbar"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<nav class=\"navbar navbar-default navbar-fixed-top\">\n    <div class=\"container-fluid\">\n        <div class=\"navbar-header\">\n            <a class=\"navbar-brand\" href=\"/\"><strong>CATALOG Web App</strong></a>\n        </div>\n        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">\n            <ul class=\"nav navbar-nav\">\n                <li class=\"dropdown\">\n                    <a href=\"/dictionary\">DICTIONARY</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/settings\">SETTINGS</a>\n                </li>\n                <li class=\"dropdown active\">\n                    <a href=\"/tools\">TOOLS</a>\n                </li>\n            </ul>\n            <ul class=\"nav navbar-nav navbar-right\">\n                <input type=\"hidden\" value=\"5\" id=\"logged_in_user\">\n                <li class=\"dropdown\">\n                    <a class=\"user-name pointer uppercase dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\"> <span class=\"caret\"></span></a>\n                    <ul class=\"dropdown-menu\" role=\"menu\">\n                        <li><a class=\"uppercase pointer\" id=\"profile_link\">Profile</a></li>\n                        <li><a class=\"uppercase pointer\" id=\"accounts_link\">Accounts</a></li>\n                        <li><a class=\"uppercase pointer\" id=\"logout_link\">Logout</a></li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n    </div>\n</nav>";
},"useData":true});
jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Tools.templates.navbar());
    $('#content').html(Tools.templates.content());
    // END HANDLEBARS TEMPLATE

    // toolsTab
    $("#toolsTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    // End toolsTab

    var bar = $('.progress-bar');
	var percent = $('.percent');
	var status = $('#status');	
	var uploaded_file = '';
	$('form').ajaxForm({
	    beforeSend: function() {
	    	window.onbeforeunload = function() {return '';}
	        status.empty();
	        $("#save-btn-area").empty();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	        $("#display_uploaded_table").html("");
	        $('#status').html('<span class="text-success">UPLOADING SPREADSHEET... <div class="mini-spinner"></div></span>');
	    	$('input#file_upload').attr('disabled', 'disabled');
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	    },
	    success: function(xhr) {
	        var percentVal = '100%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	        var dest = $('#select_table').val();
	        $('#status').html('<span class="text-success">SPREADSHEET UPLOADED &#x2714;<br/>READING AND VALIDATING YOUR DATA... <div class="mini-spinner"></div></span>');
	        $.ajax({
			    type: 'GET',
			    url: 'tools/read-source/'+xhr.file,
			    success: function(data){
			    	$('#status').html('');     	
		        	$("#display_uploaded_table").html(data);
		        	$(".import_to_db").appendTo("#save-btn-area");
		        	$('input#file_upload').removeAttr('disabled');

		        	$('#datatables').dataTable( {
						dom: "<'row'<'col-sm-6'><'col-sm-6'f>>" +
								"Z<'row'<'col-sm-12'tr>>" +
								"<'row'<'col-sm-5'i><'col-sm-7'p>>",
						oLanguage: {
			                sInfo: "_START_ TO _END_ OF _TOTAL_ ROWS",
			                oPaginate: {
			                    sFirst: "FIRST",
			                    sLast: "LAST",
			                    sNext: "NEXT",
			                    sPrevious: "PREVIOUS"
			                },
			                sSearch: "",
			                sSearchPlaceholder: "SEARCH...",
			            },
					});

		        	$("#message").appendTo("div#datatables_wrapper div.row div.col-sm-6:eq(0)");
		        	$("#data_counter").appendTo("#counter");

		        	uploaded_file = xhr.file;
		        	window.onbeforeunload = function() {}
			    },
			    error: function(xhr){
			    	var errors = xhr.responseJSON;
			    	$('#status').html('<span class="text-danger">ERROR</span>');
			    	$('input#file_upload').removeAttr('disabled');
			    	window.onbeforeunload = function() {}
			    }
			});
	        // $('#div.progress').remove();
	    },
		complete: function(xhr) {},
		error: function(xhr) {
			var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);

	        var errors = xhr.responseJSON;
			$('#status').html('<span class="text-danger">ERROR</span>');
			$("#display_uploaded_table").html("");
			$('input#file_upload').removeAttr('disabled');
			window.onbeforeunload = function() {}
		}
	});

	$('#file_upload').change(function() {
	  $('form').submit();
	});

	$('#file_upload').click(function() {
	    this.value = null;
	});

	// IMPORT to DATABASE
	var uploaded_file = uploaded_file;
	$(document).on('click', '.import_to_db', function() {

		if($(this).hasClass('import_inc')){
			var url = 'tools/import-inc/'+uploaded_file;
			var data_name = 'INC';
			var action = true;
		}else if($(this).hasClass('import_char')){
			var url = 'tools/import-char/'+uploaded_file;
			var data_name = 'CHARACTERISTIC';
			var action = true;
		}else if($(this).hasClass('import_inc_char')){
			var url = 'tools/import-inc-char/'+uploaded_file;
			var data_name = 'INC CHARACTERISTIC';
			var action = true;
		}else if($(this).hasClass('import_group')){
			var url = 'tools/import-group/'+uploaded_file;
			var data_name = 'GROUP';
			var action = true;
		}else if($(this).hasClass('import_group_class')){
			var url = 'tools/import-group-class/'+uploaded_file;
			var data_name = 'GROUP CLASS';
			var action = true;
		}else if($(this).hasClass('import_inc_group_class')){
			var url = 'tools/import-inc-group-class/'+uploaded_file;
			var data_name = 'INC GROUP CLASS';
			var action = true;
		}else if($(this).hasClass('import_inc_char_value')){
			var url = 'tools/import-inc-char-value/'+uploaded_file;
			var data_name = 'INC CHARACTERISTIC VALUE';
			var action = true;
		}else if($(this).hasClass('import_manufacturer_code')){
			var url = 'tools/import-manufacturer-code/'+uploaded_file;
			var data_name = 'MANUFACTURER CODE';
			var action = true;
		}else if($(this).hasClass('import_source_type')){
			var url = 'tools/import-source-type/'+uploaded_file;
			var data_name = 'SOURCE TYPE';
			var action = true;
		}else if($(this).hasClass('import_part_man_code_type')){
			var url = 'tools/import-part-man-code-type/'+uploaded_file;
			var data_name = 'PART MANUFACTURER CODE TYPE';
			var action = true;
		}else if($(this).hasClass('import_eq_code')){
			var url = 'tools/import-eq-code/'+uploaded_file;
			var data_name = 'EQUIPMENT CODE';
			var action = true;
		}else if($(this).hasClass('import_part_master')){
			var url = 'tools/import-part-master/'+uploaded_file;
			var data_name = 'PART MASTER';
			var action = true;
		}else if($(this).hasClass('import_part_man_code')){
			var url = 'tools/import-part-man-code/'+uploaded_file;
			var data_name = 'PART MANUFACTURER CODE';
			var action = true;
		}else if($(this).hasClass('import_part_eq_code')){
			var url = 'tools/import-part-eq-code/'+uploaded_file;
			var data_name = 'PART EQUIPMENT CODE';
			var action = true;
		}else if($(this).hasClass('import_holding')){
			var url = 'tools/import-holding/'+uploaded_file;
			var data_name = 'HOLDING';
			var action = true;
		}else if($(this).hasClass('import_company')){
			var url = 'tools/import-company/'+uploaded_file;
			var data_name = 'COMPANY';
			var action = true;
		}else if($(this).hasClass('import_plant')){
			var url = 'tools/import-plant/'+uploaded_file;
			var data_name = 'PLANT';
			var action = true;
		}else if($(this).hasClass('import_location')){
			var url = 'tools/import-location/'+uploaded_file;
			var data_name = 'LOCATION';
			var action = true;
		}else if($(this).hasClass('import_shelf')){
			var url = 'tools/import-shelf/'+uploaded_file;
			var data_name = 'SHELF';
			var action = true;
		}else if($(this).hasClass('import_bin')){
			var url = 'tools/import-bin/'+uploaded_file;
			var data_name = 'BIN';
			var action = true;
		}else if($(this).hasClass('import_user_class')){
			var url = 'tools/import-user-class/'+uploaded_file;
			var data_name = 'USER CLASS';
			var action = true;
		}else if($(this).hasClass('import_item_type')){
			var url = 'tools/import-item-type/'+uploaded_file;
			var data_name = 'ITEM TYPE';
			var action = true;
		}else if($(this).hasClass('import_harmonized_code')){
			var url = 'tools/import-harmonized-code/'+uploaded_file;
			var data_name = 'HARMONIZED CODE';
			var action = true;
		}else if($(this).hasClass('import_hazard_class')){
			var url = 'tools/import-hazard-class/'+uploaded_file;
			var data_name = 'HAZARD CLASS';
			var action = true;
		}else if($(this).hasClass('import_weight_unit')){
			var url = 'tools/import-weight-unit/'+uploaded_file;
			var data_name = 'WEIGHT UNIT';
			var action = true;
		}else if($(this).hasClass('import_bin')){
			var url = 'tools/import-bin/'+uploaded_file;
			var data_name = 'BIN';
			var action = true;
		}else if($(this).hasClass('import_stock_type')){
			var url = 'tools/import-stock-type/'+uploaded_file;
			var data_name = 'STOCK TYPE';
			var action = true;
		}else if($(this).hasClass('import_unit_of_measurement')){
			var url = 'tools/import-unit-of-measurement/'+uploaded_file;
			var data_name = 'UNIT OF MEASUREMENT';
			var action = true;
		}else{
			var action = false;
		}

		if(action == true){

			$.ajax({
			    type: 'GET',
			    url: url,
			    beforeSend: function(){
			    	window.onbeforeunload = function() {return '';}
			    	$('input#file_upload').attr('disabled', 'disabled');
			    	$('.import_inc').attr('disabled', 'disabled');
			    	$("#message").html("IMPORTING YOUR <strong>"+data_name+"</strong> DATA... <div class='mini-spinner'></div>");
			    },
			    success: function(data){
			    	window.onbeforeunload = function() {}
			    	$('#status').empty();    	
			    	$("span.group-span-filestyle.input-group-btn > label > span").text('SELECT SPREADSHEET AGAIN');
			    	$('input#file_upload').removeAttr('disabled');
		        	$("#save-btn-area").empty();
		        	$("#display_uploaded_table").empty();
		        	file_name = $("div.bootstrap-filestyle.input-group input").val();
		        	$("#status").html("<span class='text-success'><strong>"+data+" OF "+data_name+"</strong> DATA HAS BEEN IMPORTED SUCCESSFULLY<br/>UPLOADED FILE NAME: <b>"+file_name+"</b></span>");
			    	$("div.bootstrap-filestyle.input-group input").val('');
			    },
			    error: function(){
			    	window.onbeforeunload = function() {}
			    	$("span.group-span-filestyle.input-group-btn > label > span").text('SELECT SPREADSHEET AGAIN');
			    	$('input#file_upload').removeAttr('disabled');
			    	$('.import_inc').removeAttr('disabled');
		        	$("#message").html("<strong style='color:red;'>ERROR</strong> IMPORTING YOUR <strong>"+data_name+"</strong> DATA");
			    }
			});

		}
		
	});
});

function upload_pmc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-pmc',
	    data: $('.part_master_id').serialize()+'&'+$('.tbl_manufacturer_code_id').serialize()+'&'+$('.tbl_source_type_id').serialize()+'&'+$('.manufacturer_ref').serialize()+'&'+$('.tbl_part_manufacturer_code_type_id').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Part Manufacturer Code</u> data has been saved successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('UPLOAD AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_pec() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-pec',
	    data: $('.part_master_id').serialize()+'&'+$('.tbl_equipment_code_id').serialize()+'&'+$('.qty_install').serialize()+'&'+$('.tbl_manufacturer_code_id').serialize()+'&'+$('.doc_ref').serialize()+'&'+$('.dwg_ref').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Part Equipment Code</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_tgc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-tgc',
	    data: $('.tbl_group_id').serialize()+'&'+$('.class').serialize()+'&'+$('.name').serialize()+'&'+$('.eng_definition').serialize()+'&'+$('.ind_definition').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Group Class</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_igc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-igc',
	    data: $('.tbl_inc_id').serialize()+'&'+$('.tbl_group_class_id').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC Group Class</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_ic() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-ic',
	    data: $('.tbl_inc_id').serialize()+'&'+$('.tbl_characteristic_id').serialize()+'&'+$('.sequence').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC CHARACTERISTIC</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_icv() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-icv',
	    data: $('.link_inc_characteristic_id').serialize()+'&'+$('.value').serialize()+'&'+$('.abbrev').serialize()+'&'+$('.approved').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC CHARACTERISTIC VALUE</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_m() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-m',
	    data: $('.catalog_no').serialize()+'&'+$('.tbl_holding_id').serialize()+'&'+$('.holding_no').serialize()+'&'+$('.reference_no').serialize()+'&'+$('.link_inc_group_class_id').serialize()+'&'+$('.catalog_type').serialize()+'&'+$('.unit_issue').serialize()+'&'+$('.unit_purchase').serialize()+'&'+$('.tbl_catalog_status_id').serialize()+'&'+$('.conversion').serialize()+'&'+$('.tbl_user_class_id').serialize()+'&'+$('.tbl_item_type_id').serialize()+'&'+$('.tbl_harmonized_code_id').serialize()+'&'+$('.tbl_hazard_class_id').serialize()+'&'+$('.weight_value').serialize()+'&'+$('.tbl_weight_unit_id').serialize()+'&'+$('.tbl_stock_type_id').serialize()+'&'+$('.average_unit_price').serialize()+'&'+$('.memo').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>MASTER</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
				err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};
(function($){var nextId=0;var Filestyle=function(element,options){this.options=options;this.$elementFilestyle=[];this.$element=$(element)};Filestyle.prototype={clear:function(){this.$element.val("");this.$elementFilestyle.find(":text").val("");this.$elementFilestyle.find(".badge").remove()},destroy:function(){this.$element.removeAttr("style").removeData("filestyle");this.$elementFilestyle.remove()},disabled:function(value){if(value===true){if(!this.options.disabled){this.$element.attr("disabled","true");this.$elementFilestyle.find("label").attr("disabled","true");this.options.disabled=true}}else{if(value===false){if(this.options.disabled){this.$element.removeAttr("disabled");this.$elementFilestyle.find("label").removeAttr("disabled");this.options.disabled=false}}else{return this.options.disabled}}},buttonBefore:function(value){if(value===true){if(!this.options.buttonBefore){this.options.buttonBefore=true;if(this.options.input){this.$elementFilestyle.remove();this.constructor();this.pushNameFiles()}}}else{if(value===false){if(this.options.buttonBefore){this.options.buttonBefore=false;if(this.options.input){this.$elementFilestyle.remove();this.constructor();this.pushNameFiles()}}}else{return this.options.buttonBefore}}},icon:function(value){if(value===true){if(!this.options.icon){this.options.icon=true;this.$elementFilestyle.find("label").prepend(this.htmlIcon())}}else{if(value===false){if(this.options.icon){this.options.icon=false;this.$elementFilestyle.find(".icon-span-filestyle").remove()}}else{return this.options.icon}}},input:function(value){if(value===true){if(!this.options.input){this.options.input=true;if(this.options.buttonBefore){this.$elementFilestyle.append(this.htmlInput())}else{this.$elementFilestyle.prepend(this.htmlInput())}this.$elementFilestyle.find(".badge").remove();this.pushNameFiles();this.$elementFilestyle.find(".group-span-filestyle").addClass("input-group-btn")}}else{if(value===false){if(this.options.input){this.options.input=false;this.$elementFilestyle.find(":text").remove();var files=this.pushNameFiles();if(files.length>0&&this.options.badge){this.$elementFilestyle.find("label").append(' <span class="badge">'+files.length+"</span>")}this.$elementFilestyle.find(".group-span-filestyle").removeClass("input-group-btn")}}else{return this.options.input}}},size:function(value){if(value!==undefined){var btn=this.$elementFilestyle.find("label"),input=this.$elementFilestyle.find("input");btn.removeClass("btn-lg btn-sm");input.removeClass("input-lg input-sm");if(value!="nr"){btn.addClass("btn-"+value);input.addClass("input-"+value)}}else{return this.options.size}},placeholder:function(value){if(value!==undefined){this.options.placeholder=value;this.$elementFilestyle.find("input").attr("placeholder",value)}else{return this.options.placeholder}},buttonText:function(value){if(value!==undefined){this.options.buttonText=value;this.$elementFilestyle.find("label .buttonText").html(this.options.buttonText)}else{return this.options.buttonText}},buttonName:function(value){if(value!==undefined){this.options.buttonName=value;this.$elementFilestyle.find("label").attr({"class":"btn "+this.options.buttonName})}else{return this.options.buttonName}},iconName:function(value){if(value!==undefined){this.$elementFilestyle.find(".icon-span-filestyle").attr({"class":"icon-span-filestyle "+this.options.iconName})}else{return this.options.iconName}},htmlIcon:function(){if(this.options.icon){return'<span class="icon-span-filestyle '+this.options.iconName+'"></span> '}else{return""}},htmlInput:function(){if(this.options.input){return'<input type="text" class="form-control '+(this.options.size=="nr"?"":"input-"+this.options.size)+'" placeholder="'+this.options.placeholder+'" disabled> '}else{return""}},pushNameFiles:function(){var content="",files=[];if(this.$element[0].files===undefined){files[0]={name:this.$element[0]&&this.$element[0].value}}else{files=this.$element[0].files}for(var i=0;i<files.length;i++){content+=files[i].name.split("\\").pop()+", "}if(content!==""){this.$elementFilestyle.find(":text").val(content.replace(/\, $/g,""))}else{this.$elementFilestyle.find(":text").val("")}return files},constructor:function(){var _self=this,html="",id=_self.$element.attr("id"),files=[],btn="",$label;if(id===""||!id){id="filestyle-"+nextId;_self.$element.attr({id:id});nextId++}btn='<span class="group-span-filestyle '+(_self.options.input?"input-group-btn":"")+'"><label for="'+id+'" class="btn '+_self.options.buttonName+" "+(_self.options.size=="nr"?"":"btn-"+_self.options.size)+'" '+(_self.options.disabled?'disabled="true"':"")+">"+_self.htmlIcon()+'<span class="buttonText">'+_self.options.buttonText+"</span></label></span>";html=_self.options.buttonBefore?btn+_self.htmlInput():_self.htmlInput()+btn;_self.$elementFilestyle=$('<div class="bootstrap-filestyle input-group">'+html+"</div>");_self.$elementFilestyle.find(".group-span-filestyle").attr("tabindex","0").keypress(function(e){if(e.keyCode===13||e.charCode===32){_self.$elementFilestyle.find("label").click();return false}});_self.$element.css({position:"absolute",clip:"rect(0px 0px 0px 0px)"}).attr("tabindex","-1").after(_self.$elementFilestyle);if(_self.options.disabled){_self.$element.attr("disabled","true")}_self.$element.change(function(){var files=_self.pushNameFiles();if(_self.options.input==false&&_self.options.badge){if(_self.$elementFilestyle.find(".badge").length==0){_self.$elementFilestyle.find("label").append(' <span class="badge">'+files.length+"</span>")}else{if(files.length==0){_self.$elementFilestyle.find(".badge").remove()}else{_self.$elementFilestyle.find(".badge").html(files.length)}}}else{_self.$elementFilestyle.find(".badge").remove()}});if(window.navigator.userAgent.search(/firefox/i)>-1){_self.$elementFilestyle.find("label").click(function(){_self.$element.click();return false})}}};var old=$.fn.filestyle;$.fn.filestyle=function(option,value){var get="",element=this.each(function(){if($(this).attr("type")==="file"){var $this=$(this),data=$this.data("filestyle"),options=$.extend({},$.fn.filestyle.defaults,option,typeof option==="object"&&option);if(!data){$this.data("filestyle",(data=new Filestyle(this,options)));data.constructor()}if(typeof option==="string"){get=data[option](value)}}});if(typeof get!==undefined){return get}else{return element}};$.fn.filestyle.defaults={buttonText:"Choose file",iconName:"glyphicon glyphicon-folder-open",buttonName:"btn-default",size:"nr",input:true,badge:true,icon:true,buttonBefore:false,disabled:false,placeholder:""};$.fn.filestyle.noConflict=function(){$.fn.filestyle=old;return this};$(function(){$(".filestyle").each(function(){var $this=$(this),options={input:$this.attr("data-input")==="false"?false:true,icon:$this.attr("data-icon")==="false"?false:true,buttonBefore:$this.attr("data-buttonBefore")==="true"?true:false,disabled:$this.attr("data-disabled")==="true"?true:false,size:$this.attr("data-size"),buttonText:$this.attr("data-buttonText"),buttonName:$this.attr("data-buttonName"),iconName:$this.attr("data-iconName"),badge:$this.attr("data-badge")==="false"?false:true,placeholder:$this.attr("data-placeholder")};$this.filestyle(options)})})})(window.jQuery);
// $(document).ajaxComplete(function(){
// 	if(typeof cat_status_raw_update === 'undefined'){
// 		$('.cat_status_raw_update').remove();
// 	}

// 	if(typeof cat_status_cat_update === 'undefined'){
// 		$('.cat_status_cat_update').remove();
// 	}

// 	if(typeof cat_status_qa_update === 'undefined'){
// 		$('.cat_status_qa_update').remove();
// 	}

// 	if(typeof cat_status_locked_update === 'undefined'){
// 		$('.cat_status_locked_update').remove();
// 	}
// });