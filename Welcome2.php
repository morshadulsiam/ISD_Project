<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <title>Welcome | Pethub</title>
    <link rel="stylesheet" href="welcome.css">
  </head>
  <body>
    <div class="container">
      <img src="upload/bg2.png" alt="Avatar" class="rectangle">
      <div class="radio-tile-group">
        <div class="input-container" onclick="window.location.href='proRegistration.php'">
          <input id="provider" type="radio" name="radio">
          <div class="radio-tile">
            <ion-icon name="person-outline"></ion-icon>
            <label for="provider">Provider</label>
          </div>
        </div>
        <div class="input-container" onclick="window.location.href='recRegistration.php'">
          <input id="receiver" type="radio" name="radio">
          <div class="radio-tile">
            <ion-icon name="person-outline"></ion-icon>
            <label for="receiver">Receiver</label>
          </div>
        </div>
      </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>