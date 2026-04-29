jQuery(document).ready(function ($) {
    "use strict";
    if ( typeof theme !== "undefined" && theme !== "" ) {
        if (theme == "auto") {
            theme = (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches)
                    ? "dark"
                    : "";
        }
        if (theme != "") {
            document.documentElement.setAttribute("data-bs-theme", theme);
        }
    };
    AOS.init({
        duration: 800,
        easing: "slide",
        once: true
    });
    initProgressBars();
    initGallery();
    fixCarouselHeight();
    initModal();
    initCounter();
    initAlerts();
    initCodeText();
    initTooltips();
    initAudioPlayer();
    initPolls();
    initMagnifierGlass();
    initSideCe();
    initRandomCe();
    initCircleCounters();

});

function initGallery() {
    var glightboxes = [];
    $(".glightbox").each(function() {
        glightboxes[$(this).attr("data-glightbox-id")] = GLightbox({
            selector: "." + $(this).attr("data-glightbox-id")
        });
    });
}

function initProgressBars() {
    $(".tx-das-content-progressbar-vertical").each(function() {
        $("#" + $(this).attr("data-id")).css("position", "relative").css("height", $(this).attr("data-barsheight") + "px");
        $(this).css("width", $(this).attr("data-barsheight") + "px");
    });
    $(".progress-bar").each(function() {
        $(this).animate({
            width: $(this).attr("data-area") + "%"
        }, 1000);
    });
}

function initModal() {
    $(".tx-das-content-modal").each(function() {
        if ( ($(this).attr("data-showonlyonce")=="1") && (Cookies.get(modalId)) ) {
        } else {
            var modalId = $(this).attr("id"),
                autoOpen = Number($(this).attr("data-autoopen")),
                autoClose = Number($(this).attr("data-autoclose")) + autoOpen;
            Cookies.set(modalId, "1");
            if (autoOpen) {
                setTimeout('$("#' + modalId + '").modal("show")', autoOpen*1000);
            } else {
                $("#" + modalId).modal("show");
            }
            if (autoClose && autoClose > autoOpen) {
                setTimeout('$("#' + modalId + '").modal("hide")', autoClose*1000);
            }
        }
    });
}

$.fn.isOnScreen = function () {
    var win = $(window);
    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};

function initCounter() {
    $(".tx-das-content-counter h1 span").each(function () {
        var counterId = $(this).attr("id");
        if ($("#" + counterId).isOnScreen()) {
            dasCounter(counterId, $("#" + counterId).data("from"), $("#" + counterId).data("to"), parseInt($("#" + counterId).data("speed")) * 5);
        } else {
            $(window).scroll(function () {
                if ($("#" + counterId).isOnScreen()) {
                    dasCounter(counterId, $("#" + counterId).data("from"), $("#" + counterId).data("to"), parseInt($("#" + counterId).data("speed")) * 5);
                }
            });
        }
    });
}

function dasCounter(target, fromNumber, toNumber, speed) {
    var numberToShow = fromNumber.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
    $("#" + target).html(numberToShow);
    var fromNumber = parseInt(fromNumber),
        toNumber = parseInt(toNumber);
    if (fromNumber < toNumber) {
        fromNumber++;
        var done = (fromNumber <= toNumber)
            ? 0
            : 1;
    } else {
        fromNumber--;
        var done = (fromNumber >= toNumber)
            ? 0
            : 1;
    }
    if (!done) {
        setTimeout(dasCounter, speed, target, fromNumber, toNumber, speed);
    }
}

function fixCarouselHeight() {
    $(".carousel").each(function () {
        var carouselId = $(this).attr("id");
        var maxHeight = 0;
        $("#" + carouselId + " .carousel-item").each(function () {
            var thisHeight = $(this).outerHeight();
            if (thisHeight > maxHeight) {
                maxHeight = thisHeight;
            }
        });
        $("#" + carouselId + " .carousel-item").css("height", maxHeight + "px");
    });
}

function initAlerts() {
    $(".ce-type-das_alert .alert").on("closed.bs.alert", function() {
        $("#" + $(this).attr("data-id")).remove();
    });
}

function initCodeText() {
    $(".code").on("click", function() {
        navigator.clipboard.writeText($(this).text());
    });
}

function initTooltips() {
    $(".tooltipthis").each(function () {
        $(this).attr("data-bs-title", $(this).attr("title"));
        $(this).attr("title", "");
    });
    $(".code").each(function () {
        $(this).attr("data-bs-title", copy_to_clipboard);
    });
    const tooltipTriggerList = document.querySelectorAll(".tooltipthis");
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

function initAudioPlayer() {
    $(".js-audioplayer").each(function() {
        var id = $(this).attr("id");
        $(this).find(".js-control")[0].addEventListener("click", function() {
            resetPlayback(id, 1);
            
        });
        $(this).find("audio")[0].addEventListener("ended", function() {
            resetPlayback(id, 0);
        });
    });
}

function playback(id) {
    var audio = $("#" + id).find("audio");
    if (audio[0].paused) {
        $("#" + id).addClass("is-playing"); 
        audio[0].play();
        audio.animate({ volume: 1 }, 500);
    } else {
        $("#" + id).removeClass("is-playing");
        audio.animate({ volume: 0 }, 500, function() {
            audio[0].pause();
        });
    }
}

function resetPlayback(id, play) {
    $(".js-audioplayer").each(function() {
        if ($(this).attr("id") !== id) {
            $(this).removeClass("is-playing");
            $(this).find("audio").animate({ volume: 0 }, 500, function() {
                $(this)[0].pause();
            });
        }
    });
    if (play) {
        playback(id);
    }
}

function initPolls() {
    $(".tx-das-content-poll").each(function() {
        sendPoll($(this).attr("data-poll"), 0);
    });
}

function initPoll(poll) {
    $("#tx-das-content-poll-" + poll + " a.btn-answer").on("click", function() {
        $(".tx-das-content-poll a.btn-answer").each(function() {
            if ($(this).hasClass("btn-" + $("#tx-das-content-poll-" + $(this).attr("data-poll")).attr("data-color"))) {
                $(this).removeClass("btn-" + $("#tx-das-content-poll-" + $(this).attr("data-poll")).attr("data-color")).addClass("btn-outline-" + $("#tx-das-content-poll-" + $(this).attr("data-poll")).attr("data-color"));
            }
        });
        $(this).removeClass("btn-outline-" + $("#tx-das-content-poll-" + $(this).attr("data-poll")).attr("data-color")).addClass("btn-" + $("#tx-das-content-poll-" + $(this).attr("data-poll")).attr("data-color"));
        $("#tx-das-content-poll-" + poll + " a.btn-send").removeClass("disabled").attr("data-answer", $(this).attr("data-answer"));
        return false;
    });
    $("#tx-das-content-poll-" + poll + " a.btn-send").on("click", function() {
        sendPoll($(this).attr("data-poll"), $(this).attr("data-answer"));
        return false;
    });
}

function sendPoll(poll, answer) {
    let pollx = poll;
    $.get(window.location.href, { no_cache: 1, pk_campaign: poll, pk_kwd: answer }).done(function( data ) {
        const $resp = $("<div>").html(data);
        const html = $resp.find("#tx-das-content-poll-board-" + pollx).html() || "";
        $("#tx-das-content-poll-board-" + pollx).html(html);
    });
}

function initRandomCe() {
    $(".tx-das-content-randomce").each(function() {
        let pid = $(this).attr("data-id");
        $.get(window.location.href, { no_cache: 1, gclid: pid }).done(function( data ) {
            const $resp = $("<div>").html(data);
            const html = $resp.find("#tx-das-content-randomce-" + pid).html() || "";
            $("#tx-das-content-randomce-" + pid).html(html);
        });
    });
}

function initMagnifierGlass() {
    $(".tx-das-content-magnifierglass").each(function() {
        var large = $(this).find(".large"),
            small = $(this).find(".small"),
            native_width = 0,
	        native_height = 0
            large_width = 0,
            small_width = 0,
            large_height = 0,
            small_height = 0;
        $(this).on("mousemove", function(e) {
            if (!native_width && !native_height){
                native_width = small.attr("data-width");
                native_height = small.attr("data-height");
                large_width = large.width();
                small_width = small.width();
                large_height = large.height();
                small_height = small.height();
            }
            var magnify_offset = $(this).offset(),
                mx = e.pageX - magnify_offset.left,
                my = e.pageY - magnify_offset.top;
            if (mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0) {
                large.fadeIn(100);
            } else{
                large.fadeOut(100);
            }
            if (large.is(":visible")) {
                var rx = Math.round(mx/small.width()*native_width - large_width/2) * -1,
                    ry = Math.round(my/small.height()*native_height - large_height/2) * -1,
                    bgp = rx + "px " + ry + "px",                
                    px = mx - large_width / 2,
                    py = my - large_height / 2;
                large.css({left: px, top: py, backgroundPosition: bgp});
            }
        });
    });
}

function initSideCe() {
    $(".tx-das-content-sidece button").on("click", function() {
        $(this).closest('.tx-das-content-sidece').toggleClass('open');
    });
}

function initCircleCounters() {
    var testInterval = {};
    $(".tx-das-content-circlecounters .circlecounter").each(function() {
        var $el = $(this),
            id = $el.attr("id"),
            percentage = parseFloat($el.attr("data-percentage")) || 0;
        $el.circleProgress({
            size: 200,
            value: percentage,
            color: $el.attr("data-color"),
            progressWidth: 10
        });
        (function(elId, $elRef) {
            testInterval[elId] = setInterval(function() {
                var seconds = parseInt($elRef.attr("data-seconds"), 10) || 0;
                if (seconds > $el.attr("data-percentage")) {
                    clearInterval(testInterval[elId]);
                    return;
                }
                $elRef.circleProgress("updateOptions", { value: seconds });
                $elRef.attr("data-seconds", seconds + 1);
            }, 30);
        })(id, $el);
    });
};

(function ($) {
    $.fn.circleProgress = function (options, params) {
        if ($(this).length > 1) {
            return $(this).each(function (i, e) {
                return $(e).circleProgress(options, params);
            });
        }
        const DEFAULTS = {
            size: 200,
            value: 0,
            background: "transparent",
            color: "primary",
            progressWidth: null
        };
        const $element = $(this);
        function setValue(value) {
            let showValue = value;
            if (value > 100) {
                value = 100;
            }
            $element.data("value", showValue);
            $element.find(".js-prozess-value").text(Math.round(showValue));
            const left = $element.find(".progress-left .progress-bar");
            const right = $element.find(".progress-right .progress-bar");
            if (value > 0) {
                if (value <= 50) {
                    right.css("transform", "rotate(" + percentageToDegrees(value) + "deg)")
                } else {
                    right.css("transform", "rotate(180deg)")
                    left.css("transform", "rotate(" + percentageToDegrees(value - 50) + "deg)")
                }
            } else {
                left.css("transform", "rotate(0deg)");
                right.css("transform", "rotate(0deg)");
            }
        }
        function getColor(color) {
            if (["dark", "secondary", "light", "info", "warning", "danger", "success", "primary"].includes(color)) {
                return {
                    class: "progress-bar border-" + color
                };
            } else {
                return {
                    class: "progress-bar",
                    css: {
                        borderColor: color
                    }
                };
            }
        }
        function getColorBackgroundColor(color) {
            if (["dark", "secondary", "light", "info", "warning", "danger", "success", "primary", "transparent"].includes(color)) {
                return {
                    class: "bg-" + color
                };
            } else {
                return {
                    css: {
                        background: color
                    }
                };
            }
        }
        function build($e) {
            const settings = $e.data("settings");
            const spanColor = getColor(settings.color);
            const borderWidth = settings.progressWidth ?? (settings.size / 10);
            const backgroundColor = getColorBackgroundColor(settings.background);
            const backgroundCss = $.extend({
                maxWidth: settings.size + "px",
                minWidth: settings.size + "px",
                width: settings.size + "px",
                maxHeight: settings.size + "px",
                minHeight: settings.size + "px",
                height: settings.size + "px",
                borderRadius: settings.size + "px"
            }, backgroundColor.css || {})
            $e
                .addClass("position-relative")
                .css(backgroundCss);

            if (backgroundColor.class) {
                $e.addClass(backgroundColor.class)
            }
            const cssSpan = {
                width: "50%",
                height: "100%",
                overflow: "hidden",
                position: "absolute",
                top: 0,
                zIndex: 1
            };
            const progressBarCss = {
                width: "100%",
                height: "100%",
                background: "none",
                borderWidth: borderWidth + "px",
                borderStyle: "solid",
                position: "absolute",
                top: 0,
                zIndex: 2
            };
            // left border
            const leftCSS = $.extend(structuredClone(cssSpan), {left: 0});
            const leftProgressBarCss = $.extend(structuredClone(cssSpan), structuredClone(progressBarCss), {
                left: "100%",
                borderTopRightRadius: (settings.size / 2 + borderWidth) + "px",
                borderBottomRightRadius: (settings.size / 2 + borderWidth) + "px",
                borderLeft: 0,
                transformOrigin: "center left"
            });
            const left = $("<span>", {
                class: "progress-left",
                css: leftCSS
            }).appendTo($e);
            $("<span>", {
                class: spanColor.class,
                css: spanColor.css ? $.extend(leftProgressBarCss, spanColor.css) : leftProgressBarCss
            }).appendTo(left);
            // right border
            const rightCSS = $.extend(structuredClone(cssSpan), {right: 0});
            const rightProgressBarCss = $.extend(structuredClone(cssSpan), structuredClone(progressBarCss), {
                left: "-100%",
                borderTopLeftRadius: (settings.size / 2 + borderWidth) + "px",
                borderBottomLeftRadius: (settings.size / 2 + borderWidth) + "px",
                borderRight: 0,
                transformOrigin: "center right"
            });
            const right = $("<span>", {
                class: "progress-right",
                css: rightCSS
            }).appendTo($e);
            $("<span>", {
                class: spanColor.class,
                css: spanColor.css ? $.extend(rightProgressBarCss, spanColor.css) : rightProgressBarCss
            }).appendTo(right);
            // value container
            $("<div>", {
                css: {
                    position: "absolute",
                    top: 0,
                    left: 0,
                    width: "50%",
                    height: "100%",
                    overflow: "hidden",
                    zIndex: 0,
                    fontSize: (settings.size / 5) + "px",
                    borderWidth: borderWidth + "px",
                    borderStyle: "solid",
                    borderColor: "rgb(128, 128, 128, .3)"
                },
                class: "progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center",
                html: '<div class="font-weight-bold m-0"><span class="js-prozess-value"></span>%</div>'
            }).appendTo($e);
            setValue($element.data("value") || settings.value);
        }
        function percentageToDegrees(percentage) {
            return percentage / 100 * 360
        }
        function events($e) {
        }
        function init() {
            if (!$element.data("init")) {
                if (typeof options === "object" && !$element.data("settings")) {
                    $element.data("settings", $.extend(DEFAULTS, options || {}));
                }
                if (!$element.data("settings")) {
                    $element.data("settings", DEFAULTS);
                }
                build($element);
                events($element);
                $element.data("init", true);
            }
        }
        init();
        if (typeof options === "string") {
            switch (options) {
                case "val": {
                    setValue(params);
                    break;
                }
                case "updateOptions": {
                    const beforeOptions = $element.data("settings") || DEFAULTS;
                    const beforeValue = $element.data("value");
                    const newOptions = $.extend(beforeOptions, params);
                    $element.data("settings", newOptions);
                    $element.empty();
                    build($element);
                    if (params.value) {
                        setValue(params.value)
                    }
                    break;
                }
            }
        }
        return $element;
    }
}(jQuery));
