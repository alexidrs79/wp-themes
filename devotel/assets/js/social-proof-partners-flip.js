(function () {
    function escapeRe(s) {
      return s.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }
  
    /**
     * Deep-clone an inline SVG for a second instance in the document.
     * Only rewrite url(#id) and same-document fragment hrefs — never blind
     * "#id" replacement (that corrupts hex colors like #909CAE and breaks masks).
     */
    function uniquifySVG(original) {
      var el = original.cloneNode(true);
      var uid = "x" + Math.random().toString(36).slice(2, 10);
      var map = new Map();
      el.querySelectorAll("[id]").forEach(function (node) {
        var oldId = node.id;
        if (!oldId) return;
        var newId = oldId + "_" + uid;
        map.set(oldId, newId);
        node.id = newId;
      });
      var oldIds = Array.from(map.keys()).sort(function (a, b) {
        return b.length - a.length;
      });
      function rewriteAttrValue(value) {
        if (!value || typeof value !== "string") return value;
        var out = value;
        for (var i = 0; i < oldIds.length; i++) {
          var oldId = oldIds[i];
          var newId = map.get(oldId);
          out = out.replace(
            new RegExp("url\\(#" + escapeRe(oldId) + "\\)", "g"),
            "url(#" + newId + ")"
          );
          out = out.replace(
            new RegExp("url\\('#" + escapeRe(oldId) + "'\\)", "g"),
            "url('#" + newId + "')"
          );
          if (out === "#" + oldId) {
            out = "#" + newId;
          }
        }
        return out;
      }
      el.querySelectorAll("*").forEach(function (node) {
        for (var j = 0; j < node.attributes.length; j++) {
          var attr = node.attributes[j];
          var v = attr.value;
          if (v.indexOf("url(#") === -1 && v.indexOf("#") === -1) continue;
          var nv = rewriteAttrValue(v);
          if (nv !== v) node.setAttribute(attr.name, nv);
        }
      });
      return el;
    }
  
    function whenReady(fn) {
      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", fn);
      } else {
        fn();
      }
    }
  
    function applyRasterDims(target, source) {
      var ref = source || target;
      var nw = ref.naturalWidth;
      var nh = ref.naturalHeight;
      if (nw > 0 && nh > 0) {
        target.setAttribute("width", String(nw));
        target.setAttribute("height", String(nh));
        target.style.removeProperty("width");
        target.style.removeProperty("height");
        return true;
      }
      var w = ref.getAttribute("width");
      var h = ref.getAttribute("height");
      if (w && h) {
        target.setAttribute("width", w);
        target.setAttribute("height", h);
        return true;
      }
      return false;
    }

    function waitAllRasterNodes(nodes, onDone) {
      var imgs = [];
      for (var i = 0; i < nodes.length; i++) {
        if (nodes[i].tagName === "IMG") imgs.push(nodes[i]);
      }
      if (!imgs.length) {
        onDone();
        return;
      }
      var pending = imgs.length;
      var finished = false;
      function finishAll() {
        if (finished) return;
        finished = true;
        onDone();
      }
      window.setTimeout(finishAll, 4000);
      function oneDone() {
        pending--;
        if (pending <= 0) finishAll();
      }
      imgs.forEach(function (im) {
        function afterDecode() {
          applyRasterDims(im);
          oneDone();
        }
        function onLoad() {
          if (im.decode) {
            im.decode().then(afterDecode).catch(afterDecode);
          } else {
            afterDecode();
          }
        }
        if (im.complete) {
          if (im.naturalWidth > 0) onLoad();
          else im.addEventListener("load", onLoad, { once: true });
          im.addEventListener("error", oneDone, { once: true });
        } else {
          im.addEventListener("load", onLoad, { once: true });
          im.addEventListener("error", oneDone, { once: true });
        }
      });
    }

    whenReady(function () {
      var main = document.querySelector(".sp-logo-grid");
      if (!main) return;
      if (window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
      }
      if (main.dataset && main.dataset.spFlipInit === "1") return;
      if (main.dataset) main.dataset.spFlipInit = "1";

      var poolSources = [].slice
        .call(main.querySelectorAll(":scope > svg, :scope > img"))
        .filter(function (el) {
          return /\bsp-grid-logo-\d{2}\b/.test(el.getAttribute("class") || "");
        });
      if (!poolSources.length) return;

      var slotCount = poolSources.length;
      var logoPool = [];
      var cfg = window.devotelPartnerLogos || {};
      var logoNumbers = cfg.logoNumbers;
      if (!logoNumbers || !logoNumbers.length) {
        logoNumbers = [];
        var fallbackN;
        for (fallbackN = 1; fallbackN <= 13; fallbackN++) {
          logoNumbers.push(fallbackN);
        }
        for (fallbackN = 15; fallbackN <= 27; fallbackN++) {
          logoNumbers.push(fallbackN);
        }
      }
      var poolSize = logoNumbers.length;
      if (cfg.uploadsBase) {
        for (var lp = 0; lp < logoNumbers.length; lp++) {
          logoPool.push(
            cfg.uploadsBase + "2026/05/partner-logo-" + logoNumbers[lp] + ".png"
          );
        }
      } else {
        poolSources.forEach(function (el) {
          logoPool.push(el.currentSrc || el.getAttribute("src") || el.src || "");
        });
        poolSize = logoPool.length;
      }
      if (!logoPool.length) return;

      function shuffledPermutation(n) {
        var a = [];
        for (var p = 0; p < n; p++) a.push(p);
        for (var q = n - 1; q > 0; q--) {
          var r = Math.floor(Math.random() * (q + 1));
          var t = a[q];
          a[q] = a[r];
          a[r] = t;
        }
        return a;
      }

      /** Pick `count` unique logo indices from the full partner pool (26 brands, 14 visible slots). */
      function pickDistinctLogoIndices(count) {
        var perm = shuffledPermutation(poolSize);
        return perm.slice(0, Math.min(count, poolSize));
      }
  
      var states = [];
      poolSources.forEach(function (svg) {
        var posClasses = (svg.getAttribute("class") || "").trim();
        var slot = document.createElement("div");
        slot.className = ("sp-flip-slot " + posClasses).trim();
        slot.setAttribute("aria-live", "polite");
        svg.removeAttribute("class");
  
        // Two panels per slot to avoid swapping DOM mid-animation (reduces jank).
        var panelA = document.createElement("div");
        panelA.className = "sp-flip-panel";
        var panelB = document.createElement("div");
        panelB.className = "sp-flip-panel is-sp-flip-hidden is-sp-flip-pre";
  
        var parent = svg.parentNode;
        parent.insertBefore(slot, svg);
        slot.appendChild(panelA);
        slot.appendChild(panelB);
  
        states.push({
          slot: slot,
          panels: [panelA, panelB],
          front: 0,
        });
      });
  
      var n = slotCount;
      function cloneLogo(poolIndex) {
        var url = logoPool[poolIndex];
        if (!url) {
          return document.createElement("img");
        }
        var ref =
          poolIndex < poolSources.length ? poolSources[poolIndex] : poolSources[0];
        var node = document.createElement("img");
        node.setAttribute("src", url);
        node.setAttribute("alt", "Brand partner logo");
        node.decoding = "async";
        node.loading = "eager";
        if (ref && ref.tagName === "IMG") {
          var refUrl = ref.currentSrc || ref.getAttribute("src") || ref.src;
          if (refUrl === url) {
            applyRasterDims(node, ref);
          }
        }
        return node;
      }

      /* First paint: logo N stays in grid cell N (no random shuffle on load). */
      for (var init = 0; init < n; init++) {
        states[init].index = init;
        states[init].panels[states[init].front].appendChild(cloneLogo(init));
      }

      /* Remove pool nodes only after clones are in flip panels (avoids empty grid flash). */
      var hold = document.createDocumentFragment();
      poolSources.forEach(function (svg) {
        hold.appendChild(svg);
      });

      main.classList.add("is-sp-logos-ready");

      waitAllRasterNodes(poolSources, function () {
        for (var ri = 0; ri < n; ri++) {
          var panel = states[ri].panels[states[ri].front];
          var im = panel.querySelector("img");
          if (im) applyRasterDims(im, poolSources[ri]);
        }
      });
  
      function cleanupPanel(panel) {
        panel.classList.remove("is-sp-flip-in");
        panel.classList.remove("is-sp-flip-out");
        panel.classList.add("is-sp-flip-hidden");
        panel.classList.add("is-sp-flip-pre");
      }
  
      function showPanel(panel) {
        panel.classList.remove("is-sp-flip-hidden");
        panel.classList.remove("is-sp-flip-pre");
      }
  
      var waveBusy = false;
      var FLIP_STAGGER_MS = 52;
      var FLIP_DURATION_MS = 520;
      var FLIP_WAVE_GAP_MS = 3200;
  
      /**
       * Same wave (one permutation, no duplicate brands). Each slot swaps and
       * flip-in when its own flip-out finishes so earlier columns never sit empty
       * while waiting for the rest of the cascade.
       */
      function waveFlip() {
        var z;
        if (waveBusy) return;
        for (z = 0; z < n; z++) {
          var s = states[z];
          var p0 = s.panels[0];
          var p1 = s.panels[1];
          if (p0.classList.contains("is-sp-flip-out") || p0.classList.contains("is-sp-flip-in")) return;
          if (p1.classList.contains("is-sp-flip-out") || p1.classList.contains("is-sp-flip-in")) return;
        }
  
        var OUT_STAGGER_MS = FLIP_STAGGER_MS;
        waveBusy = true;
        var next = pickDistinctLogoIndices(n);
        var waveDoneAt = (n - 1) * OUT_STAGGER_MS + FLIP_DURATION_MS + 120;
        setTimeout(function () {
          waveBusy = false;
        }, waveDoneAt);
  
        for (z = 0; z < n; z++) {
          (function (idx) {
            setTimeout(function () {
              var st = states[idx];
              var front = st.panels[st.front];
              var back = st.panels[1 - st.front];
  
              st.index = next[idx];
              // Prepare back panel offscreen (pre state), inject next logo.
              back.replaceChildren(cloneLogo(next[idx]));
              cleanupPanel(back);
              back.classList.remove("is-sp-flip-hidden"); // visible for animation
  
              // Start both animations on next frame (same duration/timing).
              requestAnimationFrame(function () {
                // Incoming plays forward, outgoing plays reverse of same keyframes.
                front.classList.add("is-sp-flip-out");
                back.classList.add("is-sp-flip-in");
                back.classList.remove("is-sp-flip-pre");
  
                var done = 0;
                function onDone(e) {
                  // Ignore bubbled animationend from inner SVG (unlikely but safe).
                  if (e && e.target !== front && e.target !== back) return;
                  done++;
                  if (done < 2) return;
                  front.removeEventListener("animationend", onDone);
                  back.removeEventListener("animationend", onDone);
  
                  // Hide old, keep new as front.
                  cleanupPanel(front);
                  back.classList.remove("is-sp-flip-in");
                  back.classList.remove("is-sp-flip-out");
                  showPanel(back);
                  st.front = 1 - st.front;
                }
                front.addEventListener("animationend", onDone);
                back.addEventListener("animationend", onDone);
  
                // Fallback in case animationend doesn't fire.
                setTimeout(function () {
                  if (done >= 2) return;
                  try {
                    front.removeEventListener("animationend", onDone);
                    back.removeEventListener("animationend", onDone);
                  } catch (e) {}
                  cleanupPanel(front);
                  back.classList.remove("is-sp-flip-in");
                  back.classList.remove("is-sp-flip-out");
                  showPanel(back);
                  st.front = 1 - st.front;
                }, FLIP_DURATION_MS + 80);
              });
            }, idx * OUT_STAGGER_MS);
          })(z);
        }
      }
  
      function scheduleWaves(delay) {
        setTimeout(function tick() {
          waveFlip();
          setTimeout(tick, FLIP_WAVE_GAP_MS);
        }, delay);
      }

      scheduleWaves(900);
    });
  })();
