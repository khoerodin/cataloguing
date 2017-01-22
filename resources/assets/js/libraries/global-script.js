// (function () {
//     var method;
//     var noop = function noop() { };
//     var methods = [
//     'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
//     'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
//     'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
//     'timeStamp', 'trace', 'warn'
//     ];
//     var length = methods.length;
//     var console = (window.console = window.console || {});

//     while (length--) {
//         method = methods[length];
//         console[method] = noop;
//     }
// }());

// window.console.log = function(){
//   console.error('Sorry , developers tools are blocked here....');
//   window.console.log = function() {
//       return false;
//   }
// }

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