<?php
include "config.php";
if (!isset($_SESSION["user_id"])) { header("Location: index.php"); exit(); }

$user_id = $_SESSION["user_id"];
$current_field_id = isset($_GET['field_id']) ? intval($_GET['field_id']) : 0;
$all_fields = mysqli_query($conn, "SELECT * FROM fields WHERE user_id=$user_id");

if ($current_field_id == 0) {
    $first_field = mysqli_query($conn, "SELECT id FROM fields WHERE user_id=$user_id LIMIT 1");
    $row = mysqli_fetch_assoc($first_field);
    $current_field_id = $row['id'] ?? 0;
}

$field_data = mysqli_query($conn, "SELECT * FROM fields WHERE id=$current_field_id");
$field = mysqli_fetch_assoc($field_data);
$s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sensors WHERE field_id=$current_field_id ORDER BY last_updated DESC LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | AgroSenyx</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h2 style="color:var(--primary); margin-bottom:30px;">AgroSenyx</h2>
    <p style="font-size:12px; color:#888; text-transform:uppercase;">Moje Parcele</p>
    <?php while($f = mysqli_fetch_assoc($all_fields)): ?>
        <a href="dashboard.php?field_id=<?php echo $f['id']; ?>" 
           style="display:block; padding:12px; margin-bottom:8px; text-decoration:none; border-radius:8px; 
                  background: <?php echo ($f['id'] == $current_field_id) ? '#e8f5e9' : 'transparent'; ?>;
                  color: <?php echo ($f['id'] == $current_field_id) ? 'var(--primary)' : '#555'; ?>; font-weight:bold;">
            🌾 <?php echo $f['field_name']; ?>
        </a>
    <?php endwhile; ?>
    
    <div style="margin-top:auto; padding-top:20px;">
        <hr style="border:0; border-top:1px solid #eee; margin-bottom:20px;">
        <p style="font-size:14px;">👤 <strong><?php echo $_SESSION["username"]; ?></strong></p>
        <a href="logout.php" style="color:#d32f2f; text-decoration:none; font-size:14px; font-weight:bold;">Odjavi se</a>
    </div>
</div>

<div class="main-content">
    <h1 style="margin-bottom:30px;"><?php echo $field['field_name'] ?? "Nema parcele"; ?></h1>
    
    <div class="dashboard-grid">
        <div class="stat-card"><h4>💧 Vlažnost</h4><div style="font-size:28px; font-weight:bold; color:var(--primary);"><?php echo $s['soil_moisture'] ?? 0; ?>%</div></div>
        <div class="stat-card"><h4>🌡️ Temp.</h4><div style="font-size:28px; font-weight:bold; color:var(--primary);"><?php echo $s['soil_temp'] ?? 0; ?>°C</div></div>
        <div class="stat-card"><h4>🧪 pH</h4><div style="font-size:28px; font-weight:bold; color:var(--primary);"><?php echo $s['ph_value'] ?? 0; ?></div></div>
        <div class="stat-card"><h4>⚡ EC</h4><div style="font-size:28px; font-weight:bold; color:var(--primary);"><?php echo $s['ec_value'] ?? 0; ?></div></div>
    </div>

    <div class="map-container">
        <h3>Interaktivna mapa zona</h3>
        <div class="interactive-grid">
            <div class="zone-card optimal"><span>Zona A</span><div style="margin:auto; font-size:24px;">📡</div></div>
            <div class="zone-card warning"><span>Zona B</span><div style="margin:auto; font-size:24px;">📡</div></div>
            <div class="zone-card optimal"><span>Zona C</span><div style="margin:auto; font-size:24px;">📡</div></div>
            <div class="zone-card optimal"><span>Zona D</span><div style="margin:auto; font-size:24px;">📡</div></div>
            <div class="zone-card critical"><span>Zona E</span><div style="margin:auto; font-size:24px;">📡</div></div>
            <div class="zone-card optimal"><span>Zona F</span><div style="margin:auto; font-size:24px;">📡</div></div>
        </div>
    </div>
</div>

</body>
</html>