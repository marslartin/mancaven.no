include(__DIR__ . '/../konfigurasjon/hemmelighet.php');

// Hent rådata og GitHub-signatur
$payload = file_get_contents('php://input');
$github_signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret, false);

// Sjekk at signaturen matcher
if (!hash_equals($expected, $github_signature)) {
    http_response_code(403);
    echo "Feil signatur.";
    exit;
}

// Kjør deploy
include(__DIR__ . '/../konfigurasjon/griper.php');
