let みるめも = "Thank you for coming!!";
console.log("わざわざこんなところまで見に来てくれたんですね！！\nそれならこのコンソールに「みるめも」と入力してみてね～");

//**************コメントthxをjsでnotifyする*************
$(document).ready(function () {
  setTimeout(() => {
    if (location.href.indexOf("#comment-") !== -1) {
      const nb = $(".notify-bar.success");
      nb.css("display", "block");
      setTimeout(() => {
        nb.css("opacity", "0.98");
        setTimeout(() => {
          nb.css("opacity", "0");
          setTimeout(() => {
            nb.css("display", "none");
          }, 333);
        }, 7777);
      }, 333);
    }
  }, 333);
});


//*********************いいねボタン********************
// TODO?: cookieのキー自体が増えていくのはちょっと変だけど別に害はないので直してない
$(document).ready(function () {
  let url = location.pathname.slice(1);
  let cookies = document.cookie.split(";");
  let result = false;
  for (let i = 0; i < cookies.length; i++) {
    let keyValue = cookies[i].split("=");
    keyValue[0] = keyValue[0].trim(" ");
    if (keyValue[0] == "pressedLike_" + url) {
      result = true;
    }
  }
  if (result) {
    off2on();
  } else {
    // ドッキュンアニメーション…はとりあえずやめた
  }
  let toggle = result;
  $(".like-button").click(function () {
    if (toggle === false) {
      off2on();
      document.cookie = "pressedLike_" + url + "=arigatou;max-age=315360000";
      writeLikeButtonDB("on", url);
      toggle = true;
    } else {
      on2off();
      document.cookie = "pressedLike_" + url + "=arigatou;max-age=0";
      writeLikeButtonDB("off", url);
      toggle = false;
    }
  });
});
function off2on() {
  $(".heart-wrapper").addClass("active");
  // $(".like-button").css("background-color", "#ffe9ec");
  $(".like-outline").attr("fill", "#ed7e8e");
  $(".like-inner").attr("fill", "#ed7e8e");
  $(".like-button+.snsbadge").html(parseInt($(".like-button+.snsbadge").html()) + 1);
  $(".like-button+.snsbadge").css("color", "#ed7e8e");
}
function on2off() {
  $(".heart-wrapper").removeClass("active");
  // $(".like-button").css("background-color", "#f5f2f0");
  $(".like-outline").attr("fill", "#c4c1be");
  $(".like-inner").attr("fill", "#f5f2f0");
  $(".like-button+.snsbadge").html(parseInt($(".like-button+.snsbadge").html()) - 1);
  $(".like-button+.snsbadge").css("color", "#bebebe");
}
function writeLikeButtonDB(type, url) {
  $.ajax({
    type: "POST",
    url: "/wp-admin/admin-ajax.php",
    data: {
      action: "like_button",
      type: type,
      slug: url,
    },
  });
}


//*********************左下にランダムでヒミツのパスワードを表示する********************
$(document).ready(function () {
  function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
  }
  let url = location.pathname.slice(1);
  let passwordSet = [
    // "1:" + String.fromCodePoint(0x307F),
    "2:" + String.fromCodePoint(0x3093),
    "3:" + String.fromCodePoint(0x307f),
    "4:" + String.fromCodePoint(0x3093),
    "5:" + String.fromCodePoint(0x305c),
    "6:" + String.fromCodePoint(0x307f),
  ];
  let randomDispPage = getRandomInt(13);
  let randomPickArray = getRandomInt(4);
  let tag = '<div class="secret-password">' + passwordSet[randomPickArray] + '<a href="/what-is-this-blog#omake">' + String.fromCodePoint(0x3053) + String.fromCodePoint(0x308c) + String.fromCodePoint(0x306f) + String.fromCodePoint(0x4f55) + String.fromCodePoint(0xff1f) + "</a></div>";

  if (
    randomDispPage === 0 && //確率7.1%
    window.performance.navigation.type === 0 && //リンクのクリックのみ
    location.href !== "/" &&
    url !== "all-entries" &&
    url !== "profile" &&
    url !== "what-is-this-blog" &&
    url !== "contact" &&
    url !== "about" &&
    url !== "privacy-policy" &&
    !url.match(/category/) &&
    !url.match(/tag/)
  ) {
    $("body").append(tag);
  }
});


//*webp対応でIEのときにキャッシュ効いちゃうのでjsで置換(記事、固定ページ、カテゴリページ)*
//TOPページでも同じことをやってるがカスタムJavaScriptに書いている
$(document).ready(function () {
  let userAgent = window.navigator.userAgent;
  if (userAgent.toLowerCase().indexOf("trident") !== -1 || userAgent.toLowerCase().indexOf("msie") !== -1) {
    //PCメニューの-ms-gridもこちらに移行した
    let tag =
      "<style>" +
      ".navi-in > ul .sub-menu li:nth-child(1) {" +
      "   -ms-grid-column: 1;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(2) {" +
      "    -ms-grid-column: 2;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(3) {" +
      "    -ms-grid-column: 3;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(4) {" +
      "    -ms-grid-column: 4;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(5) {" +
      "    -ms-grid-column: 5;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(6) {" +
      "    -ms-grid-column: 1;" +
      "    -ms-grid-row: 2;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(7) {" +
      "    -ms-grid-column: 2;" +
      "    -ms-grid-row: 2;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(8) {" +
      "    -ms-grid-column: 3;" +
      "    -ms-grid-row: 2;" +
      "}" +
      ".navi-in > ul .sub-menu li:nth-child(9) {" +
      "    -ms-grid-column: 4;" +
      "    -ms-grid-row: 2;" +
      "}" +
      "</style>";
    $("body").append(tag);

    //読み込み順の問題で-ms-grid対応を上にしてる
    let imgTag = $("<div>").append($("figure.eye-catch > img").clone(true)).html();
    let imgElement = document.getElementsByClassName("eye-catch-image");
    let type;
    if (imgElement[0].classList.contains("type-jpg")) {
      type = "jpg";
    } else if (imgElement[0].classList.contains("type-jpeg")) {
      type = "jpeg";
    } else if (imgElement[0].classList.contains("type-png")) {
      type = "png";
    } else {
    }
    imgTag = imgTag.replace(/(.*\.)webp/gim, "$1" + type);
    $("figure.eye-catch > img").remove();
    $("figure.eye-catch").prepend(imgTag);
  }
});


//*********************固定ヘッダー********************
$(function () {
  let $win = $(window);
  let $header_for_scroll = $(".header-for-scroll");
  $win.on("load scroll", function () {
    var value = $(this).scrollTop();
    if (value > 273) {
      $header_for_scroll.fadeIn(503).css("display", "flex");
    } else {
      $header_for_scroll.fadeOut(503);
    }
  });
});


//********************スクロールふわっとエフェクト********************
$(document).ready(function () {
  scroll_effect();
  $(window).scroll(function () {
    scroll_effect();
  });
  function scroll_effect() {
    $(".effect-fade").each(function () {
      var elemPos = $(this).offset().top;
      var scroll = $(window).scrollTop();
      var windowHeight = $(window).height();
      if (scroll > elemPos - windowHeight) {
        $(this).addClass("effect-scroll");
      }
    });
  }
});


//*********************右上の検索ボックス展開********************
//スクロールヘッダー用
$(document).ready(function () {
  $(".header-search-btn-for-scroll").click(function () {
    $(this).fadeOut(137);
    $("#header-search-for-scroll input").css("display", "inline-block");
    $("#header-search-for-scroll").addClass("start-animation-1");
  });
  $("#header-search-for-scroll").on("animationend", function () {
    $("#header-search-for-scroll").removeClass("start-animation-1");
    $("#header-search-for-scroll").css({opacity: "1", width: "13em"});
    $("#header-search-for-scroll input").focus();
  });
  $("#header-search-for-scroll input").blur(function () {
    $(this).fadeOut(137);
    setTimeout(function () {
      $(".header-search-btn-for-scroll").fadeIn(337);
    }, 237);
  });
});


//*************************カテゴリメニュー*************************
let flgHover = false;
// let flgDisp = false;
$(document).ready(function () {
  $(".header-category").hover(
    function () {
      let userAgent = window.navigator.userAgent.toLowerCase();
      if (userAgent.indexOf("trident") != -1) {
        $(".menu-header .header-category > ul").fadeIn(317).css("display", "-ms-grid");
      } else {
        $(".menu-header .header-category > ul").fadeIn(317).css("display", "grid");
      }
      $(".menu-mobile .header-category > ul").fadeIn(317);
      flgHover = true;
    },
    function () {
      $(".menu-header .header-category > ul").fadeOut(317);
      $(".menu-mobile .header-category > ul").fadeOut(317);
      flgHover = false;
    }
  );
});


//*************************スマホ用両サイドメニュー1*************************
let flgHover1 = false;
// let flgDisp = false;
$(document).ready(function () {
  $(".header-sumaho-menu-1").hover(
    function () {
      let userAgent = window.navigator.userAgent.toLowerCase();
      if (userAgent.indexOf("trident") != -1) {
        $(".menu-header .header-sumaho-menu-1 > ul").fadeIn(317).css("display", "-ms-grid");
      } else {
        $(".menu-header .header-sumaho-menu-1 > ul").fadeIn(317).css("display", "grid");
      }
      $(".menu-mobile .header-sumaho-menu-1 > ul").fadeIn(317);
      flgHover1 = true;
    },
    function () {
      $(".menu-header .header-sumaho-menu-1 > ul").fadeOut(317);
      $(".menu-mobile .header-sumaho-menu-1 > ul").fadeOut(317);
      flgHover1 = false;
    }
  );
});


//*************************スマホ用両サイドメニュー2*************************
let flgHover2 = false;
// let flgDisp = false;
$(document).ready(function () {
  $(".header-sumaho-menu-2").hover(
    function () {
      let userAgent = window.navigator.userAgent.toLowerCase();
      if (userAgent.indexOf("trident") != -1) {
        $(".menu-header .header-sumaho-menu-2 > ul").fadeIn(317).css("display", "-ms-grid");
      } else {
        $(".menu-header .header-sumaho-menu-2 > ul").fadeIn(317).css("display", "grid");
      }
      $(".menu-mobile .header-sumaho-menu-2 > ul").fadeIn(317);
      flgHover2 = true;
    },
    function () {
      $(".menu-header .header-sumaho-menu-2 > ul").fadeOut(317);
      $(".menu-mobile .header-sumaho-menu-2 > ul").fadeOut(317);
      flgHover2 = false;
    }
  );
});


//*************************topBtn.js*************************
$(function () {
  var topBtn = $(".topBtn");
  $(window).scroll(function () {
    if ($(this).scrollTop() > 273) {
      topBtn.fadeIn("503");
    } else {
      topBtn.fadeOut("503");
    }
  });
  $(".topBtn.backToTop").click(function () {
    $("html, body").animate({scrollTop: 0}, 313);
  });
});


//*************************ugoku_marker.js*************************
$(window).scroll(function () {
  $(".ugoku-marker-yellow").each(function () {
    var position = $(this).offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll > position - windowHeight) {
      $(this).addClass("active");
    }
  });
});
