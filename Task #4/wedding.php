<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wed me Today!</title>
    <link href="style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
    <script src="j_ajax.js"> </script>
</head>

<body>

<main>

<div class="bg-image"> 

  <nav class="container">
    <h1> Wed me Today! </h1>

    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>

  <div class="container center-text">
    <h2> Organizing best weddings since 2022.. </h2>
    <button class="button" onclick="moveToSearch()"> Book now </button>
  </div>

</div>

<section id="form-container" class="container">
  <form class='container'>

  <div class="form-col">
    <label for="inputDate"> Booking date </label>
    <input type="date" class="form-input" id="inputDate" name="date" min="<?php echo date("Y-m-d"); ?>" required>
  </div>

  <div class="form-col">
      <label for="partySize"> Party size </label>
      <input type="number" class="form-input" id="partySize" name="partySize" min="0" required>
  </div>

  <div class="form-col">
    <label for="cateringGrade">Catering grade</label>
    <select class="form-input" id="cateringGrade" name="cateringGrade" required>
      <option selected>Choose grade..</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
      <option value="4">Four</option>
      <option value="5">Five</option>
    </select>
  </div>

  <div class="form-col">
    <button onclick="submitForm()" type="submit">Submit</button>
  </div>
  
  </form>
</section>
<section id="results-container" class="container">

<div class="date-container" id="insertDay"></div>

<div class="results-list" id="insertVenues"></div>

</section>
</main>

<footer> 
  <div class="container">
    <h3> Wed me Today! </h3>
    <p> Wed me Today is a fictional wedding venue planner website created solely for the Web Programming coursework task. I do understand it is a work of art, but I will have to disappoint you with the news that it will cease its operations after submission. Thanks!</p>
  </div>
  <div class="container bottom">
    <p>copyright &copy;2022 <a href="#">F011321</a>  </p>
  </div>
</footer>
</body>
</html>