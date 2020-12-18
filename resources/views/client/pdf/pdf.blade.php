<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <style type="text/css" media="all">

      @font-face {
          font-family: "Roboto";
          src: url( {{ storage_path('fonts/Roboto-Medium.ttf') }});
      }

      @font-face {
          font-family: "Vibes";
          src: url({{ storage_path('fonts/GreatVibes-Regular.ttf') }}) format('truetype');
      }

      * {
        padding: 0;
        margin: 0;
      }

      body {
        padding: 20px;
        margin: 0;
      }

      .certificate {
        position: relative;
        /* padding: 20px; */
      }

      .background {
          position: absolute;
          width: 1120px;
          height: 800px;
          left: 50%;
          transform: translate(-50%, -3%);
          z-index: -999;
      }

      .text-box {
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -20%);
        text-align: center;
        width: 900px;
      }

      .text-box h1 {
          font-size: 60px;
      }

      .text-box h2 {
          font-size: 40px;
      }

      .text-box h3 {
          font-size: 50px;
      }

      .text-box p {
          margin: 25px 0;
          font-size: 20px;
      }

      .logo {
        position: absolute;
        bottom: 15%;
        left: 50%;
        transform: translate(-50%, -20%);
        color: #636e72;
        font-size: 45px;
        font-family: "Roboto";
      }

      .logo .dot {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #6c5ce7;
      }

    </style>
  </head>
  <body>
    <div class="certificate">
        <img src="{{ storage_path('images/certificate.jpg') }}" class="background">
        <div class="text-box">
            <h1>Certificate of Completion</h1>
            <p>Diberikan Kepada : </p>
            <h2>{{ Auth::user()->name }}</h2>
            <p>Yang telah berhasil menyelesaikan seri pembelajaran</p>
            <h3>{{ $series->title }}</h3>
        </div>
        <div class="logo">Webacademy<span class="dot"></span></div>
    </div>
  </body>
</html>
