/**
 * Created by Administrator on 2018/8/16.
 */
window.fbAsyncInit = function() {
    FB.init({
        appId   : '1068912489952175',
        cookie  : true,
        xfbml   : true,
        version : 'v3.1'
    });
    FB.AppEvents.logPageView();
};
(function(d, s, id) {
    var js,
        fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
/*FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});*/
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}
