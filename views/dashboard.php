<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incedo Pro - Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans h-screen flex flex-col">

    <header class="bg-slate-950 border-b border-slate-800 px-6 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-3 h-3 bg-cyan-500 rounded-full shadow-[0_0_10px_#06b6d4]"></div>
            <h1 class="text-lg font-semibold tracking-wider text-slate-200">ASSA ABLOY <span class="text-cyan-400 font-bold">incedo</span> <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded ml-2">PRO v4.2</span></h1>
        </div>
        <nav class="flex gap-4">
            <a href="index.php?tab=dashboard" class="px-4 py-2 rounded-lg text-sm font-medium transition bg-cyan-600 text-white">📊 Monitoring</a>
            <a href="index.php?tab=hardware" class="px-4 py-2 rounded-lg text-sm font-medium transition text-slate-400 hover:bg-slate-900 hover:text-slate-200">🚪 Térkép & Hardver</a>
        </nav>
    </header>

    <main class="flex-1 p-6 max-w-5xl w-full mx-auto space-y-6 overflow-y-auto">
        <h2 class="text-lg font-bold text-slate-300 border-b border-slate-800 pb-2">📊 Dashboard & Monitoring</h2>

        <!-- Ajtók állapota -->
        <section>
            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Ajtók állapota</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($doors as $door):
                    $statusColor = match($door['mode']) {
                        'LOCKED' => 'border-rose-500 text-rose-400',
                        'ALWAYS_OPEN' => 'border-cyan-500 text-cyan-400',
                        default => 'border-emerald-500 text-emerald-400',
                    };
                    $dotColor = match($door['mode']) {
                        'LOCKED' => 'bg-rose-500',
                        'ALWAYS_OPEN' => 'bg-cyan-500',
                        default => 'bg-emerald-500',
                    };
                    $modeLabel = match($door['mode']) {
                        'LOCKED' => 'Lezárva',
                        'ALWAYS_OPEN' => 'Nyitva tartva',
                        default => 'Normál',
                    };
                ?>
                <div class="p-4 bg-slate-950 border <?= $statusColor ?> rounded-xl shadow-md">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2.5 h-2.5 <?= $dotColor ?> rounded-full animate-pulse"></div>
                        <span class="font-semibold text-sm text-slate-200"><?= htmlspecialchars($door['name']) ?></span>
                    </div>
                    <span class="text-xs uppercase tracking-wider"><?= $modeLabel ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Utolsó belépések -->
        <section>
            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Utolsó belépések</h3>
            <?php if (empty($logs)): ?>
                <p class="text-slate-500 text-sm">Még nincsenek naplóbejegyzések.</p>
            <?php else: ?>
                <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="text-left px-4 py-3">Időpont</th>
                                <th class="text-left px-4 py-3">Felhasználó</th>
                                <th class="text-left px-4 py-3">Ajtó</th>
                                <th class="text-left px-4 py-3">Eredmény</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log):
                                $resultColor = ($log['result'] ?? '') === 'GRANT' ? 'text-emerald-400' : 'text-rose-400';
                            ?>
                            <tr class="border-b border-slate-800/50 hover:bg-slate-900/50 transition">
                                <td class="px-4 py-2.5 text-slate-400"><?= htmlspecialchars($log['timestamp'] ?? '') ?></td>
                                <td class="px-4 py-2.5 text-slate-200"><?= htmlspecialchars($log['user_name'] ?? $log['uid'] ?? 'N/A') ?></td>
                                <td class="px-4 py-2.5 text-slate-300"><?= htmlspecialchars($log['door_name'] ?? 'Ajtó #' . ($log['door_id'] ?? '?')) ?></td>
                                <td class="px-4 py-2.5 font-semibold <?= $resultColor ?>"><?= htmlspecialchars($log['result'] ?? 'N/A') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
