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

// disable datatables error prompt
$.fn.dataTable.ext.errMode = 'none';

// CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Logout from apllication
$(document).on('click', '#logoutapp', function() {
    $.ajax({
        type: 'POST',
        url: 'logout',
        error: function(){
            window.location = '/login';
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