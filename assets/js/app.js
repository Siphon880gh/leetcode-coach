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

  var pathAiModal = document.getElementById('coaching-path-ai-modal');
  var pathAiOpen = document.getElementById('coaching-path-ai-open');
  var pathAiPreview = document.getElementById('coaching-path-ai-preview');
  var pathAiCopy = document.getElementById('coaching-path-ai-copy');
  var pathAiDone = document.getElementById('coaching-path-ai-modal-done');
  var pathAiChatgpt = document.getElementById('coaching-path-open-chatgpt');
  var pathAiClaude = document.getElementById('coaching-path-open-claude');
  var pathAiWrap = document.querySelector('[data-path-ai]');
  var pathAiSubtitle = document.getElementById('coaching-path-ai-modal-subtitle');
  var pathAiHint = document.getElementById('coaching-path-ai-hint');
  var pathAiPanel = document.getElementById('coaching-path-ai-panel');
  var pathAiTabs = pathAiModal ? pathAiModal.querySelectorAll('[data-path-ai-tab]') : [];
  var pathAiMode = 'proceed';
  var lastPathAiFocus = null;

  function parsePathAiData() {
    if (!pathAiWrap) return null;
    try {
      return JSON.parse(pathAiWrap.getAttribute('data-path-ai') || 'null');
    } catch (e) {
      return null;
    }
  }

  function pathAiHasAnswered() {
    var data = parsePathAiData();
    if (data && typeof data.answered === 'boolean') return data.answered;
    var steps = data && Array.isArray(data.steps) ? data.steps : [];
    return steps.some(function (step) {
      return step && step.choice;
    });
  }

  function coachingPathAiSideNotes(verb) {
    return 'While you ' + verb + ', add a lot of side notes. Whenever a keyword, concept, data structure, algorithm pattern, or complexity expression shows up — including hash map, two pointers, sliding window, complement, recursion, nested loops, and Big-O such as O(n), O(n²), O(n log n), O(n·k), O(n*m) — pause and explain it in a clearly labeled side note (for example: "Side note — O(n·k): …"). Assume I may not know the term yet. Do not skip jargon. Put each side note right after the sentence that used the term.';
  }

  function coachingPathAiTaskLines(mode) {
    if (mode === 'optimize') {
      return [
        'Task: Tell me how to optimize what I have so far. Stay with the decisions I already made. Point out extra work, weaker complexity, missed pruning, and concrete ways to tighten this same path. Do not throw the work away unless a change is clearly better.',
        '',
        coachingPathAiSideNotes('answer'),
        '',
        'Keep the main story linear (my path only). Reply in plain language, not JSON. Use short sections.'
      ];
    }
    if (mode === 'proceed') {
      return [
        'Task: Answer the entire problem from this point. Start from where I am now and give the complete remaining solution and reasoning — the full answer from here, not a hint or a partial nudge. Cover the approach, why it is correct, and the time and space complexity. Use my path so far as the starting point; do not restart from the beginning unless I have not taken any steps yet.',
        '',
        coachingPathAiSideNotes('answer'),
        '',
        'Reply in plain language, not JSON. Use short sections. Finish the rest of the problem from this point.'
      ];
    }
    return [
      'Task: Explain this path so far in plain English. Walk through what I decided, what each step was doing, and why those decisions matter for the problem.',
      '',
      coachingPathAiSideNotes('explain'),
      '',
      'Keep the main story linear (my path only). Reply in plain language, not JSON. Use short sections.'
    ];
  }

  function buildCoachingPathAiPrompt(data, mode) {
    if (!data || typeof data !== 'object') {
      return '';
    }
    var lines = [];
    var title = data.title ? String(data.title) : 'this step-by-step session';
    lines.push('I am working through a deterministic step-by-step algorithm session in an Algo Learning IDE.');
    lines.push('');
    lines.push('Session: ' + title);
    if (data.topic) lines.push('Topic: ' + String(data.topic));
    if (data.category || data.subcategory) {
      var filing = [data.category, data.subcategory].filter(Boolean).join(' / ');
      if (filing) lines.push('Filed as: ' + filing);
    }
    if (data.summary) lines.push('Summary: ' + String(data.summary));
    if (Array.isArray(data.tags) && data.tags.length) {
      lines.push('Tags: ' + data.tags.join(', '));
    }
    lines.push('');
    lines.push('Here is the path I have taken so far, oldest step first. Each step is a node I visited. "You chose" is the button I clicked to leave that node.');
    lines.push('');

    var steps = Array.isArray(data.steps) ? data.steps : [];
    steps.forEach(function (step, i) {
      if (!step || typeof step !== 'object') return;
      var outcome = step.outcome ? String(step.outcome) : 'continue';
      var head = 'Step ' + (i + 1) + ' — node `' + String(step.id || '') + '` (' + outcome + ')';
      if (step.current) head += ' ← I am here now';
      lines.push(head);
      var message = step.message ? String(step.message).trim() : '';
      lines.push(message !== '' ? message : '(no message)');
      if (step.choice) {
        lines.push('You chose: ' + String(step.choice));
      } else if (!step.current) {
        lines.push('Continued without a labeled choice.');
      }
      if (outcome === 'wrong' && step.rewind_to) {
        lines.push('Wrong turn — session says step back to node `' + String(step.rewind_to) + '`.');
      }
      lines.push('');
    });

    if (Array.isArray(data.open_choices) && data.open_choices.length) {
      lines.push('Choices still on the current node (I have not picked the next one yet):');
      data.open_choices.forEach(function (choice) {
        lines.push('- ' + String(choice));
      });
      lines.push('');
    }

    if (data.outcome === 'wrong' && data.rewind_to) {
      lines.push('I am on a wrong-turn leaf. The session tells me to step back to node `' + String(data.rewind_to) + '`.');
      lines.push('');
    } else if (data.outcome === 'success') {
      lines.push('I reached a success leaf.');
      lines.push('');
    }

    return lines.concat(coachingPathAiTaskLines(mode)).join('\n');
  }

  function currentCoachingPathAiPrompt() {
    return buildCoachingPathAiPrompt(parsePathAiData(), pathAiMode);
  }

  function syncCoachingPathAiTabAvailability() {
    var answered = pathAiHasAnswered();
    pathAiTabs.forEach(function (tab) {
      var mode = tab.getAttribute('data-path-ai-tab');
      var needsAnswer = mode === 'explain' || mode === 'optimize';
      tab.disabled = needsAnswer && !answered;
      if (tab.disabled) {
        tab.setAttribute('title', 'Answer a step first');
      } else {
        tab.removeAttribute('title');
      }
    });
    return answered;
  }

  function selectCoachingPathAiTab(mode) {
    var answered = syncCoachingPathAiTabAvailability();
    if ((mode === 'explain' || mode === 'optimize') && !answered) {
      mode = 'proceed';
    }
    if (mode !== 'explain' && mode !== 'optimize' && mode !== 'proceed') {
      mode = answered ? 'explain' : 'proceed';
    }
    pathAiMode = mode;
    pathAiTabs.forEach(function (tab) {
      var id = tab.getAttribute('data-path-ai-tab');
      var selected = id === mode;
      tab.setAttribute('aria-selected', selected ? 'true' : 'false');
      tab.tabIndex = selected ? 0 : -1;
      if (selected) {
        if (pathAiSubtitle && tab.getAttribute('data-subtitle')) {
          pathAiSubtitle.textContent = tab.getAttribute('data-subtitle');
        }
        if (pathAiHint && tab.getAttribute('data-hint')) {
          pathAiHint.textContent = tab.getAttribute('data-hint');
        }
        if (pathAiPanel) {
          pathAiPanel.setAttribute('aria-labelledby', tab.id);
        }
      }
    });
    if (pathAiPreview) {
      pathAiPreview.textContent = currentCoachingPathAiPrompt();
    }
  }

  function setCoachingPathAiModalOpen(open) {
    if (!pathAiModal) return;
    pathAiModal.hidden = !open;
    document.body.classList.toggle('modal-open', open);
    if (pathAiOpen) {
      pathAiOpen.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    if (open) {
      selectCoachingPathAiTab(pathAiHasAnswered() ? 'explain' : 'proceed');
      var panel = pathAiModal.querySelector('.modal__panel');
      if (panel && typeof panel.focus === 'function') {
        if (!panel.hasAttribute('tabindex')) panel.setAttribute('tabindex', '-1');
        panel.focus();
      }
    } else if (lastPathAiFocus && typeof lastPathAiFocus.focus === 'function') {
      lastPathAiFocus.focus();
    }
  }

  function copyCoachingPathAiPrompt(done) {
    copyText(currentCoachingPathAiPrompt()).then(function () {
      if (typeof done === 'function') done();
    }).catch(function () {
      if (typeof done === 'function') done();
    });
  }

  function openCoachingPathAiService(url) {
    copyCoachingPathAiPrompt(function () {
      window.open(url, '_blank', 'noopener,noreferrer');
    });
  }

  if (pathAiOpen && pathAiModal) {
    pathAiOpen.setAttribute('aria-expanded', 'false');
    pathAiOpen.addEventListener('click', function () {
      lastPathAiFocus = pathAiOpen;
      setCoachingPathAiModalOpen(true);
    });
  }

  if (pathAiModal) {
    var pathAiBackdrop = pathAiModal.querySelector('[data-action="close-coaching-path-ai-modal"]');
    if (pathAiBackdrop) {
      pathAiBackdrop.addEventListener('click', function () {
        setCoachingPathAiModalOpen(false);
      });
    }
    pathAiModal.addEventListener('click', function (e) {
      var tab = e.target.closest('[data-path-ai-tab]');
      if (!tab || tab.disabled || !pathAiModal.contains(tab)) return;
      selectCoachingPathAiTab(tab.getAttribute('data-path-ai-tab'));
    });
    var pathAiTablist = pathAiModal.querySelector('.coaching-path-ai-tabs');
    if (pathAiTablist) {
      pathAiTablist.addEventListener('keydown', function (e) {
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight' && e.key !== 'Home' && e.key !== 'End') {
          return;
        }
        var tab = e.target.closest('[data-path-ai-tab]');
        if (!tab) return;
        var enabled = [];
        pathAiTabs.forEach(function (item) {
          if (!item.disabled) enabled.push(item);
        });
        if (!enabled.length) return;
        var i = enabled.indexOf(tab);
        var next = null;
        if (e.key === 'Home') next = enabled[0];
        else if (e.key === 'End') next = enabled[enabled.length - 1];
        else if (e.key === 'ArrowRight') next = enabled[i < 0 ? 0 : (i + 1) % enabled.length];
        else next = enabled[i < 0 ? enabled.length - 1 : (i - 1 + enabled.length) % enabled.length];
        e.preventDefault();
        selectCoachingPathAiTab(next.getAttribute('data-path-ai-tab'));
        next.focus();
      });
    }
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && pathAiModal && !pathAiModal.hidden) {
        e.preventDefault();
        setCoachingPathAiModalOpen(false);
      }
    });
  }

  if (pathAiDone) {
    pathAiDone.addEventListener('click', function () {
      setCoachingPathAiModalOpen(false);
    });
  }

  if (pathAiCopy) {
    pathAiCopy.addEventListener('click', function () {
      copyCoachingPathAiPrompt(function () {
        flashCopied(pathAiCopy);
      });
    });
  }

  if (pathAiChatgpt) {
    pathAiChatgpt.addEventListener('click', function (e) {
      e.preventDefault();
      openCoachingPathAiService(pathAiChatgpt.href || 'https://chatgpt.com/');
    });
  }

  if (pathAiClaude) {
    pathAiClaude.addEventListener('click', function (e) {
      e.preventDefault();
      openCoachingPathAiService(pathAiClaude.href || 'https://claude.ai/new');
    });
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
