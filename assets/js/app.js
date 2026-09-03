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
    var filterBtn = root.querySelector('[aria-controls="resource-filter"]');
    var filterList = root.querySelector('[data-user-tag-filters]');
    var emptyEl = root.querySelector('[data-user-tag-empty]');
    var tiles = root.querySelectorAll('[data-user-tag-resource]');
    var clearBtn = root.querySelector('[data-filter-clear]');
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

      var headingCount = root.querySelector('.browse__heading .resource-n');

      function applyFilterVisibility() {
        var selected = filterTagIds(state, section);
        var anyShown = false;
        var shown = 0;
        tiles.forEach(function (tile) {
          var key = tile.getAttribute('data-user-tag-resource');
          var ids = resourceTagIds(state, key);
          var show = selected.length === 0;
          var i;
          if (!show) {
            for (i = 0; i < selected.length; i++) {
              if (ids.indexOf(selected[i]) >= 0) {
                show = true;
                break;
              }
            }
          }
          tile.hidden = !show;
          if (show) {
            anyShown = true;
            shown += 1;
          }
        });
        if (headingCount) {
          headingCount.textContent = '(' + shown + ')';
        }
        if (emptyEl) {
          emptyEl.hidden = selected.length === 0 || anyShown;
        }
        var topicOn = !!(filterBtn && filterBtn.classList.contains('is-active'));
        var tagOn = selected.length > 0;
        if (filterBtn) {
          filterBtn.classList.toggle('has-filter', topicOn || tagOn);
          if (tagOn) filterBtn.classList.add('has-tag-filter');
          else filterBtn.classList.remove('has-tag-filter');
        }
        if (tagsBtn) {
          if (tagOn) tagsBtn.classList.add('has-tag-filter');
          else tagsBtn.classList.remove('has-tag-filter');
        }
        if (clearBtn) {
          clearBtn.hidden = !(topicOn || tagOn);
        }
      }

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

      if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var topicOn = !!(filterBtn && filterBtn.classList.contains('is-active'));
          var href = clearBtn.getAttribute('href');
          clearSectionTagFilters(db, state, section).then(function () {
            if (topicOn && href) {
              window.location.href = href;
              return;
            }
            renderAll();
          });
        });
      }

      renderAll();
    });
  }

  initUserTags();

  document.querySelectorAll('[data-pop]').forEach(function (root) {
    var btn = root.querySelector('[data-pop-btn]');
    var panel = root.querySelector('[data-pop-panel]');
    if (!btn || !panel) return;

    function setOpen(open) {
      panel.hidden = !open;
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (!open) {
        var nestedTags = panel.querySelector('[data-filter-tags-panel]');
        var nestedTagsBtn = panel.querySelector('[data-filter-tags-btn]');
        var nestedTagsRoot = panel.querySelector('[data-filter-tags]');
        if (nestedTags) nestedTags.hidden = true;
        if (nestedTagsBtn) nestedTagsBtn.setAttribute('aria-expanded', 'false');
        if (nestedTagsRoot) nestedTagsRoot.classList.remove('is-pinned');
      }
    }

    function closeAll() {
      document.querySelectorAll('[data-pop]').forEach(function (other) {
        var otherBtn = other.querySelector('[data-pop-btn]');
        var otherPanel = other.querySelector('[data-pop-panel]');
        if (otherBtn && otherPanel) {
          otherPanel.hidden = true;
          otherBtn.setAttribute('aria-expanded', 'false');
          var nestedTags = otherPanel.querySelector('[data-filter-tags-panel]');
          var nestedTagsBtn = otherPanel.querySelector('[data-filter-tags-btn]');
          var nestedTagsRoot = otherPanel.querySelector('[data-filter-tags]');
          if (nestedTags) nestedTags.hidden = true;
          if (nestedTagsBtn) nestedTagsBtn.setAttribute('aria-expanded', 'false');
          if (nestedTagsRoot) nestedTagsRoot.classList.remove('is-pinned');
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
})();
