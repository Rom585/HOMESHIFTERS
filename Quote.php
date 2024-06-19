<?php

session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['customer_id'];

// Fetch user data from the database
$sql = "SELECT fullname, email FROM customers WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
    $email = $row['email'];
} else {
    // Handle case where no user data is found
    $fullname = "";
    $email = "";
}

if(isset($_POST['btnSave'])){
    $moving_to = mysqli_real_escape_string($conn, $_POST['moving_to']);
    $moving_from = mysqli_real_escape_string($conn, $_POST['moving_from']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $quote_date = date('Y-m-d', strtotime($_POST['quote_date']));
    $moving_date = date('Y-m-d', strtotime($_POST['moving_date']));
    $moving_package = mysqli_real_escape_string($conn, $_POST['moving_package']);

    $stmt = mysqli_prepare($conn, "INSERT INTO moving (moving_to, moving_from, fullname, email, phone_number, quote_date, moving_date, moving_package) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssss", $moving_to, $moving_from, $fullname, $email, $phone_number, $quote_date, $moving_date, $moving_package);
    mysqli_stmt_execute($stmt);

    if(mysqli_stmt_affected_rows($stmt) > 0){
        ?>
        <script>window.alert('Record Saved');</script>
        <script>window.location='ConfirmedForm.php';</script>
        <?php
    }else{
        echo mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quote</title>
    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="Quote.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
<!-- Header design -->
<header>
    <a href="Homepage.php" class="logo">Home<span>Shifters</span></a>

    <ul class="navbar">
        <li><a href="Homepage.php">Home</a></li>
        <li><a href="BrochurePage.php">Brochure</a></li>
        <li><a href="About.php">About</a></li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Services</a>
            <div class="dropdown-content">
                <a href="Services.php">Moving Services</a>
                <a href="StorageService.php">Storage Services</a>
            </div>
        </li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="#" data-toggle="modal" data-target="#profileModal">Profile</a></li>
    </ul>
</header>

<!-- Fill up section design -->
<section class="fill-up">
    <div class="container">
        <h1>Get a Free Moving Quote</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-box">
            <label>Moving To:</label>
            <select id="updatecity" name="updatecity" required onchange="updateCityDropdown()">
                <option value="" disabled selected>Select Province</option>
                <option value="Cagayan">Cagayan</option>
                <option value="Isabela">Isabela</option>
                <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                <option value="Quirino">Quirino</option>
            </select>
            <br>
            <select id="cityDropdown" required onchange="updateBarangayDropdown()">
                <option value="" disabled selected>Select City/Municipality</option>
            </select>
            <br>
            <select id="barangayDropdown" required onchange="updateToAddress()">
                <option value="" disabled selected>Select Barangay</option>
            </select>
            <br>
            <input type="text" id="moving_number1" placeholder="House Number1 and Street." required oninput="updateToAddress()">
            <br>
            <input type="text" id="moving_to" name="moving_to" placeholder="Poblacion Wext, Flora, Apayao 1245">
        </div>
        <div class="input-box">
            <label>Moving From:</label>
            <select id="updatecityfrom" name="updatecityfrom" required onchange="updateFromCityDropdown()">
                <option value="" disabled selected>Select Province</option>
                <option value="Cagayan">Cagayan</option>
                <option value="Isabela">Isabela</option>
                <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                <option value="Quirino">Quirino</option>
            </select>
            <br>
            <select id="fromCityDropdown" required onchange="updateFromBarangayDropdown()">
                <option value="" disabled selected>Select City/Municipality</option>
            </select>
            <br>
            <select id="fromBarangayDropdown" required onchange="updateFromAddress()">
                <option value="" disabled selected>Select Barangay</option>
            </select>
            <br>
            <input type="text" id="moving_number2" placeholder="House Number2 and Street." required oninput="updateFromAddress()">
            <br>
            <input type="text" id="moving_from" name="moving_from" placeholder="Poblacion Wext, Flora, Apayao 1245">
        </div>
            <div class="input-box">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" placeholder="First M. Last" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="input-box">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="(123) 456-7890" required>
            </div>
            <div class="input-box">
                <label for="moving_date">Quote Date:</label>
                <input type="date" id="quote_date" name="quote_date" value="<?php echo date('Y-m-d');?>" readonly>
            </div>
            <div class="input-box">
                <label for="moving_date">Moving Date:</label>
                <input type="date" id="moving_date" name="moving_date" required>
            </div>
            <div class="input-box">
                <label for="moving_package">Moving Package:</label>
                <select id="moving_package" name="moving_package" required>
                    <option value="">Select an option</option>
                    <option value="Basic Package">Basic Package</option>
                    <option value="Premium Package">Premium Package</option>
                    <option value="Executive Package">Executive Package</option>
                </select>
            </div>
            <div class="input-box">
                <h4>By pressing the submit button below, I give HomeShifters consent to use automated telephone dialing technology to call and/or use SMS text messages at the phone number provided including a wireless number for telemarketing purposes. I understand consent is not a condition of purchase of HomeShifters services.</h4>
                <label>
                    <input type="checkbox" id="myCheckBox" required>
                    I agree to the terms and conditions
                </label>
            </div>
            <button type="submit" class="button" id="btnSave" name="btnSave" disabled>Submit</button>
        </form>
    </div>
</section>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Name :  <?php echo htmlspecialchars($fullname); ?></li>
                        <li>Email :  <?php echo htmlspecialchars($email); ?></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="logoutButton" ><a href="Logout.php">Log Out</a></button>
                </div>
            </div>
        </div>
    </div>

<!-- Footer section design -->
<section class="footer">
   <div class="footer-box">
        <h3>About</h3>
        <a href="#">Our story</a>
        <a href="#">Benefits</a>
        <a href="#">Team</a>
        <a href="#">Careers</a>
    </div>

    <div class="footer-box">
        <h3>Help</h3>
        <a href="#">FAQs</a>
        <a href="#">Contact Us</a>
    </div>

    <div class="footer-box">
        <h3>Social Media</h3>
        <div class="social">
            <a href="#"><i class="ri-instagram-line"></i></a>
            <a href="#"><i class="ri-twitter-x-line"></i></a>
            <a href="#"><i class="ri-facebook-fill"></i></a>
        </div>
    </div>
</section>

<!-- Custom js file -->
<script src="script.js"></script>
<script>
                const provinces = {
                    "Cagayan": ["Abulug", "Alcala", "Allacapan", "Amulung", "Aparri", "Baggao", "Ballesteros", "Buguey", "Calayan", "Camalaniugan", "Claveria", "Enrile", "Gattaran", "Gonzaga", "Iguig", "Lal-lo", "Lasam", "Pamplona", "Peñablanca", "Piat", "Rizal", "Sanchez Mira", "Santa Ana", "Santa Praxedes", "Santa Teresita", "Santo Niño", "Solana", "Sta. Ana", "Sta. Teresita", "Tuao", "Tuguegarao City"],
                    "Isabela":["Alicia","Angadanan", "Aurora", "Benito Soliven", "Burgos", "Cabagan", "Cabatuan", "Cauayan City", "Cordon", "Delfin Albano", "Dinapigue", "Divilacan", "Echague", "Gamu", "Ilagan", "Jones", "Luna", "Maconacon", "Mallig", "Naguilian", "Palanan", "Quezon", "Quirino", "Ramon", "Reina Mercedes", "Roxas", "San Agustin", "San Guillermo", "San Isidro", "San Manuel", "San Mariano", "San Mateo", "San Pablo", "Santa Maria", "Santiago City", "Santo Tomas", "Tumauini"],
                    "Nueva Vizcaya":["Alfonso Castaneda", "Ambaguio", "Aritao", "Bagabag", "Bambang", "Bayombong", "Diadi", "Dupax Del Norte", "Dupax Del Sur", "Kasibu", "Kayapa", "Quezon", "Santa Fe", "Solano", "Villaverde"],
                    "Quirino": ["Aglipay", "Cabarroguis", "Diffun", "Maddela", "Nagtipunan", "Saguday"]
                };

                const barangays = {
                    "Alcala": ["Abbeg", "Afusing Bato", "Afusing Daga", "Agani", "Baculod", "Baybayog", "Cabuluan", "Calantac", "Carallangan", "Centro Norte (Poblacion)", "Centro Sur (Poblacion)", "Dalaoig", "Damurog", "Jurisdiction", "Malalatan", "Maraburab", "Masin", "Pagbangkeruan", "Pared", "Piggatan", "Pinopoc", "Pussian", "San Esteban", "Tamban", "Tupang"],
                    "Aparri": ["Backiling", "Bangag", "Binalan", "Bisagu", "Bukig", "Bulala Norte", "Bulala Sur", "Caagaman", "Centro 1 (Poblacion)", "Centro 2 (Poblacion)", "Centro 3 (Poblacion)", "Centro 4 (Poblacion)", "Centro 5 (Poblacion)", "Centro 6 (Poblacion)", "Centro 7 (Poblacion)", "Centro 8 (Poblacion)", "Centro 9 (Poblacion)", "Centro 10 (Poblacion)", "Centro 11 (Poblacion)", "Centro 12 (Poblacion)", "Centro 13 (Poblacion)", "Centro 14 (Poblacion)", "Centro 15 (Poblacion)", "Dodan", "Fuga Island", "Gaddang", "Linao", "Mabanguc", "Macanaya (Pescaria)", "Maura", "Minanga", "Navagan", "Paddaya", "Paruddun Norte", "Paruddun Sur", "Plaza", "Punta", "San Antonio", "Sanja", "Tallungan", "Toran", "Zinarag"],
                    "Baggao": ["Adaoag", "Agaman", "Agaman Norte", "Agaman Sur", "Alba", "Annayatan", "Asassi", "Asinga-Via", "Awallan", "Bacagan", "Bagunot", "Barsat East", "Barsat West", "Bitag Grande", "Bitag Pequeño", "Bunugan", "C. Verzosa", "Canagatan", "Carupian", "Catugay", "Dabbac Grande", "Dalin", "Dalla", "Hacienda Intal", "Ibulo", "Immurung", "J. Pallagao", "Lasilat", "Mabini", "Masical", "Mocag", "Nangalinan", "Remus", "Poblacion", "San Antonio", "San Francisco", "San Isidro", "San Jose", "San Miguel", "San Vicente", "Santa Margarita", "Santor", "Taguing", "Taguntungan", "Tallang", "Taytay", "Temblique", "Tungel"],
                    "Buguey": ["Ballang", "Balza", "Cabaritan", "Calamegatan", "Centro (Poblacion)", "Centro West", "Dalaya", "Fula", "Leron", "M.Antiporda", "Maddalero", "Mala Weste", "Minanga Este", "Paddaya Este", "Pattao", "Quinawegan", "Remebella", "San Isidro", "Santa Isabel", "Santa Maria", "Tabbac", "Villa Cielo", "Alucao Weste (San Lorenzo)", "Minanga Weste", "Paddaya Weste", "San Juan", "San Vicente", "Villa Gracia", "Villa Leonora"],
                    "Camalaniugan": ["Abagao", "Afunan Cabayu", "Agusi", "Alilinu", "Baggao", "Bantay", "Bulala", "Casili Norte", "Catotoran Norte", "Centro Norte (Poblacion)", "Centro Sur (Poblacion)", "Cullit", "Dacal-Lafugu", "Dammang Norte", "Dugo", "Fusina", "Batalla", "Jurisdiction", "Luec", "Minanga", "Paragat", "Tagum", "Tuluttuging", "Ziminila", "Casili Sur", "Catotoran Sur", "Dammang Sur (Felipe Tuzon)", "Sapping"],
                    "Gattaran": ["Abra", "Aguiguican", "Bangatan Ngagan", "Baracaoit", "Baraoidan", "Barbarit", "Basao", "Bolos Point", "Cabayu", "Calaoagan Bassit", "Calaoagan Dackel", "Capiddigan", "Capissayan Norte", "Capissayan Sur", "Casicallan Sur", "Casicallan Norte", "Centro Norte (Poblacion)", "Centro Sur (Poblacion)", "Cullit", "Cumao", "Cunig", "Dummun", "Fugu", "Ganzano", "Guising", "Langgan", "Lapogan", "L. Adviento", "Mabuno", "Nabaccayan", "Naddungan", "Nagatutuan", "Nassiping", "Newagac", "Palagao Norte", "Palagao Sur", "Piña Este", "Piña Weste", "Santa Ana", "San Carlos", "San Vicente", "Santa Maria", "Sidem", "Tagumay", "Takiki", "Taligan", "Tanglagan", "T. Elizaga (Mabirbira)", "Tubungan Este", "Tubungan Weste"],
                    "Gonzaga": ["Amunitan", "Batangan", "Baua", "Cabanbanan Norte", "Cabanbanan Sur", "Cabiraoan", "Callao", "Calayan", "Caroan", "Casitan", "Flourishing (Poblacion)", "Ipil", "Isca", "Magrafil", "Minanga", "Rebecca (Nagbabacalan)", "Paradise (Poblacion)", "Pateng", "Progressive (Poblacion)", "San Jose", "Santa Clara", "Santa Cruz", "Santa Maria", "Smart (Poblacion)", "Tapel"],
                    "Lal-lo": ["Abagao", "Alaguia", "Bagumbayan", "Bangag", "Bical", "Bicud", "Binag", "Cabayabasan (Capacuan)", "Cagoran", "Cambong", "Catayauan", "Catugan", "Centro (Poblacion)", "Cullit", "Dagupan", "Dalaya", "Fabrica", "Fusina", "Jurisdiction", "Lalafugan", "Logac", "Magallungon (Santa Teresa)", "Magapit", "Malanao", "Maxingal", "Naguilian", "Paranum", "Rosario", "San Antonio (Lafu)", "San Jose", "San Juan", "San Lorenzo", "San Mariano", "Santa Maria", "Tucalana"],
                    "Santa Teresita": ["Alucao", "Buyun", "Centro East (Poblacion)", "Centro West", "Dungeg", "Luga", "Masi", "Mission", "Simpatuyo", "Villa","Ariduen", "Caniugan", "Simbaluca"],
                    "Sta. Ana": ["Casagan - E", "Casambalangan (Port Irene) - W", "Centro (Poblacion) - W", "Diora-Zinungan - W", "Dungeg - E", "Kapanikian - W", "Marede - E", "Palawig - E", "Batu-Parada - E", "Patunungan - E", "Rapuli (Punti) - W", "San Vicente (Fort) - E", "Santa Clara - E", "Santa Cruz - E", "Tangatan - E", "Visitacion (Poblacion) - W"],
                    "Abulug": ["Alinunu", "Bagu", "Banguian", "Calog Norte", "Calog Sur", "Canayun", "Centro (Poblacion)", "Dana-Ili", "Guiddam", "Libertad", "Lucban", "Pinili", "Santa Filomena", "Santo Tomas", "Siguiran", "Simayung", "Sirit", "San Agustin", "San Julian", "Santa Rosa"],
                    "Allacapan": ["Bessang", "Binubungan", "Bulo", "Burot", "Capagaran (Brigida)", "Capalutan", "Capanickian Norte", "Capanickian Sur", "Cataratan", "Centro East (Poblacion)", "Centro West (Poblacion)", "Daan-Ili", "Dagupan", "Dalayap", "Gagaddangan", "Iringan", "Labben", "Maluyo", "Mapurao", "Matucay", "Nagattatan", "Pacac", "San Juan (Maguininango)", "Silagan", "Tamboli", "Tubel", "Utan"],
                    "Ballesteros": ["Ammubuan", "Baran", "Cabaritan East", "Cabaritan West", "Cabayu", "Cabuluan East", "Cabuluan West", "Centro East (Poblacion)", "Centro West (Poblacion)", "Fugu", "Mabuttal East", "Mabuttal West", "Nararagan", "Palloc", "Payagan East", "Payagan West", "San Juan", "Santa Cruz", "Zitanga"],
                    "Calayan": ["Babuyan Claro (Babuyan Island)", "Balatubat (Camiguin Island)", "Cabudadan", "Centro II", "Dadao", "Dalupiri", "Dibay", "Dilam", "Magsidel", "Minabel - (Camiguin Island)", "Naguilian - (Camiguin Island)", "Poblacion / Centro I"],
                    "Claveria": ["Alimoan", "Bacsay Cataraoan Norte", "Bacsay Cataraoan Sur", "Bacsay Mapulapula", "Bilibigao", "Buenavista", "Cadcadir East (former brgy of Santa Praxedes)", "Cadcadir West (former brgy of Santa Praxedes)", "Camalagaoan/D. Leaño", "Capannikian", "Centro I (Poblacion)", "Centro II (Poblacion)", "Centro III (Poblacion)", "Centro IV (Nangasangan)", "Centro V (Mina)", "Centro VI (Minanga)", "Centro VII (Malasin East)", "Centro VIII (Malasin West)", "Culao", "Dibalio", "Kilkiling (former brgy of Santa Praxedes)", "Lablabig (former brgy of Santa Praxedes)", "Luzon", "Mabnang (former brgy of Santa Praxedes)", "Magdalena", "Malilitao", "Nagsabaran", "Pata East", "Pata West", "Pinas", "Santiago", "San Antonio (Sayad/Bimmokel)", "San Isidro", "San Vicente", "Santa Maria", "Santo Niño (Barbarnis)", "Santo Tomas", "Tabbugan", "Taggat Norte", "Taggat Sur", "Union (former brgy of Santa Praxedes)"],
                    "Lasam": ["Aggunetan", "Alannay", "Battalan", "Cabatacan East (Duldugan)", "Cabatacan West", "Calapangan Norte", "Calapangan Sur", "Callao Norte", "Callao Sur", "Cataliganan", "Centro I (Poblacion)", "Centro II (Poblacion)", "Centro III (Poblacion)", "Finugo Norte", "Gabun", "Ignacio B. Jurado (Finugu Sur)", "Magsaysay", "Malinta", "Minanga Sur", "Minanga Norte", "Nabannagan East", "Nabannagan West", "New Orlins", "Nicolas Agatep", "Peru", "San Pedro", "Sicalao", "Tagao", "Tucalan Passing", "Viga"],
                    "Pamplona": ["Abbangkeruan", "Allasitan", "Bagu", "Balingit", "Bidduang", "Cabaggan", "Capalalian", "Casitan", "Centro", "Curva", "Gattu", "Masi (formerly Zimigui-Ziuanan[5])", "Nagattatan", "Nagtupacan", "San Juan", "Santa Cruz (Pimpila)", "Tabba", "Tupanna"],
                    "Piat": ["Apayao", "Aquib", "Baung", "Calaoagan", "Catarauan", "Dugayung", "Gumarueng", "Macapil", "Maguilling", "Minanga", "Poblacion I", "Poblacion II", "Santa Barbara", "Santo Domingo", "Sicatna", "Villa Rey (San Gaspar)", "Villa Reyno", "Warat"],
                    "Rizal": ["Anagguan", "Anurturu", "Anungu", "Baluncanag", "Batu", "Cambabangan", "Capacuan", "Dunggan", "Duyun", "Gaddangao", "Gaggabutan East", "Illuru Norte", "Lattut", "Linno (Villa Cruz)", "Liuan", "Mabbang", "Mauanan", "Masi (Zinundungan)", "Minanga", "Nanauatan", "Nanungaran", "Pasingan", "Poblacion", "San Juan (Zinundungan)", "Sinicking", "Battut", "Bural (Zinundungan)", "Gaggabutan West", "Illuru Sur"],
                    "Sanchez Mira": ["Bangan", "Callungan", "Centro I", "Centro II", "Dacal", "Dagueray", "Dammang", "Kittag", "Langagan", "Magacan", "Marzan", "Masisit", "Nagrangtayan", "Namuac", "San Andres", "Santiago", "Santor", "Tokitok"],
                    "Santo Niño": ["Abariongan Ruar", "Abariongan Uneg", "Balagan", "Balanni", "Cabayo", "Calapangan", "Calassitan", "Campo", "Centro Norte (Poblacion)", "Centro Sur (Poblacion)", "Dungao", "Lattac", "Lipatan", "Lubo", "Mabitbitnong", "Mapitac", "Masical", "Matalao", "Nag-uma (Nagbayugan)", "Namuccayan", "Niug Norte", "Niug Sur", "Palusao", "San Manuel", "San Roque", "Santa Felicitas", "Santa Maria", "Sidiran", "Tabang", "Tamucco", "Virginia"],
                    "Sta. Praxedes": ["Cadongdongan", "Capacuan", "Centro I (Poblacion)", "Centro II (Poblacion)", "Macatel", "Portabaga", "San Juan", "San Miguel", "Salungsong", "Sicul"],
                    "Amulung": ["Abolo", "Agguirit", "Alitungtung", "Annabuculan", "Annafatan", "Anquiray", "Babayuan", "Baccuit", "Bacring", "Baculud", "Balauini", "Bauan", "Bayabat", "Calamagui", "Calintaan", "Caratacat", "Casingsingan Norte", "Casingsingan Sur", "Catarauan", "Centro", "Concepcion", "Cordova", "Dadda", "Dafunganay", "Dugayung", "Estefania", "Gabut", "Gangauan", "Goran", "Jurisdiccion", "La Suerte", "Logung", "Magogod", "Manalo", "Marobbob", "Masical", "Monte Alegre", "Nabbialan", "Nagsabaran", "Nangalasauan", "Nanuccauan", "Pacac-Grande", "Pacac-Pequeño", "Palacu", "Palayag", "Tana", "Unag"],
                    "Enrile": ["Alibago", "Barangay II", "Barangay IV", "Batu", "Divisoria", "Inga", "Lanna", "Lemu Norte", "Lemu Sur", "Liwan Norte", "Liwan Sur", "Maddarulug Norte", "Maddarulug Sur", "Magalalag East", "Magalalag West (San Nicolas)", "Marracuru", "Roma Norte", "Roma Sur", "San Antonio", "San Jose (Barangay III-A)", "San Roque (Barangay III-B)", "Villa Maria (Barangay I)"],
                    "Iguig": ["Ajat (Poblacion)", "Atulu", "Baculud", "Bayo", "Campo", "Dumpao", "Gammad", "Garab", "Malabbac", "Manaoag (Aquiliquilao)", "Minanga Norte", "Minanga Sur", "Nattanzan (Poblacion)", "Redondo", "Salamague", "San Esteban (Capitan)", "San Isidro (Ugac West)", "San Lorenzo", "San Vicente (Ugac East)", "Santa Barbara", "Santa Rosa", "Santa Teresa (Gammad Sur)", "Santiago"],
                    "Peñablanca": ["Aggugaddan", "Alimanao", "Baliuag", "Bical", "Bugatay", "Buyun", "Cabasan", "Cabbo", "Callao", "Camasi", "Centro (Poblacion)", "Dodan", "Lapi", "Malibabag", "Mangga", "Minanga", "Nabbabalayan", "Nanguilattan", "Nannarian", "Parabba", "Patagueleg", "Quibal", "San Roque (Litto)", "Sisim"],
                    "Solana": ["Andarayan North", "Andarayan South", "Bangag", "Bantay", "Basi East", "Basi West", "Bauan East", "Bauan West", "Cadaanan", "Calamagui", "Calillauan", "Carilucud", "Cattaran", "Centro Northeast (Poblacion)", "Centro Northwest (Poblacion)", "Centro Southeast (Poblacion)", "Centro Southwest (Poblacion)", "Dassun", "Furagui", "Gadu", "Gen. Eulogio Balao", "Iraga", "Lanna", "Lannig", "Lingu", "Maddarulug (Santo Domingo)", "Maguirig", "Malalam-Malacabibi", "Nabbotuan", "Nangalisan", "Natappian East", "Natappian West", "Padul", "Palao", "Parug-parug", "Pataya", "Sampaguita", "Ubong"],
                    "Tuao": ["Accusilian", "Alabiao", "Alabug", "Angang", "Bagumbayan", "Barancuag", "Battung", "Bicok", "Bugnay", "Bulagao", "Cagumitan", "Cato", "Centro 1", "Centro 2", "Culong", "Dagupan", "Fugu", "Lakambini", "Lallayug", "Malalinta", "Malummin", "Mambacag", "Mungo", "Naruangan", "Palca", "Pata", "San Juan", "San Luis (Gurengad)", "San Vicente", "Santo Tomas", "Taribubu", "Villa Laida"],
                    "Tuguegarao City": ["Annafunan East", "Annafunan West", "Atulayan Norte", "Atulayan Sur", "Bagay", "Buntun", "Caggay", "Capatan", "Carig Norte", "Carig Sur", "Caritan Centro", "Caritan Norte", "Caritan Sur", "Cataggaman Nuevo", "Cataggaman Pardo", "Cataggaman Viejo", "Centro 01 (Bagumbayan)", "Centro 02", "Centro 03", "Centro 04", "Centro 05 (Bagumbayan)", "Centro 06", "Centro 07", "Centro 08", "Centro 09 (Bagumbayan)", "Centro 10 (Riverside)", "Centro 11 (Balzain East)", "Centro 12 (Balzain West)", "Dadda", "Gosi Norte", "Gosi Sur", "Larion Alto", "Larion Bajo", "Leonarda", "Libag Norte", "Libag Sur", "Linao East", "Linao Norte", "Linao West", "Namabbalan Norte", "Namabbalan Sur", "Pallua Norte", "Pallua Sur", "Pengue-Ruyu", "San Gabriel", "Tagga", "Tanza", "Ugac Norte", "Ugac Sur"],
                    "Alicia" :["Amistad","Antonino (Poblacion)","Apanay","Aurora","Bagnos","Bagong Sikat","Bantug-Petines","Bonifacio","Burgos","Calaocan (Poblacion)","Callao","Dagupan","Inanama","Linglingay","M.H. del Pilar","Mabini","Magsaysay (Poblacion)","Mataas na Kahoy","Paddad","Rizal","Rizaluna","Salvacion","San Antonio (Poblacion)","San Fernando","San Francisco","San Juan","San Pablo","San Pedro","Santa Cruz","Santa Maria","Santo Domingo","Santo Tomas","Victoria","Zamora"],
                    "Angadanan" :["Allangigan","Aniog","Baniket","Bannawag","Bantug","Barangcuag","Baui","Bonifacio","Buenavista","Bunnay","Calabayan-Minanga","Calaccab","Calaocan","Kalusutan","Campanario","Canangan","Centro I (Poblacion)","Centro II (Poblacion)","Centro III (Poblacion)","Consular","Cumu","Dalakip","Dalenat","Dipaluda","Duroc","Lourdes (El Escaño)","Esperanza","Fugaru","Liwliwa","Ingud Norte","Ingud Sur","La Suerte","Lomboy","Loria","Mabuhay","Macalauat","Macaniao","Malannao","Malasin","Mangandingay","Minanga Proper","Pappat","Pissay","Ramona","Rancho Bassit","Rang-ayan","Salay","San Ambrocio","San Guillermo","San Isidro","San Marcelo","San Roque","San Vicente","Santo Niño","Saranay","Sinabbaran","Victory","Viga","Villa Domingo"],
                    "Aurora" :["Apiat","Bagnos","Bagong Tanza","Ballesteros","Bannagao","Bannawag","Bolinao","Santo Niño (Caipilan)","Camarunggayan","Dalig-Kalinga","Diamantina (Palacol)","Divisoria","Esperanza East","Esperanza West","Kalabaza","Rizalina (Lapuz)","Macatal","Malasin","Nampicuan","Villa Nuesa","Panecien","San Andres","San Jose (Poblacion)","San Rafael","San Ramon","Santa Rita","Santa Rosa (Poblacion)","Saranay","Sili","Victoria","Villa Fugu","San Juan (Poblacion)","San Pedro-San Pablo (Poblacion)"],
                    "Benito Soliven" :["Andabuen","Ara","Binogtungan","Capuseran (Capurocan)","Dagupan","Danipa","District II (Poblacion)","Gomez","Guilingan","La Salette","Makindol","Maluno Norte","Maluno Sur","Nacalma","New Magsaysay","District I (Poblacion)","Punit","San Carlos","San Francisco","Santa Cruz","Sevillana","Sinipit","Lucban","Villaluz","Yeban Norte","Yeban Sur","Santiago","Placer","Balliao"],
                    "Burgos" :["Bacnor East","Bacnor West","Caliguian","Catabban","Cullalabo del Norte","Cullalabo del Sur","Dalig","Malasin","Masigun East","Raniag","San Antonino (Poblacion)","San Bonifacio","San Miguel","San Roque"],
                    "Cabagan" :["Aggub","Anao","Angancasilian","Balasig","Cansan","Casibarag Norte","Casibarag Sur","Catabayungan","Centro (Poblacion)","Cubag","Garita","Luquilu","Mabangug","Magassi","Masipi East","Masipi West (Magallones)","Ngarag","Pilig Abajo","Pilig Alto","San Antonio (Candanum)","San Bernardo","San Juan","Saui","Tallag","Ugad","Union"],
                    "Cabatuan" :["Calaocan","Canan","Centro (Poblacion)","Del Pilar","Culing Centro","Culing East","Culing West","Del Corpuz","Diamantina","La Paz","Luzon","Macalaoat","Magdalena","Magsaysay","Namnama","Nueva Era","Paraiso","Rang-ay","Sampaloc","San Andres","Saranay","Tandul"],
                    "Cauayan City" :["Alicaocao","Alinam","Amobocan","Andarayan","Bacolod","Baringin Norte","Baringin Sur","Buena Suerte","Bugallon","Buyon","Cabaruan","Cabugao","Carabatan Chica","Carabatan Grande","Carabatan Punta","Carabatan Bacareno","Casalatan","Cassap Fuera","Catalina","Culalabat","Dabburab","De Vera","Dianao","Dissimuray","District I (Poblacion)","District II (Poblacion)","District III (Poblacion)","Duminit","Faustino (Sipay)","Gagabutan","Gappal","Guayabal","Labinab","Linglingay","Mabantad","Maligaya","Manaoag","Marabulig I","Marabulig II","Minante I","Minante II","Nagcampegan","Naganacan","Nagrumbuan","Nungnungan I","Nungnungan II","Pinoma","Rizaluna","Rizal","Rogus","San Antonio","San Fermin (Poblacion)","San Francisco","San Isidro","San Luis","San Pablo","Santa Luciana (Daburab 2)","Santa Maria","Sillawit","Sinippil","Tagaran","Turayong","Union","Villa Luna","Villa Concepcion","Villaflor"],
                    "Cordon" :["Anonang (Balitoc)","Aguinaldo (Rizaluna Este)","Calimaturod","Capirpiriwan","Caquilingan (Ilut) (San Luis)","Dallao","Gayong","Laurel (Centro Norte)","Magsaysay (Centro Sur Oeste)","Malapat","Osmeña (Centro Sur Este)","Quezon (Centro Norte Este)","Quirino (Manasin)","Rizaluna (Rizaluna Oeste)","Roxas Pob. (Centro Sur)","Sagat","San Juan (San Juan Este)","Taliktik","Tanggal","Taringsing","Turod Norte","Turod Sur (Turod Sur Este)","Villamiemban","Villamarzo","Camarao","Wigan"],
                    "Delfin Albano":["Aga","Andarayan","Aneg","Bayabo","Calinaoan Sur","Capitol","Carmencita","Concepcion","Maui","Quibal","Ragan Almacen","Ragan Norte","Ragan Sur (Poblacion)","Rizal","San Andres","San Antonio","San Isidro","San Jose","San Juan","San Macario","San Nicolas (Fusi)","San Patricio","San Roque","Santo Rosario","Santor","Villa Luz","Villa Pereda","Visitacion","Caloocan"],
                    "Dinapigue" :["Ayod","Bucal Sur","Bucal Norte","Dibulo","Digumased (Poblacion)","Dimaluade"],
                    "Divilacan" :["Dicambangan","Dicaruyan","Dicatian","Bicobian","Dilakit","Dimapnat","Dimapula (Poblacion)","Dimasalansan","Dipudo","Dibulos","Ditarum","Sapinit"],
                    "Echague" :["Angoluan","Annafunan","Arabiat","Aromin","Babaran","Bacradal","Benguet","Buneg","Busilelao","Cabugao (Poblacion)","Caniguing","Carulay","Castillo","Dammang East","Dammang West","Diasan","Dicaraoyan","Dugayong","Fugu","Garit Norte","Garit Sur","Gucab","Gumbauan","Ipil","Libertad","Mabbayad","Mabuhay","Madadamian","Magleticia","Malibago","Maligaya","Malitao","Narra","Nilumisu","Pag-asa","Pangal Norte","Pangal Sur","Rumang-ay","Salay","Salvacion","San Antonio Ugad","San Antonio Minit","San Carlos","San Fabian","San Felipe","San Juan","San Manuel","San Miguel","San Salvador","Santa Ana","Santa Cruz","Santa Maria","Santa Monica","Santo Domingo","Silauan Sur (Poblacion)","Silauan Norte (Poblacion)","Sinabbaran","Soyung (Poblacion)","Taggappan (Poblacion)","Tuguegarao","Villa Campo","Villa Fermin","Villa Rey","Villa Victoria"],
                    "Gamu" :["Barcolan","Buenavista","Dammao","District I (Poblacion)","District II (Poblacion)","District III (Poblacion)","Furao","Guibang","Lenzon","Linglingay","Mabini","Pintor","Rizal","Songsong","Union","Upi"],
                    "Ilagan" :["Aggasian","Alibagu","Alinguigan 1st","Alinguigan 2nd","Alinguigan 3rd","Arusip","Baculud (Poblacion)","Bagong Silang","Bagumbayan (Poblacion)","Baligatan","Ballacong","Bangag","Batong-Labang","Bigao","Cabannungan 1st","Cabannungan 2nd","Cabeseria 2 (Dappat)","Cabeseria 3 (San Fernando)","Cabeseria 4 (San Manuel)","Cabeseria 5 (Baribad)","Cabeseria 6 and 24 (Villa Marcos)"],
                    "Jones" :["Abulan","Addalam","Arubub","Bannawag","Bantay","Barangay I (Poblacion - Centro)","Barangay II (Poblacion - Centro)","Barangcuag","Dalibubon","Daligan","Diarao","Linomot","Malannit","Minuri","Namnama","Napaliong"],
                    "Luna" :["Bustamante","Centro 1 (Poblacion)","Centro 2 (Poblacion)","Centro 3 (Poblacion)","Concepcion","Dadap","Harana","Lalog 1","Lalog 2","Luyao","Macañao"],
                    "Maconacon" :["Diana","Eleonor (Poblacion)","Fely (Poblacion)","Lita (Poblacion)","Reina Mercedes","Minanga","Malasin","Canadam","Aplaya","Santa Marina (Dianggo)"],
                    "Mallig" :["San Pedro (Barucbuc Sur)","Bimonton","Casili","Centro I","Holy Friday","Jacinto Baniqued (Centro II pob)","Maligaya","Manano","Olango"],
                    "Naguilian" :["Aguinaldo","Bagong Sikat","Burgos","Cabaruan","Flores","La Union","Magsaysay (Poblacion)","Manaring","Mansibang","Minallo","Minanga","Palattao"],
                    "Palanan" :["Alomanay","Bisag","Centro East (Poblacion)","Centro West (Poblacion)","Culasi","Dialaoyao","Dibewan","Dicadyuan","Dicotkotan"],
                    "Quezon" :["Abut","Alunan (Poblacion)","Arellano (Poblacion)","Aurora","Barucboc Norte"],
                    "Quirino" :["Binarzang","Cabaruan","Camaal","Dolores","Luna (Poblacion)","Manaoag","Rizal","San Isidro","San Jose","San Juan","San Mateo"],
                    "Ramon" :["Ambatali","Bantug","Bugallion Norte","Bugallion Proper (Centro)","Burgos","General Aguinaldo","Nagbacalan","Oscariz"],
                    "Reina Mercedes" :["Banquero","Binarsang","Cutog Grande","Cutog Pequeño","Dangan","District I (Poblacion)","District II","Labinab Grande","Labinab Pequeño","Mallalatang Grande","Mallalatang Tunggui"],
                    "Roxas" :["Anao","Doña Concha","Lucban","Matusalem","Quiling","San Antonio","San Luis","San Rafael","Villa Concepcion"],
                    "San Agustin" :["Bautista","Calaocan","Dabubu Grande","Dabubu Pequeño","Dappig","Laoag","Mapalad","Masaya Centro (Poblacion)"],
                    "San Guillermo" :["Anonang","Aringay","Burgos","Calaoagan","Centro 1 (Poblacion)","Centro 2 (Poblacion)","Colorado","Dietban","Dingading","Dipacamo","Estrella"],
                    "San Isidro" :["Camarag","Cebu","Gomez (Poblacion)","Gud","Nagbukel","Patanad","Quezon","Ramos East","Ramos West"],
                    "San Manuel" :["Agliam","Babanuang","Cabaritan","Caraniogan","Eden","Malalinta","Mararigue","Nueva Era","Pisang"],
                    "San Mariano" :["Alibadabad","Balagan","Binatug","Bitabian","Buyasan","San Pablo","San Pedro","Santa Filomena","Tappa","Ueg","Zamora"],
                    "San Mateo" :["Bagong Sikat","Bella Luz","Dagupan","Daramuangan Norte","Daramuangan Sur","Estrella","Gaddanan","Malasin","Mapuroc"],
                    "San Pablo" :["Annanuman","Auitan","Ballacayu","Binguang (Baculud)","Bungad","Dalena","Caddangan (Limbauan)","Calamagui","Caralucud","Guminga"],
                    "Santa Maria" :["Bangad","Buenavista","Calamagui North","Calamagui East","Calamagui West","Divisoria","Lingaling","Mozzozzin Sur","Mozzozzin North","Naganacan"],
                    "Santiago City" :["Abra","Baluarte","Batal","Cabulay","Dubinan East","Dubinan West","Naggasican","San Andres","Sinsayon","Villasis"],
                    "Santo Tomas" :["Ammugauan","Antagan","Bagabag","Bagutari","Balelleng","Barumbong","Biga Occidental","Biga Oriental","Bubug","Bolinao-Culalabo"],
                    "Tumauini" :["Annafunan","Antagan I","Antagan II","Arcon","Balug","Banig","Bantug","Fugu Sur","Lalauanan","Lanna","Lapogan","Tunggui","Ugad"],
                    "Alfonso Castaneda": ["Abuyo", "Galintuja", "Cawayan", "Lipuga", "Lublub (Poblacion)", "Pelaway"],
                    "Ambaguio": ["Ammoweg", "Camandag", "Labang", "Napo", "Poblacion", "Salingsingan", "Tiblac", "Dulli"],
                    "Aritao": ["Banganan", "Beti", "Bone North", "Bone South", "Calitlitan", "Comon", "Cutar", "Darapidap", "Kirang", "Nagcuartelan", "Poblacion", "Sta. Clara"],
                    "Bagabag": ["Bakir", "Baretbet", "Careb", "Lantap", "Murong", "Nangalisan", "Paniki (Paniqui)", "Pogonsino"],
                    "Bambang": ["Abian", "Abinganan", "Aliaga", "Almaguer North", "Almaguer South", "Banggot (Urban)", "Barat", "Buag (Urban)", "Calaocan (Urban)", "Dullao"],
                    "Bayombong": ["Bonfal East", "Bonfal Proper", "Bonfal West", "Buenavista (Vista Hills)", "Busilac", "Casat", "La Torre North"],
                    "Diadi": ["Ampakleng", "Arwas", "Balete", "Bugnay", "Butao", "Decabacan", "Duruarog", "Escoting", "Langka", "Lurad"],
                    "Dupax Del Norte": ["Belance", "Binuangan", "Bitnong", "Bulala", "Inaban", "Ineangan", "Lamo"],
                    "Dupax Del Sur": ["Abaca", "Bagumbayan", "Balzain", "Banila", "Biruk", "Canabay", "Carolotan", "Domang", "Dopaj"],
                    "Kasibu": ["Antutot", "Alimit", "Poblacion (Alloy)", "Belet", "Binogawan", "Nantawakan", "Alloy", "Kongkong"],
                    "Kayapa": ["Acacia", "Amelong Labeng", "Ansipsip", "Baan", "Babadi", "Castillo Village", "Latbang", "Lawigan", "Tidang Village"],
                    "Quezon": ["Aurora", "Baresbes", "Buliwao", "Bonifacio", "Calaocan", "Caliat"],
                    "Santa Fe": ["Atbu", "Bacneng", "Balete", "Baliling", "Bantinan", "Baracbac", "Buyasyas", "Unib", "Villaflores"],
                    "Solano": ["Aggub", "Bagahabag", "Bangaan", "Bangar", "Bascaran", "Dadap", "Lactawan", "Osmeña (Urban)"],
                    "Villaverde": ["Bintawan Norte", "Bintawan Sur", "Cabuluan", "Ibung", "Nagbitin", "Ocapon", "Pieza", "Poblacion (Turod)", "Sawmill"],
                    "Aglipay": ["Dagupan", "Dumabel", "Dungo (Osmeña)", "Guinalbin", "Ligaya", "San Leonardo", "San Ramon", "Victoria", "San Benigno", "San Manuel", "Villa Ventura"],
                    "Cabarroguis": ["Gundaway", "San Marcos", "Banuar", "Del Pilar", "Eden", "Dibibi", "Tucod"],
                    "Diffun": ["Baguio Village", "Balagbag", "Bannawag", "Cajel", "Campamento", "Gulac", "Guribang", "Aklan Village", "Gregorio Pimentel", "Don Faustino Pagaduan"],
                    "Maddela": ["Abbag", "Balligui", "Buenavista", "Cabaruan", "Dumabato Norte", "Dumabato Sur", "Lusod", "MangladVilla Gracia", "Villa Hermosa Sur", "Villa Hermosa Norte", "Ysmael"],
                    "Nagtipunan": ["Anak", "Asaklat", "Dipantan", "Disimungal", "Keat", "La Conwap (Guingin)", "Landingan", "San Ramos", "Sangbay", "Wasid"],
                    "Saguday": ["Cardenas", "Dibul", "Gamis", "La Paz", "Magsaysay (Poblacion)", "Rizal (Poblacion)", "Salvacion", "Santo Tomas", "Tres Reyes"]
                };
</script>
<script>
    // Enable submit button only when checkbox is checked
    document.getElementById('myCheckBox').addEventListener('change', function() {
        document.getElementById('btnSave').disabled = !this.checked;
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
