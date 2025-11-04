<?php
// =============================================================
//  Hex → Hash Tool (PHP)
//  Gera hexadecimal aleatória e cria hash; também converte
//  uma hexadecimal informada em hash.
// =============================================================

function generate_random_hex($length = 12)
{
    if ($length <= 0) return '';

    $bytes = (int)ceil($length / 2);

    try {
        return substr(bin2hex(random_bytes($bytes)), 0, $length);
    } catch (Exception $e) {
        // Fallback manual
        $pool = '0123456789abcdef';
        $out = '';

        for ($i = 0; $i < $length; $i++) {
            $out .= $pool[random_int(0, 15)];
        }

        return $out;
    }
}

$generated_hex   = '';
$generated_hash  = '';
$converted_hash  = '';
$messages        = [];

// =============================================================
//  Processamento do Formulário
// =============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // === Gerar hex aleatória e hashear ===
    if (!empty($_POST['action']) && $_POST['action'] === 'generate_hex') {
        $len = isset($_POST['hex_length']) ? (int)$_POST['hex_length'] : 12;
        $len = max(2, min(128, $len));

        $generated_hex  = generate_random_hex($len);
        $generated_hash = password_hash($generated_hex, PASSWORD_DEFAULT);
    }

    // === Converter hex fornecida para hash ===
    if (!empty($_POST['action']) && $_POST['action'] === 'convert_hex') {
        $user_hex = trim($_POST['user_hex'] ?? '');

        if ($user_hex === '') {
            $messages[] = "Por favor, informe a string hexadecimal.";
        } elseif (!ctype_xdigit($user_hex)) {
            $messages[] = "String inválida: apenas caracteres hexadecimais (0-9, a-f, A-F) são permitidos.";
        } else {
            $user_hex       = strtolower($user_hex);
            $converted_hash = password_hash($user_hex, PASSWORD_DEFAULT);
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Gerar Senha HASH | OliveiraPC</title>
        <link rel="icon" href="logo-oliveirapc.png" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <style>
        body {
            font-family: system-ui, Arial, Helvetica, sans-serif;
            max-width: 900px;
            margin: 28px auto;
            padding: 18px;
        }

        h1 { margin: 0 0 6px; }

        .card {
            background: #f8f9fa;
            padding: 14px;
            border-radius: 8px;
            margin-top: 14px;
            border: 1px solid #eee;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
        }

        input[type=text],
        input[type=number],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 0;
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        .small { font-size: 0.9em; color: #555; }

        pre {
            background: #222;
            color: #f8f8f8;
            padding: 10px;
            border-radius: 6px;
            overflow: auto;
        }

        .msg {
            background: #fff4e5;
            border-left: 4px solid #ffb400;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .ok {
            background: #e8f7ea;
            border-left: 4px solid #28a745;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .copy-btn {
            padding: 6px 10px;
            border-radius: 6px;
            border: 0;
            background: #444;
            color: #fff;
            cursor: pointer;
        }

        footer {
            margin-top:30px;
            font-size:14px;
            color:#aaa;
            text-align:center;
        }
    </style>

    <script>
        function copyToClipboard(id) {
            const el = document.getElementById(id);
            if (!el) return;

            const text = el.innerText || el.value || el.textContent;
            navigator.clipboard.writeText(text)
                .then(() => alert('Copiado para a área de transferência.'))
                .catch(() => alert('Falha ao copiar.'));
        }
    </script>
</head>

<body>
    <h1>Gerar Senha HASH</h1>
    <p class="small">
        Gera hexadecimal aleatória e cria hash (<code>password_hash()</code>).
        Também converte uma hexadecimal informada para hash.
    </p>

    <?php foreach ($messages as $m): ?>
        <div class="msg"><?php echo htmlspecialchars($m); ?></div>
    <?php endforeach; ?>

    <!-- ============================================================= -->
    <!--  GERAR HEX ALEATÓRIA + HASH -->
    <!-- ============================================================= -->
    <div class="card">
        <h2>Gerar hexadecimal aleatória + hash</h2>

        <form method="post" style="margin-bottom:8px">
            <label>Comprimento da hex (nº de caracteres)</label>
            <div class="row">
                <input type="number" name="hex_length" value="12" min="2" max="128" style="width:120px">
                <button type="submit" name="action" value="generate_hex">Gerar Senha Aleatória</button>
            </div>
        </form>

        <?php if ($generated_hex): ?>
            <div class="ok">
                <strong>Senha gerada</strong>
                <pre id="generated_hex"><?php echo htmlspecialchars($generated_hex); ?></pre>
                <div style="display:flex;gap:8px;margin-top:6px">
                    <button class="copy-btn" onclick="copyToClipboard('generated_hex')">Copiar Senha</button>
                </div>

                <strong style="margin-top:10px;display:block">Senha Hash</strong>
                <pre id="generated_hash"><?php echo htmlspecialchars($generated_hash); ?></pre>
                <div style="display:flex;gap:8px;margin-top:6px">
                    <button class="copy-btn" onclick="copyToClipboard('generated_hash')">Copiar Senha HASH</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- ============================================================= -->
    <!--  CONVERTER HEX PARA HASH -->
    <!-- ============================================================= -->
    <div class="card">
        <h2>Converter Senha para hash</h2>

        <form method="post">
            <label>Digite a Senha</label>
            <input type="text" name="user_hex" placeholder="ex: 1a2b3c4d">
            <button type="submit" name="action" value="convert_hex">Converter para hash</button>
        </form>

        <?php if ($converted_hash): ?>
            <div class="ok">
                <strong>Senha Hash gerada</strong>
                <pre id="converted_hash"><?php echo htmlspecialchars($converted_hash); ?></pre>
                <div style="display:flex;gap:8px;margin-top:6px">
                    <button class="copy-btn" onclick="copyToClipboard('converted_hash')">Copiar Senha HASH</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <hr>
    <p class="small"><strong>Observações:</strong></p>
    <ul class="small">
        <li>
            Este script usa <code>password_hash()</code>.  
            Hashes geradas com esse método **não são reversíveis** — o sistema apenas gera o hash para a hex informada.
        </li>
    </ul>

    <footer>
    &copy; 2025 OliveiraPC.com - Gerar Senha HASH
    </footer>

</body>
</html>
