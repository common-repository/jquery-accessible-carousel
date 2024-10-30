jQuery(document).ready(function() {
    jQuery('#mycarouselAccessible').jcarousel({
        vertical: false,
        scroll: 2,
        animation: 500,
        wrap: "both",
        itemSelectedCallback : itemSelectedCallbackFunctionAccessible
    });
});

function itemSelectedCallbackFunctionAccessible(carousel, item, index) {
    item = $(item);
    var src = item.find("img").attr("src");
    var alt = item.find("img").attr("alt");
    if (src) {
        $("#viewerImgAccessible").attr("src", src);
    } 
    if (alt) {
        $("#viewerImgAccessible").attr("alt", alt);
    } 
}