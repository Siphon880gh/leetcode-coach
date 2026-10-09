<?php
/**
 * Render Cursor AI Guide bodies from Markdown, including [!ui-builder] prompt widgets.
 *
 * Block format (blockquote):
 *
 * > [!ui-builder] Build
 * > INPUT_TOPIC: Theory or problem
 * > INPUT_SLUG: Folder slug
 * > PROMPT:
 * > Use the harness for [INPUT_TOPIC] under content/games/[INPUT_SLUG]/
 */

declare(strict_types=1);

require_once __DIR__ . '/content.php';

/**
 * @return array{html: string, builders: list<array{id: string, title: string, inputs: list<array{key: string, label: string}>, prompt: string}>}
 */
function guide_md_extract_builders(string $markdown): array
{
    $builders = [];
    $pattern = '/^> \[!ui-builder\](?:[ \t]+(.+))?\R((?:^>.*\R?)*)/m';

    $htmlParts = [];
    $offset = 0;
    if (!preg_match_all($pattern, $markdown, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
        return ['html' => $markdown, 'builders' => []];
    }

    foreach ($matches as $i => $match) {
        $start = $match[0][1];
        $full = $match[0][0];
        $title = isset($match[1][0]) ? trim($match[1][0]) : '';
        $body = $match[2][0] ?? '';

        $htmlParts[] = substr($markdown, $offset, $start - $offset);

        $parsed = guide_md_parse_builder_body($body);
        $id = 'ui-builder-' . ($i + 1);
        $builders[] = [
            'id' => $id,
            'title' => $title,
            'inputs' => $parsed['inputs'],
            'prompt' => $parsed['prompt'],
        ];
        $htmlParts[] = "\n\n%%UI_BUILDER_{$id}%%\n\n";
        $offset = $start + strlen($full);
    }

    $htmlParts[] = substr($markdown, $offset);

    return [
        'html' => implode('', $htmlParts),
        'builders' => $builders,
    ];
}

/**
 * @return array{inputs: list<array{key: string, label: string}>, prompt: string}
 */
function guide_md_parse_builder_body(string $body): array
{
    $inputs = [];
    $promptLines = [];
    $inPrompt = false;

    foreach (preg_split('/\R/', $body) ?: [] as $rawLine) {
        $line = preg_replace('/^>\s?/', '', $rawLine) ?? '';
        $trimmed = trim($line);

        if (!$inPrompt) {
            if (preg_match('/^PROMPT\s*:\s*(.*)$/i', $trimmed, $m)) {
                $inPrompt = true;
                $rest = trim($m[1]);
                if ($rest !== '') {
                    $promptLines[] = $rest;
                }
                continue;
            }
            if (preg_match('/^(INPUT_[A-Z0-9_]+)\s*:\s*(.+)$/', $trimmed, $m)) {
                $inputs[] = [
                    'key' => $m[1],
                    'label' => trim($m[2]),
                ];
            }
            continue;
        }

        $promptLines[] = $line;
    }

    $prompt = rtrim(implode("\n", $promptLines));

    return [
        'inputs' => $inputs,
        'prompt' => $prompt,
    ];
}

function guide_md_render_inline(string $text): string
{
    $escaped = e($text);
    $escaped = preg_replace('/`([^`]+)`/', '<code>$1</code>', $escaped) ?? $escaped;
    $escaped = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $escaped) ?? $escaped;
    $escaped = preg_replace('/(?<!\*)\*([^*]+)\*(?!\*)/', '<em>$1</em>', $escaped) ?? $escaped;
    return $escaped;
}

function guide_md_render_basic(string $markdown): string
{
    $lines = preg_split('/\R/', $markdown) ?: [];
    $out = [];
    $para = [];
    $list = [];
    $inCode = false;
    $code = [];

    $flushPara = static function () use (&$out, &$para): void {
        if ($para === []) {
            return;
        }
        $text = trim(implode(' ', $para));
        if ($text !== '') {
            $out[] = '<p>' . guide_md_render_inline($text) . '</p>';
        }
        $para = [];
    };

    $flushList = static function () use (&$out, &$list): void {
        if ($list === []) {
            return;
        }
        $items = '';
        foreach ($list as $item) {
            $items .= '<li>' . guide_md_render_inline($item) . '</li>';
        }
        $out[] = '<ul>' . $items . '</ul>';
        $list = [];
    };

    foreach ($lines as $line) {
        if (preg_match('/^```/', $line)) {
            if ($inCode) {
                $out[] = '<pre><code>' . e(implode("\n", $code)) . '</code></pre>';
                $code = [];
                $inCode = false;
            } else {
                $flushPara();
                $flushList();
                $inCode = true;
            }
            continue;
        }

        if ($inCode) {
            $code[] = $line;
            continue;
        }

        if (trim($line) === '') {
            $flushPara();
            $flushList();
            continue;
        }

        if (preg_match('/^(#{1,3})\s+(.+)$/', $line, $m)) {
            $flushPara();
            $flushList();
            $level = strlen($m[1]) + 1; // # → h2 (page already has h1)
            if ($level > 4) {
                $level = 4;
            }
            $out[] = '<h' . $level . '>' . guide_md_render_inline(trim($m[2])) . '</h' . $level . '>';
            continue;
        }

        if (preg_match('/^[-*]\s+(.+)$/', $line, $m)) {
            $flushPara();
            $list[] = $m[1];
            continue;
        }

        if (preg_match('/^%%UI_BUILDER_([a-z0-9-]+)%%$/', trim($line), $m)) {
            $flushPara();
            $flushList();
            $out[] = '%%UI_BUILDER_' . $m[1] . '%%';
            continue;
        }

        $flushList();
        $para[] = trim($line);
    }

    $flushPara();
    $flushList();
    if ($inCode) {
        $out[] = '<pre><code>' . e(implode("\n", $code)) . '</code></pre>';
    }

    return implode("\n", $out);
}

/**
 * @param array{id: string, title: string, inputs: list<array{key: string, label: string}>, prompt: string} $builder
 */
function guide_md_is_step_by_step_builder(array $builder): bool
{
    $title = strtolower(trim((string) ($builder['title'] ?? '')));
    if (preg_match('/step[\s-]*by[\s-]*step/', $title) === 1) {
        return true;
    }

    $prompt = (string) ($builder['prompt'] ?? '');

    return stripos($prompt, 'content/coaching/') !== false;
}

/**
 * @param array{id: string, title: string, inputs: list<array{key: string, label: string}>, prompt: string} $builder
 */
function guide_md_is_mini_game_builder(array $builder): bool
{
    $title = strtolower(trim((string) ($builder['title'] ?? '')));
    if (preg_match('/mini[\s-]*game/', $title) === 1) {
        return true;
    }

    $prompt = (string) ($builder['prompt'] ?? '');

    return stripos($prompt, 'content/games/') !== false;
}

function guide_md_render_existing_session(string $title, string $sessionSlug): string
{
    $heading = $title !== '' ? $title : 'Step-by-step';
    $href = url('coaching/session.php?id=' . rawurlencode($sessionSlug));

    return '<div class="ui-builder ui-builder--exists">'
        . '<p class="ui-builder__title">' . e($heading) . '</p>'
        . '<p class="ui-builder__exists-copy">This step-by-step is already created.</p>'
        . '<div class="ui-builder__footer">'
        . '<a class="btn btn--small btn--ghost" href="' . e($href) . '">Open step-by-step</a>'
        . '</div>'
        . '</div>';
}

function guide_md_render_existing_game(string $title, string $gameSlug): string
{
    $heading = $title !== '' ? $title : 'Mini game';
    $href = url('games/play.php?id=' . rawurlencode($gameSlug));

    return '<div class="ui-builder ui-builder--exists">'
        . '<p class="ui-builder__title">' . e($heading) . '</p>'
        . '<p class="ui-builder__exists-copy">This mini game is already created.</p>'
        . '<div class="ui-builder__footer">'
        . '<a class="btn btn--small btn--ghost" href="' . e($href) . '">Open mini game</a>'
        . '</div>'
        . '</div>';
}

/**
 * @param array{id: string, title: string, inputs: list<array{key: string, label: string}>, prompt: string} $builder
 */
function guide_md_render_builder(array $builder, ?string $existingSessionSlug = null, ?string $existingGameSlug = null): string
{
    if ($existingGameSlug !== null && $existingGameSlug !== '' && guide_md_is_mini_game_builder($builder)) {
        return guide_md_render_existing_game((string) $builder['title'], $existingGameSlug);
    }

    if ($existingSessionSlug !== null && $existingSessionSlug !== '' && guide_md_is_step_by_step_builder($builder)) {
        return guide_md_render_existing_session((string) $builder['title'], $existingSessionSlug);
    }

    $id = $builder['id'];
    $title = $builder['title'];
    $inputs = $builder['inputs'];
    $prompt = $builder['prompt'];

    $fieldsHtml = '';
    foreach ($inputs as $index => $input) {
        $fieldId = $id . '-field-' . $index;
        $key = $input['key'];
        $label = $input['label'];
        $fieldsHtml .= '<div class="ui-builder__field">'
            . '<label class="ui-builder__label" for="' . e($fieldId) . '">' . e($label) . '</label>'
            . '<input class="ui-builder__input" type="text" id="' . e($fieldId) . '"'
            . ' data-ui-builder-key="' . e($key) . '"'
            . ' autocomplete="off">'
            . '</div>';
    }

    $previewId = $id . '-preview';
    $titleHtml = $title !== ''
        ? '<p class="ui-builder__title">' . e($title) . '</p>'
        : '';

    $keysJson = e(json_encode(array_column($inputs, 'key'), JSON_UNESCAPED_UNICODE) ?: '[]');
    $promptJson = e(json_encode($prompt, JSON_UNESCAPED_UNICODE) ?: '""');

    return '<div class="ui-builder" data-ui-builder'
        . ' data-prompt="' . $promptJson . '"'
        . ' data-keys="' . $keysJson . '">'
        . $titleHtml
        . $fieldsHtml
        . '<details class="why-not-auto">'
        . '<summary class="why-not-auto__summary"><span class="why-not-auto__icon" aria-hidden="true">i</span> Why is this not automatic</summary>'
        . '<div class="why-not-auto__body">'
        . '<p>Weng provides this service for free and cannot cover the ongoing cost of AI tokens. That\'s why this Prompt Builder is designed to let users supply their own AI processing resources rather than having the app pay for them. This is also why AI processing isn\'t integrated directly into the app for a more seamless experience.</p>'
        . '<p>There are several ways to accomplish this:</p>'
        . '<ol>'
        . '<li><strong>Copy the generated prompt into ChatGPT or Claude:</strong> Users can use their existing AI subscriptions to process the prompt.</li>'
        . '<li><strong>Copy the generated prompt into an AI harness like Cursor or Claude Code:</strong> Users can leverage their own AI coding environments and available token allowances.</li>'
        . '<li><strong>Provide their own API key:</strong> The app could process prompts directly using the user\'s API key, with usage billed to the user. However, this requires trusting that the app does not store, log, or copy the key. This is generally easier to verify with a locally running application or a Chrome extension, although neither is inherently secure without reviewing how it handles credentials.</li>'
        . '</ol>'
        . '<p><strong>For now, letting you use your own AI tools is the most practical approach.</strong> It keeps the service free while allowing you to use AI resources you already have access to. This app uses the method best suited to its particular workflow.</p>'
        . '<p>If the service eventually becomes commercial and can sustain the cost of AI tokens, AI processing could be integrated directly into the app for a more seamless experience.</p>'
        . '</div></details>'
        . '<div class="ui-builder__preview-wrap">'
        . '<p class="ui-builder__label">Prompt preview</p>'
        . '<pre class="ui-builder__preview" id="' . e($previewId) . '" data-ui-builder-preview></pre>'
        . '</div>'
        . '<div class="ui-builder__footer">'
        . '<button type="button" class="btn btn--small btn--ghost" data-ui-builder-copy data-copy-from="#' . e($previewId) . '">Copy prompt</button>'
        . '<span class="ui-builder__hint">Then open in your favorite IDE (Cursor, Claude Code, etc)</span>'
        . '</div>'
        . '</div>';
}

/**
 * Guide markdown with [!ui-builder] blocks removed, for Generate Code prompts.
 */
function guide_md_prompt_source(string $markdown): string
{
    $extracted = guide_md_extract_builders($markdown);
    $source = $extracted['html'];
    $source = preg_replace('/\R*%%UI_BUILDER_[a-z0-9-]+%%\R*/', "\n\n", $source) ?? $source;

    return trim($source);
}

function render_guide_markdown(string $markdown, ?string $existingSessionSlug = null, ?string $existingGameSlug = null): string
{
    $extracted = guide_md_extract_builders($markdown);
    $html = guide_md_render_basic($extracted['html']);

    foreach ($extracted['builders'] as $builder) {
        $token = '%%UI_BUILDER_' . $builder['id'] . '%%';
        $widget = guide_md_render_builder($builder, $existingSessionSlug, $existingGameSlug);
        $html = str_replace($token, $widget, $html);
    }

    return $html;
}
