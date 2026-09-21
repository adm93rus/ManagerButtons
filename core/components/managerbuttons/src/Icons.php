<?php

namespace ManagerButtons;

/**
 * Curated Font Awesome 5 Free solid icons available in the MODX 3 manager.
 *
 * Stored values are icon names without prefix (e.g. "home").
 * In the manager they render as class "icon icon-{name}".
 */
class Icons
{
    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return [
            'home', 'tachometer-alt', 'th-large', 'th', 'bars', 'ellipsis-h', 'ellipsis-v',
            'plus', 'plus-circle', 'plus-square', 'minus', 'minus-circle', 'times', 'times-circle',
            'check', 'check-circle', 'check-square', 'ban', 'exclamation', 'exclamation-circle',
            'exclamation-triangle', 'question', 'question-circle', 'info', 'info-circle',
            'search', 'filter', 'sort', 'sort-up', 'sort-down', 'sync', 'redo', 'undo',
            'save', 'download', 'upload', 'share', 'share-alt', 'external-link-alt', 'link',
            'unlink', 'paperclip', 'print', 'copy', 'paste', 'cut', 'clone', 'trash', 'trash-alt',
            'edit', 'pencil-alt', 'pen', 'highlighter', 'magic', 'wrench', 'cog', 'cogs',
            'sliders-h', 'tools', 'hammer', 'screwdriver', 'paint-brush', 'palette', 'eye',
            'eye-slash', 'lock', 'unlock', 'unlock-alt', 'key', 'shield-alt', 'user-shield',
            'user', 'user-plus', 'user-edit', 'user-cog', 'user-check', 'user-times', 'users',
            'users-cog', 'id-badge', 'id-card', 'address-card', 'address-book',
            'file', 'file-alt', 'file-code', 'file-image', 'file-pdf', 'file-word', 'file-excel',
            'file-archive', 'file-audio', 'file-video', 'file-import', 'file-export', 'file-upload',
            'file-download', 'file-invoice', 'file-contract', 'copy', 'folder', 'folder-open',
            'folder-plus', 'archive', 'box', 'boxes', 'database', 'server', 'hdd', 'sitemap',
            'project-diagram', 'code', 'code-branch', 'terminal', 'bug', 'laptop-code',
            'image', 'images', 'camera', 'video', 'film', 'photo-video', 'music', 'headphones',
            'play', 'pause', 'stop', 'forward', 'backward',
            'globe', 'globe-americas', 'map', 'map-marker-alt', 'map-pin', 'location-arrow',
            'compass', 'route', 'building', 'city', 'industry', 'store', 'store-alt',
            'shopping-cart', 'shopping-bag', 'shopping-basket', 'cash-register', 'credit-card',
            'wallet', 'money-bill', 'money-bill-wave', 'dollar-sign', 'euro-sign', 'ruble-sign',
            'percent', 'calculator',             'chart-bar', 'chart-line', 'chart-pie', 'chart-area',
            'bullhorn', 'ad', 'envelope', 'envelope-open', 'inbox', 'paper-plane',
            'comment', 'comments', 'comment-dots', 'sms', 'phone', 'phone-alt', 'mobile-alt',
            'desktop', 'laptop', 'tablet-alt', 'wifi', 'broadcast-tower', 'rss',
            'calendar', 'calendar-alt', 'calendar-plus', 'clock', 'history', 'hourglass-half',
            'bell', 'bell-slash', 'bookmark', 'star', 'heart', 'flag', 'flag-checkered',
            'tag', 'tags', 'hashtag', 'at', 'thumbtack',
            'book', 'book-open', 'bookmark', 'newspaper', 'blog', 'graduation-cap', 'chalkboard',
            'language', 'spell-check', 'quote-right', 'align-left', 'align-center', 'align-right',
            'list', 'list-ul', 'list-ol', 'list-alt', 'table', 'columns',
            'power-off', 'sign-in-alt', 'sign-out-alt', 'door-open', 'plug', 'lightbulb',
            'rocket', 'paper-plane', 'life-ring', 'hands-helping', 'handshake', 'gift',
            'trophy', 'medal', 'award', 'crown', 'fire', 'bolt', 'sun', 'moon', 'cloud',
            'leaf', 'tree', 'seedling', 'umbrella', 'recycle',
            'truck', 'shipping-fast', 'dolly', 'box-open', 'warehouse',
            'briefcase', 'clipboard', 'clipboard-list', 'tasks', 'check-double',
            'thumbs-up', 'thumbs-down', 'hand-pointer', 'mouse-pointer', 'keyboard',
            'expand', 'compress', 'expand-alt', 'compress-alt', 'arrows-alt', 'crop',
            'search-plus', 'search-minus', 'eye-dropper',
            'home', 'hospital', 'clinic-medical', 'heartbeat', 'stethoscope',
            'puzzle-piece', 'cubes', 'cube', 'layer-group', 'object-group',
            'share-square', 'reply', 'reply-all', 'retweet',
            'toggle-on', 'toggle-off', 'circle', 'dot-circle', 'square',
        ];
    }

    /**
     * @return list<array{name: string, class: string}>
     */
    public static function catalog(): array
    {
        $unique = array_values(array_unique(self::names()));
        sort($unique, SORT_NATURAL | SORT_FLAG_CASE);
        $out = [];
        foreach ($unique as $name) {
            $out[] = [
                'name' => $name,
                'class' => self::cssClass($name),
            ];
        }

        return $out;
    }

    public static function cssClass(string $icon): string
    {
        $icon = trim($icon);
        if ($icon === '') {
            return 'icon icon-link';
        }
        if (preg_match('/\b(fa[srlb]?|icon)\b/', $icon) && str_contains($icon, ' ')) {
            return $icon;
        }
        $name = preg_replace('/^(fa[srlb]?|icon)-/', '', $icon) ?: $icon;

        return 'icon icon-' . $name;
    }
}
