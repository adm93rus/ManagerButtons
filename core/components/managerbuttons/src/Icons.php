<?php

namespace ManagerButtons;

/**
 * Font Awesome 5 icons shipped with the MODX 3 manager.
 *
 * Names are the `.icon-{name}:before` rules from
 * manager/templates/default/css/index.css. Stored values are the name
 * without a prefix. The manager renders them as `icon icon-{name}`.
 */
class Icons
{
    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return [
            '3gp', '500px', '7z', 'aac', 'access', 'accessible-icon', 'accusoft', 'acquisitions-incorporated',
            'action', 'ad', 'address-book', 'address-book-o', 'address-card', 'address-card-o', 'adjust', 'adn',
            'adversal', 'affiliatetheme', 'aif', 'aiff', 'airbnb', 'air-freshener', 'algolia', 'align-center',
            'align-justify', 'align-left', 'align-right', 'alipay', 'allergies', 'amazon', 'amazon-pay', 'ambulance',
            'american-sign-language-interpreting', 'amilia', 'anchor', 'android', 'angellist', 'angle-double-down', 'angle-double-left', 'angle-double-right',
            'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'angry', 'angrycreative', 'angular',
            'ankh', 'apper', 'apple', 'apple-alt', 'apple-pay', 'app-store', 'app-store-ios', 'archive',
            'archway', 'area-chart', 'arrow-alt-circle-down', 'arrow-alt-circle-left', 'arrow-alt-circle-right', 'arrow-alt-circle-up', 'arrow-circle-down', 'arrow-circle-left',
            'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left',
            'arrow-right', 'arrows', 'arrows-alt', 'arrows-alt-h', 'arrows-alt-v', 'arrows-h', 'arrows-v', 'arrow-up',
            'artstation', 'as', 'asl-interpreting', 'assistive-listening-systems', 'asterisk', 'asymmetrik', 'at', 'atlas',
            'atlassian', 'atom', 'audible', 'audio-description', 'automobile', 'autoprefixer', 'avi', 'avianex',
            'aviato', 'award', 'aws', 'baby', 'baby-carriage', 'backspace', 'backup', 'backward',
            'bacon', 'bacteria', 'bacterium', 'bahai', 'bak', 'balance-scale', 'balance-scale-left', 'balance-scale-right',
            'ban', 'band-aid', 'bandcamp', 'bank', 'bar-chart', 'bar-chart-o', 'barcode', 'bars',
            'baseball-ball', 'basketball-ball', 'bat', 'bath', 'bathtub', 'battery', 'battery-0', 'battery-1',
            'battery-2', 'battery-3', 'battery-4', 'battery-empty', 'battery-full', 'battery-half', 'battery-quarter', 'battery-three-quarters',
            'battle-net', 'bed', 'beer', 'behance', 'behance-square', 'bell', 'bell-o', 'bell-slash',
            'bell-slash-o', 'bezier-curve', 'bible', 'bicycle', 'biking', 'bimobject', 'binoculars', 'biohazard',
            'birthday-cake', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bity', 'bk', 'blackberry', 'black-tie',
            'blender', 'blender-phone', 'blind', 'blog', 'blogger', 'blogger-b', 'bluetooth', 'bluetooth-b',
            'bmp', 'bold', 'bolt', 'bomb', 'bone', 'bong', 'book', 'book-dead',
            'bookmark', 'bookmark-o', 'book-medical', 'book-open', 'book-reader', 'bootstrap', 'border-all', 'border-none',
            'border-style', 'bowling-ball', 'box', 'boxes', 'box-open', 'box-tissue', 'braille', 'brain',
            'bread-slice', 'briefcase', 'briefcase-medical', 'broadcast-tower', 'broom', 'brush', 'btc', 'buffer',
            'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'burn', 'buromobelexperte', 'bus',
            'bus-alt', 'business-time', 'buy-n-large', 'buysellads', 'bz2', 'cab', 'cal', 'calculator',
            'calendar', 'calendar-alt', 'calendar-check', 'calendar-check-o', 'calendar-day', 'calendar-minus', 'calendar-minus-o', 'calendar-o',
            'calendar-plus', 'calendar-plus-o', 'calendar-times', 'calendar-times-o', 'calendar-week', 'camera', 'camera-retro', 'campground',
            'canadian-maple-leaf', 'candy-cane', 'cannabis', 'capsules', 'car', 'car-alt', 'caravan', 'car-battery',
            'car-crash', 'caret-down', 'caret-left', 'caret-right', 'caret-square-down', 'caret-square-left', 'caret-square-o-down', 'caret-square-o-left',
            'caret-square-o-right', 'caret-square-o-up', 'caret-square-right', 'caret-square-up', 'caret-up', 'carrot', 'car-side', 'cart-arrow-down',
            'cart-plus', 'cash-register', 'cat', 'cc', 'cc-amazon-pay', 'cc-amex', 'cc-apple-pay', 'cc-diners-club',
            'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'centercode', 'centos',
            'certificate', 'cfm', 'chain', 'chain-broken', 'chair', 'chalkboard', 'chalkboard-teacher', 'charging-station',
            'chart-area', 'chart-bar', 'chart-line', 'chart-pie', 'check', 'check-circle', 'check-circle-o', 'check-double',
            'check-square', 'check-square-o', 'cheese', 'chess', 'chess-bishop', 'chess-board', 'chess-king', 'chess-knight',
            'chess-pawn', 'chess-queen', 'chess-rook', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down',
            'chevron-left', 'chevron-right', 'chevron-up', 'child', 'chrome', 'chromecast', 'church', 'circle',
            'circle-notch', 'circle-o', 'circle-o-notch', 'circle-thin', 'city', 'clinic-medical', 'clipboard', 'clipboard-check',
            'clipboard-list', 'clock', 'clock-o', 'clone', 'close', 'closed-captioning', 'cloud', 'cloud-download',
            'cloud-download-alt', 'cloudflare', 'cloud-meatball', 'cloud-moon', 'cloud-moon-rain', 'cloud-rain', 'cloudscale', 'cloud-showers-heavy',
            'cloudsmith', 'cloud-sun', 'cloud-sun-rain', 'cloud-upload', 'cloud-upload-alt', 'cloudversify', 'cny', 'cocktail',
            'code', 'code-branch', 'code-fork', 'codepen', 'codiepie', 'coffee', 'coffeescript', 'cog',
            'cogs', 'coins', 'columns', 'comment', 'comment-alt', 'comment-dollar', 'comment-dots', 'commenting',
            'commenting-o', 'comment-medical', 'comment-o', 'comments', 'comments-dollar', 'comment-slash', 'comments-o', 'compact-disc',
            'compass', 'compress', 'compress-alt', 'compress-arrows-alt', 'concierge-bell', 'confluence', 'connectdevelop', 'contao',
            'cookie', 'cookie-bite', 'copy', 'copyright', 'cotton-bureau', 'couch', 'cpanel', 'creative-commons',
            'creative-commons-by', 'creative-commons-nc', 'creative-commons-nc-eu', 'creative-commons-nc-jp', 'creative-commons-nd', 'creative-commons-pd', 'creative-commons-pd-alt', 'creative-commons-remix',
            'creative-commons-sa', 'creative-commons-sampling', 'creative-commons-sampling-plus', 'creative-commons-share', 'creative-commons-zero', 'credit-card', 'credit-card-alt', 'critical-role',
            'crop', 'crop-alt', 'cross', 'crosshairs', 'crow', 'crown', 'crutch', 'css',
            'css3', 'css3-alt', 'csv', 'cube', 'cubes', 'cut', 'cutlery', 'cuttlefish',
            'dailymotion', 'd-and-d', 'd-and-d-beyond', 'dashboard', 'dashcube', 'database', 'db', 'deaf',
            'deafness', 'dedent', 'deezer', 'delicious', 'democrat', 'deploydog', 'deskpro', 'desktop',
            'dev', 'deviantart', 'dharmachakra', 'dhl', 'diagnoses', 'diamond', 'diaspora', 'dice',
            'dice-d20', 'dice-d6', 'dice-five', 'dice-four', 'dice-one', 'dice-six', 'dice-three', 'dice-two',
            'digg', 'digital-ocean', 'digital-tachograph', 'directions', 'discord', 'discourse', 'disease', 'divide',
            'dizzy', 'dmg', 'dna', 'doc', 'dochub', 'docker', 'docx', 'dog',
            'dollar', 'dollar-sign', 'dolly', 'dolly-flatbed', 'donate', 'door-closed', 'door-open', 'dot-circle',
            'dot-circle-o', 'dove', 'download', 'draft2digital', 'drafting-compass', 'dragon', 'draw-polygon', 'dribbble',
            'dribbble-square', 'drivers-license', 'drivers-license-o', 'dropbox', 'drum', 'drum-steelpan', 'drumstick-bite', 'drupal',
            'dumbbell', 'dumpster', 'dumpster-fire', 'dungeon', 'dyalog', 'earlybirds', 'ebay', 'edge',
            'edge-legacy', 'edit', 'eercast', 'egg', 'eject', 'elementor', 'ellipsis-h', 'ellipsis-v',
            'ello', 'ember', 'empire', 'envelope', 'envelope-o', 'envelope-open', 'envelope-open-o', 'envelope-open-text',
            'envelope-square', 'envira', 'equals', 'eraser', 'erlang', 'ethereum', 'ethernet', 'etsy',
            'eur', 'euro', 'euro-sign', 'evernote', 'exchange', 'exchange-alt', 'exclamation', 'exclamation-circle',
            'exclamation-triangle', 'expand', 'expand-alt', 'expand-arrows-alt', 'expeditedssl', 'external-link', 'external-link-alt', 'external-link-square',
            'external-link-square-alt', 'eye', 'eye-dropper', 'eyedropper', 'eye-slash', 'fa', 'facebook', 'facebook-f',
            'facebook-messenger', 'facebook-official', 'facebook-square', 'fan', 'fantasy-flight-games', 'fast-backward', 'fast-forward', 'faucet',
            'fax', 'feather', 'feather-alt', 'fedex', 'fedora', 'feed', 'female', 'fighter-jet',
            'figma', 'file', 'file-alt', 'file-archive', 'file-archive-o', 'file-audio', 'file-audio-o', 'file-code',
            'file-code-o', 'file-contract', 'file-csv', 'file-download', 'file-excel', 'file-excel-o', 'file-export', 'file-image',
            'file-image-o', 'file-import', 'file-invoice', 'file-invoice-dollar', 'file-medical', 'file-medical-alt', 'file-movie-o', 'file-o',
            'file-pdf', 'file-pdf-o', 'file-photo-o', 'file-picture-o', 'file-powerpoint', 'file-powerpoint-o', 'file-prescription', 'file-signature',
            'files-o', 'file-sound-o', 'file-text', 'file-text-o', 'file-upload', 'file-video', 'file-video-o', 'file-word',
            'file-word-o', 'file-zip-o', 'fill', 'fill-drip', 'film', 'filter', 'fingerprint', 'fire',
            'fire-alt', 'fire-extinguisher', 'firefox', 'firefox-browser', 'first-aid', 'firstdraft', 'first-order', 'first-order-alt',
            'fish', 'fist-raised', 'fla', 'flac', 'flag', 'flag-checkered', 'flag-o', 'flag-usa',
            'flash', 'flask', 'flickr', 'flipboard', 'floppy-o', 'flushed', 'flv', 'fly',
            'folder', 'folder-minus', 'folder-o', 'folder-open', 'folder-open-o', 'folder-plus', 'font', 'font-awesome',
            'font-awesome-alt', 'font-awesome-flag', 'font-awesome-logo-full', 'fonticons', 'fonticons-fi', 'football-ball', 'fort-awesome', 'fort-awesome-alt',
            'forumbee', 'forward', 'foursquare', 'freebsd', 'free-code-camp', 'frog', 'frown', 'frown-o',
            'frown-open', 'fulcrum', 'funnel-dollar', 'futbol', 'futbol-o', 'galactic-republic', 'galactic-senate', 'gamepad',
            'gas-pump', 'gavel', 'gbp', 'ge', 'gear', 'gears', 'gem', 'genderless',
            'get-pocket', 'gg', 'gg-circle', 'ghost', 'gif', 'gift', 'gifts', 'git',
            'git-alt', 'github', 'github-alt', 'github-square', 'gitkraken', 'gitlab', 'git-square', 'gitter',
            'gittip', 'glass', 'glass-cheers', 'glasses', 'glass-martini', 'glass-martini-alt', 'glass-whiskey', 'glide',
            'glide-g', 'globe', 'globe-africa', 'globe-americas', 'globe-asia', 'globe-europe', 'gofore', 'golf-ball',
            'goodreads', 'goodreads-g', 'google', 'google-drive', 'google-pay', 'google-play', 'google-plus', 'google-plus-circle',
            'google-plus-g', 'google-plus-official', 'google-plus-square', 'google-wallet', 'gopuram', 'graduation-cap', 'gratipay', 'grav',
            'greater-than', 'greater-than-equal', 'grimace', 'grin', 'grin-alt', 'grin-beam', 'grin-beam-sweat', 'grin-hearts',
            'grin-squint', 'grin-squint-tears', 'grin-stars', 'grin-tears', 'grin-tongue', 'grin-tongue-squint', 'grin-tongue-wink', 'grin-wink',
            'gripfire', 'grip-horizontal', 'grip-lines', 'grip-lines-vertical', 'grip-vertical', 'group', 'grunt', 'guilded',
            'guitar', 'gulp', 'gz', 'hacker-news', 'hacker-news-square', 'hackerrank', 'hamburger', 'hammer',
            'hamsa', 'hand-grab-o', 'hand-holding', 'hand-holding-heart', 'hand-holding-medical', 'hand-holding-usd', 'hand-holding-water', 'hand-lizard',
            'hand-lizard-o', 'hand-middle-finger', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hand-paper', 'hand-paper-o',
            'hand-peace', 'hand-peace-o', 'hand-point-down', 'hand-pointer', 'hand-pointer-o', 'hand-point-left', 'hand-point-right', 'hand-point-up',
            'hand-rock', 'hand-rock-o', 'hands', 'hand-scissors', 'hand-scissors-o', 'handshake', 'handshake-alt-slash', 'handshake-o',
            'handshake-slash', 'hands-helping', 'hand-sparkles', 'hand-spock', 'hand-spock-o', 'hand-stop-o', 'hands-wash', 'hanukiah',
            'hard-hat', 'hard-of-hearing', 'hashtag', 'hat-cowboy', 'hat-cowboy-side', 'hat-wizard', 'hdd', 'hdd-o',
            'header', 'heading', 'headphones', 'headphones-alt', 'headset', 'head-side-cough', 'head-side-cough-slash', 'head-side-mask',
            'head-side-virus', 'heart', 'heartbeat', 'heart-broken', 'heart-o', 'helicopter', 'highlighter', 'hiking',
            'hippo', 'hips', 'hire-a-helper', 'history', 'hive', 'hockey-puck', 'holly-berry', 'home',
            'hooli', 'hornbill', 'horse', 'horse-head', 'hospital', 'hospital-alt', 'hospital-o', 'hospital-symbol',
            'hospital-user', 'hotdog', 'hotel', 'hotjar', 'hot-tub', 'hourglass', 'hourglass-1', 'hourglass-2',
            'hourglass-3', 'hourglass-end', 'hourglass-half', 'hourglass-o', 'hourglass-start', 'house-damage', 'house-user', 'houzz',
            'hryvnia', 'h-square', 'htaccess', 'htm', 'html', 'html5', 'hubspot', 'ical',
            'ice-cream', 'icicles', 'icons', 'ics', 'i-cursor', 'id-badge', 'id-card', 'id-card-alt',
            'id-card-o', 'ideal', 'igloo', 'ils', 'image', 'images', 'imdb', 'inbox',
            'indent', 'industry', 'infinity', 'info', 'info-circle', 'innosoft', 'inr', 'instagram',
            'instagram-square', 'instalod', 'institution', 'intercom', 'internet-explorer', 'intersex', 'invision', 'ioxhost',
            'iso', 'italic', 'itch-io', 'itunes', 'itunes-note', 'jar', 'java', 'jedi',
            'jedi-order', 'jenkins', 'jira', 'joget', 'joint', 'joomla', 'journal-whills', 'jpeg',
            'jpg', 'jpy', 'js', 'jsfiddle', 'json', 'js-square', 'kaaba', 'kaggle',
            'key', 'keybase', 'keyboard', 'keyboard-o', 'keycdn', 'khanda', 'kickstarter', 'kickstarter-k',
            'kiss', 'kiss-beam', 'kiss-wink-heart', 'kiwi-bird', 'korvue', 'krw', 'landmark', 'language',
            'laptop', 'laptop-code', 'laptop-house', 'laptop-medical', 'laravel', 'lastfm', 'lastfm-square', 'laugh',
            'laugh-beam', 'laugh-squint', 'laugh-wink', 'layer-group', 'leaf', 'leanpub', 'legal', 'lemon',
            'lemon-o', 'less', 'less-than', 'less-than-equal', 'level-down', 'level-down-alt', 'level-up', 'level-up-alt',
            'life-bouy', 'life-buoy', 'life-ring', 'life-saver', 'lightbulb', 'lightbulb-o', 'line', 'line-chart',
            'link', 'linkedin', 'linkedin-in', 'linkedin-square', 'linode', 'linux', 'lira-sign', 'list',
            'list-alt', 'list-new', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'locked', 'lock-open',
            'log', 'long-arrow-alt-down', 'long-arrow-alt-left', 'long-arrow-alt-right', 'long-arrow-alt-up', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right',
            'long-arrow-up', 'low-vision', 'luggage-cart', 'lungs', 'lungs-virus', 'lyft', 'm4a', 'm4v',
            'magento', 'magic', 'magnet', 'mail-bulk', 'mailchimp', 'mail-forward', 'mail-reply', 'mail-reply-all',
            'male', 'mandalorian', 'map', 'map-marked', 'map-marked-alt', 'map-marker', 'map-marker-alt', 'map-o',
            'map-pin', 'map-signs', 'mark-active', 'mark-complete', 'markdown', 'marker', 'mars', 'mars-double',
            'mars-stroke', 'mars-stroke-h', 'mars-stroke-v', 'mask', 'mastodon', 'maxcdn', 'mdb', 'meanpath',
            'medal', 'medapps', 'medium', 'medium-m', 'medkit', 'medrt', 'meetup', 'megaport',
            'meh', 'meh-blank', 'meh-o', 'meh-rolling-eyes', 'memory', 'mendeley', 'menorah', 'mercury',
            'meteor', 'microblog', 'microchip', 'microphone', 'microphone-alt', 'microphone-alt-slash', 'microphone-slash', 'microscope',
            'microsoft', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mitten', 'mix', 'mixcloud',
            'mixer', 'mizuni', 'mobile', 'mobile-alt', 'mobile-phone', 'modx', 'monero', 'money',
            'money-bill', 'money-bill-alt', 'money-bill-wave', 'money-bill-wave-alt', 'money-check', 'money-check-alt', 'monument', 'moon',
            'moon-o', 'mortar-board', 'mortar-pestle', 'mosque', 'motorcycle', 'mountain', 'mouse', 'mouse-pointer',
            'mov', 'mp3', 'mp4', 'mpeg', 'mpg', 'mug-hot', 'music', 'namespace',
            'napster', 'navicon', 'neos', 'network-wired', 'neuter', 'newspaper', 'newspaper-o', 'nimblr',
            'node', 'node-js', 'not-equal', 'notes-medical', 'npm', 'ns8', 'nutritionix', 'object-group',
            'object-ungroup', 'octopus-deploy', 'odnoklassniki', 'odnoklassniki-square', 'ogg', 'oil-can', 'old-republic', 'om',
            'opencart', 'openid', 'opera', 'optin-monster', 'orcid', 'osi', 'otter', 'outdent',
            'package', 'page4', 'pagelines', 'pager', 'paint-brush', 'paint-roller', 'palette', 'palfed',
            'pallet', 'paperclip', 'paper-plane', 'paper-plane-o', 'parachute-box', 'paragraph', 'parking', 'passport',
            'pastafarianism', 'paste', 'patreon', 'pause', 'pause-circle', 'pause-circle-o', 'paw', 'paypal',
            'pdf', 'peace', 'pen', 'pen-alt', 'pencil', 'pencil-alt', 'pencil-ruler', 'pencil-square',
            'pencil-square-o', 'pen-fancy', 'pen-nib', 'penny-arcade', 'pen-square', 'people-arrows', 'people-carry', 'pepper-hot',
            'perbyte', 'percent', 'percentage', 'periscope', 'person-booth', 'phabricator', 'phoenix-framework', 'phoenix-squadron',
            'phone', 'phone-alt', 'phone-slash', 'phone-square', 'phone-square-alt', 'phone-volume', 'photo', 'photo-video',
            'php', 'picture-o', 'pie-chart', 'pied-piper', 'pied-piper-alt', 'pied-piper-hat', 'pied-piper-pp', 'pied-piper-square',
            'piggy-bank', 'pills', 'pinterest', 'pinterest-p', 'pinterest-square', 'pizza-slice', 'place-of-worship', 'plane',
            'plane-arrival', 'plane-departure', 'plane-slash', 'play', 'play-circle', 'play-circle-o', 'playstation', 'plug',
            'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'png', 'podcast', 'poll', 'poll-h',
            'poo', 'poop', 'poo-storm', 'portrait', 'pound-sign', 'power-off', 'ppt', 'pptx',
            'pray', 'praying-hands', 'prescription', 'prescription-bottle', 'prescription-bottle-alt', 'print', 'procedures', 'product-hunt',
            'project-diagram', 'pump-medical', 'pump-soap', 'pushed', 'puzzle-piece', 'python', 'qq', 'qrcode',
            'question', 'question-circle', 'question-circle-o', 'quidditch', 'quinscape', 'quora', 'quote-left', 'quote-right',
            'quran', 'ra', 'radiation', 'radiation-alt', 'rainbow', 'random', 'rar', 'raspberry-pi',
            'ravelry', 'rb', 'react', 'reacteurope', 'readme', 'rebel', 'receipt', 'record-vinyl',
            'recycle', 'reddit', 'reddit-alien', 'reddit-square', 'redhat', 'redo', 'redo-alt', 'red-river',
            'refresh', 'registered', 'remove', 'remove-format', 'renren', 'reorder', 'repeat', 'reply',
            'reply-all', 'replyd', 'republican', 'researchgate', 'resistance', 'resolving', 'restroom', 'retweet',
            'rev', 'ribbon', 'ring', 'rmb', 'road', 'robot', 'rocket', 'rocketchat',
            'rockrms', 'rotate-left', 'rotate-right', 'rouble', 'route', 'r-project', 'rss', 'rss-square',
            'rub', 'ruble', 'ruble-sign', 'ruler', 'ruler-combined', 'ruler-horizontal', 'ruler-vertical', 'running',
            'rupee', 'rupee-sign', 'rust', 's15', 'sad-cry', 'sad-tear', 'safari', 'salesforce',
            'sass', 'satellite', 'satellite-dish', 'save', 'schlix', 'school', 'scissors', 'scr',
            'screwdriver', 'scribd', 'scroll', 'scss', 'sd-card', 'search', 'search-dollar', 'searchengin',
            'search-location', 'search-minus', 'search-plus', 'seedling', 'sellcast', 'sellsy', 'send', 'send-o',
            'server', 'servicestack', 'sh', 'shapes', 'share', 'share-alt', 'share-alt-square', 'share-square',
            'share-square-o', 'shekel', 'shekel-sign', 'sheqel', 'shield', 'shield-alt', 'shield-virus', 'ship',
            'shipping-fast', 'shirtsinbulk', 'shoe-prints', 'shopify', 'shopping-bag', 'shopping-basket', 'shopping-cart', 'shopware',
            'shower', 'shuttle-van', 'sign', 'signal', 'signature', 'sign-in', 'sign-in-alt', 'signing',
            'sign-language', 'sign-out', 'sign-out-alt', 'sim-card', 'simplybuilt', 'sink', 'sistrix', 'sitemap',
            'sith', 'skating', 'sketch', 'skiing', 'skiing-nordic', 'skull', 'skull-crossbones', 'skyatlas',
            'skype', 'slack', 'slack-hash', 'slash', 'sleigh', 'sliders', 'sliders-h', 'slideshare',
            'smile', 'smile-beam', 'smile-o', 'smile-wink', 'smog', 'smoking', 'smoking-ban', 'sms',
            'snapchat', 'snapchat-ghost', 'snapchat-square', 'snowboarding', 'snowflake', 'snowflake-o', 'snowman', 'snowplow',
            'soap', 'soccer-ball-o', 'socks', 'solar-panel', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-alpha-down',
            'sort-alpha-down-alt', 'sort-alpha-up', 'sort-alpha-up-alt', 'sort-amount-asc', 'sort-amount-desc', 'sort-amount-down', 'sort-amount-down-alt', 'sort-amount-up',
            'sort-amount-up-alt', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-numeric-down', 'sort-numeric-down-alt',
            'sort-numeric-up', 'sort-numeric-up-alt', 'sort-up', 'soundcloud', 'sourcetree', 'spa', 'space-shuttle', 'speakap',
            'speaker-deck', 'spell-check', 'spider', 'spinner', 'splotch', 'spoon', 'spotify', 'spray-can',
            'sql', 'square', 'square-full', 'square-o', 'square-root-alt', 'squarespace', 'stack-exchange', 'stack-overflow',
            'stackpath', 'stamp', 'star', 'star-and-crescent', 'star-half', 'star-half-alt', 'star-half-empty', 'star-half-full',
            'star-half-o', 'star-o', 'star-of-david', 'star-of-life', 'staylinked', 'steam', 'steam-square', 'steam-symbol',
            'step-backward', 'step-forward', 'stethoscope', 'sticker-mule', 'sticky-note', 'sticky-note-o', 'stop', 'stop-circle',
            'stop-circle-o', 'stopwatch', 'stopwatch-20', 'store', 'store-alt', 'store-alt-slash', 'store-slash', 'strava',
            'stream', 'street-view', 'strikethrough', 'stripe', 'stripe-s', 'stroopwafel', 'studiovinari', 'stumbleupon',
            'stumbleupon-circle', 'styl', 'subscript', 'subway', 'suitcase', 'suitcase-rolling', 'sun', 'sun-o',
            'superpowers', 'superscript', 'supple', 'support', 'surprise', 'suse', 'svg', 'swatchbook',
            'swf', 'swift', 'swimmer', 'swimming-pool', 'symfony', 'synagogue', 'sync', 'sync-alt',
            'syringe', 'table', 'tablet', 'tablet-alt', 'table-tennis', 'tablets', 'tachometer', 'tachometer-alt',
            'tag', 'tags', 'tape', 'tar', 'tasks', 'taxi', 'teamspeak', 'teeth',
            'teeth-open', 'telegram', 'telegram-plane', 'television', 'temperature-high', 'temperature-low', 'tencent-weibo', 'tenge',
            'terminal', 'text-height', 'text-width', 'tgz', 'th', 'theater-masks', 'themeco', 'themeisle',
            'the-red-yeti', 'thermometer', 'thermometer-0', 'thermometer-1', 'thermometer-2', 'thermometer-3', 'thermometer-4', 'thermometer-empty',
            'thermometer-full', 'thermometer-half', 'thermometer-quarter', 'thermometer-three-quarters', 'think-peaks', 'th-large', 'th-list', 'thumbs-down',
            'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'thumb-tack', 'thumbtack', 'ticket', 'ticket-alt', 'tiff',
            'tiktok', 'times', 'times-circle', 'times-circle-o', 'times-rectangle', 'times-rectangle-o', 'tint', 'tint-slash',
            'tired', 'toggle-down', 'toggle-left', 'toggle-off', 'toggle-on', 'toggle-right', 'toggle-up', 'toilet',
            'toilet-paper', 'toilet-paper-slash', 'toolbox', 'tools', 'tooth', 'torah', 'torii-gate', 'tractor',
            'trade-federation', 'trademark', 'traffic-light', 'trailer', 'train', 'tram', 'transgender', 'transgender-alt',
            'trash', 'trash-alt', 'trash-o', 'trash-restore', 'trash-restore-alt', 'tree', 'trello', 'trophy',
            'truck', 'truck-loading', 'truck-monster', 'truck-moving', 'truck-pickup', 'try', 'tshirt', 'tty',
            'tumblr', 'tumblr-square', 'turkish-lira', 'tv', 'twitch', 'twitter', 'twitter-square', 'txt',
            'typo3', 'uber', 'ubuntu', 'uikit', 'umbraco', 'umbrella', 'umbrella-beach', 'uncharted',
            'underline', 'undo', 'undo-alt', 'uniregistry', 'unity', 'universal-access', 'university', 'unlink',
            'unlock', 'unlock-alt', 'unsorted', 'unsplash', 'untappd', 'upload', 'ups', 'usb',
            'usd', 'user', 'user-alt', 'user-alt-slash', 'user-astronaut', 'user-check', 'user-circle', 'user-circle-o',
            'user-clock', 'user-cog', 'user-edit', 'user-friends', 'user-graduate', 'user-injured', 'user-lock', 'user-md',
            'user-minus', 'user-ninja', 'user-nurse', 'user-o', 'user-plus', 'users', 'users-cog', 'user-secret',
            'user-shield', 'user-slash', 'users-slash', 'user-tag', 'user-tie', 'user-times', 'usps', 'ussunnah',
            'utensils', 'utensil-spoon', 'vaadin', 'vcard', 'vcard-o', 'vcs', 'vector-square', 'venus',
            'venus-double', 'venus-mars', 'vest', 'vest-patches', 'viacoin', 'viadeo', 'viadeo-square', 'vial',
            'vials', 'viber', 'video', 'video-camera', 'video-slash', 'vihara', 'vimeo', 'vimeo-square',
            'vimeo-v', 'vine', 'virus', 'viruses', 'virus-slash', 'vk', 'vnv', 'voicemail',
            'volleyball-ball', 'volume-control-phone', 'volume-down', 'volume-mute', 'volume-off', 'volume-up', 'vote-yea', 'vr-cardboard',
            'vuejs', 'walking', 'wallet', 'warehouse', 'warning', 'watchman-monitoring', 'water', 'wav',
            'wave-square', 'waze', 'wechat', 'weebly', 'weibo', 'weight', 'weight-hanging', 'weixin',
            'whatsapp', 'whatsapp-square', 'wheelchair', 'wheelchair-alt', 'whmcs', 'wifi', 'wikipedia-w', 'wind',
            'window-close', 'window-close-o', 'window-maximize', 'window-minimize', 'window-restore', 'windows', 'wine-bottle', 'wine-glass',
            'wine-glass-alt', 'wix', 'wizards-of-the-coast', 'wma', 'wmv', 'wodu', 'wolf-pack-battalion', 'won',
            'won-sign', 'wordpress', 'wordpress-simple', 'wpbeginner', 'wpexplorer', 'wpforms', 'wpressr', 'wrench',
            'xbox', 'xing', 'xing-square', 'xls', 'xlsx', 'xml', 'x-ray', 'yahoo',
            'yammer', 'yandex', 'yandex-international', 'yarn', 'yc', 'y-combinator', 'y-combinator-square', 'yc-square',
            'yelp', 'yen', 'yen-sign', 'yin-yang', 'yoast', 'youtube', 'youtube-play', 'youtube-square',
            'zhihu', 'zip'
        ];
    }

    /**
     * @return list<array{name: string, class: string}>
     */
    public static function catalog(): array
    {
        $out = [];
        foreach (self::names() as $name) {
            $out[] = [
                'name' => $name,
                'class' => self::cssClass($name),
            ];
        }

        return $out;
    }

    public static function cssClass(string $icon): string
    {
        $icon = strtolower(trim($icon));
        $icon = preg_replace('/\s+/', ' ', $icon) ?? '';
        if (preg_match('/^(?:icon\s+)?(?:icon-|fa[srlbd]?\s+fa-|fa[srlbd]-|fa-)([a-z0-9-]+)$/', $icon, $match)) {
            return 'icon icon-' . $match[1];
        }
        if (preg_match('/^([a-z0-9-]+)$/', $icon, $match)) {
            return 'icon icon-' . $match[1];
        }

        return 'icon icon-link';
    }

    public static function normalizeName(string $icon): string
    {
        $class = self::cssClass($icon);
        $name = substr($class, strlen('icon icon-'));

        return is_string($name) && $name !== '' ? $name : 'link';
    }
}
