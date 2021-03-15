<?php
//Sätter in header och nav.

require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/nav.php";
$view = new View\UserView();
?>
<main role="main" class="container position-relative" style="max-width: 500px;">
<body>
<?php
//Instansierar info metoden så vi kan visa upp olika GET request.
$mv = new View\View();
$mv->infoDisplay();
?>
<h4>Select User to Add Github Repos.</h4>
<!--Formulär för föremål -->
<form class="form-group"  action="/classes/Controller/RepoContr.class.php" method="post">
<select class="form-control" name="add_repo">
<?php
//Hämtar alla föremål typer, med en option tag.
$view->selectAllUsersOption();
?>
</select name="add_repos">
<input class="form-control btn-dark mt-1" type="submit" name="submit" value="Submit">
</form>
</body>
</main>
</html>
