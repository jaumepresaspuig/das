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
    $(".ce-type-das_alert .alert").each(function () {
        $(this).on("closed.bs.alert", function() {
            $("#" + $(this).attr("data-id")).remove();
        });
    });
}

function initCodeText() {
    $(".code").each(function () {
        $(this).on("click", function() {
            navigator.clipboard.writeText($(this).text());
        });
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
        $('#tx-das-content-poll-board-' + pollx).html(html);
    });

}