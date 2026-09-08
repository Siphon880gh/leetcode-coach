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

  var USER_TAG_LS_LEGACY = 'algos-user-tags-v1';
  var USER_TAG_DB = 'algos';
  var USER_TAG_DB_VERSION = 1;
  var USER_TAG_PRESETS = [
    { id: 'extreme', label: 'Need extreme review', color: '#c23a2b' },
    { id: 'much', label: 'Need much review', color: '#d97706' },
    { id: 'unsure', label: 'Unsure if need review or that it sticks', color: '#7c3aed' },
    { id: 'pass', label: 'Confident Pass', color: '#166534' }
  ];

  /*
   * IndexedDB `algos` — object stores shaped like MySQL tables:
   *   users(id PK AUTO_INCREMENT, name)
   *   tags(id PK AUTO_INCREMENT, user_id FK, name, color, is_preset, slug, sort_order)
   *   resource_tags(id PK AUTO_INCREMENT, user_id FK, resource_key, tag_id FK)
   *   tag_filters(id PK AUTO_INCREMENT, user_id FK, section, tag_id FK)
   * Seed: one users row, name = 'Local'
   */

  function idbReq(req) {
    return new Promise(function (resolve, reject) {
      req.onsuccess = function () {
        resolve(req.result);
      };
      req.onerror = function () {
        reject(req.error);
      };
    });
  }

  function txDone(tx) {
    return new Promise(function (resolve, reject) {
      tx.oncomplete = function () {
        resolve();
      };
      tx.onerror = function () {
        reject(tx.error);
      };
      tx.onabort = function () {
        reject(tx.error);
      };
    });
  }

  function openAlgoDb() {
    return new Promise(function (resolve, reject) {
      var req = indexedDB.open(USER_TAG_DB, USER_TAG_DB_VERSION);
      req.onupgradeneeded = function () {
        var db = req.result;
        var users;
        var tags;
        var resourceTags;
        var tagFilters;
        if (!db.objectStoreNames.contains('users')) {
          users = db.createObjectStore('users', { keyPath: 'id', autoIncrement: true });
          users.createIndex('name', 'name', { unique: true });
        }
        if (!db.objectStoreNames.contains('tags')) {
          tags = db.createObjectStore('tags', { keyPath: 'id', autoIncrement: true });
          tags.createIndex('user_id', 'user_id', { unique: false });
        }
        if (!db.objectStoreNames.contains('resource_tags')) {
          resourceTags = db.createObjectStore('resource_tags', { keyPath: 'id', autoIncrement: true });
          resourceTags.createIndex('user_id', 'user_id', { unique: false });
          resourceTags.createIndex('user_resource', ['user_id', 'resource_key'], { unique: false });
          resourceTags.createIndex('user_resource_tag', ['user_id', 'resource_key', 'tag_id'], { unique: true });
        }
        if (!db.objectStoreNames.contains('tag_filters')) {
          tagFilters = db.createObjectStore('tag_filters', { keyPath: 'id', autoIncrement: true });
          tagFilters.createIndex('user_id', 'user_id', { unique: false });
          tagFilters.createIndex('user_section_tag', ['user_id', 'section', 'tag_id'], { unique: true });
        }
      };
      req.onsuccess = function () {
        resolve(req.result);
      };
      req.onerror = function () {
        reject(req.error);
      };
    });
  }

  function readLegacyTagState() {
    try {
      var raw = JSON.parse(localStorage.getItem(USER_TAG_LS_LEGACY) || 'null');
      if (!raw || typeof raw !== 'object') return null;
      return raw;
    } catch (e) {
      return null;
    }
  }

  function ensureLocalUser(db) {
    var tx = db.transaction(['users'], 'readonly');
    return idbReq(tx.objectStore('users').getAll()).then(function (rows) {
      var i;
      for (i = 0; i < (rows || []).length; i++) {
        if (rows[i].name === 'Local') return rows[i];
      }
      var wtx = db.transaction(['users'], 'readwrite');
      return idbReq(wtx.objectStore('users').add({ name: 'Local' })).then(function (id) {
        return txDone(wtx).then(function () {
          return { id: id, name: 'Local' };
        });
      });
    });
  }

  function ensurePresetTags(db, user) {
    var tx = db.transaction(['tags'], 'readonly');
    return idbReq(tx.objectStore('tags').index('user_id').getAll(user.id)).then(function (rows) {
      var havePreset = (rows || []).some(function (row) {
        return row.is_preset === 1;
      });
      if (havePreset) return;
      var wtx = db.transaction(['tags'], 'readwrite');
      var store = wtx.objectStore('tags');
      USER_TAG_PRESETS.forEach(function (preset, i) {
        store.add({
          user_id: user.id,
          name: preset.label,
          color: preset.color,
          is_preset: 1,
          slug: preset.id,
          sort_order: i
        });
      });
      return txDone(wtx);
    });
  }

  function loadUserTagState(db, user) {
    var tx = db.transaction(['tags', 'resource_tags', 'tag_filters'], 'readonly');
    return Promise.all([
      idbReq(tx.objectStore('tags').index('user_id').getAll(user.id)),
      idbReq(tx.objectStore('resource_tags').index('user_id').getAll(user.id)),
      idbReq(tx.objectStore('tag_filters').index('user_id').getAll(user.id))
    ]).then(function (parts) {
      return {
        user: user,
        tags: parts[0] || [],
        resourceTags: parts[1] || [],
        tagFilters: parts[2] || []
      };
    });
  }

  function migrateLegacyTags(db, user) {
    var legacy = readLegacyTagState();
    if (!legacy) return Promise.resolve();
    return loadUserTagState(db, user).then(function (state) {
      var slugToId = {};
      var nameToId = {};
      var customMap = legacy.custom && typeof legacy.custom === 'object' ? legacy.custom : {};
      var customIds = Object.keys(customMap);
      var presetColors = legacy.presetColors && typeof legacy.presetColors === 'object' ? legacy.presetColors : {};
      var oldToNew = {};

      state.tags.forEach(function (row) {
        if (row.slug) slugToId[row.slug] = row.id;
        nameToId[String(row.name).trim().toLowerCase()] = row.id;
      });

      function addCustomAt(i) {
        if (i >= customIds.length) return Promise.resolve();
        var oldId = customIds[i];
        var spec = customMap[oldId] || {};
        var label = String(spec.label || oldId.replace(/^c:/, '')).trim();
        if (!label) return addCustomAt(i + 1);
        var want = label.toLowerCase();
        if (nameToId[want]) {
          oldToNew[oldId] = nameToId[want];
          return addCustomAt(i + 1);
        }
        var wtx = db.transaction(['tags'], 'readwrite');
        var row = {
          user_id: user.id,
          name: label,
          color: hexColor(spec.color, '#0d6e6e'),
          is_preset: 0,
          slug: null,
          sort_order: 100 + i
        };
        return idbReq(wtx.objectStore('tags').add(row)).then(function (id) {
          oldToNew[oldId] = id;
          nameToId[want] = id;
          return txDone(wtx);
        }).then(function () {
          return addCustomAt(i + 1);
        });
      }

      function mapOldId(oldId) {
        if (slugToId[oldId]) return slugToId[oldId];
        if (oldToNew[oldId]) return oldToNew[oldId];
        return null;
      }

      return addCustomAt(0).then(function () {
        var colorTx = db.transaction(['tags'], 'readwrite');
        var tagStore = colorTx.objectStore('tags');
        state.tags.forEach(function (row) {
          if (row.slug && presetColors[row.slug]) {
            row.color = hexColor(presetColors[row.slug], row.color);
            tagStore.put(row);
          }
        });
        return txDone(colorTx);
      }).then(function () {
        var byResource = legacy.byResource && typeof legacy.byResource === 'object' ? legacy.byResource : {};
        var rtx = db.transaction(['resource_tags'], 'readwrite');
        var rstore = rtx.objectStore('resource_tags');
        Object.keys(byResource).forEach(function (key) {
          var ids = Array.isArray(byResource[key]) ? byResource[key] : [];
          ids.forEach(function (oldId) {
            var tagId = mapOldId(oldId);
            if (!tagId) return;
            rstore.add({
              user_id: user.id,
              resource_key: key,
              tag_id: tagId
            });
          });
        });
        return txDone(rtx);
      }).then(function () {
        var filter = legacy.filter && typeof legacy.filter === 'object' ? legacy.filter : {};
        var ftx = db.transaction(['tag_filters'], 'readwrite');
        var fstore = ftx.objectStore('tag_filters');
        Object.keys(filter).forEach(function (section) {
          var ids = Array.isArray(filter[section]) ? filter[section] : [];
          ids.forEach(function (oldId) {
            var tagId = mapOldId(oldId);
            if (!tagId) return;
            fstore.add({
              user_id: user.id,
              section: section,
              tag_id: tagId
            });
          });
        });
        return txDone(ftx);
      }).then(function () {
        try {
          localStorage.removeItem(USER_TAG_LS_LEGACY);
        } catch (e2) {}
      });
    });
  }

  function bootUserTags() {
    return openAlgoDb().then(function (db) {
      return ensureLocalUser(db).then(function (user) {
        return ensurePresetTags(db, user).then(function () {
          return migrateLegacyTags(db, user).then(function () {
            return loadUserTagState(db, user).then(function (state) {
              return { db: db, state: state };
            });
          });
        });
      });
    });
  }

  function hexColor(value, fallback) {
    var raw = String(value || '').trim();
    if (/^#[0-9a-fA-F]{6}$/.test(raw)) return raw.toLowerCase();
    if (/^#[0-9a-fA-F]{3}$/.test(raw)) {
      return ('#' + raw.charAt(1) + raw.charAt(1) + raw.charAt(2) + raw.charAt(2) + raw.charAt(3) + raw.charAt(3)).toLowerCase();
    }
    return fallback || '#0d6e6e';
  }

  function inkForBg(hex) {
    var h = hexColor(hex, '#0d6e6e').slice(1);
    var r = parseInt(h.slice(0, 2), 16) / 255;
    var g = parseInt(h.slice(2, 4), 16) / 255;
    var b = parseInt(h.slice(4, 6), 16) / 255;
    var l = 0.2126 * r + 0.7152 * g + 0.0722 * b;
    return l > 0.55 ? '#1a1f24' : '#f4f1ea';
  }

  function cssEscape(id) {
    if (window.CSS && CSS.escape) return CSS.escape(id);
    return String(id).replace(/[^a-zA-Z0-9_-]/g, '\\$&');
  }

  function tagById(state, id) {
    var want = Number(id);
    var i;
    for (i = 0; i < state.tags.length; i++) {
      if (Number(state.tags[i].id) === want) return state.tags[i];
    }
    return null;
  }

  function catalog(state) {
    return state.tags.slice().sort(function (a, b) {
      if (a.is_preset !== b.is_preset) return b.is_preset - a.is_preset;
      if (a.is_preset) return (a.sort_order || 0) - (b.sort_order || 0);
      return String(a.name).localeCompare(String(b.name));
    }).map(function (row) {
      return {
        id: Number(row.id),
        label: String(row.name),
        color: hexColor(row.color, '#0d6e6e'),
        preset: row.is_preset === 1
      };
    });
  }

  function resourceTagIds(state, key) {
    var ids = [];
    state.resourceTags.forEach(function (row) {
      if (row.resource_key === key) ids.push(Number(row.tag_id));
    });
    return ids;
  }

  function filterTagIds(state, section) {
    var ids = [];
    state.tagFilters.forEach(function (row) {
      if (row.section === section) ids.push(Number(row.tag_id));
    });
    return ids;
  }

  function findResourceTagRow(state, key, tagId) {
    var want = Number(tagId);
    var i;
    for (i = 0; i < state.resourceTags.length; i++) {
      if (state.resourceTags[i].resource_key === key && Number(state.resourceTags[i].tag_id) === want) {
        return state.resourceTags[i];
      }
    }
    return null;
  }

  function findFilterRow(state, section, tagId) {
    var want = Number(tagId);
    var i;
    for (i = 0; i < state.tagFilters.length; i++) {
      if (state.tagFilters[i].section === section && Number(state.tagFilters[i].tag_id) === want) {
        return state.tagFilters[i];
      }
    }
    return null;
  }

  function confirmRemoveTag(name) {
    return window.confirm('Remove tag "' + name + '"?');
  }

  function toggleResourceTag(db, state, key, tagId) {
    var existing = findResourceTagRow(state, key, tagId);
    var tx = db.transaction(['resource_tags'], 'readwrite');
    var store = tx.objectStore('resource_tags');
    var done = txDone(tx);
    if (existing) {
      return idbReq(store.delete(existing.id)).then(function () {
        state.resourceTags = state.resourceTags.filter(function (row) {
          return row.id !== existing.id;
        });
        return done;
      });
    }
    var row = {
      user_id: state.user.id,
      resource_key: key,
      tag_id: Number(tagId)
    };
    return idbReq(store.add(row)).then(function (id) {
      row.id = id;
      state.resourceTags.push(row);
      return done;
    });
  }

  function applyResourceTag(db, state, key, tagId) {
    if (findResourceTagRow(state, key, tagId)) return Promise.resolve();
    return toggleResourceTag(db, state, key, tagId);
  }

  function addCustomTag(db, state, label, color) {
    var want = String(label).trim().toLowerCase();
    var existing = null;
    var maxSort = 0;
    state.tags.forEach(function (row) {
      if (String(row.name).trim().toLowerCase() === want) existing = row;
      if ((row.sort_order || 0) > maxSort) maxSort = row.sort_order || 0;
    });
    if (existing) {
      if (existing.is_preset !== 1) {
        return updateTagColor(db, state, existing.id, color).then(function () {
          return existing.id;
        });
      }
      return Promise.resolve(existing.id);
    }
    var row = {
      user_id: state.user.id,
      name: String(label).trim(),
      color: hexColor(color, '#0d6e6e'),
      is_preset: 0,
      slug: null,
      sort_order: maxSort + 1
    };
    var tx = db.transaction(['tags'], 'readwrite');
    var done = txDone(tx);
    return idbReq(tx.objectStore('tags').add(row)).then(function (id) {
      row.id = id;
      state.tags.push(row);
      return done.then(function () {
        return id;
      });
    });
  }

  function updateTagColor(db, state, id, color) {
    var row = tagById(state, id);
    if (!row) return Promise.resolve();
    row.color = hexColor(color, row.color);
    var tx = db.transaction(['tags'], 'readwrite');
    var done = txDone(tx);
    return idbReq(tx.objectStore('tags').put(row)).then(function () {
      return done;
    });
  }

  function clearSectionTagFilters(db, state, section) {
    var rows = state.tagFilters.filter(function (row) {
      return row.section === section;
    });
    if (!rows.length) return Promise.resolve();
    var tx = db.transaction(['tag_filters'], 'readwrite');
    var store = tx.objectStore('tag_filters');
    var done = txDone(tx);
    rows.forEach(function (row) {
      store.delete(row.id);
    });
    state.tagFilters = state.tagFilters.filter(function (row) {
      return row.section !== section;
    });
    return done;
  }

  function toggleFilterTag(db, state, section, tagId) {
    var existing = findFilterRow(state, section, tagId);
    var tx = db.transaction(['tag_filters'], 'readwrite');
    var store = tx.objectStore('tag_filters');
    var done = txDone(tx);
    if (existing) {
      return idbReq(store.delete(existing.id)).then(function () {
        state.tagFilters = state.tagFilters.filter(function (row) {
          return row.id !== existing.id;
        });
        return done;
      });
    }
    var row = {
      user_id: state.user.id,
      section: section,
      tag_id: Number(tagId)
    };
    return idbReq(store.add(row)).then(function (id) {
      row.id = id;
      state.tagFilters.push(row);
      return done;
    });
  }

  function closeUserTagPickers(except) {
    document.querySelectorAll('[data-user-tag-picker]').forEach(function (picker) {
      if (except && picker === except) return;
      picker.hidden = true;
      var open = picker.parentNode && picker.parentNode.querySelector('[data-user-tag-open]');
      if (open) open.setAttribute('aria-expanded', 'false');
    });
  }

  function initUserTags() {
    var root = document.querySelector('[data-user-tags-root]');
    if (!root) return;

    var section = root.getAttribute('data-user-tag-section') || 'guides';
    var filterList = root.querySelector('[data-user-tag-filters]');
    var tiles = root.querySelectorAll('[data-user-tag-resource]');
    var tagsRoot = root.querySelector('[data-filter-tags]');
    var tagsBtn = root.querySelector('[data-filter-tags-btn]');
    var tagsPanel = root.querySelector('[data-filter-tags-panel]');

    function setTagsOpen(open) {
      if (!tagsBtn || !tagsPanel) return;
      if (!open && tagsRoot) tagsRoot.classList.remove('is-pinned');
      tagsPanel.hidden = !open;
      tagsBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    bootUserTags().then(function (boot) {
      var db = boot.db;
      var state = boot.state;

      function applyFilterVisibility() {
        root._filterTagIds = filterTagIds(state, section);
        root._resourceTagIdsFor = function (key) {
          return resourceTagIds(state, key);
        };
        applyBrowseTileFilters(root);
      }

      root._applyResourceFilter = applyFilterVisibility;
      root._clearTagFilters = function () {
        return clearSectionTagFilters(db, state, section);
      };
      root._renderTagFilters = function () {
        renderFilters();
      };
      bindFilterClear(root);

      function renderApplied(tile) {
        var key = tile.getAttribute('data-user-tag-resource');
        var wrap = tile.querySelector('[data-user-tags-applied]');
        if (!wrap || !key) return;
        wrap.textContent = '';
        resourceTagIds(state, key).forEach(function (id) {
          var row = tagById(state, id);
          if (!row) return;
          var chip = document.createElement('button');
          chip.type = 'button';
          chip.className = 'user-tag';
          chip.setAttribute('data-tag-id', String(id));
          chip.textContent = row.name;
          chip.setAttribute('aria-label', 'Remove tag ' + row.name);
          chip.style.background = hexColor(row.color, '#0d6e6e');
          chip.style.color = inkForBg(row.color);
          chip.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (!confirmRemoveTag(row.name)) return;
            toggleResourceTag(db, state, key, id).then(renderAll);
          });
          wrap.appendChild(chip);
        });
      }

      function appendChoice(picker, tileKey, def, applied) {
        var btn = document.createElement('button');
        var on = applied.indexOf(def.id) >= 0;
        btn.type = 'button';
        btn.className = 'user-tag-choice' + (on ? ' is-on' : '');
        btn.setAttribute('aria-pressed', on ? 'true' : 'false');
        var swatch = document.createElement('span');
        swatch.className = 'user-tag-choice__swatch';
        swatch.setAttribute('data-tag-id', String(def.id));
        swatch.style.background = def.color;
        var name = document.createElement('span');
        name.textContent = def.label;
        btn.appendChild(swatch);
        btn.appendChild(name);
        if (on) {
          var mark = document.createElement('span');
          mark.className = 'user-tag-choice__mark';
          mark.textContent = '✓';
          mark.setAttribute('aria-hidden', 'true');
          btn.appendChild(mark);
        }
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          if (on && !confirmRemoveTag(def.label)) return;
          toggleResourceTag(db, state, tileKey, def.id).then(renderAll);
        });
        picker.appendChild(btn);
      }

      function renderPicker(tile) {
        var key = tile.getAttribute('data-user-tag-resource');
        var picker = tile.querySelector('[data-user-tag-picker]');
        if (!picker || !key) return;
        picker.textContent = '';
        var applied = resourceTagIds(state, key);
        var defs = catalog(state);
        var presetCount = 0;
        defs.forEach(function (def) {
          if (def.preset) presetCount += 1;
        });
        defs.forEach(function (def, index) {
          if (index === presetCount) {
            var split = document.createElement('hr');
            split.className = 'user-tag-picker__rule';
            picker.appendChild(split);
          }
          appendChoice(picker, key, def, applied);
        });
        var rule = document.createElement('hr');
        rule.className = 'user-tag-picker__rule';
        picker.appendChild(rule);
        var form = document.createElement('form');
        form.className = 'user-tag-new';
        var nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.maxLength = 48;
        nameInput.required = true;
        nameInput.placeholder = 'New tag';
        nameInput.setAttribute('aria-label', 'New tag name');
        var colorInput = document.createElement('input');
        colorInput.type = 'color';
        colorInput.className = 'user-tag-swatch';
        colorInput.value = '#0d6e6e';
        colorInput.setAttribute('aria-label', 'New tag color');
        var addBtn = document.createElement('button');
        addBtn.type = 'submit';
        addBtn.textContent = 'Add';
        form.appendChild(nameInput);
        form.appendChild(colorInput);
        form.appendChild(addBtn);
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var label = nameInput.value.trim();
          if (!label) return;
          addCustomTag(db, state, label, colorInput.value).then(function (id) {
            return applyResourceTag(db, state, key, id);
          }).then(renderAll);
        });
        picker.appendChild(form);
      }

      function paintTagColor(id, next) {
        var ink = inkForBg(next);
        root.querySelectorAll('[data-tag-id="' + cssEscape(String(id)) + '"]').forEach(function (el) {
          if (el.classList.contains('user-tag')) {
            el.style.background = next;
            el.style.color = ink;
          } else if (el.classList.contains('user-tag-choice__swatch')) {
            el.style.background = next;
          } else if (el.classList.contains('user-tag-swatch') && el.tagName === 'INPUT' && el !== document.activeElement) {
            el.value = next;
          }
        });
      }

      function renderFilters() {
        if (!filterList) return;
        filterList.textContent = '';
        var selected = filterTagIds(state, section);
        catalog(state).forEach(function (def) {
          var row = document.createElement('li');
          row.className = 'user-tag-filter-row';
          var wrap = document.createElement('div');
          wrap.className = 'filter-tag' + (selected.indexOf(def.id) >= 0 ? ' is-current' : '');
          var swatchWrap = document.createElement('span');
          swatchWrap.className = 'user-tag-swatch-wrap';
          var swatch = document.createElement('input');
          swatch.type = 'color';
          swatch.className = 'user-tag-swatch';
          swatch.value = hexColor(def.color, '#0d6e6e');
          swatch.setAttribute('data-tag-id', String(def.id));
          swatch.setAttribute('aria-label', 'Change color for ' + def.label);
          swatch.addEventListener('click', function (e) {
            e.stopPropagation();
          });
          swatch.addEventListener('mousedown', function (e) {
            e.stopPropagation();
          });
          swatch.addEventListener('input', function (e) {
            e.stopPropagation();
            var next = hexColor(swatch.value, def.color);
            updateTagColor(db, state, def.id, next).then(function () {
              paintTagColor(def.id, next);
            });
          });
          swatchWrap.appendChild(swatch);
          var opt = document.createElement('button');
          opt.type = 'button';
          opt.className = 'filter-tag__label';
          opt.setAttribute('aria-pressed', selected.indexOf(def.id) >= 0 ? 'true' : 'false');
          opt.textContent = def.label;
          opt.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleFilterTag(db, state, section, def.id).then(function () {
              renderFilters();
              applyFilterVisibility();
            });
          });
          wrap.appendChild(swatchWrap);
          wrap.appendChild(opt);
          row.appendChild(wrap);
          filterList.appendChild(row);
        });
      }

      function renderAll() {
        tiles.forEach(function (tile) {
          renderApplied(tile);
          var picker = tile.querySelector('[data-user-tag-picker]');
          if (picker && !picker.hidden) renderPicker(tile);
        });
        renderFilters();
        applyFilterVisibility();
      }

      tiles.forEach(function (tile) {
        var openBtn = tile.querySelector('[data-user-tag-open]');
        var picker = tile.querySelector('[data-user-tag-picker]');
        if (!openBtn || !picker) return;
        openBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var willOpen = picker.hidden;
          closeUserTagPickers();
          if (willOpen) {
            renderPicker(tile);
            picker.hidden = false;
            openBtn.setAttribute('aria-expanded', 'true');
          }
        });
        picker.addEventListener('click', function (e) {
          e.stopPropagation();
        });
      });

      if (tagsRoot && tagsBtn && tagsPanel) {
        tagsRoot.addEventListener('mouseenter', function () {
          closeFilterCompaniesFlyout(root, true);
          setTagsOpen(true);
        });
        tagsRoot.addEventListener('mouseleave', function () {
          if (!tagsRoot.classList.contains('is-pinned')) setTagsOpen(false);
        });
        tagsBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          if (tagsPanel.hidden) {
            tagsRoot.classList.add('is-pinned');
            setTagsOpen(true);
          } else if (tagsRoot.classList.contains('is-pinned')) {
            setTagsOpen(false);
          } else {
            tagsRoot.classList.add('is-pinned');
            setTagsOpen(true);
          }
        });
        tagsPanel.addEventListener('click', function (e) {
          e.stopPropagation();
        });
      }

      document.addEventListener('click', function () {
        closeUserTagPickers();
        setTagsOpen(false);
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeUserTagPickers();
      });

      renderAll();
    });
  }

  initUserTags();

  var BROWSE_SORT_MODES = ['usual', 'az', 'za', 'lc', 'lcdesc'];
  var BROWSE_PERSIST_PREFIX = 'algos-browse-state-v1:';

  function browsePersistKey() {
    var path = String(window.location.pathname || '').replace(/\/+$/, '') || '/';
    var kind = '';
    try {
      kind = new URLSearchParams(window.location.search).get('kind') || '';
    } catch (err) {}
    return BROWSE_PERSIST_PREFIX + path + (kind ? '?kind=' + kind : '');
  }

  function readBrowsePersist() {
    try {
      var raw = JSON.parse(localStorage.getItem(browsePersistKey()) || 'null');
      if (!raw || typeof raw !== 'object') return { sort: 'usual', q: '' };
      var sort = raw.sort;
      if (BROWSE_SORT_MODES.indexOf(sort) < 0) sort = 'usual';
      var q = typeof raw.q === 'string' ? raw.q : '';
      return { sort: sort, q: q };
    } catch (err) {
      return { sort: 'usual', q: '' };
    }
  }

  function writeBrowsePersist(patch) {
    var cur = readBrowsePersist();
    if (patch.sort !== undefined) cur.sort = patch.sort;
    if (patch.q !== undefined) cur.q = patch.q;
    try {
      var key = browsePersistKey();
      if (cur.sort === 'usual' && String(cur.q).trim() === '') {
        localStorage.removeItem(key);
      } else {
        localStorage.setItem(key, JSON.stringify(cur));
      }
    } catch (err) {}
  }

  function browseSearchQuery(root) {
    var input = root.querySelector('[data-browse-search-input]');
    return input ? String(input.value || '').trim().toLowerCase() : '';
  }

  function browseTileMatches(tile, q) {
    if (!q) return true;
    return (tile.getAttribute('data-browse-q') || '').indexOf(q) !== -1;
  }

  function companyFilterStorageKey() {
    return 'algos-company-filter-v1:' + browsePersistKey().slice(BROWSE_PERSIST_PREFIX.length);
  }

  function readCompanyFilter() {
    try {
      var raw = JSON.parse(localStorage.getItem(companyFilterStorageKey()) || 'null');
      if (!Array.isArray(raw)) return [];
      return raw.filter(function (slug) {
        return typeof slug === 'string' && slug !== '';
      });
    } catch (err) {
      return [];
    }
  }

  function writeCompanyFilter(slugs) {
    try {
      var key = companyFilterStorageKey();
      if (!slugs.length) localStorage.removeItem(key);
      else localStorage.setItem(key, JSON.stringify(slugs));
    } catch (err) {}
  }

  function tileCompanySlugs(tile) {
    var raw = tile.getAttribute('data-companies');
    if (!raw) return [];
    return raw.split(/\s+/).filter(Boolean);
  }

  function tileMatchesCompanies(tile, selected) {
    if (!selected.length) return true;
    var have = tileCompanySlugs(tile);
    var i;
    for (i = 0; i < selected.length; i++) {
      if (have.indexOf(selected[i]) >= 0) return true;
    }
    return false;
  }

  function companySlugsInLevel(level) {
    return Array.prototype.map.call(level.querySelectorAll('[data-filter-company]'), function (btn) {
      return btn.getAttribute('data-filter-company') || '';
    }).filter(Boolean);
  }

  function paintCompanyFilterOptions(root, selected) {
    var selectedSet = {};
    selected.forEach(function (slug) {
      selectedSet[slug] = true;
    });
    root.querySelectorAll('[data-filter-company]').forEach(function (btn) {
      var slug = btn.getAttribute('data-filter-company');
      var on = !!selectedSet[slug];
      btn.classList.toggle('is-current', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
    root.querySelectorAll('[data-filter-company-level]').forEach(function (level) {
      var n = 0;
      companySlugsInLevel(level).forEach(function (slug) {
        if (selectedSet[slug]) n += 1;
      });
      var btn = level.querySelector('[data-filter-company-level-btn]');
      if (btn) btn.classList.toggle('has-company-filter', n > 0);
      var count = level.querySelector('[data-filter-company-level-n]');
      if (count) {
        count.hidden = n === 0;
        count.textContent = '(' + n + ')';
      }
    });
  }

  function applyBrowseTileFilters(root) {
    if (!root) return;
    var selectedTags = root._filterTagIds || [];
    var selectedCompanies = root._companyFilterSlugs || [];
    var q = browseSearchQuery(root);
    var tiles = root.querySelectorAll('.content-tile');
    var headingCount = root.querySelector('.browse__heading .resource-n');
    var filterBtn = root.querySelector('[aria-controls="resource-filter"]');
    var tagsBtn = root.querySelector('[data-filter-tags-btn]');
    var companiesBtn = root.querySelector('[data-filter-companies-btn]');
    var clearBtn = root.querySelector('[data-filter-clear]');
    var emptyEl = root.querySelector('[data-user-tag-empty]');
    var browseEmpty = root.querySelector('[data-browse-empty]');
    var lookup = root._resourceTagIdsFor;
    var shown = 0;
    var anyShown = false;

    tiles.forEach(function (tile) {
      var tagOk = selectedTags.length === 0;
      if (!tagOk && lookup) {
        var key = tile.getAttribute('data-user-tag-resource');
        var ids = key ? lookup(key) : [];
        var i;
        for (i = 0; i < selectedTags.length; i++) {
          if (ids.indexOf(selectedTags[i]) >= 0) {
            tagOk = true;
            break;
          }
        }
      }
      var companyOk = tileMatchesCompanies(tile, selectedCompanies);
      var searchOk = browseTileMatches(tile, q);
      var visible = tagOk && companyOk && searchOk;
      tile.hidden = !visible;
      tile.classList.toggle('is-browse-miss', !visible);
      if (visible) {
        anyShown = true;
        shown += 1;
      }
    });

    if (headingCount) headingCount.textContent = '(' + shown + ')';
    var currentTopicN = root.querySelector('.pop__list--topics .pop__opt.is-current .resource-n');
    if (currentTopicN) currentTopicN.textContent = '(' + shown + ')';
    if (browseEmpty) browseEmpty.hidden = !(q !== '' && !anyShown);
    if (emptyEl) {
      var filterMiss = q === '' && (selectedTags.length > 0 || selectedCompanies.length > 0) && !anyShown;
      emptyEl.hidden = !filterMiss;
      if (filterMiss) {
        if (selectedTags.length && selectedCompanies.length) {
          emptyEl.textContent = 'No resources match those filters.';
        } else if (selectedCompanies.length) {
          emptyEl.textContent = 'No resources for those companies.';
        } else {
          emptyEl.textContent = 'No resources with that tag.';
        }
      }
    }

    var topicOn = !!(filterBtn && filterBtn.classList.contains('is-active'));
    var tagOn = selectedTags.length > 0;
    var companyOn = selectedCompanies.length > 0;
    if (filterBtn) {
      filterBtn.classList.toggle('has-filter', topicOn || tagOn || companyOn);
      filterBtn.classList.toggle('has-tag-filter', tagOn);
      filterBtn.classList.toggle('has-company-filter', companyOn);
    }
    if (tagsBtn) tagsBtn.classList.toggle('has-tag-filter', tagOn);
    if (companiesBtn) companiesBtn.classList.toggle('has-company-filter', companyOn);
    if (clearBtn) clearBtn.hidden = !(topicOn || tagOn || companyOn);
    paintCompanyFilterOptions(root, selectedCompanies);
  }

  function bindFilterClear(root) {
    if (!root || root._filterClearBound) return;
    var clearBtn = root.querySelector('[data-filter-clear]');
    if (!clearBtn) return;
    root._filterClearBound = true;
    clearBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var filterBtn = root.querySelector('[aria-controls="resource-filter"]');
      var topicOn = !!(filterBtn && filterBtn.classList.contains('is-active'));
      var href = clearBtn.getAttribute('href');
      var tasks = [];
      if (typeof root._clearCompanyFilter === 'function') tasks.push(root._clearCompanyFilter());
      if (typeof root._clearTagFilters === 'function') tasks.push(root._clearTagFilters());
      Promise.all(tasks).then(function () {
        if (topicOn && href) {
          window.location.href = href;
          return;
        }
        if (typeof root._renderTagFilters === 'function') root._renderTagFilters();
        if (typeof root._applyResourceFilter === 'function') root._applyResourceFilter();
        else applyBrowseTileFilters(root);
      });
    });
  }

  function closeFilterTagsFlyout(root, unpin) {
    var tagsRoot = root.querySelector('[data-filter-tags]');
    var tagsBtn = root.querySelector('[data-filter-tags-btn]');
    var tagsPanel = root.querySelector('[data-filter-tags-panel]');
    if (unpin && tagsRoot) tagsRoot.classList.remove('is-pinned');
    if (tagsPanel) tagsPanel.hidden = true;
    if (tagsBtn) tagsBtn.setAttribute('aria-expanded', 'false');
  }

  function setCompanyLevelOpen(level, open, unpin) {
    var btn = level.querySelector('[data-filter-company-level-btn]');
    var panel = level.querySelector('[data-filter-company-level-panel]');
    if (unpin || !open) level.classList.remove('is-pinned');
    if (panel) panel.hidden = !open;
    if (btn) btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  function closeFilterCompaniesFlyout(root, unpin) {
    var wrap = root.querySelector('[data-filter-companies]');
    var btn = root.querySelector('[data-filter-companies-btn]');
    var panel = root.querySelector('[data-filter-companies-panel]');
    if (unpin && wrap) wrap.classList.remove('is-pinned');
    if (panel) panel.hidden = true;
    if (btn) btn.setAttribute('aria-expanded', 'false');
    root.querySelectorAll('[data-filter-company-level]').forEach(function (level) {
      setCompanyLevelOpen(level, false, true);
    });
  }

  function closeFilterNested(panel) {
    if (!panel) return;
    var root = panel.closest('.browse') || panel;
    closeFilterTagsFlyout(root, true);
    closeFilterCompaniesFlyout(root, true);
  }

  function initCompanyFilter() {
    var wrap = document.querySelector('[data-filter-companies]');
    var root = wrap && wrap.closest('.browse');
    if (!wrap || !root) return;

    var companiesBtn = wrap.querySelector('[data-filter-companies-btn]');
    var companiesPanel = wrap.querySelector('[data-filter-companies-panel]');
    if (!companiesBtn || !companiesPanel) return;

    root._companyFilterSlugs = readCompanyFilter();

    function setSelected(slugs) {
      var seen = {};
      var next = [];
      slugs.forEach(function (slug) {
        if (!slug || seen[slug]) return;
        seen[slug] = true;
        next.push(slug);
      });
      root._companyFilterSlugs = next;
      writeCompanyFilter(next);
      if (next.length) wrap.classList.add('is-pinned');
      if (typeof root._applyResourceFilter === 'function') root._applyResourceFilter();
      applyBrowseTileFilters(root);
    }

    function setCompaniesOpen(open) {
      if (!open && !wrap.classList.contains('is-pinned')) {
        closeFilterCompaniesFlyout(root, false);
        return;
      }
      if (!open) {
        closeFilterCompaniesFlyout(root, true);
        return;
      }
      companiesPanel.hidden = false;
      companiesBtn.setAttribute('aria-expanded', 'true');
    }

    function openLevel(level) {
      root.querySelectorAll('[data-filter-company-level]').forEach(function (other) {
        if (other !== level) setCompanyLevelOpen(other, false, true);
      });
      setCompanyLevelOpen(level, true);
    }

    wrap.addEventListener('mouseenter', function () {
      closeFilterTagsFlyout(root, true);
      setCompaniesOpen(true);
    });
    wrap.addEventListener('mouseleave', function () {
      if (!wrap.classList.contains('is-pinned')) setCompaniesOpen(false);
    });
    companiesBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      closeFilterTagsFlyout(root, true);
      if (companiesPanel.hidden) {
        wrap.classList.add('is-pinned');
        setCompaniesOpen(true);
      } else if (wrap.classList.contains('is-pinned')) {
        setCompaniesOpen(false);
      } else {
        wrap.classList.add('is-pinned');
        setCompaniesOpen(true);
      }
    });
    companiesPanel.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    wrap.querySelectorAll('[data-filter-company-level]').forEach(function (level) {
      var levelBtn = level.querySelector('[data-filter-company-level-btn]');
      var levelPanel = level.querySelector('[data-filter-company-level-panel]');
      var selectAll = level.querySelector('[data-filter-company-select-all]');
      var clearLevel = level.querySelector('[data-filter-company-clear]');
      if (!levelBtn || !levelPanel) return;

      level.addEventListener('mouseenter', function () {
        openLevel(level);
      });
      level.addEventListener('mouseleave', function () {
        if (!level.classList.contains('is-pinned')) setCompanyLevelOpen(level, false);
      });
      levelBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (levelPanel.hidden) {
          level.classList.add('is-pinned');
          openLevel(level);
        } else if (level.classList.contains('is-pinned')) {
          setCompanyLevelOpen(level, false, true);
        } else {
          level.classList.add('is-pinned');
          openLevel(level);
        }
      });
      if (selectAll) {
        selectAll.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var current = (root._companyFilterSlugs || []).slice();
          companySlugsInLevel(level).forEach(function (slug) {
            if (current.indexOf(slug) < 0) current.push(slug);
          });
          setSelected(current);
        });
      }
      if (clearLevel) {
        clearLevel.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var drop = {};
          companySlugsInLevel(level).forEach(function (slug) {
            drop[slug] = true;
          });
          setSelected((root._companyFilterSlugs || []).filter(function (slug) {
            return !drop[slug];
          }));
        });
      }
    });

    wrap.querySelectorAll('[data-filter-company]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var slug = btn.getAttribute('data-filter-company');
        if (!slug) return;
        var current = (root._companyFilterSlugs || []).slice();
        var idx = current.indexOf(slug);
        if (idx >= 0) current.splice(idx, 1);
        else current.push(slug);
        setSelected(current);
      });
    });

    root._clearCompanyFilter = function () {
      setSelected([]);
      return Promise.resolve();
    };
    if (typeof root._applyResourceFilter !== 'function') {
      root._applyResourceFilter = function () {
        applyBrowseTileFilters(root);
      };
    }
    bindFilterClear(root);
    applyBrowseTileFilters(root);
  }

  initCompanyFilter();

  function syncBrowseIndicator(root) {
    var btn = root.querySelector('[aria-controls="resource-browse"]');
    if (!btn) return;
    var filtered = browseSearchQuery(root) !== '';
    var sorted = (root.getAttribute('data-browse-sort-mode') || 'usual') !== 'usual';
    var on = filtered || sorted;
    btn.classList.toggle('has-filter', on);
    if (!on) btn.removeAttribute('aria-label');
    else if (filtered && sorted) btn.setAttribute('aria-label', 'Browse, filtered and sorted');
    else if (filtered) btn.setAttribute('aria-label', 'Browse, filtered');
    else btn.setAttribute('aria-label', 'Browse, sorted');
  }

  function initBrowseSearch() {
    var MAX_SUGGEST = 8;

    function kids(parent, selector) {
      return Array.prototype.filter.call(parent.children, function (el) {
        return el.matches(selector);
      });
    }

    function accLabel(details) {
      var label = details.querySelector(':scope > .taxonomy-acc__summary .taxonomy-acc__label');
      return label ? (label.textContent || '').trim() : '';
    }

    function topicText(li) {
      var name = li.querySelector('.taxonomy-topics__name');
      var lc = li.querySelector('.taxonomy-topics__lc');
      var bits = [];
      if (name) bits.push(name.textContent || '');
      if (lc) bits.push(lc.textContent || '');
      return bits.join(' ');
    }

    function topicName(li) {
      var name = li.querySelector('.taxonomy-topics__name');
      return name ? (name.textContent || '').trim() : '';
    }

    document.querySelectorAll('[data-browse-search]').forEach(function (wrap) {
      var panel = wrap.closest('[data-pop-panel]');
      var root = wrap.closest('.browse');
      var input = wrap.querySelector('[data-browse-search-input]');
      var clearBtn = wrap.querySelector('[data-browse-search-clear]');
      var suggest = wrap.querySelector('[data-browse-suggest]');
      var nav = panel && panel.querySelector('.taxonomy');
      if (!panel || !root || !input || !suggest || !nav) return;

      var headingCount = root.querySelector('.browse__heading .resource-n');
      var browseEmpty = root.querySelector('[data-browse-empty]');
      var tiles = root.querySelectorAll('.content-tile');
      var activeIndex = -1;

      nav.querySelectorAll('details.taxonomy-acc').forEach(function (d) {
        d.setAttribute('data-was-open', d.open ? '1' : '0');
      });

      function optionEls() {
        return Array.prototype.slice.call(suggest.querySelectorAll('[role="option"]'));
      }

      function closeSuggest() {
        suggest.hidden = true;
        suggest.innerHTML = '';
        activeIndex = -1;
        input.setAttribute('aria-expanded', 'false');
        input.removeAttribute('aria-activedescendant');
      }

      function setActive(index) {
        var opts = optionEls();
        if (!opts.length) {
          activeIndex = -1;
          input.removeAttribute('aria-activedescendant');
          return;
        }
        if (index < 0) index = opts.length - 1;
        if (index >= opts.length) index = 0;
        activeIndex = index;
        opts.forEach(function (opt, i) {
          var on = i === activeIndex;
          opt.classList.toggle('is-active', on);
          opt.setAttribute('aria-selected', on ? 'true' : 'false');
          if (on) {
            input.setAttribute('aria-activedescendant', opt.id);
            if (opt.scrollIntoView) opt.scrollIntoView({ block: 'nearest' });
          }
        });
      }

      function collectTopics() {
        var out = [];
        nav.querySelectorAll('.taxonomy-topics li').forEach(function (li) {
          var name = topicName(li);
          if (!name) return;
          out.push({
            name: name,
            hay: topicText(li).toLowerCase(),
            li: li
          });
        });
        return out;
      }

      function applyAccordion(q) {
        kids(nav, '.taxonomy-acc').forEach(function (cat) {
          var catHit = q !== '' && accLabel(cat).toLowerCase().indexOf(q) !== -1;
          var anySub = false;
          kids(cat, '.taxonomy-acc').forEach(function (sub) {
            var subHit = q !== '' && accLabel(sub).toLowerCase().indexOf(q) !== -1;
            var list = sub.querySelector(':scope > .taxonomy-topics');
            var anyTopic = false;
            if (list) {
              kids(list, 'li').forEach(function (li) {
                var hit = q === '' || catHit || subHit || topicText(li).toLowerCase().indexOf(q) !== -1;
                li.hidden = !hit;
                if (hit) anyTopic = true;
              });
            }
            var showSub = q === '' || catHit || subHit || anyTopic;
            sub.hidden = !showSub;
            if (showSub) {
              anySub = true;
              if (q && (subHit || anyTopic || catHit)) sub.open = true;
              else if (!q) sub.open = sub.getAttribute('data-was-open') === '1';
            }
          });
          var showCat = q === '' || catHit || anySub;
          cat.hidden = !showCat;
          if (showCat) {
            if (q && (catHit || anySub)) cat.open = true;
            else if (!q) cat.open = cat.getAttribute('data-was-open') === '1';
          }
        });
      }

      function applyTiles(q) {
        if (typeof root._applyResourceFilter === 'function') {
          root._applyResourceFilter();
          return;
        }
        var shown = 0;
        tiles.forEach(function (tile) {
          var ok = browseTileMatches(tile, q);
          tile.classList.toggle('is-browse-miss', !ok);
          if (ok) shown += 1;
        });
        if (headingCount) headingCount.textContent = '(' + shown + ')';
        if (browseEmpty) browseEmpty.hidden = !(q !== '' && shown === 0);
      }

      function renderSuggest(q) {
        suggest.innerHTML = '';
        activeIndex = -1;
        if (q === '') {
          closeSuggest();
          return;
        }
        var matches = [];
        var seen = {};
        collectTopics().forEach(function (row) {
          if (matches.length >= MAX_SUGGEST) return;
          if (row.hay.indexOf(q) === -1) return;
          var key = row.name.toLowerCase();
          if (seen[key]) return;
          seen[key] = true;
          matches.push(row);
        });
        if (!matches.length) {
          closeSuggest();
          return;
        }
        matches.forEach(function (row, i) {
          var li = document.createElement('li');
          li.setAttribute('role', 'presentation');
          var btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'browse-search__opt';
          btn.setAttribute('role', 'option');
          btn.id = 'browse-opt-' + i;
          btn.setAttribute('aria-selected', 'false');
          btn.textContent = row.name;
          btn.addEventListener('mousedown', function (e) {
            e.preventDefault();
          });
          btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            pick(row.name);
          });
          li.appendChild(btn);
          suggest.appendChild(li);
        });
        suggest.hidden = false;
        input.setAttribute('aria-expanded', 'true');
      }

      function applyQuery() {
        var q = browseSearchQuery(root);
        if (clearBtn) clearBtn.hidden = q === '';
        syncBrowseIndicator(root);
        applyAccordion(q);
        applyTiles(q);
        writeBrowsePersist({ q: input.value });
      }

      function pick(name) {
        input.value = name;
        closeSuggest();
        applyQuery();
      }

      function clearSearch() {
        input.value = '';
        closeSuggest();
        applyQuery();
        input.focus();
      }

      input.addEventListener('input', function () {
        var q = browseSearchQuery(root);
        applyQuery();
        renderSuggest(q);
      });

      input.addEventListener('keydown', function (e) {
        var opts = optionEls();
        if (e.key === 'ArrowDown' && !suggest.hidden && opts.length) {
          e.preventDefault();
          setActive(activeIndex + 1);
          return;
        }
        if (e.key === 'ArrowUp' && !suggest.hidden && opts.length) {
          e.preventDefault();
          setActive(activeIndex - 1);
          return;
        }
        if (e.key === 'Enter' && !suggest.hidden && opts.length) {
          e.preventDefault();
          var chosen = activeIndex >= 0 ? opts[activeIndex] : opts[0];
          if (chosen) pick(chosen.textContent || '');
          return;
        }
        if (e.key === 'Escape') {
          if (!suggest.hidden) {
            e.preventDefault();
            e.stopPropagation();
            closeSuggest();
          }
        }
      });

      if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          clearSearch();
        });
      }

      nav.addEventListener('mousedown', function () {
        closeSuggest();
      });

      root._restoreBrowseSearch = function (q) {
        input.value = q || '';
        closeSuggest();
        applyQuery();
      };
    });
  }

  initBrowseSearch();

  function initBrowseSort() {
    var modes = BROWSE_SORT_MODES;
    var labels = { usual: 'Sort', az: 'A-Z', za: 'Z-A', lc: '1-n', lcdesc: 'n-1' };
    var spoken = {
      usual: 'Sort, usual order',
      az: 'Sort, A to Z',
      za: 'Sort, Z to A',
      lc: 'Sort, LeetCode number ascending',
      lcdesc: 'Sort, LeetCode number descending'
    };

    function kids(parent, selector) {
      return Array.prototype.filter.call(parent.children, function (el) {
        return el.matches(selector);
      });
    }

    function stamp(nodes) {
      nodes.forEach(function (el, i) {
        el.setAttribute('data-browse-ord', String(i));
      });
    }

    function nameOfAcc(details) {
      var label = details.querySelector(':scope > .taxonomy-acc__summary .taxonomy-acc__label');
      return label ? (label.textContent || '').trim() : '';
    }

    function nameOfTopic(li) {
      var name = li.querySelector('.taxonomy-topics__name');
      return name ? (name.textContent || '').trim() : '';
    }

    function lcOfTopic(li) {
      var raw = li.getAttribute('data-leetcode');
      if (raw === null || raw === '') return null;
      var n = Number(raw);
      return isFinite(n) ? n : null;
    }

    function byOrd(a, b) {
      return Number(a.getAttribute('data-browse-ord')) - Number(b.getAttribute('data-browse-ord'));
    }

    function reorder(parent, nodes, mode, getName, getLc) {
      var ordered = nodes.slice();
      if (mode === 'usual') {
        ordered.sort(byOrd);
      } else if (mode === 'lc' || mode === 'lcdesc') {
        if (!getLc) {
          ordered.sort(byOrd);
        } else {
          ordered.sort(function (a, b) {
            var na = getLc(a);
            var nb = getLc(b);
            if (na === null && nb === null) return byOrd(a, b);
            if (na === null) return 1;
            if (nb === null) return -1;
            if (na !== nb) return mode === 'lcdesc' ? nb - na : na - nb;
            return byOrd(a, b);
          });
        }
      } else {
        ordered.sort(function (a, b) {
          return getName(a).localeCompare(getName(b), undefined, { numeric: true, sensitivity: 'base' });
        });
        if (mode === 'za') ordered.reverse();
      }
      ordered.forEach(function (el) {
        parent.appendChild(el);
      });
    }

    function titleOfTile(tile) {
      var title = tile.querySelector('.content-tile__title');
      return title ? (title.textContent || '').trim() : '';
    }

    function lcOfTile(tile) {
      var raw = tile.getAttribute('data-leetcode');
      if (raw === null || raw === '') return null;
      var n = Number(raw);
      return isFinite(n) ? n : null;
    }

    function applySort(nav, mode, tileList) {
      var catMode = mode === 'lc' || mode === 'lcdesc' ? 'usual' : mode;
      var cats = kids(nav, '.taxonomy-acc');
      reorder(nav, cats, catMode, nameOfAcc);
      kids(nav, '.taxonomy-acc').forEach(function (cat) {
        var subs = kids(cat, '.taxonomy-acc');
        reorder(cat, subs, catMode, nameOfAcc);
        kids(cat, '.taxonomy-acc').forEach(function (sub) {
          var list = sub.querySelector(':scope > .taxonomy-topics');
          if (!list) return;
          reorder(list, kids(list, 'li'), mode, nameOfTopic, lcOfTopic);
        });
      });
      if (tileList) {
        reorder(tileList, kids(tileList, '.content-tile'), mode, titleOfTile, lcOfTile);
      }
    }

    document.querySelectorAll('[data-browse-sort]').forEach(function (btn) {
      var panel = btn.closest('[data-pop-panel]');
      var nav = panel && panel.querySelector('.taxonomy');
      var root = panel && panel.closest('.browse');
      if (!panel || !nav) return;

      var tileList = root && root.querySelector('.content-tiles');
      var cats = kids(nav, '.taxonomy-acc');
      stamp(cats);
      cats.forEach(function (cat) {
        var subs = kids(cat, '.taxonomy-acc');
        stamp(subs);
        subs.forEach(function (sub) {
          var list = sub.querySelector(':scope > .taxonomy-topics');
          if (!list) return;
          stamp(kids(list, 'li'));
        });
      });
      if (tileList) stamp(kids(tileList, '.content-tile'));
      if (root) root.setAttribute('data-browse-sort-mode', 'usual');

      var modeIndex = 0;

      function setSortMode(mode, persist) {
        var idx = modes.indexOf(mode);
        modeIndex = idx < 0 ? 0 : idx;
        mode = modes[modeIndex];
        var label = btn.querySelector('[data-browse-sort-label]');
        btn.setAttribute('data-browse-sort', mode);
        btn.setAttribute('aria-label', spoken[mode]);
        if (label) label.textContent = labels[mode];
        if (root) root.setAttribute('data-browse-sort-mode', mode);
        applySort(nav, mode, tileList);
        if (root) syncBrowseIndicator(root);
        if (persist !== false) writeBrowsePersist({ sort: mode });
      }

      btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        setSortMode(modes[(modeIndex + 1) % modes.length]);
      });

      var saved = readBrowsePersist();
      if (saved.sort !== 'usual') setSortMode(saved.sort, false);
      if (root && saved.q && typeof root._restoreBrowseSearch === 'function') {
        root._restoreBrowseSearch(saved.q);
      }
    });
  }

  initBrowseSort();

  document.querySelectorAll('[data-pop]').forEach(function (root) {
    var btn = root.querySelector('[data-pop-btn]');
    var panel = root.querySelector('[data-pop-panel]');
    if (!btn || !panel) return;

    function setOpen(open) {
      panel.hidden = !open;
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (!open) closeFilterNested(panel);
    }

    function closeAll() {
      document.querySelectorAll('[data-pop]').forEach(function (other) {
        var otherBtn = other.querySelector('[data-pop-btn]');
        var otherPanel = other.querySelector('[data-pop-panel]');
        if (otherBtn && otherPanel) {
          otherPanel.hidden = true;
          otherBtn.setAttribute('aria-expanded', 'false');
          closeFilterNested(otherPanel);
        }
      });
    }

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      closeUserTagPickers();
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

  var guideSelectRoot = document.querySelector('[data-guide-select]');
  var guideSelectMenu = document.getElementById('guide-select-menu');
  var guideGenModal = document.getElementById('guide-gen-modal');
  var guideGenPreview = document.getElementById('guide-gen-preview');
  var guideGenCopy = document.getElementById('guide-gen-copy');
  var guideGenDone = document.getElementById('guide-gen-modal-done');
  var guideGenChatgpt = document.getElementById('guide-gen-open-chatgpt');
  var guideGenClaude = document.getElementById('guide-gen-open-claude');
  var guideGenCursor = document.getElementById('guide-gen-open-cursor');
  var guideGenCursorNote = document.getElementById('guide-gen-cursor-note');
  var guideSelectGenerate = document.getElementById('guide-select-generate');
  var guideSelectCopy = document.getElementById('guide-select-copy');
  var savedGuideSelectionText = '';
  var savedGuideExplanation = '';
  var lastGuideGenFocus = null;
  var guideSelectTimer = null;

  function guideClosestEl(node) {
    if (!node) return null;
    return node.nodeType === 1 ? node : node.parentElement;
  }

  function guideNodeIn(node, selector) {
    var el = guideClosestEl(node);
    return !!(el && el.closest && el.closest(selector));
  }

  function isUsableGuideSelection(sel) {
    if (!guideSelectRoot || !sel || sel.rangeCount === 0 || sel.isCollapsed) return false;
    var text = String(sel.toString() || '').trim();
    if (!text) return false;
    var range = sel.getRangeAt(0);
    if (!guideSelectRoot.contains(range.startContainer) || !guideSelectRoot.contains(range.endContainer)) {
      return false;
    }
    if (guideNodeIn(range.startContainer, '.ui-builder') && guideNodeIn(range.endContainer, '.ui-builder')) {
      return false;
    }
    return true;
  }

  function explanationThroughSelection(sel) {
    var title = guideSelectRoot ? String(guideSelectRoot.getAttribute('data-guide-title') || '').trim() : '';
    if (!sel || sel.rangeCount === 0) return title ? '# ' + title : '';
    var range = sel.getRangeAt(0);
    var collect = document.createRange();
    collect.selectNodeContents(guideSelectRoot);
    try {
      collect.setEnd(range.endContainer, range.endOffset);
    } catch (err) {
      return title ? '# ' + title : '';
    }
    var wrap = document.createElement('div');
    wrap.appendChild(collect.cloneContents());
    wrap.querySelectorAll('.ui-builder').forEach(function (el) {
      el.remove();
    });
    var plainPrefix = String(wrap.innerText || wrap.textContent || '').replace(/\s+/g, ' ').trim();
    var sourceMd = readGuideSourceMd();
    var body = '';
    if (sourceMd && plainPrefix) {
      body = cutMarkdownToPlainPrefix(sourceMd, plainPrefix);
    }
    if (!body) {
      body = htmlFragmentToMarkdown(wrap);
    }
    body = String(body || '').replace(/\n{3,}/g, '\n\n').trim();
    if (!title) return body;
    var heading = '# ' + title;
    if (!body) return heading;
    if (body.indexOf(heading) === 0) return body;
    return heading + '\n\n' + body;
  }

  function readGuideSourceMd() {
    var el = document.getElementById('guide-source-md');
    if (!el) return '';
    try {
      var parsed = JSON.parse(el.textContent || '""');
      return typeof parsed === 'string' ? parsed : '';
    } catch (err) {
      return '';
    }
  }

  function cutMarkdownToPlainPrefix(md, plainPrefix) {
    var target = String(plainPrefix || '').replace(/\s+/g, ' ').trim();
    if (!target) return '';
    var i = 0;
    var p = 0;
    var inFence = false;
    var n = md.length;

    function atLineStart(idx) {
      return idx === 0 || md.charAt(idx - 1) === '\n' || md.charAt(idx - 1) === '\r';
    }

    while (i < n && p < target.length) {
      if (atLineStart(i) && md.slice(i, i + 3) === '```') {
        inFence = !inFence;
        i += 3;
        while (i < n && md.charAt(i) !== '\n') i++;
        if (i < n && md.charAt(i) === '\n') i++;
        continue;
      }

      var mc = md.charAt(i);
      var pc = target.charAt(p);

      if (/\s/.test(mc)) {
        i++;
        if (/\s/.test(pc)) {
          while (p < target.length && /\s/.test(target.charAt(p))) p++;
        }
        continue;
      }

      if (/\s/.test(pc)) {
        p++;
        continue;
      }

      if (mc === pc) {
        i++;
        p++;
        continue;
      }

      if (!inFence) {
        if (atLineStart(i) && mc === '#') {
          while (i < n && md.charAt(i) === '#') i++;
          while (i < n && md.charAt(i) === ' ') i++;
          continue;
        }
        if (atLineStart(i) && (mc === '-' || mc === '*') && i + 1 < n && md.charAt(i + 1) === ' ') {
          i += 2;
          continue;
        }
        if (mc === '`' || mc === '*' || mc === '_') {
          i++;
          continue;
        }
      }

      break;
    }

    if (p < target.length * 0.85) return '';
    return md.slice(0, i).replace(/[ \t]+$/g, '').replace(/\n+$/g, '');
  }

  function htmlFragmentToMarkdown(root) {
    var blocks = [];

    function inlineMd(el) {
      var out = '';
      Array.prototype.forEach.call(el.childNodes, function (child) {
        if (child.nodeType === 3) {
          out += child.nodeValue;
          return;
        }
        if (child.nodeType !== 1) return;
        var tag = child.tagName.toLowerCase();
        var inner = inlineMd(child);
        if (tag === 'code') out += '`' + inner + '`';
        else if (tag === 'strong' || tag === 'b') out += '**' + inner + '**';
        else if (tag === 'em' || tag === 'i') out += '*' + inner + '*';
        else if (tag === 'br') out += '\n';
        else out += inner;
      });
      return out.replace(/[ \t]+\n/g, '\n').replace(/[ \t]{2,}/g, ' ');
    }

    function pushBlock(text) {
      var t = String(text || '').trim();
      if (t) blocks.push(t);
    }

    Array.prototype.forEach.call(root.childNodes, function walk(child) {
      if (child.nodeType === 3) {
        var loose = String(child.nodeValue || '').replace(/\s+/g, ' ').trim();
        if (loose) pushBlock(loose);
        return;
      }
      if (child.nodeType !== 1) return;
      if (child.classList && child.classList.contains('ui-builder')) return;
      var tag = child.tagName.toLowerCase();
      if (tag === 'h1' || tag === 'h2') pushBlock('# ' + inlineMd(child).trim());
      else if (tag === 'h3') pushBlock('## ' + inlineMd(child).trim());
      else if (tag === 'h4') pushBlock('### ' + inlineMd(child).trim());
      else if (tag === 'p') pushBlock(inlineMd(child).trim());
      else if (tag === 'ul' || tag === 'ol') {
        var items = [];
        Array.prototype.forEach.call(child.children, function (li, idx) {
          if (li.tagName.toLowerCase() !== 'li') return;
          var bullet = tag === 'ol' ? String(idx + 1) + '. ' : '- ';
          items.push(bullet + inlineMd(li).trim());
        });
        if (items.length) pushBlock(items.join('\n'));
      } else if (tag === 'pre') {
        var code = String(child.textContent || '').replace(/\n+$/g, '');
        pushBlock('```\n' + code + '\n```');
      } else {
        Array.prototype.forEach.call(child.childNodes, walk);
      }
    });

    return blocks.join('\n\n');
  }

  function buildGuideGenPrompt(explanation) {
    return [
      'Read this explanation to the end. At the last section, generate the code snippet it\'s talking about. If that code snippet wouldn\'t be optimized, do not optimize it. If the section appears to talk about more than one approach, ask User which approach they want before generating the code snippet.',
      '',
      'Explanation here:',
      '"""',
      explanation,
      '"""',
      '',
      '---',
      '',
      'After the code snippet, give fast facts to these items (no need to explain, just give the fact):',
      '',
      '## Fast Facts',
      '- What is time complexity?',
      '- What is space complexity?',
      '- What is the data structure(s)?',
      '',
      '---',
      '',
      'After that, offer user what they can ask (Echo back to user exactly):',
      '',
      '## Ask Me',
      '- Explain the time complexity',
      '- Explain the space complexity',
      '- Explain why use the data structure(s)',
      '',
      'Or if you want to be coached on the concept, then prompt me with:',
      '```',
      'Be my interactive coach for algorithm and coding-interview problems. Before solving, write a short roadmap in paragraph prose describing the questions you will guide me through: first testing my understanding of the question by repeating the explanation text and asking me to reply in my own wording what I think the problem is, then correcting me if needed; then understanding the input, output, and constraints; finding a simple baseline; identifying a useful pattern or data structure; deriving the algorithm; walking through an example; and checking time and space complexity. Then ask me only the first question.',
      '',
      'Start with that first step: repeat the explanation text and ask me to reply with my own wording of what I think the problem is. Tell me that if I am having a hard time, I can ask you to reword the problem for me. Correct me if needed before continuing. Guide me one step at a time and wait for my answer before moving on. Do not reveal the full solution, code, or later hints unless I ask for them or have completed the current step. If I am wrong or stuck, briefly explain why, give the smallest useful hint, and let me try again. Adapt the pace and explanations to my answers. Once I can explain the approach in my own words, help me write the JavaScript solution and then have me identify its time and space complexity.',
      '```',  
    ].join('\n');
  }

  function currentGuideGenPrompt() {
    return buildGuideGenPrompt(savedGuideExplanation);
  }

  function hideGuideSelectMenu() {
    if (guideSelectMenu) guideSelectMenu.hidden = true;
  }

  function placeGuideSelectMenu(range) {
    if (!guideSelectMenu) return;
    var rect = range.getBoundingClientRect();
    guideSelectMenu.hidden = false;
    var menuRect = guideSelectMenu.getBoundingClientRect();
    var top = rect.top - menuRect.height - 8;
    if (top < 8) top = rect.bottom + 8;
    var left = rect.left + rect.width / 2 - menuRect.width / 2;
    var maxLeft = window.innerWidth - menuRect.width - 8;
    if (left < 8) left = 8;
    if (left > maxLeft) left = Math.max(8, maxLeft);
    guideSelectMenu.style.top = top + 'px';
    guideSelectMenu.style.left = left + 'px';
  }

  function captureGuideSelection(sel) {
    savedGuideSelectionText = String(sel.toString() || '').trim();
    try {
      savedGuideExplanation = explanationThroughSelection(sel);
    } catch (err) {
      savedGuideExplanation = savedGuideSelectionText;
    }
  }

  function syncGuideSelectMenu() {
    if (guideGenModal && !guideGenModal.hidden) {
      hideGuideSelectMenu();
      return;
    }
    var sel = window.getSelection();
    if (!isUsableGuideSelection(sel)) {
      hideGuideSelectMenu();
      return;
    }
    captureGuideSelection(sel);
    placeGuideSelectMenu(sel.getRangeAt(0));
  }

  function scheduleGuideSelectMenu() {
    clearTimeout(guideSelectTimer);
    guideSelectTimer = setTimeout(syncGuideSelectMenu, 80);
  }

  function setGuideGenCursorNoteOpen(open) {
    if (guideGenCursorNote) guideGenCursorNote.hidden = !open;
    if (guideGenCursor) guideGenCursor.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  function setGuideGenModalOpen(open) {
    if (!guideGenModal) return;
    guideGenModal.hidden = !open;
    document.body.classList.toggle('modal-open', open);
    if (open) {
      hideGuideSelectMenu();
      setGuideGenCursorNoteOpen(false);
      if (guideGenPreview) guideGenPreview.textContent = currentGuideGenPrompt();
      var panel = guideGenModal.querySelector('.modal__panel');
      if (panel && typeof panel.focus === 'function') panel.focus();
    } else if (lastGuideGenFocus && typeof lastGuideGenFocus.focus === 'function') {
      lastGuideGenFocus.focus();
    }
  }

  function copyGuideGenPrompt(done) {
    copyText(currentGuideGenPrompt()).then(function () {
      if (typeof done === 'function') done();
    }).catch(function () {
      if (typeof done === 'function') done();
    });
  }

  function openGuideGenService(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
    copyGuideGenPrompt(function () {
      if (guideGenCopy) flashCopied(guideGenCopy);
    });
  }

  if (guideSelectRoot && guideSelectMenu && guideGenModal) {
    document.addEventListener('selectionchange', scheduleGuideSelectMenu);
    document.addEventListener('mouseup', scheduleGuideSelectMenu);
    document.addEventListener('keyup', function (e) {
      if (e.key === 'Shift' || e.key.indexOf('Arrow') === 0) scheduleGuideSelectMenu();
    });

    window.addEventListener('scroll', hideGuideSelectMenu, true);
    window.addEventListener('resize', hideGuideSelectMenu);

    document.addEventListener('mousedown', function (e) {
      if (guideSelectMenu.contains(e.target)) {
        e.preventDefault();
        return;
      }
      if (!guideGenModal.hidden && guideGenModal.contains(e.target)) return;
      hideGuideSelectMenu();
    });

    if (guideSelectGenerate) {
      guideSelectGenerate.addEventListener('click', function () {
        lastGuideGenFocus = guideSelectGenerate;
        try {
          var sel = window.getSelection();
          if (isUsableGuideSelection(sel)) captureGuideSelection(sel);
        } catch (err) {}
        setGuideGenModalOpen(true);
      });
    }

    if (guideSelectCopy) {
      guideSelectCopy.addEventListener('click', function () {
        var text = savedGuideSelectionText;
        if (!text) {
          var sel = window.getSelection();
          text = sel ? String(sel.toString() || '').trim() : '';
        }
        if (!text) return;
        copyText(text).then(function () {
          flashCopied(guideSelectCopy);
        });
      });
    }

    var guideGenBackdrop = guideGenModal.querySelector('[data-action="close-guide-gen-modal"]');
    if (guideGenBackdrop) {
      guideGenBackdrop.addEventListener('click', function () {
        setGuideGenModalOpen(false);
      });
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && guideGenModal && !guideGenModal.hidden) {
        e.preventDefault();
        setGuideGenModalOpen(false);
      }
    });

    if (guideGenDone) {
      guideGenDone.addEventListener('click', function () {
        setGuideGenModalOpen(false);
      });
    }

    if (guideGenCopy) {
      guideGenCopy.addEventListener('click', function () {
        copyGuideGenPrompt(function () {
          flashCopied(guideGenCopy);
        });
      });
    }

    if (guideGenChatgpt) {
      guideGenChatgpt.addEventListener('click', function (e) {
        e.preventDefault();
        openGuideGenService(guideGenChatgpt.href || 'https://chatgpt.com/');
      });
    }

    if (guideGenClaude) {
      guideGenClaude.addEventListener('click', function (e) {
        e.preventDefault();
        openGuideGenService(guideGenClaude.href || 'https://claude.ai/new');
      });
    }

    if (guideGenCursor) {
      guideGenCursor.addEventListener('click', function () {
        copyGuideGenPrompt(function () {
          if (guideGenCopy) flashCopied(guideGenCopy);
        });
        setGuideGenCursorNoteOpen(true);
      });
    }
  }
})();
