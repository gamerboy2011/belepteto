<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incedo Pro - Hardware & Térkép</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans h-screen flex flex-col">

    <header class="bg-slate-950 border-b border-slate-800 px-6 py-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-3 h-3 bg-cyan-500 rounded-full shadow-[0_0_10px_#06b6d4]"></div>
            <h1 class="text-lg font-semibold tracking-wider text-slate-200">ASSA ABLOY <span class="text-cyan-400 font-bold">incedo</span> <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded ml-2">PRO v4.2</span></h1>
        </div>
        <nav class="flex gap-4">
            <a href="index.php?tab=dashboard" class="px-4 py-2 rounded-lg text-sm font-medium transition text-slate-400 hover:bg-slate-900 hover:text-slate-200">📊 Monitoring</a>
            <a href="index.php?tab=hardware" class="px-4 py-2 rounded-lg text-sm font-medium transition bg-cyan-600 text-white">🚪 Térkép & Hardver</a>
        </nav>
    </header>

    <main class="flex-1 p-6 max-w-5xl w-full mx-auto space-y-6">
        <h2 class="text-lg font-bold text-slate-300 border-b border-slate-800 pb-2">🚪 Hardware & Térkép Menedzsment (MVC View)</h2>
        
        <div class="relative w-full h-80 bg-slate-950 rounded-xl border border-slate-800 shadow-inner overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>

            <?php foreach($doors as $door): 
                // Színkódok igazítása az adatbázis állapothoz
                $color = $door['mode'] === 'LOCKED' ? 'bg-rose-500 shadow-[0_0_10px_#f43f5e]' : ($door['mode'] === 'ALWAYS_OPEN' ? 'bg-cyan-500 shadow-[0_0_10px_#06b6d4]' : 'bg-emerald-500 shadow-[0_0_10px_#10b981]');
            ?>
                <div class="absolute transition-all duration-500 transform -translate-x-1/2 -translate-y-1/2" style="left: <?= (int)$door['map_x'] ?>%; top: <?= (int)$door['map_y'] ?>%;">
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-4 h-4 <?= $color ?> rounded-full animate-pulse"></div>
                        <span class="text-[10px] bg-slate-900/90 px-1.5 py-0.5 rounded border border-slate-800 font-medium text-slate-300 block whitespace-nowrap shadow-md"><?= htmlspecialchars($door['name']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach($doors as $door): ?>
                <div class="p-4 bg-slate-950 border border-slate-800 rounded-xl flex justify-between items-center shadow-md">
                    <div class="space-y-1">
                        <span class="font-semibold text-sm text-slate-200 block"><?= htmlspecialchars($door['name']) ?></span>
                        <span class="text-[10px] text-slate-500 uppercase tracking-wider">Mód: <b class="text-slate-400"><?= $door['mode'] ?></b></span>
                    </div>
                    
                    <div class="flex gap-1 text-xs">
                        <a href="index.php?tab=hardware&change_mode=NORMAL&door_id=<?= $door['id'] ?>" class="px-3 py-1.5 bg-slate-900 border border-slate-800 rounded-lg text-slate-300 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition">Auto</a>
                        <a href="index.php?tab=hardware&change_mode=ALWAYS_OPEN&door_id=<?= $door['id'] ?>" class="px-3 py-1.5 bg-slate-900 border border-slate-800 rounded-lg text-slate-300 hover:bg-cyan-600 hover:text-white hover:border-cyan-600 transition">Nyit</a>
                        <a href="index.php?tab=hardware&change_mode=LOCKED&door_id=<?= $door['id'] ?>" class="px-3 py-1.5 bg-slate-900 border border-slate-800 rounded-lg text-slate-300 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition">Tilt</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>