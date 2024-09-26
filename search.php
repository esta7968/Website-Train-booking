<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Availablity</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Treazure</h1>
        </div>
    </nav>
    <div class="wrapper">
        <form action="available.php" method="post">
            <h1>Search for Trains</h1>
            <div class="input-box">
                <select name="source" required>
                    <option value="">Select Source Station</option>
                    <option value="London">London</option>
                    <option value="Manchester">Manchester</option>
                    <option value="Birmingham">Birmingham</option>
                    <option value="Glasgow">Glasgow</option>
                    <option value="Edinburgh">Edinburgh</option>
                    <option value="Cardiff">Cardiff</option>
                    <option value="Bristol">Bristol</option>
                    <option value="Liverpool">Liverpool</option>
                </select>
                <i class='bx bx-map'></i>
            </div>
            <div class="input-box">
                <select name="destination" required>
                    <option value="">Select Destination Station</option>
                    <option value="London">London</option>
                    <option value="Manchester">Manchester</option>
                    <option value="Birmingham">Birmingham</option>
                    <option value="Glasgow">Glasgow</option>
                    <option value="Edinburgh">Edinburgh</option>
                    <option value="Cardiff">Cardiff</option>
                    <option value="Bristol">Bristol</option>
                    <option value="Liverpool">Liverpool</option>
                </select>
                <i class='bx bxs-map-pin'></i>
            </div>
            <div class="input-box">
                <input type="time" name="departure_time" placeholder="Departure Time" required>
                <i class='bx bx-time-five'></i>
            </div>
            <div class="input-box">
                <input type="date" name="departure_date" placeholder="Departure Date" required>
                <i class='bx bx-date'></i>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
        
    </div>
    

</body>
</html>