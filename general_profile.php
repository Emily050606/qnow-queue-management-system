<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: rgb(250, 253, 174);
        }

        .page-title {
            text-align: center;
            font-size: 35px;
            font-weight: 800;
            color: #FF8A00;
            margin-top: 130px;
        }

        .menu-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            padding: 15px 40px;
            z-index: 100;
        }

        .menu-bar .logo {
            height: 70px;
            cursor: pointer;
            margin-left: 50px;
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
            gap: 65px;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .menu-bar ul li a {
            text-decoration: none;   
            color: #333;            
            font-weight: 800;
            transition: color 0.3s ease;
        }

        .menu-bar ul li a:hover {
            color: #FF8A00;         
        }

        .menu-bar .profile-logo {
            height: 50px;          
            width: 50px;         
            border-radius: 50%;     
            cursor: pointer;
            margin-left: 1050px;      
        }

        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.2);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 50;
        }

        .menu-bar:hover + .blur-overlay {
            opacity: 1;
        }

        .page-title {
            margin-top: 10px;  
            text-align: center;
            font-size: 38px;
            font-weight: 800;
            color: #FF8A00;
            letter-spacing: 1px;
        }

        .branch-wrapper {
            padding: 150px 40px 80px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        .branch-link {
            width: 100%;
            max-width: 800px;
            text-decoration: none;
            color: inherit;
        }

        .branch-card {
            background: linear-gradient(to bottom, #ffffff, #fff8e6);
            border-radius: 22px;
            padding: 28px;
            border: 1px solid rgba(255, 138, 0, 0.2);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            text-align: center;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            cursor: pointer;
        }

        .branch-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 28px rgba(255, 138, 0, 0.25);
        }

        .branch-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 18px;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .branch-name {
            margin-top: 18px;
            font-size: 24px;
            font-weight: 800;
            color: #FF8A00;
            letter-spacing: 0.5px;
        }

        .branch-address {
            margin-top: 8px;
            font-size: 16px;
            color: #666;
        }


    </style>
</head>
<body>
    <div class="menu-bar">
        <img src="logo.png" alt="Logo" class="logo">
        <ul>
            <li><a href="generalinterface.php">Customer Check In</a></li>
            <li><a href="general_managequeue.php">Queue</a></li>
            <li><a href="general_analysisofrestaurant.php">Analysis</a></li>
            <li><a href="general_report.php">Report Web Issue</a></li>
            <li><a href="adminlogout.php">Log Out</a></li>
        </ul>
        <a href="general_profile.php">
            <img src="profile.png" alt="Profile" class="profile-logo">
        </a>
    </div>
    <div class="blur-overlay"></div>
   <div class="branch-wrapper">
    <h1 class="page-title">All Branches</h1>

        <a href="global_setting.php" class="branch-link">
            <div class="branch-card">
                <div class="branch-text">
                    <h3 class="branch-name">Global Settings</h3>
                    <p class="branch-address">Manage operation hours applied to all branches.</p>
                </div>
            </div>
        </a>

        <a href="branch1.php" class="branch-link">
            <div class="branch-card">
                <img src="branch1.jpg" class="branch-img">
                <div class="branch-text">
                    <h3 class="branch-name">Shin Zushi USJ</h3>
                    <p class="branch-address">19-G, 19-G, Jalan USJ 10/1, Taipan USJ, 47620 Subang Jaya, Selangor.</p>
                </div>
            </div>
        </a>

        <a href="branch2.php" class="branch-link">
            <div class="branch-card">
                <img src="branch2.webp" class="branch-img">
                <div class="branch-text">
                    <h3 class="branch-name">Shin Zushi Kepong</h3>
                    <p class="branch-address">109, Jln Rimbunan Raya 1, Laman Rimbunan, 52100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
                </div>
            </div>
        </a>

        <a href="branch3.php" class="branch-link">
            <div class="branch-card">
                <img src="branch3.webp" class="branch-img">
                <div class="branch-text">
                    <h3 class="branch-name">Shin Zushi Bukit Jalil</h3>
                    <p class="branch-address">Ground Floor, No.11, Jalan Jalil Jaya 7 Jalil Link, Bukit Jalil, 57000 Kuala Lumpur</p>
                </div>
            </div>
        </a>

        <a href="branch4.php" class="branch-link">
            <div class="branch-card">
                <img src="branch4.webp" class="branch-img">
                <div class="branch-text">
                    <h3 class="branch-name">Shin Zushi SS2</h3>
                    <p class="branch-address">4, Jalan SS 2/66, SS 2, 47300 Petaling Jaya, Selangor</p>
                </div>
            </div>
        </a>

        <a href="branch5.php" class="branch-link">
            <div class="branch-card">
                <img src="branch5.webp" class="branch-img">
                <div class="branch-text">
                    <h3 class="branch-name">Uo Shin Setapak</h3>
                    <p class="branch-address">LOT 126-G-7, METRO GENTING KLANG, Jalan Genting Kelang, Taman Danau Kota, 53300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
                </div>
            </div>
        </a>
    </div>

    <script type="module">
</script>
</body>
</html>
