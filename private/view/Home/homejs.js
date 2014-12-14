$(document).ready(function(){
    if (page == "messages") {
        messages();
    } else {
        home();
    }

});

function home() {
    checkOnClickHome();
    mapActions();
    getPosts("friends");
}
function messages() {
    checkOnClickMessages();
}
function mapActions() {
    $("#leftlocation").html("<a href='#'><div id='leftgetlocation'>Use My Location</div></a><div id='leftmap'></div>");
    loadLeftMap();
}
/* ---------------------------- MAP FUNCTIONS ----------------------------- */
var lat;
var lng;
var myLat;
var myLng;
var leftMap;
var addMap;
var addMapCircle;

function loadLeftMap() {
    var mapOptions = {
        center: new google.maps.LatLng(40.0,-96.0,2),
        zoom: 2
    };
    $("#leftmap").css("height","200px");
    leftMap = new google.maps.Map(document.getElementById('leftmap'),mapOptions);
    $("#leftgetlocation").click(function(){
        if (navigator.geolocation) {
            $("#leftgetlocation").html("Loading...");
            navigator.geolocation.getCurrentPosition(function(position) {
                myLat = position.coords.latitude;
                myLng = position.coords.longitude;
                lat = position.coords.latitude;
                lng = position.coords.longitude;
                var pos = new google.maps.LatLng(lat,lng);
                leftMap.setCenter(pos);
                leftMap.setZoom(10);
                $("#leftgetlocation").html("Use My Location");
                updateFeedByLocation();
            },function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        $("#leftmap").html("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        $("#leftmap").html("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        $("#leftmap").html("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        $("#leftmap").html("An unknown error occurred.");
                        break;
                }
                $("#leftgetlocation").html("Use My Location");
            }
            );
        } else {
            alert("Geolocation not available");
        }
    });
}

function loadAddMap() {
    var mapOptions;
    var circleOptions;
    var marker;
    if (lat==null || lng==null) {
        mapOptions = {
            center: new google.maps.LatLng(40.0,-96.0),
            zoom: 3
        };
    } else {
        mapOptions = {
            center: new google.maps.LatLng(lat,lng),
            zoom: 10
        };
    }
    $("#addmap").css("height","300px");
    if (addMap == null) {
        addMap = new google.maps.Map(document.getElementById('addmap'),mapOptions);
    }
    if (lat==null || lng==null) {
        markerOptions = {
            map: addMap,
            position: new google.maps.LatLng(40.0,-90.0),
            draggable: true,
            title: 'Drag'
        };
        circleOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: addMap,
            radius: 1000000
        };
        $("#newRadius").val(9);
        $("#newRadiusDisplay").val("1000000");
    } else {
        markerOptions = {
            map: addMap,
            position: new google.maps.LatLng(lat,lng),
            draggable: true,
            title: 'Drag'
        };
        circleOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: addMap,
            radius: 20000
        };
        $("#newRadius").val(4);
        $("#newRadiusDisplay").val("10000");
    }
    if (addMapCircle == undefined) {
        addMapCircle = new google.maps.Circle(circleOptions);
        marker = new google.maps.Marker(markerOptions);
        addMapCircle.bindTo('center',marker,'position');
    }
    google.maps.event.addListener(marker, 'dragend', function() {
        var markPos = marker.getPosition();
        lat = markPos.lat();
        lng = markPos.lng();
    });
    $("#addgetlocation").click(function(){
        if (navigator.geolocation) {
            $("#addgetlocation").html("Loading...");
            $("#newRadius").val(4);
            $("#newRadiusDisplay").val("10000");
            navigator.geolocation.getCurrentPosition(function(position) {
                myLat = position.coords.latitude;
                myLng = position.coords.longitude;
                lat = position.coords.latitude;
                lng = position.coords.longitude;
                var pos = new google.maps.LatLng(lat,lng);
                addMap.setCenter(pos);
                addMap.setZoom(10);
                leftMap.setCenter(pos);
                leftMap.setZoom(10);
                newCircleOptions = {
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: addMap,
                    radius: getAndValidateRadius()
                };
                newMarkerOptions = {
                    map: addMap,
                    position: new google.maps.LatLng(lat,lng),
                    draggable: true,
                    title: 'Drag'
                };
                addMapCircle.setOptions(newCircleOptions);
                marker.setOptions(newMarkerOptions);
                $("#addgetlocation").html("Use My Location");
                updateFeedByLocation();
            },function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        $("#addmap").html("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        $("#addmap").html("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        $("#addmap").html("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        $("#addmap").html("An unknown error occurred.");
                        break;
                }
                $("#addgetlocation").html("Use My Location");
            }
            );
        } else {
            alert("Geolocation not available");
        }
    });
}

function addLocation() {
    if (navigator.geolocation) {
        if ($("#locationinfo").css('display')=='none') {
            $("#locationinfo").css('display','block');
            $("#newInputTextTop").val($("#newInputText").val());
            $("#expireTimeTop").val($("#expireTime").val());
            $("#postToTop").val($("#postTo").val());
            $("#newRadiusDisplay").val(getAndValidateRadius());
            loadAddMap();
        } else {
            $("#locationinfo").css('display','none');
        }
    } else {
        alert("Geolocation not supported by this browser.");
    }
    return false;
}

function getCircleRadius() {
    var sliderNumber;
    sliderNumber = +$("#newRadius").val();
    switch(sliderNumber) {
        case 0:
            return "Only Me"
        case 1:
            return 10;
        case 2:
            return 100;
        case 3:
            return 5000;
        case 4:
            return 10000;
        case 5:
            return 50000;
        case 6:
            return 100000;
        case 7:
            return 200000;
        case 8:
            return 500000;
        case 9:
            return 1000000;
        case 10:
            return 2000000;
        case 11:
            return 3000000;
        case 12:
            return 4000000;
        case 13:
            return "World";
    }
}
function getAndValidateRadius() {
    //used for custom radius values entered into input box
    var rad = $("#newRadiusDisplay").val();
    if (rad == "Only Me") {
        return 0;
    } else if (rad == "World") {
        return 100000000;
    }
    rad = +rad;
    if (!(rad >= 1 && rad <= 4000000)) {
        if (rad < 1) {
            rad = 1;
        } else {
            rad = 4000000;
        }
    }
    return rad;
}

function updateFeedByLocation() {
    if (escapeHtml($("#morefeedtype").val()) == "friends") {
        getPosts(escapeHtml($("#morefeedtype").val()),escapeHtml($("#currentnumberofposts").val()));
    }
}
/* ---------------------------- DATABASE / HELPER FUNCTIONS --------------------------------- */
function morePosts() {
    getPosts(escapeHtml($("#morefeedtype").val()),escapeHtml($("#currentnumberofposts").val()),true,false);
}
function newPost(obj) {
    var text;
    var expireTime;
    var postTo;
    var radius;
    text = obj["newinputtext"].value;
    expireTime = obj["expireTime"].value;
    postTo = obj["postTo"].value;
    radius = getAndValidateRadius();
    if (text.length > 0) {
        if (expireTime == "Never" || expireTime == "5 Minutes" || expireTime == "2 Hours" || expireTime == "1 Day" || expireTime == "30 Days" || expireTime == "1 Year") {
            if (postTo == "Friends" || postTo == "Near Me" || postTo == "World") {
                $.post(
                    "../private/model/javascript/posts.php",
                    {
                        text:text,
                        expiretime:expireTime,
                        postto:postTo,
                        id:id,
                        lat:lat,
                        lng:lng,
                        radius:radius,
                        job:"newpost"
                    },
                    function(response) {
                    }
                );
            } else {
                alert("Invalid visibility");
            }
        } else {
            alert("Invalid expire time");
        }
    } else {
        alert("Please enter a post");
    }
    $(".posts").prepend("Loading...");
    getPosts(escapeHtml($("#morefeedtype").val()),escapeHtml($("#currentnumberofposts").val()));
    $("#newinputall").removeClass("newinputall");
    $("#newinputall").addClass("newinputallnone");
    $("#locationinfo").css('display','none');
    $("#newInputText").val("");
    $("#newInputTextTop").val("");
    return false;
}

function removePost(obj) {
    var postId;
    var postersId;
    var collection;
    postId = obj["postid"].value;
    postersId = obj["postersid"].value;
    collection = obj["collection"].value;
    $.post(
        "../private/model/javascript/posts.php",
        {
            id:id,
            postid:postId,
            postersid:postersId,
            collection:collection,
            job:"deletepost"
        },
        function(response) {
        }
    );
    $(".posts").prepend("Loading...");
    getPosts(escapeHtml($("#morefeedtype").val()),escapeHtml($("#currentnumberofposts").val()));
    return false;
}

function getPosts(type,currentNum,loadBottom,isNew) {
    if (type != "friends" && type != "world") {
        $(".posts").html("");
        return;
    }
    $.post(
        "../private/model/javascript/feed.php?type=friends&id="+id,
        {
            type:type,
            id:id,
            first:escapeHtml($(".postdatesec").first().text()),
            last:escapeHtml($(".postdatesec").last().text()),
            loadbottom:loadBottom,
            currentnum:currentNum,
            mylat:myLat,
            mylng:myLng,
            newload:isNew
        },
        function(response) {
            if (loadBottom) {
                $(".posts").append(response);
            } else {
                $(".posts").html(response);
            }
        }
    );
}


function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}

/* --------- ON CLICK EVENTS ----------- */

function checkOnClickHome() {
    var currentFeedType = null;
    var currentNumberOfPosts = null;
    if ($("#morefeedtype").length) {
        currentFeedType = escapeHtml($("#morefeedtype").val());
    }
    if ($("#currentnumberofposts").length) {
        currentNumberOfPosts = escapeHtml($("#currentnumberofposts").val());
    }
    $("#lpanellink").click(function(e){
        $("#lpanel").toggleClass("lpanelbodyfixed lpanelbodyfixedhidden");
        if ($("#lpanel").hasClass("lpanelbodyfixedhidden")) {
            $(".lpanelbodylink").css("height","50px");
        } else {
            $(".lpanelbodylink").css("height","300px");
        }
        e.preventDefault();
    });
    $("#bottomchattoggle").click(function(e) {
        $("#chatholder").toggleClass("chatholder chatholderhidden");
        e.preventDefault();
    });
    $("#chatheaderhold").click(function(e) {
        $("#chatholder").toggleClass("chatholder chatholderhidden");
        e.preventDefault();
    });
    $("#friendsfeedlink").click(function(e) {
        if (currentFeedType == "friends") {
            getPosts("friends",currentNumberOfPosts,false,false);
        } else {
            getPosts("friends",currentNumberOfPosts,false,true);
        }
        $("#friendsfeedlink").children().css("background","#FFFFFF");
        $("#nearmefeedlink").children().css("background","#F0F0F0");
        $("#worldfeedlink").children().css("background","#F0F0F0");
        $("#otherfeedlink").children().css("background","#F0F0F0");
        e.preventDefault();
    });
    $("#nearmefeedlink").click(function(e) {
        if (currentFeedType == "nearme") {
            getPosts("nearme",currentNumberOfPosts,false,false);
        } else {
            getPosts("nearme",currentNumberOfPosts,false,true);
        }
        $("#friendsfeedlink").children().css("background","#F0F0F0");
        $("#nearmefeedlink").children().css("background","#FFFFFF");
        $("#worldfeedlink").children().css("background","#F0F0F0");
        $("#otherfeedlink").children().css("background","#F0F0F0");
        e.preventDefault();
    });
    $("#worldfeedlink").click(function(e) {
        if (currentFeedType == "world") {
            getPosts("world",currentNumberOfPosts,false,false);
        } else {
            getPosts("world",currentNumberOfPosts,false,true);
        }
        $("#friendsfeedlink").children().css("background","#F0F0F0");
        $("#nearmefeedlink").children().css("background","#F0F0F0");
        $("#worldfeedlink").children().css("background","#FFFFFF");
        $("#otherfeedlink").children().css("background","#F0F0F0");
        e.preventDefault();
    });
    $("#otherfeedlink").click(function(e) {
        if (currentFeedType == "other") {
            getPosts("",currentNumberOfPosts,false,false);
        } else {
            getPosts("",currentNumberOfPosts,false,true);
        }
        $("#friendsfeedlink").children().css("background","#F0F0F0");
        $("#nearmefeedlink").children().css("background","#F0F0F0");
        $("#worldfeedlink").children().css("background","#F0F0F0");
        $("#otherfeedlink").children().css("background","#FFFFFF");
        e.preventDefault();
    });
    $("#newtext").click(function(e) {
        if ($("#triangleup").hasClass("triangletext") && $("#newinputall").hasClass("newinputall")) {
            $("#newinputall").removeClass("newinputall");
            $("#newinputall").addClass("newinputallnone");
        } else {
            $("#newinputall").removeClass("newinputallnone");
            $("#newinputall").addClass("newinputall");
            $("#triangleup").removeClass();
            $("#innertriangleup").removeClass();
            $("#triangleup").addClass("triangletext");
            $("#innertriangleup").addClass("innertriangletext");
        }
        e.preventDefault();
    });
    $("#newphoto").click(function(e) {
        if ($("#triangleup").hasClass("trianglephoto") && $("#newinputall").hasClass("newinputall")) {
            $("#newinputall").removeClass("newinputall");
            $("#newinputall").addClass("newinputallnone");
        } else {
            $("#newinputall").removeClass("newinputallnone");
            $("#newinputall").addClass("newinputall");
            $("#triangleup").removeClass();
            $("#innertriangleup").removeClass();
            $("#triangleup").addClass("trianglephoto");
            $("#innertriangleup").addClass("innertrianglephoto");
        }
        e.preventDefault();
    });
    $("#newvideo").click(function(e) {
        if ($("#triangleup").hasClass("trianglevideo") && $("#newinputall").hasClass("newinputall")) {
            $("#newinputall").removeClass("newinputall");
            $("#newinputall").addClass("newinputallnone");
        } else {
            $("#newinputall").removeClass("newinputallnone");
            $("#newinputall").addClass("newinputall");
            $("#triangleup").removeClass();
            $("#innertriangleup").removeClass();
            $("#triangleup").addClass("trianglevideo");
            $("#innertriangleup").addClass("innertrianglevideo");
        }
        e.preventDefault();
    });
    $("#newlocation").click(function(e) {
        if ($("#triangleup").hasClass("trianglelocation") && $("#newinputall").hasClass("newinputall")) {
            $("#newinputall").removeClass("newinputall");
            $("#newinputall").addClass("newinputallnone");
        } else {
            $("#newinputall").removeClass("newinputallnone");
            $("#newinputall").addClass("newinputall");
            $("#triangleup").removeClass();
            $("#innertriangleup").removeClass();
            $("#triangleup").addClass("trianglelocation");
            $("#innertriangleup").addClass("innertrianglelocation");
        }
        e.preventDefault();
    });
    $("#newlink").click(function(e) {
        if ($("#triangleup").hasClass("trianglelink") && $("#newinputall").hasClass("newinputall")) {
            $("#newinputall").removeClass("newinputall");
            $("#newinputall").addClass("newinputallnone");
        } else {
            $("#newinputall").removeClass("newinputallnone");
            $("#newinputall").addClass("newinputall");
            $("#triangleup").removeClass();
            $("#innertriangleup").removeClass();
            $("#triangleup").addClass("trianglelink");
            $("#innertriangleup").addClass("innertrianglelink");
        }
        e.preventDefault();
    });
    $("#closeAddMap").click(function() {
        $("#locationinfo").css('display','none');
    });
    $("#newRadius").change(function() {
        $("#newRadiusDisplay").val(getCircleRadius());
        newCircleOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: addMap,
            //center: new google.maps.LatLng(lat,lng),
            radius: getAndValidateRadius()
        };
        addMapCircle.setOptions(newCircleOptions);
    });
}
/* ------------------------------- MESSAGES ------------------------------- */
function checkOnClickMessages() {
    $("#lpanellink").click(function(e){
        $("#lpanel").toggleClass("lpanelbodyfixed lpanelbodyfixedhidden");
        if ($("#lpanel").hasClass("lpanelbodyfixedhidden")) {
            $(".lpanelbodylink").css("height","50px");
        } else {
            $(".lpanelbodylink").css("height","300px");
        }
        e.preventDefault();
    });
    $("#bottomchattoggle").click(function(e) {
        $("#chatholder").toggleClass("chatholder chatholderhidden");
        e.preventDefault();
    });
    $("#chatheaderhold").click(function(e) {
        $("#chatholder").toggleClass("chatholder chatholderhidden");
        e.preventDefault();
    });
}

