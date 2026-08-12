(function () {
  function isHeroMobile() {
    return window.matchMedia("(max-width: 768px)").matches;
  }
  function heroTiming() {
    if (isHeroMobile()) {
      return { rotation: 5600, fade: 240 };
    }
    return { rotation: 3000, fade: 300 };
  }

  var PLACEHOLDER_MAIN =
    "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-4.svg";
  var PLACEHOLDER_SECONDARY =
    "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-2.webp";
  var PLACEHOLDER_ICON =
    "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228712.svg";

  var CATEGORIES = [
    {
      id: "platforms",
      label: "Platforms",
      subs: [
        {
          id: "orbit",
          title: "Orbit",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-2.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-2.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228715.svg",
          useSecondaryImage: true,
        },
        {
          id: "cmp",
          title: "CMP",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-3.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-8.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228716.svg",
          useSecondaryImage: true,
        },
        {
          id: "esimora",
          title: "Esimora",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788.png",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228714.svg",
          useSecondaryImage: true,
        },
        {
          id: "devhub",
          title: "DevHub",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.png",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-1.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228712.svg",
          useSecondaryImage: true,
        },
      ],
    },
    {
      id: "apis",
      label: "Communication APIs",
      subs: [
        {
          id: "whatsapp",
          title: "WhatsApp",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/07/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/07/Frame-2147227788.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228713.svg",
          useSecondaryImage: true,
        },
        {
          id: "email",
          title: "Email",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/07/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228748.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228712-2.svg",
          useSecondaryImage: true,
        },
        {
          id: "sms",
          title: "SMS",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/07/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228747.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228714-2.svg",
          useSecondaryImage: true,
        },
        {
          id: "rcs",
          title: "RCS",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/07/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228749.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228715-2-1.svg",
          useSecondaryImage: true,
        },
      ],
    },
    {
      id: "telco",
      label: "Telco",
      subs: [
        {
          id: "sms-services",
          title: "SMS",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_16kjm816kjm816kj-2-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-6.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228712-1.svg",
          useSecondaryImage: true,
        },
        {
          id: "voice",
          title: "Voice",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Generated-Image-January-13-2026-5_51PM-2.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-5.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228714-1.svg",
          useSecondaryImage: true,
        },
        {
          id: "sms-firewall",
          title: "Firewall",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/Gemini_Generated_Image_16kjm816kjm816kj-2.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-7.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228716-1.svg",
          useSecondaryImage: true,
        },
        {
          id: "monetize",
          title: "Monetize",
          mainImage:
            "https://devotel.com/wp-content/uploads/2026/05/ChatGPT-Image-May-5-2026-04_03_06-PM-1.webp",
          secondaryImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147227788-3.webp",
          iconImage:
            "https://devotel.com/wp-content/uploads/2026/05/Frame-2147228715-2.svg",
          useSecondaryImage: true,
        },
      ],
    },
  ];

  (function rewriteDevotelHeroAssetUrls() {
    var cfg = window.devotelHomeHero;
    if (!cfg || !cfg.uploadsBase) {
      return;
    }
    var legacy = "https://devotel.com/wp-content/uploads/";
    var base = cfg.uploadsBase;
    function mapUrl(url) {
      if (typeof url === "string" && url.indexOf(legacy) === 0) {
        return base + url.slice(legacy.length);
      }
      return url;
    }
    PLACEHOLDER_MAIN = mapUrl(PLACEHOLDER_MAIN);
    PLACEHOLDER_SECONDARY = mapUrl(PLACEHOLDER_SECONDARY);
    PLACEHOLDER_ICON = mapUrl(PLACEHOLDER_ICON);
    for (var c = 0; c < CATEGORIES.length; c++) {
      for (var s = 0; s < CATEGORIES[c].subs.length; s++) {
        var sub = CATEGORIES[c].subs[s];
        sub.mainImage = mapUrl(sub.mainImage);
        sub.secondaryImage = mapUrl(sub.secondaryImage);
        sub.iconImage = mapUrl(sub.iconImage);
      }
    }
  })();

  var rootEl = document.getElementById("devotel-solutions-root");
  var mainImageEl = document.getElementById("devotel-solutions-main-image");
  var secondaryImageEl = document.getElementById("devotel-solutions-secondary-image");
  var previewPanelEl = document.getElementById("devotel-solutions-preview-panel");
  var codeFallbackEl = document.getElementById("devotel-solutions-code-fallback");
  var subRow = document.getElementById("devotel-solutions-subcategory-icons-row");
  var subPanel = document.getElementById("devotel-solutions-subcategory-panel");
  var tabEls = document.querySelectorAll("[data-devotel-category-index]");
  var tabIndicatorEl = document.getElementById("devotel-solutions-tab-indicator");
  var tabInnerEl = document.querySelector(".devotel-solutions__category-tabs-inner");

  var categoryIndex = 0;
  var subIndex = 0;
  var timerId = null;
  var stripHovered = false;
  var pendingMainFadeToken = 0;
  var pendingSecondaryFadeToken = 0;
  var lastHeroPreloadKey = "";
  var devotelHeroHydrated = false;

  function getCurrentSub() {
    return CATEGORIES[categoryIndex].subs[subIndex];
  }

  function stopTimer() {
    if (timerId) {
      clearInterval(timerId);
      timerId = null;
    }
  }

  function startTimer() {
    stopTimer();
    if (stripHovered) return;
    timerId = setInterval(onTick, heroTiming().rotation);
  }

  function onTick() {
    var next = getNextSubIndices();
    var nextSub = CATEGORIES[next.categoryIndex].subs[next.subIndex];
    preloadSubHeroPair(nextSub);
    categoryIndex = next.categoryIndex;
    subIndex = next.subIndex;
    syncTabs();
    render();
    preloadAdjacentSubs();
  }

  function syncTabs() {
    for (var i = 0; i < tabEls.length; i++) {
      var el = tabEls[i];
      var idx = parseInt(el.getAttribute("data-devotel-category-index"), 10);
      var active = idx === categoryIndex;
      el.setAttribute("aria-selected", active ? "true" : "false");
      el.tabIndex = active ? 0 : -1;
      var labelEl = el.firstElementChild;
      if (active) {
        el.classList.remove("devotel-solutions__category-tab-inactive");
        el.classList.add("devotel-solutions__category-tab-active");
        labelEl.classList.remove("devotel-solutions__category-tab-label-inactive");
        labelEl.classList.add("devotel-solutions__category-tab-label-active");
      } else {
        el.classList.remove("devotel-solutions__category-tab-active");
        el.classList.add("devotel-solutions__category-tab-inactive");
        labelEl.classList.remove("devotel-solutions__category-tab-label-active");
        labelEl.classList.add("devotel-solutions__category-tab-label-inactive");
      }
    }
    syncTabIndicator();
  }

  function syncTabIndicator() {
    if (!tabIndicatorEl || !tabInnerEl) return;
    if (isMobileLayout()) return;

    var activeTab = null;
    for (var i = 0; i < tabEls.length; i++) {
      var idx = parseInt(tabEls[i].getAttribute("data-devotel-category-index"), 10);
      if (idx === categoryIndex) {
        activeTab = tabEls[i];
        break;
      }
    }
    if (!activeTab) return;

    var innerRect = tabInnerEl.getBoundingClientRect();
    var tabRect = activeTab.getBoundingClientRect();
    var x = tabRect.left - innerRect.left;
    var w = tabRect.width;

    tabIndicatorEl.style.width = w + "px";
    tabIndicatorEl.style.transform = "translateX(" + x + "px)";
  }

  var subSlotsBuiltForCategory = -1;

  function buildSubcategoryIconSlots() {
    subRow.innerHTML = "";
    var subs = CATEGORIES[categoryIndex].subs;
    for (var i = 0; i < subs.length; i++) {
      (function (slotIndex) {
        var sub = subs[slotIndex];
        var item = document.createElement("div");
        item.className = "devotel-solutions__subcategory-item";
        if (slotIndex === subIndex) {
          item.classList.add("devotel-solutions__subcategory-item--active");
        }
        item.setAttribute("role", "group");
        item.setAttribute("aria-label", sub.title);

        var slot = document.createElement("div");
        slot.className = "devotel-solutions__subcategory-icon-slot";
        var img = document.createElement("img");
        img.src = sub.iconImage;
        img.alt = "";
        img.loading = "eager";
        img.decoding = "async";
        img.fetchPriority = slotIndex === subIndex ? "high" : "auto";
        img.addEventListener("error", function onIconErr() {
          if (img.getAttribute("data-devotel-src-retry")) return;
          img.setAttribute("data-devotel-src-retry", "1");
          img.removeEventListener("error", onIconErr);
          img.src = bustCacheUrl(sub.iconImage);
        });
        slot.appendChild(img);

        var label = document.createElement("div");
        label.className = "devotel-solutions__subcategory-item-label";
        label.textContent = sub.title;

        item.appendChild(slot);
        item.appendChild(label);

        item.addEventListener("mouseenter", function () {
          subIndex = slotIndex;
          render();
        });
        subRow.appendChild(item);
      })(i);
    }
    subSlotsBuiltForCategory = categoryIndex;
    try {
      var iconUrls = [];
      for (var k = 0; k < subs.length; k++) {
        if (subs[k].iconImage) iconUrls.push(subs[k].iconImage);
      }
      preloadUrls(iconUrls, { maxInflight: 10 });
    } catch (e) {}
  }

  function updateSubcategoryIconActiveStates() {
    var items = subRow.children;
    for (var i = 0; i < items.length; i++) {
      items[i].classList.toggle(
        "devotel-solutions__subcategory-item--active",
        i === subIndex
      );
    }
  }

  function isMobileLayout() {
    return window.matchMedia("(max-width: 768px)").matches;
  }

  function collectHeroImageUrls(categoryOnly) {
    var urls = [];
    var cats = categoryOnly != null ? [CATEGORIES[categoryOnly]] : CATEGORIES;
    for (var c = 0; c < cats.length; c++) {
      var cat = cats[c];
      if (!cat) continue;
      var subs = cat.subs || [];
      for (var s = 0; s < subs.length; s++) {
        var sub = subs[s] || {};
        if (sub.mainImage) urls.push(sub.mainImage);
        if (sub.secondaryImage) urls.push(sub.secondaryImage);
      }
    }
    return urls;
  }

  function collectAllAssetUrls() {
    var urls = [];
    var seen = {};
    function add(u) {
      if (!u || seen[u]) return;
      seen[u] = true;
      urls.push(u);
    }
    for (var c = 0; c < CATEGORIES.length; c++) {
      var subs = (CATEGORIES[c] && CATEGORIES[c].subs) || [];
      for (var s = 0; s < subs.length; s++) {
        var sub = subs[s] || {};
        add(sub.mainImage);
        add(sub.secondaryImage);
        add(sub.iconImage);
      }
    }
    return urls;
  }

  function getNextSubIndices() {
    var cat = CATEGORIES[categoryIndex];
    var nextSub = subIndex + 1;
    var nextCat = categoryIndex;
    if (nextSub >= cat.subs.length) {
      nextSub = 0;
      nextCat = (categoryIndex + 1) % CATEGORIES.length;
    }
    return { categoryIndex: nextCat, subIndex: nextSub };
  }

  function preloadSubHeroPair(sub) {
    if (!sub) return;
    var urls = [];
    if (sub.mainImage) urls.push(sub.mainImage);
    if (sub.secondaryImage) urls.push(sub.secondaryImage);
    preloadUrls(urls, { maxInflight: 12 });
  }

  function preloadAdjacentSubs() {
    try {
      var next = getNextSubIndices();
      var sub = CATEGORIES[next.categoryIndex].subs[next.subIndex];
      preloadSubHeroPair(sub);
    } catch (e) {}
  }

  var devotelPreloadDone = {};

  var devotelPreloadInflight = 0;
  var DEVOTEL_PRELOAD_MAX = 12;

  function preloadUrls(urls, opts) {
    opts = opts || {};
    var maxInflight =
      typeof opts.maxInflight === "number" ? opts.maxInflight : DEVOTEL_PRELOAD_MAX;
    try {
      if (!urls || !urls.length) return;
      var seen = {};
      for (var i = 0; i < urls.length; i++) {
        var u = urls[i];
        if (!u || seen[u] || devotelPreloadDone[u]) continue;
        if (devotelPreloadInflight >= maxInflight) break;
        seen[u] = true;
        devotelPreloadInflight++;
        (function (url) {
          var img = new Image();
          img.decoding = "async";
          if (img.fetchPriority !== undefined) img.fetchPriority = "low";
          function finish() {
            devotelPreloadInflight = Math.max(0, devotelPreloadInflight - 1);
          }
          img.addEventListener(
            "load",
            function () {
              devotelPreloadDone[url] = true;
              finish();
            },
            { once: true }
          );
          img.addEventListener(
            "error",
            function () {
              if (img.getAttribute("data-devotel-preload-retry")) {
                finish();
                return;
              }
              img.setAttribute("data-devotel-preload-retry", "1");
              img.src = bustCacheUrl(url);
            },
            { once: true }
          );
          img.src = url;
        })(u);
      }
    } catch (e) {
      // Ignore preload failures; rendering will still work.
    }
  }

  function preloadCurrentSubImages() {
    try {
      var sub = getCurrentSub();
      var urls = [];
      if (sub && sub.mainImage) urls.push(sub.mainImage);
      if (sub && sub.secondaryImage) urls.push(sub.secondaryImage);
      if (sub && sub.iconImage) urls.push(sub.iconImage);
      preloadUrls(urls, { maxInflight: 12 });
    } catch (e) {}
  }

  /** Warm the active category's hero pairs so rotations do not wait on the network. */
  function preloadCategoryHeroes(catIndex) {
    try {
      preloadUrls(collectHeroImageUrls(catIndex), { maxInflight: 12 });
    } catch (e) {}
  }

  function shouldSkipWarmImageCache() {
    try {
      var c = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
      if (c && c.saveData) return true;
      if (c && /2g/.test(String(c.effectiveType || ""))) return true;
    } catch (e) {}
    return false;
  }

  /**
   * Prefetch all solution assets in parallel batches (skipped on save-data / 2g).
   */
  function scheduleWarmImageCache() {
    var started = false;
    function run() {
      if (started) return;
      started = true;
      if (shouldSkipWarmImageCache()) return;
      var q = collectAllAssetUrls().filter(function (u) {
        return u && !devotelPreloadDone[u];
      });
      var idx = 0;
      var batchSize = 6;
      var batchGapMs = 40;
      function pump() {
        if (idx >= q.length) return;
        var batch = q.slice(idx, idx + batchSize);
        idx += batch.length;
        preloadUrls(batch, { maxInflight: 14 });
        if (idx < q.length) window.setTimeout(pump, batchGapMs);
      }
      pump();
    }
    function kick() {
      if (window.requestIdleCallback) {
        window.requestIdleCallback(run, { timeout: 1200 });
      } else {
        window.setTimeout(run, 200);
      }
    }
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", kick, { once: true });
    } else {
      kick();
    }
  }

  function detachImageReveal(imgEl) {
    if (!imgEl || !imgEl._devotelOnReveal) return;
    var fn = imgEl._devotelOnReveal;
    imgEl.removeEventListener("load", fn);
    imgEl.removeEventListener("error", fn);
    imgEl._devotelOnReveal = null;
    if (imgEl._devotelRevealTimer) {
      clearTimeout(imgEl._devotelRevealTimer);
      imgEl._devotelRevealTimer = null;
    }
  }

  function bustCacheUrl(raw) {
    try {
      var u = new URL(raw, window.location.href);
      u.searchParams.set("duc-retry", String(Date.now()));
      return u.toString();
    } catch (e) {
      return raw + (raw.indexOf("?") >= 0 ? "&" : "?") + "duc-retry=" + Date.now();
    }
  }

  function setImageSrcWithFade(imgEl, nextSrc, nextAlt, tokenKey) {
    if (!imgEl) return;
    if (!nextSrc) return;
    if (imgEl.getAttribute("src") === nextSrc) {
      if (typeof nextAlt === "string") imgEl.alt = nextAlt;
      imgEl.classList.remove(
        "devotel-solutions__image--fade-out",
        "devotel-solutions__image--fade-in"
      );
      return;
    }

    imgEl.removeAttribute("data-devotel-src-retry");

    var currentSrc = imgEl.getAttribute("src");
    var isFirstPaint = !devotelHeroHydrated || !currentSrc;
    var isPreloaded = !!devotelPreloadDone[nextSrc];

    if (isFirstPaint) {
      detachImageReveal(imgEl);
      if (typeof nextAlt === "string") imgEl.alt = nextAlt;
      if (tokenKey === "main" || tokenKey === "secondary") {
        imgEl.fetchPriority = "high";
      }
      imgEl.src = nextSrc;
      imgEl.classList.remove("devotel-solutions__image--fade-out");
      imgEl.classList.add("devotel-solutions__image--fade-in");
      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          imgEl.classList.remove(
            "devotel-solutions__image--fade-in",
            "devotel-solutions__image--animating"
          );
        });
      });
      devotelPreloadDone[nextSrc] = true;
      return;
    }

    detachImageReveal(imgEl);

    var token = tokenKey === "main" ? ++pendingMainFadeToken : ++pendingSecondaryFadeToken;
    var fadeMs = heroTiming().fade;

    function swapAndReveal() {
      if (tokenKey === "main" && token !== pendingMainFadeToken) return;
      if (tokenKey === "secondary" && token !== pendingSecondaryFadeToken) return;

      if (typeof nextAlt === "string") imgEl.alt = nextAlt;
      if (tokenKey === "main") imgEl.fetchPriority = "high";
      if (tokenKey === "secondary") imgEl.fetchPriority = "high";
      imgEl.src = nextSrc;
      imgEl.classList.add("devotel-solutions__image--fade-in");

      var revealed = false;
      function reveal() {
        if (revealed) return;
        if (tokenKey === "main" && token !== pendingMainFadeToken) return;
        if (tokenKey === "secondary" && token !== pendingSecondaryFadeToken) return;
        revealed = true;
        detachImageReveal(imgEl);
        devotelPreloadDone[nextSrc] = true;
        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            imgEl.classList.remove(
              "devotel-solutions__image--fade-out",
              "devotel-solutions__image--fade-in",
              "devotel-solutions__image--animating"
            );
          });
        });
      }

      if (isPreloaded) {
        reveal();
        return;
      }

      var retriedLoad = false;
      function onRevealEvent(ev) {
        if (ev && ev.type === "error" && !retriedLoad) {
          retriedLoad = true;
          if (!imgEl.getAttribute("data-devotel-src-retry")) {
            imgEl.setAttribute("data-devotel-src-retry", "1");
            imgEl.src = bustCacheUrl(nextSrc);
            return;
          }
        }
        reveal();
      }

      imgEl._devotelOnReveal = onRevealEvent;
      imgEl.addEventListener("load", onRevealEvent);
      imgEl.addEventListener("error", onRevealEvent);

      var isSvgAsset = /\.svg(\?|#|$)/i.test(nextSrc);
      if (!isSvgAsset && imgEl.decode && typeof imgEl.decode === "function") {
        imgEl.decode().then(reveal).catch(reveal);
      }

      requestAnimationFrame(function () {
        if (tokenKey === "main" && token !== pendingMainFadeToken) return;
        if (tokenKey === "secondary" && token !== pendingSecondaryFadeToken) return;
        try {
          if (imgEl.complete && (isSvgAsset || imgEl.naturalWidth > 0)) reveal();
        } catch (e) {
          reveal();
        }
      });

      imgEl._devotelRevealTimer = window.setTimeout(function () {
        imgEl._devotelRevealTimer = null;
        reveal();
      }, 12000);
    }

    function afterFadeOut(cb) {
      var settled = false;
      function done() {
        if (settled) return;
        settled = true;
        imgEl.removeEventListener("transitionend", onEnd);
        clearTimeout(fallback);
        cb();
      }
      function onEnd(e) {
        if (e && e.target !== imgEl) return;
        if (e.propertyName && e.propertyName !== "opacity") return;
        done();
      }
      imgEl.addEventListener("transitionend", onEnd);
      var fallback = window.setTimeout(done, fadeMs + 40);
    }

    imgEl.classList.remove("devotel-solutions__image--fade-in");
    imgEl.classList.add("devotel-solutions__image--fade-out", "devotel-solutions__image--animating");
    void imgEl.offsetWidth;
    afterFadeOut(swapAndReveal);
  }

  function render() {
    var sub = getCurrentSub();
    rootEl.classList.toggle("devotel-solutions--sub-esimora", sub.id === "esimora");
    rootEl.classList.toggle("devotel-solutions--sub-devhub", sub.id === "devhub");

    var preloadKey =
      String(sub.mainImage || "") + "|" + String(sub.secondaryImage || "");
    if (preloadKey !== lastHeroPreloadKey) {
      lastHeroPreloadKey = preloadKey;
      preloadSubHeroPair(sub);
      preloadAdjacentSubs();
    }

    setImageSrcWithFade(mainImageEl, sub.mainImage, sub.title, "main");

    if (sub.mainImageObjectFit) {
      mainImageEl.style.objectFit = sub.mainImageObjectFit;
    } else {
      mainImageEl.style.removeProperty("object-fit");
    }
    if (isMobileLayout()) {
      mainImageEl.style.setProperty("object-position", "top center", "important");
      if (typeof sub.mainImageTranslateYMobile === "number") {
        mainImageEl.style.transform =
          "translateY(" + sub.mainImageTranslateYMobile + "px)";
      } else {
        mainImageEl.style.removeProperty("transform");
      }
    } else {
      mainImageEl.style.removeProperty("transform");
      if (sub.mainImageObjectPosition) {
        mainImageEl.style.objectPosition = sub.mainImageObjectPosition;
      } else {
        mainImageEl.style.removeProperty("object-position");
      }
    }

    if (sub.useSecondaryImage) {
      secondaryImageEl.classList.add("devotel-solutions__preview-image--visible");
      codeFallbackEl.classList.add("devotel-solutions__code-window--hidden");
      previewPanelEl.classList.add("devotel-solutions__preview-panel--image-only");
      setImageSrcWithFade(
        secondaryImageEl,
        sub.secondaryImage,
        sub.title + " preview",
        "secondary"
      );
      if (sub.secondaryImageObjectFit) {
        secondaryImageEl.style.objectFit = sub.secondaryImageObjectFit;
      } else {
        secondaryImageEl.style.removeProperty("object-fit");
      }
      if (sub.secondaryImageObjectPosition) {
        secondaryImageEl.style.objectPosition = sub.secondaryImageObjectPosition;
      } else {
        secondaryImageEl.style.removeProperty("object-position");
      }
      /* Desktop: stronger vertical framing; mobile: optional lighter shift (e.g. Esimora). */
      if (isMobileLayout() && typeof sub.secondaryImageTranslateYMobile === "number") {
        secondaryImageEl.style.transform =
          "translateY(" + sub.secondaryImageTranslateYMobile + "px)";
      } else if (!isMobileLayout() && typeof sub.secondaryImageTranslateY === "number") {
        var ty = sub.secondaryImageTranslateY;
        secondaryImageEl.style.transform = "translateY(" + ty + "px)";
      } else {
        secondaryImageEl.style.removeProperty("transform");
      }
    } else {
      detachImageReveal(secondaryImageEl);
      secondaryImageEl.classList.remove("devotel-solutions__preview-image--visible");
      secondaryImageEl.removeAttribute("src");
      secondaryImageEl.style.removeProperty("object-fit");
      secondaryImageEl.style.removeProperty("object-position");
      secondaryImageEl.style.removeProperty("transform");
      codeFallbackEl.classList.remove("devotel-solutions__code-window--hidden");
      previewPanelEl.classList.remove("devotel-solutions__preview-panel--image-only");
    }

    if (subSlotsBuiltForCategory !== categoryIndex) {
      buildSubcategoryIconSlots();
    } else {
      updateSubcategoryIconActiveStates();
    }
  }

  function selectCategory(index) {
    categoryIndex = index;
    subIndex = 0;
    subSlotsBuiltForCategory = -1;
    lastHeroPreloadKey = "";
    preloadCategoryHeroes(categoryIndex);
    syncTabs();
    render();
    startTimer();
  }

  function markDomHeroLoaded() {
    [mainImageEl, secondaryImageEl].forEach(function (img) {
      if (!img) return;
      var src = img.currentSrc || img.getAttribute("src");
      if (!src) return;
      function mark() {
        devotelPreloadDone[src] = true;
      }
      var isSvg = /\.svg(\?|#|$)/i.test(src);
      if (img.complete && (isSvg || img.naturalWidth > 0)) mark();
      else img.addEventListener("load", mark, { once: true });
    });
  }

  for (var t = 0; t < tabEls.length; t++) {
    tabEls[t].addEventListener("click", function (ev) {
      var el = ev.currentTarget;
      var idx = parseInt(el.getAttribute("data-devotel-category-index"), 10);
      selectCategory(idx);
    });
  }

  subPanel.addEventListener("mouseenter", function () {
    stripHovered = true;
    stopTimer();
  });
  subPanel.addEventListener("mouseleave", function () {
    stripHovered = false;
    startTimer();
  });

  preloadCurrentSubImages();
  preloadCategoryHeroes(categoryIndex);
  preloadAdjacentSubs();
  if (!shouldSkipWarmImageCache()) {
    preloadUrls(collectAllAssetUrls(), { maxInflight: 14 });
  }
  scheduleWarmImageCache();

  markDomHeroLoaded();
  syncTabs();
  render();
  devotelHeroHydrated = true;
  startTimer();

  var resizeTimer = null;
  window.addEventListener("resize", function () {
    if (resizeTimer) clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      render();
      syncTabIndicator();
      startTimer();
    }, 120);
  });
})();
