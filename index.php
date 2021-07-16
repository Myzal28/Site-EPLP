<?php 

error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once __DIR__ . "/services/UserService.php";
require_once __DIR__ . "/services/MissionService.php";
require_once __DIR__ . "/services/ScoreService.php";
require_once __DIR__ . "/services/SecretService.php";
require_once __DIR__ . "/services/PhotosService.php";
$uService = UserService::getInstance();
$mService = MissionService::getInstance();
$pService = PhotosService::getInstance();
$allUsers = $uService->getAllActive();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>EPLP - Games</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Libraries CSS Files -->
  <script src="https://kit.fontawesome.com/8c58d132fd.js" crossorigin="anonymous"></script>
  <link href="lib/animate/animate.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
          <a href="#home"><img src="img/logo2.png" alt="" width="70px"></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#home"><i class="fa fa-home"></i>  Accueil</a></li>
          <?php
          if (isset($_SESSION['user'])) {
            ?>
            <!-- <li><a href="#stats"><i class="fa fa-chart-bar"></i> Statistiques</a></li> -->
            <!-- <li><a href="#leaderboard"><i class="fa fa-trophy"></i> Leaderboard</a></li> -->
            <!-- <li><a href="#secret"><i class="fas fa-mask"></i> Secret</a></li> -->
            <li><a href="#killer"><i class="fas fa-skull-crossbones"></i> Killer</a></li>
            <li><a href="#photos"><i class="fas fa-camera-retro"></i> Photos</a></li>
            <!-- <li><a href="#history"><i class="fas fa-history"></i> Historique</a></li> -->
            <li><a href="disconnect.php"><i class="fas fa-power-off"></i> &nbsp;<?= ucfirst($_SESSION['user']['first_name']);?></a></li>
            <?php
          }else{
            ?>
            <li><a href="#connection"><i class="fa fa-sign-in-alt"></i> Se Connecter</a></li>
            <?php
          }
          ?>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->


  <section id="home">
    <div class="hero-container">
      <h1>Bienvenue sur Eplp</h1>
      <h2>Ici des amitiés se briseront. Des secrets seront percés. Êtes vous prêt ? </h2>
      <?php 
      if (isset($_SESSION['user'])) {
        ?>
        <!-- <a href="#stats" class="btn-get-started">Voir les statistiques</a> -->
        <?php
      }else{
        ?>
        <a href="#connection" class="btn-get-started">Se connecter</a>
        <?php
      }
      ?>
    </div>
  </section> 
  <main id="main">
    <?php 
    if (isset($_SESSION['user'])) {
      if($_SESSION['user']['username'] == "admin"){
        ?>
        <section id="photoAdd">
          <div class="container wow fadeIn">
            <div class="section-header text-center">
              <h3 class="section-title">Ajouter ma photo</h3>
              <form action="script/addPhoto.php" method="POST" enctype="multipart/form-data">
                <select name="user" id="user" class="form-control mt-4" required>
                  <option value="" selected disabled>---</option>
                  <?php 
                  foreach($allUsers as $user){
                    if($user['photo'] == null){
                      ?>
                      <option value="<?= $user['id'];?>"><?= $user['first_name']." ".$user['last_name'];?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <input type="file" name="photo" class="form-control mt-4" required>
                <button type="submit" class="btn btn-vacation mt-4">
                  C'est dans la boîte <i class="fas fa-camera-retro"></i>
                </button>
              </form>
            </div>
          </div>
        </section>
        <?php
      }else{
        $mission = $mService->getActive($_SESSION['user']['id']);
        ?>
        <section id="killer">
          <div class="container wow fadeIn">
            <div class="section-header text-center">
              <h3 class="section-title">Killer</h3>
              <?php
              switch ($mission->getState()) {
                case NULL:
                  ?>
                  <p class="section-description">
                    Il n'y a pas encore de missions distribuées<br>
                    <span class="h1"><i class="fas fa-cog fa-spin"></i></i></span>
                    <br>
                  </p>
                  <?php
                  break;
                // Si on est en lice
                case 0:
                  ?>
                  <p class="section-description">Votre mission pour la soirée, si vous l'acceptez.</p>
                  <?php
                  break;
                // Si on a été tué
                case 1:
                  ?>
                  <p class="section-description">
                    Vous avez été tué par <span class="pseudo"><?= $uService->getName($mission->getKiller());?></span>
                    <br>
                    <span class="h1"><i class="fas fa-skull-crossbones"></i></span>
                  </p>
                  <?php
                  break;
                // Si on a été découvert
                case 2: 
                  ?>
                  <p class="section-description">
                    Vous avez été découvert par <span class="pseudo"><?= $uService->getName($mission->getKiller());?></span>
                    <br>
                    <span class="h1"><i class="fas fa-skull-crossbones"></i></span>
                  </p>
                  <?php
                  break;
                // Si on a gagné
                case 3:
                  ?>
                  <p class="section-description">
                    Vous avez gagné cette partie
                    <br>
                    <span class="h1 pseudo"><i class="fas fa-trophy"></i></span>
                  </p>
                  <?php
                  break;
                // Default
                default:
                  ?>
                  <p class="section-description">
                    Il n'y a pas encore de missions lancées
                    <br>
                    Revenez quand elles seront distribuées
                    <br>
                    <span class="h1"><i class="fas fa-cog fa-spin"></i></i></span>
                  </p>
                  <?php
                  break;
              }
              ?>
            </div>
            <br>
            <?php 
            if ($mission->getState() == 0 & (!is_null($mission->getState()))) {
              ?>
              <div class="row justify-content-center">
                <div class="col-lg-10 col-md-8 wow fadeInUp" data-wow-delay="0.4s">
                  <div class="box">
                    <div class="icon"><a href=""><i class="<?= $mission->getMission()->getLogo();?>"></i></a></div>
                    <h4 class="title"><a href=""><?= $mission->getMission()->getTitle();?></a></h4>
                    <p class="description">
                        <div class='countdown' data-date="<?= date('Y-m-d',strtotime($nextMissionDay));?>" data-time="12:00"></div>
                        <br>
                        <?= str_replace("{joueur}", "<span class='pseudo'>".$uService->getName($mission->getTarget())."</span>",$mission->getMission()->getDescription());?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-6">
                  <form method="POST" class="text-center" action="script/getKilled.php">
                    <div class="form-group mx-sm-3 mb-2">
                      <span>Je me suis fait kill</span>
                    </div>
                    <button type="submit" name="kill" value="kill" class="btn btn-vacation mb-4">Valider</button>
                  </form>
                </div>
                <div class="col-6">
                  <form method="POST" class="text-center" action="script/getDiscovered.php">
                    <div class="form-group mx-sm-3 mb-2">
                      <span>J'ai été percé à jour par </span>
                      <span class="pseudo"><?= $uService->getName($mission->getTarget());?></span>
                    </div>
                    <button type="submit" name="kill" value="kill" class="btn btn-vacation mb-4">Valider</button>
                  </form>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </section>

        <section id="photos">
          <div class="container wow fadeIn">
            <div class="section-header text-center">
              <h3 class="section-title">Concours de Costumes</h3>
              <br>
              
              <br>
              <?php
              if($uService->hasVoted($_SESSION['user']['id'])){
                ?>
                <p class="section-description">
                    Vous avez déjà voté    
                    <br>
                    Les résultats seront donnés dans la soirée
                    <br>
                    <span class="h1"><i class="fas fa-cog fa-spin"></i></i></span>
                  </p>
                <?php
              }else{
                ?>
                <form method="POST" action="script/addVotes.php">
                  <h5>Costume le plus drôle <i class="fas fa-grin-squint"></i></h5>
                  <select class="form-control" id="funniest" name="funniest">
                      <option value="none" selected disabled>---</option>
                      <?php
                      foreach ($allUsers as $user) {
                          if( ($user['id'] != $_SESSION['user']['id']) && ($user['photo'] != NULL) ){
                              ?>
                              <option value="<?= $user['id'];?>"><?= $user['first_name'];?></option>
                              <?php
                          }
                      }
                      ?>
                  </select>
                  <br>
                  <h5>Costume le plus stylé <i class="fas fa-crown"></i></h5>
                  <select class="form-control" id="styliest" name="styliest">
                      <option value="none" selected disabled>---</option>
                      <?php
                      foreach ($allUsers as $user) {
                          if( ($user['id'] != $_SESSION['user']['id']) && ($user['photo'] != NULL) ){
                              ?>
                              <option value="<?= $user['id'];?>"><?= $user['first_name'];?></option>
                              <?php
                          }
                      }
                      ?>
                  </select>
                  <br>
                  <h5>Costume le plus original/atypique <i class="fas fa-hat-cowboy"></i></h5>
                  <select class="form-control" id="original" name="original">
                      <option value="none" selected disabled>---</option>
                      <?php
                      foreach ($allUsers as $user) {
                          if( ($user['id'] != $_SESSION['user']['id']) && ($user['photo'] != NULL) ){
                              ?>
                              <option value="<?= $user['id'];?>"><?= $user['first_name'];?></option>
                              <?php
                          }
                      }
                      ?>
                  </select>
                  <button type="submit" class="btn btn-vacation mt-4">Envoyer mon vote <i class="fas fa-vote-yea"></i></button>
                </form>
                <?php
              }
              ?>
            </div>
          </div>
        </section>
        <?php
      }
    }else{
      ?>
      <section id="connection">
        <div class="container wow fadeInUp">
          <div class="section-header">
            <h3 class="section-title">Se connecter</h3>
            <p class="section-description">Rejoins la partie dès maintenant</p>
          </div>
          <div class="row justify-content-center">
            <form method="POST" class="text-center" action="script/verifyConnect.php">
              <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
              </div>
              <button type="submit" class="btn btn-vacation mb-4">Se connecter <i class="fa fa-sign-in-alt"></i></button>
            </form>
          </div>  
        </div>
      </section>
      <?php
    }
    ?>
  </main>
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Maxime Lalo</strong>. All Rights Reserved
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/counterup/counterup.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/countdown/js/countdown.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script type="text/javascript">
    function seeMission(mission){
      $.post(
        'script/getMission.php',
        { mission:mission },
        function(data){
          console.log(data);
          Swal.fire({
            type: 'info',
            html: data
          })
          console.log(data);
        }
      );
    }
  </script>
  <?php
  if (isset($_SESSION['flash'])) {
    if (isset($_SESSION['flash']['error'])) {
      ?>
      <script type="text/javascript">
        jQuery(document).ready(function ($) {
          Swal.fire({
            title: "Erreur",
            text: "<?= $_SESSION['flash']['error'];?>",
            type: "error",
          });
        });
      </script>
      <?php
    }
    if (isset($_SESSION['flash']['success'])) {
      ?>
      <script type="text/javascript">
        jQuery(document).ready(function ($) {
          Swal.fire({
            title: "Succès",
            text: "<?= $_SESSION['flash']['success'];?>",
            type: "success",
          });
        });
      </script>
      <?php
    }

    if (isset($_SESSION['flash']['missionLost'])) {
      ?>
      <script type="text/javascript">
        jQuery(document).ready(function ($) {
          Swal.fire({
            title: "Eliminé",
            text: "<?= $_SESSION['flash']['missionLost'];?>",
            type: "error",
          });
        });
      </script>
      <?php
    }
    unset($_SESSION['flash']);
  }
  ?>
</body>
</html>
