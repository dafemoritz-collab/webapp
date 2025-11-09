<?php
// real-madrid-index.php
// Simple single-file PHP website about Real Madrid
// Drop this file into your webroot (e.g., /var/www/html) and open in browser.

// Sample data (you can replace with real data or a database later)
$club = [
    'name' => 'Real Madrid CF',
    'founded' => 1902,
    'stadium' => 'Santiago Bernabéu',
    'manager' => 'Carlo Ancelotti',
    'website' => 'https://www.realmadrid.com',
    'description' => "Real Madrid Club de Fútbol is a professional football club based in Madrid, Spain. Known for its rich history, record-breaking achievements and a galaxy of the world's top players, Real Madrid is one of the most successful and popular clubs in football history."
];

$achievements = [
    'La Liga titles' => 35,
    'UEFA Champions League' => 14,
    'Copa del Rey' => 19,
    'FIFA Club World Cup' => 5
];

// Small sample squad (replace/extend as needed)
$squad = [
    ['number' => 1, 'name' => 'Thibaut Courtois', 'position' => 'Goalkeeper'],
    ['number' => 4, 'name' => 'Éder Militão', 'position' => 'Defender'],
    ['number' => 5, 'name' => 'Nacho', 'position' => 'Defender'],
    ['number' => 8, 'name' => 'Toni Kroos', 'position' => 'Midfielder'],
    ['number' => 9, 'name' => 'Brahim Díaz', 'position' => 'Forward'],
    ['number' => 11, 'name' => 'Rodrygo', 'position' => 'Forward'],
    ['number' => 14, 'name' => 'Karim Benzema', 'position' => 'Forward']
];

$recent_matches = [
    ['date' => '2025-11-02', 'opponent' => 'Atlético Madrid', 'score' => '2 - 1', 'competition' => 'La Liga'],
    ['date' => '2025-10-26', 'opponent' => 'Liverpool', 'score' => '1 - 1', 'competition' => 'UEFA Champions League'],
    ['date' => '2025-10-19', 'opponent' => 'Valencia', 'score' => '3 - 0', 'competition' => 'La Liga']
];

// Simple contact form processing (no email sending by default) - keeps submissions in session
session_start();
if (!isset($_SESSION['messages'])) $_SESSION['messages'] = [];
$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($name && $email && $msg) {
        $_SESSION['messages'][] = ['name' => htmlspecialchars($name), 'email' => htmlspecialchars($email), 'message' => htmlspecialchars($msg), 'time' => date('Y-m-d H:i:s')];
        $message_sent = true;
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($club['name']); ?> — Fan Site</title>
    <style>
        :root{font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}
        body{margin:0;background:#f7f7f8;color:#111}
        header{background:#002663;color:#fff;padding:24px 16px;display:flex;align-items:center;justify-content:space-between}
        .logo{display:flex;align-items:center;gap:12px}
        .logo .crest{width:56px;height:56px;border-radius:8px;background:linear-gradient(135deg,#fff,#eee);display:flex;align-items:center;justify-content:center;color:#002663;font-weight:700}
        nav a{color:#fff;margin-left:16px;text-decoration:none;font-weight:600}
        .container{max-width:1100px;margin:28px auto;padding:0 16px}
        .hero{background:#fff;border-radius:12px;padding:20px;display:flex;gap:20px;align-items:center;box-shadow:0 6px 18px rgba(16,24,40,.06)}
        .hero .text h1{margin:0;font-size:28px}
        .grid{display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-top:20px}
        .card{background:#fff;border-radius:10px;padding:16px;box-shadow:0 6px 18px rgba(16,24,40,.04)}
        ul.clean{list-style:none;padding:0;margin:0}
        table{width:100%;border-collapse:collapse}
        table td,table th{padding:8px;border-bottom:1px solid #eee;text-align:left}
        footer{padding:24px;text-align:center;color:#666}
        .squad-list li{padding:8px 0;border-bottom:1px dashed #eee}
        .badge{display:inline-block;padding:6px 8px;border-radius:999px;background:#fde047;font-weight:700}
        @media(max-width:800px){.grid{grid-template-columns:1fr;}.hero{flex-direction:column;align-items:flex-start}}
    </style>
</head>
<body>
<header>
    <div class="logo">
        <div class="crest">RM</div>
        <div>
            <div style="font-size:18px;font-weight:800"><?php echo htmlspecialchars($club['name']); ?></div>
            <div style="font-size:12px;opacity:.85">Founded <?php echo (int)$club['founded']; ?> • <?php echo htmlspecialchars($club['stadium']); ?></div>
        </div>
    </div>
    <nav>
        <a href="#club">Club</a>
        <a href="#squad">Squad</a>
        <a href="#matches">Matches</a>
        <a href="#contact">Contact</a>
    </nav>
</header>

<main class="container">
    <section class="hero">
        <div class="text">
            <h1>Welcome to the fan-made Real Madrid page</h1>
            <p style="margin:8px 0 0;max-width:60ch"><?php echo htmlspecialchars($club['description']); ?></p>
            <p style="margin:12px 0 0"><a href="<?php echo htmlspecialchars($club['website']); ?>" target="_blank">Official website</a></p>
        </div>
        <div style="margin-left:auto;text-align:right">
            <div class="badge">Latest: La Liga & Champions</div>
            <div style="margin-top:8px;font-size:13px;opacity:.9">Manager: <?php echo htmlspecialchars($club['manager']); ?></div>
        </div>
    </section>

    <div class="grid">
        <section class="card" id="club">
            <h2>Club Info</h2>
            <table>
                <tr><th>Founded</th><td><?php echo (int)$club['founded']; ?></td></tr>
                <tr><th>Stadium</th><td><?php echo htmlspecialchars($club['stadium']); ?></td></tr>
                <tr><th>Manager</th><td><?php echo htmlspecialchars($club['manager']); ?></td></tr>
                <tr><th>Notable trophies</th><td>
                    <ul class="clean">
                        <?php foreach($achievements as $k => $v): ?>
                            <li><?php echo htmlspecialchars($k); ?> — <strong><?php echo htmlspecialchars((string)$v); ?></strong></li>
                        <?php endforeach; ?>
                    </ul>
                </td></tr>
            </table>

            <h3 style="margin-top:18px">About the club</h3>
            <p style="line-height:1.6">Real Madrid has produced and signed many of the world's best players across eras. This fan page provides a quick overview of the club, recent results, and the current squad.</p>

        </section>

        <aside class="card" id="squad">
            <h3>First Team Squad</h3>
            <ul class="clean squad-list">
                <?php foreach($squad as $player): ?>
                    <li><?php echo sprintf("#%d — %s <span style='float:right;font-size:12px;opacity:.7'>%s</span>", (int)$player['number'], htmlspecialchars($player['name']), htmlspecialchars($player['position'])); ?></li>
                <?php endforeach; ?>
            </ul>

            <h4 style="margin-top:14px">Quick facts</h4>
            <p style="font-size:13px;opacity:.9">Stadium capacity and ticket info changes frequently — check the official site for the latest details.</p>
        </aside>
    </div>

    <div class="grid" style="margin-top:18px">
        <section class="card" id="matches">
            <h2>Recent Matches</h2>
            <table>
                <thead>
                    <tr><th>Date</th><th>Opponent</th><th>Score</th><th>Competition</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_matches as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['date']); ?></td>
                            <td><?php echo htmlspecialchars($m['opponent']); ?></td>
                            <td><?php echo htmlspecialchars($m['score']); ?></td>
                            <td><?php echo htmlspecialchars($m['competition']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 style="margin-top:14px">Match highlights</h3>
            <p style="line-height:1.6">Add short highlights here or embed videos (YouTube embeds require switching to HTTPS and possibly updating site CSP).</p>
        </section>

        <aside class="card" id="contact">
            <h3>Contact / Fan messages</h3>
            <?php if($message_sent): ?>
                <div style="padding:10px;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:12px">Thanks! Your message was saved locally for this session.</div>
            <?php endif; ?>

            <form method="post" style="display:flex;flex-direction:column;gap:8px">
                <input type="text" name="name" placeholder="Your name" required style="padding:8px;border-radius:6px;border:1px solid #ddd">
                <input type="email" name="email" placeholder="Email" required style="padding:8px;border-radius:6px;border:1px solid #ddd">
                <textarea name="message" placeholder="Message to the fans" rows="4" required style="padding:8px;border-radius:6px;border:1px solid #ddd"></textarea>
                <button type="submit" name="contact_submit" style="padding:10px;border-radius:8px;border:none;background:#002663;color:#fff;font-weight:700">Send message</button>
            </form>

            <?php if(!empty($_SESSION['messages'])): ?>
                <h4 style="margin-top:14px">Messages (session)</h4>
                <ul class="clean" style="max-height:180px;overflow:auto">
                    <?php foreach(array_reverse($_SESSION['messages']) as $msg): ?>
                        <li style="padding:8px;border-bottom:1px solid #f1f1f1"><strong><?php echo $msg['name']; ?></strong> <small style="opacity:.7">@ <?php echo $msg['time']; ?></small><div style="margin-top:6px;font-size:14px"><?php echo $msg['message']; ?></div></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>
    </div>

    <section class="card" style="margin-top:18px">
        <h2>Gallery & Stadium</h2>
        <p style="margin-top:0">Add images for the crest, kit, or the Santiago Bernabéu. For now we show placeholders you should replace with real media.</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
            <div style="width:220px;height:120px;border-radius:8px;background:#e9eef7;display:flex;align-items:center;justify-content:center">Stadium (placeholder)</div>
            <div style="width:220px;height:120px;border-radius:8px;background:#ffeef0;display:flex;align-items:center;justify-content:center">Team kit (placeholder)</div>
            <div style="width:220px;height:120px;border-radius:8px;background:#eafaea;display:flex;align-items:center;justify-content:center">Crest (placeholder)</div>
        </div>
    </section>

</main>

<footer>
    <div class="container">
        <p>This is a fan-made site and not affiliated with or endorsed by Real Madrid CF. For official news, visit the club's official website.</p>
        <p style="margin-top:8px">© <?php echo date('Y'); ?> Fan Site</p>
    </div>
</footer>

</body>
</html>
