<?php
//Sätter in header och nav.

require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/nav.php";
$view = new View\UserView()
?>
<main role="main" class="container position-relative" style="max-width: 500px;">
<body>
<?php
//Instansierar info metoden så vi kan visa upp olika GET request.
$mv = new View\View();
$mv->infoDisplay();
?>
<h4>Search for a user and all its feedback!</h4>
<!--Formulär för kategorier -->
<form class="form-group" action="/classes/Controller/FeedContr.class.php" method="post">
<select class="form-control" name="search-user">
<?php
//Hämtar alla föremål typer, med en option tag.
$view->selectAllUsersOption();
?>
</select>
<input class="form-control btn-dark mt-1" type="submit" name="search-submit-user" value="Submit">
</form></br>
<h4>Search for Repo Title</h4>
<form class="form-group" action="/classes/Controller/FeedContr.class.php" method="post">
<input class="form-control" type="text" name="search-title" placeholder="name">
<input class="form-control btn-dark mt-1" type="submit" name="search-submit-title" value="Submit">
</form>
</body>
</main>
</html>