$(document).on("pageshow",function() {
    $("#home").on("pageshow",function() {
        initHome();
    });
    $("#profile").on("pageshow",function() {
        initProfile();
    });
    $("#addLocation").on("pageshow",function() {
        showAddMyLocationMap();
    });
    $("#footerFeedLink").click(function(e) {
        //e.preventDefault();
        initHome();
        
    });
    $("#footerProfileLink").click(function(e) {
        //e.preventDefault();
        initProfile();
    });
    $("#footerMessagesLink").click(function(e) {
        //e.preventDefault();
        //initMessages();
    });
    $("#footerSearchLink").click(function(e) {
        //e.preventDefault();
        //initSearch();
    });
});

function initHome() {
    getFeed("friends",true);
    if (typeof nearCity != "undefined") {
        $("#homeNear").html(nearCity+", "+nearState);
    }
    /*$.post("",{pass:true,page:"friendsFeed"},function(data) {
        $("#content").html(data).trigger('create');
        homeScript();
    });*/
}
function initProfile() {
    renderProfilePosts(null,true,false);
    /*$.post("",{pass:true,page:"profile"},function(data) {
        $("#content").html(data).trigger('create');
        profileScript();
    });*/
}
function initMessages() {
}
function initSearch() {
}
    
function homeScript() {
}

function homeFriendsCheckOnClick() {
}
function getFeed(feedType,newFeed,loadBottom) {
    if (loadBottom) {
        $.post("",{pass:true,page:"home",action:"getFeed",feedType:feedType,loadBottom:loadBottom,firstPostDate:null,lastPostDate:lastPostDate},function(data) {
            $("#friendsPosts").append(data);
        });
    } else if (newFeed) {
        $.post("",{pass:true,page:"home",action:"getFeed",feedType:feedType},function(data) {
            $("#friendsPosts").html(data);
        });
    } else {
        $.post("",{pass:true,page:"home",action:"getFeed",feedType:feedType,loadBottom:null,firstPostDate:$(".postdatesec").first().text(),lastPostDate:null},function(data) {
            $("#friendsPosts").prepend(data);
        });
    }
}

/* --------------- FORM FUNCTIONS ---------------- */

function removePost(obj) {
    obj["submit"].value = "Loading...";
    $.post("",{pass:true, page:"home",action:"removePost",postId:obj["postId"].value,collection:obj["collection"].value},function(){
        $('.ui-dialog').dialog('close');
        return;
    });
}
function likeAction(obj) {
    if (obj["like"].value == "LikeTrue") {
        obj["like"].value="Loading";
        $.post("",{pass:true, page:"home",action:"likePost",postId:obj["postid"].value,postersId:obj["postersid"].value,collection:obj["collection"].value},function(result) {
            if (result) {
                $.post("",{pass:true, page:"home", action:"getUpdatedPost",postId:obj["postid"].value,collection:obj["collection"].value},function(result2) {
                    $(obj).parent().parent().parent().parent().parent().html(result2);
                    //$(obj).parent().parent().parent().parent().parent().removeClass('eachpostholder');
                    return false;
                });
            }
        });
        obj["like"].value="Like";
    } else if (obj["like"].value == "UnlikeTrue") {
        obj["like"].value="Loading";
        $.post("",{pass:true, page:"home",action:"unlikePost",postId:obj["postid"].value,collection:obj["collection"].value},function(result) {
            if (result) {
                $.post("",{pass:true, page:"home",action:"getUpdatedPost",postId:obj["postid"].value,collection:obj["collection"].value},function(result2) {
                    $(obj).parent().parent().parent().parent().parent().html(result2);
                    //$(obj).parent().parent().parent().parent().parent().removeClass('eachpostholder');
                    return false;
                });
            }
        });
        obj["like"].value="Unlike";
    } else if (obj["dislike"].value == "DislikeTrue") {
        obj["dislike"].value = "Loading";
        $.post("",{pass:true, page:"home",action:"dislikePost",postId:obj["postid"].value,postersId:obj["postersid"].value,collection:obj["collection"].value},function(result) {
            if (result) {
                $.post("",{pass:true, page:"home", action:"getUpdatedPost",postId:obj["postid"].value,collection:obj["collection"].value},function(result2) {
                    $(obj).parent().parent().parent().parent().parent().html(result2);
                    //$(obj).parent().parent().parent().parent().parent().removeClass('eachpostholder');
                    return false;
                });
            }
        });
        obj["dislike"].value="Dislike";
    } else if (obj["dislike"].value == "UndislikeTrue") {
        obj["dislike"].value = "Loading";
        $.post("",{pass:true, page:"home",action:"undislikePost",postId:obj["postid"].value,collection:obj["collection"].value},function(result) {
            if (result) {
                $.post("",{pass:true, page:"home",action:"getUpdatedPost",postId:obj["postid"].value,collection:obj["collection"].value},function(result2) {
                    $(obj).parent().parent().parent().parent().parent().html(result2);
                    //$(obj).parent().parent().parent().parent().parent().removeClass('eachpostholder');
                    return false;
                });
            }
        });
        obj["dislike"].value="Undislike";
    }
    return false;
}
function likeClick(obj) {
    if (obj.value=="Like") {
        obj.value="LikeTrue";
    } else if (obj.value=="Unlike") {
        obj.value="UnlikeTrue";
    }
    return true;
}
function dislikeClick(obj) {
    if (obj.value=="Dislike") {
        obj.value="DislikeTrue";
    } else if (obj.value=="Undislike") {
        obj.value="UndislikeTrue";
    }
    return true;
}

function newPostText(obj) {
    if (obj["newText"].value.length > 0 && obj["expireTime"].value.length > 0 && obj["postTo"].value.length > 0) {
        $.post("",{pass:true,page:"home",action:"newPost",text:obj["newText"].value,expireTime:obj["expireTime"].value,postTo:obj["postTo"].value,near:obj["addNear"].value,lat:obj["addLat"].value,lng:obj["addLng"].value,radius:obj["addRadius"].value},function(response){
        });
    }
    $('.ui-dialog').dialog('close');
    return false;
}

function newPostPhoto(obj) {
    if (obj["uploadMobilePhoto"].value.length == 0) {
        $('.ui-dialog').dialog('close');
        getFeed("friends",false,false);
        return false;
    }
    return true;
}

function renderFeedType(obj) {
    var feedSelect;
    if (obj["feedSelect"].value.length > 0) {
        feedSelect = obj["feedSelect"].value;
        if (feedSelect == "Friends") {
            getFeed("friends",true,false);
        } else if (feedSelect == "Near Me") {
            getFeed("nearme",true,false);
        } else if (feedSelect == "World") {
            getFeed("world",true,false);
        }
    }
}

/* ----------------------- HOME ------------------------- */

function statusDialog() {
    $("#inputText").css("display","block");
    //if ($("#inputText") has child blank) {
    $.post("",{pass:true,page:"main",action:"getNewStatusPage"}, function(data) {
        $("#inputText").append(data).trigger('create');
    });
}
function closeStatusDialog() {
    $("#inputText").css("display","none");
}

function photoDialog() {
    $("#inputText").css("display","block");
    $.post("",{pass:true,page:"main",action:"getNewPhotoPage"}, function(data) {
        $("#inputText").append(data).trigger('create');
    });
}
function addLocationDialog() {
    $("#addLocationDialog").css("display","block");
    //if
    $.post("",{pass:true,page:"main",action:"getAddLocationPage",from:"home"}, function(data) {
        $("#addLocationDialog").append(data).trigger('create');
    });
}
function closeAddLocationDialog() {
    $("#addLocationDialog").css("display","none");
}

function newPostTextAddLocation() {
    if (lat == 0 && lng == 0) {
        closeAddLocationDialog();
        return;
    }
    $("#addNear").val(nearCity+", "+nearState);
    $("#addLat").val(lat);
    $("#addLng").val(lng);
    $("#addRadius").val($("#addLocationRadiusDisplay").val());
    closeAddLocationDialog();
    $("#newPostTextLocationDisplay").css("visibility","visible");
}

function clearNewPostTextLocationDisplay() {
    $("#addNear").val("");
    $("#addLat").val("");
    $("#addLng").val("");
    $("#addRadius").val("");
    $("#newPostTextLocationDisplay").css("visibility","hidden");
}
    
/* ----------------------- PROFILE ---------------------- */
function profileScript() {
    renderProfilePosts(null,true,false);
}

function renderProfilePosts(profileId,newFeed,loadBottom) {
    if (loadBottom) {
        $.post("",{pass:true,page:"profile",action:"getFeed",profileId:profileId,loadBottom:loadBottom,firstPostDate:null,lastPostDate:lastPostDate},function(data) {
            $("#profileContent").append(data);
        });
    } else if (newFeed) {
        $.post("",{pass:true,page:"profile",action:"getFeed",profileId:profileId},function(data) {
            $("#profileContent").html(data);
        });
    } else {
        $.post("",{pass:true,page:"profile",action:"getFeed",profileId:profileId,loadBottom:null,firstPostDate:$(".postdatesec").first().text(),lastPostDate:null},function(data) {
            $("#profileContent").prepend(data);
        });
    }
}

function renderProfileInfo(profileId) {
    $.post("",{pass:true,page:"profile",action:"getInfo",profileId:profileId},function(data) {
        $("#profileContent").html(data);
    });
}

function renderProfilePhotos(profileId) {
    $.post("",{pass:true,page:"profile",action:"getPhotos",profileId:profileId},function(data) {
        $("#profileContent").html(data);
    });
}

function renderProfilePlaces(profileId) {
    $.post("",{pass:true,page:"profile",action:"getPlaces",profileId:profileId},function(data) {
        $("#profileContent").html(data);
    });
}
function renderProfileFriends(profileId) {
    $.post("",{pass:true,page:"profile",action:"getFriends",profileId:profileId},function(data) {
        $("#profileContent").html(data);
    });
}

function link(obj) {
    var str;
    var params;
    var param;
    var page = "";
    var profileId = "";
    var postId = "";
    var collection = "";
    str = obj["href"];
    str = str.split("?");
    if (str.length > 1) {
        params = str[1].split("&");
        for (var i=0;i<params.length;i++) {
            param = params[i].split("=");
            if (param[0] == "page" && param[1] == "profile") {
                page = "profile";
            } else if (param[0] == "id") {
                profileId = param[1];
            } else if (param[0] == "page" && param[1] == "post") {
                page = "post";
            } else if (param[0] == "postId") {
                postId = param[1];
            } else if (param[0] == "collection") {
                collection = param[1];
            }
        }
        if (page.length > 0 && profileId.length > 0) {
            $.post("",{pass:true,page:"profile",action:"getProfileById",profileId:profileId},function(data) {
                $("#content").html(data).trigger('create');
            });
        } else if (page.length > 0 && postId.length > 0) {
            $.post("",{pass:true,page:"home",action:"getOnePost",postId:postId,collection:collection},function(data) {
                $("#content").html(data).trigger('create');
            });
        }
    }     
}

function addFriend(obj) {
    $.post("",{pass:true,page:"profile",action:"addFriend",profileId:obj["profileId"].value},function(data) {
        if (data.length > 0) {
            $("#friendStatus").html(data);
        }
    });
}
function acceptFriend(obj) {
    $.post("",{pass:true,page:"profile",action:"acceptFriend",profileId:obj["profileId"].value},function(data) {
        if (data.length > 0) {
            $("#friendStatus").html(data);
        }
    });
}
function removeFriendRequest(obj) {
    $.post("",{pass:true,page:"profile",action:"removeFriendRequest",profileId:obj["profileId"].value},function(data) {
        alert("Code not written yet");
    });
}
/* ------------------------- SEARCH ----------------------------- */

function search(obj) {
    if (obj["footerSearch"].value.length > 0) {
        $.post("",{pass:true,page:"search",action:"search",searchText:obj["footerSearch"].value},function(data) {
            $("#searchContent").html(data);
        });
    }
}


/* ------------------------- GEOLOCATION ------------------------- */
var lat = 0;
var lng = 0;
var myLat = 40;
var myLng = -90;
var nearCity;
var nearState;
var addLocationMap;
var addLocationMapCircle;
var marker;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            myLat = position.coords.latitude;
            myLng = position.coords.longitude;
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            $.post("",{pass:true,page:"main",action:"updateLatLng",lat:myLat,lng:myLng});
            getNear(myLat,myLng);
            updateAddLocationMap();
        },function(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("Permission Denied");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Position Unavailable");
                    break;
                case error.TIMEOUT:
                    alert("Timeout");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Unknown Error");
                    break;
            }
        });
    } else {
        alert("Geolocation not available on your browser");
    }
}

function getNear(myLat,myLng) {
    $.ajax({
        type:'Get',
        dataType:'json',
        url:'http://maps.googleapis.com/maps/api/geocode/json?latlng='+myLat+','+myLng+'&sensor=true',
        data: {},
        success: function(data) {
            console.log(data)
            var components = data.results[0].address_components;
            for (var i = 0; i < components.length; i++) {
                if (components[i].types[0] == "locality") {
                    nearCity = data.results[0].address_components[i].long_name;
                }
                if (components[i].types[0] == "administrative_area_level_1") {
                    nearState = data.results[0].address_components[i].long_name;
                }
            }
            $("#myLocationNear").html("Near "+nearCity+", "+nearState);
            $.post("",{pass:true,page:"main",action:"updateNear",near:"Near "+nearCity+", "+nearState});
        }, error: function () {
            alert("Error getting nearby city");
        }
    });
}
function showAddMyLocationMap() {
    var markerOptions;
    var circleOptions;
    var useragent = navigator.userAgent;
    /*if (useragent.indexOf('iPhone') != 1 || useragent.indexOf('Andriod') != -1 || useragent.indexOf('iPod') != -1 ) {
        return;
    } else {
    */
        var latlng = new google.maps.LatLng(myLat,myLng);
        if (addLocationMap == null) {
            var options = {
                zoom: 3,
                center: latlng
            };
            addLocationMap = new google.maps.Map(document.getElementById("myLocationMap"),options);
            google.maps.event.trigger(addLocationMap, 'resize');
        } else {
            //addLocationMap.setCenter(latlng);
            //addLocationMap.setZoom(10);
            var options = {
                zoom: 3,
                center: latlng
            };
            addLocationMap = new google.maps.Map(document.getElementById("myLocationMap"),options);
            google.maps.event.trigger(addLocationMap, 'resize');
        }
        markerOptions = {
            map: addLocationMap,
            position: new google.maps.LatLng(myLat,myLng),
            draggable: true,
            title: 'Drag'
        };
        circleOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF000',
            fillOpacity: 0.35,
            map: addLocationMap,
            radius: 20000
        };
        //if (addLocationMapCircle == undefined) {
            addLocationMapCircle = new google.maps.Circle(circleOptions);
            marker = new google.maps.Marker(markerOptions);
            addLocationMapCircle.bindTo('center',marker,'position');
        //}
        google.maps.event.addListener(marker,'dragend',function() {
            var markPos = marker.getPosition();
            lat = markPos.lat();
            lng = markPost.lng();
        });
        /*$("#addLocationRadius").val('5');
        $("#addLocationRadius").slider('refresh');
        $("#addLocationRadiusDisplay").val("20000");*/
    //}
}

function updateAddLocationMap() {
    var latlng = new google.maps.LatLng(myLat,myLng);
    addLocationMap.setCenter(latlng);
    addLocationMap.setZoom(10);
    marker.setPosition(latlng);
    addLocationMapCircle.setRadius(20000);
    $("#addLocationRadius").val('4');
    $("#addLocationRadius").slider('refresh');
    $("#addLocationRadiusDisplay").val("10000");
    google.maps.event.trigger(addLocationMap, 'resize');
}
function changeCircleRadius(obj) {
    $("#addLocationRadiusDisplay").val(getCircleRadius());
    var circleOptions = {
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: addLocationMap,
        radius: getAndValidateRadius()
    };
    addLocationMapCircle.setOptions(circleOptions);
}

function getAndValidateRadius() {
    //used for custom radius values entered into input box
    var rad = $("#addLocationRadiusDisplay").val();
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

function getCircleRadius() {
    var sliderNumber;
    sliderNumber = +$("#addLocationRadius").val();
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


