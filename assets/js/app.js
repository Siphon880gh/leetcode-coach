(function () {
  'use strict';

  function copyText(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      return navigator.clipboard.writeText(text);
    }
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.position = 'absolute';
    ta.style.left = '-9999px';
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    return Promise.resolve();
  }

  function flashCopied(btn) {
    var prev = btn.textContent;
    btn.textContent = 'Copied';
    setTimeout(function () {
      btn.textContent = prev;
    }, 1600);
  }

  document.querySelectorAll('[data-copy-target]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var sel = btn.getAttribute('data-copy-target');
      var el = sel ? document.querySelector(sel) : null;
      if (!el) return;
      var text = el.textContent || '';
      copyText(text.trim()).then(function () {
        flashCopied(btn);
      });
    });
  });

  function fillPromptTemplate(template, values) {
    var out = template;
    Object.keys(values).forEach(function (key) {
      var raw = values[key];
      var filled = raw && String(raw).trim() !== '' ? String(raw).trim() : '___';
      out = out.split('[' + key + ']').join(filled);
    });
    return out;
  }

  document.querySelectorAll('[data-ui-builder]').forEach(function (root) {
    var template = '';
    var keys = [];
    try {
      template = JSON.parse(root.getAttribute('data-prompt') || '""');
    } catch (e) {
      template = '';
    }
    try {
      keys = JSON.parse(root.getAttribute('data-keys') || '[]');
    } catch (e2) {
      keys = [];
    }
    var preview = root.querySelector('[data-ui-builder-preview]');
    var inputs = root.querySelectorAll('[data-ui-builder-key]');

    function refresh() {
      var values = {};
      keys.forEach(function (key) {
        values[key] = '';
      });
      inputs.forEach(function (input) {
        var key = input.getAttribute('data-ui-builder-key');
        if (key) values[key] = input.value || '';
      });
      if (preview) {
        preview.textContent = fillPromptTemplate(template, values);
      }
    }

    inputs.forEach(function (input) {
      input.addEventListener('input', refresh);
    });
    refresh();

    var copyBtn = root.querySelector('[data-ui-builder-copy]');
    if (copyBtn) {
      copyBtn.addEventListener('click', function () {
        var fromSel = copyBtn.getAttribute('data-copy-from');
        var el = fromSel ? root.querySelector(fromSel) || document.querySelector(fromSel) : preview;
        if (!el) return;
        copyText((el.textContent || '').trim()).then(function () {
          flashCopied(copyBtn);
        });
      });
    }
  });

  // Coaching: client history for step-back when using choice links with data attributes
  var coachingRoot = document.getElementById('coaching-session');
  if (coachingRoot) {
    var historyKey = coachingRoot.getAttribute('data-history-key') || 'coaching-history';
    var historyInput = document.getElementById('coaching-history');

    function readHistory() {
      if (historyInput && historyInput.value) {
        try {
          return JSON.parse(historyInput.value);
        } catch (e) {
          return [];
        }
      }
      try {
        return JSON.parse(sessionStorage.getItem(historyKey) || '[]');
      } catch (e2) {
        return [];
      }
    }

    function writeHistory(stack) {
      var json = JSON.stringify(stack);
      if (historyInput) historyInput.value = json;
      sessionStorage.setItem(historyKey, json);
    }

    coachingRoot.querySelectorAll('[data-choice-next]').forEach(function (form) {
      form.addEventListener('submit', function () {
        var next = form.getAttribute('data-choice-next');
        var current = coachingRoot.getAttribute('data-node');
        var stack = readHistory();
        if (current) stack.push(current);
        writeHistory(stack);
        var histField = form.querySelector('input[name="history"]');
        if (histField) histField.value = JSON.stringify(stack);
      });
    });

    var stepBack = document.getElementById('coaching-step-back');
    if (stepBack) {
      stepBack.addEventListener('click', function (e) {
        var stack = readHistory();
        var rewindTo = stepBack.getAttribute('data-rewind-to');
        var target = null;
        if (rewindTo) {
          var idx = stack.lastIndexOf(rewindTo);
          if (idx >= 0) {
            target = rewindTo;
            stack = stack.slice(0, idx);
          } else {
            target = rewindTo;
            stack = [];
          }
        } else if (stack.length) {
          target = stack.pop();
        }
        if (!target) {
          e.preventDefault();
          return;
        }
        writeHistory(stack);
        var url = new URL(stepBack.href);
        url.searchParams.set('node', target);
        url.searchParams.set('history', JSON.stringify(stack));
        stepBack.href = url.toString();
      });
    }
  }

  document.querySelectorAll('[data-pop]').forEach(function (root) {
    var btn = root.querySelector('[data-pop-btn]');
    var panel = root.querySelector('[data-pop-panel]');
    if (!btn || !panel) return;

    function setOpen(open) {
      panel.hidden = !open;
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function closeAll() {
      document.querySelectorAll('[data-pop]').forEach(function (other) {
        var otherBtn = other.querySelector('[data-pop-btn]');
        var otherPanel = other.querySelector('[data-pop-panel]');
        if (otherBtn && otherPanel) {
          otherPanel.hidden = true;
          otherBtn.setAttribute('aria-expanded', 'false');
        }
      });
    }

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var willOpen = panel.hidden;
      closeAll();
      if (willOpen) setOpen(true);
    });

    panel.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    document.addEventListener('click', function () {
      setOpen(false);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeAll();
    });
  });
})();
