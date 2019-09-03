<?php 

error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once __DIR__ . "/services/UserService.php";
require_once __DIR__ . "/services/MissionService.php";
require_once __DIR__ . "/services/ScoreService.php";
require_once __DIR__ . "/services/SecretService.php";
$uService = UserService::getInstance();
$mService = MissionService::getInstance();
$sService = ScoreService::getInstance();
$secretService = SecretService::getInstance();
$allUsers = $uService->getAll();
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
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="lib/animate/animate.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
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
            <li><a href="#stats"><i class="fa fa-chart-bar"></i> Statistiques</a></li>
            <li><a href="#leaderboard"><i class="fa fa-trophy"></i> Leaderboard</a></li>
            <li><a href="#secret"><i class="fas fa-mask"></i> Secret</a></li>
            <li><a href="#killer"><i class="fas fa-utensils"></i> Killer</a></li>
            <li><a href="#history"><i class="fas fa-history"></i> Historique</a></li>
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
        <a href="#stats" class="btn-get-started">Voir les statistiques</a>
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
    <?php if (isset($_SESSION['user'])) {
      ?>
        <section id="stats">
          <div class="container wow fadeIn">
            <div class="section-header">
              <h3 class="section-title">Statistiques</h3>
              <p class="section-description">Un petit point sur la situation s'impose </p>
            </div>
            <div class="row counters">
              <div class="col-lg-3 col-6 text-center">
                <span data-toggle="counter-up">
                  <?= $secretService->nbNotFound();?>
                </span>
                <p>Secrets découverts</p>
              </div>
              <div class="col-lg-3 col-6 text-center">
                <span data-toggle="counter-up">0</span>
                <p>Missions accomplies</p>
              </div>
              <div class="col-lg-3 col-6 text-center">
                <span data-toggle="counter-up">
                  <?= $sService->getTotalScore();?>
                </span>
                <p>Points marqués au total</p>
              </div>
              <div class="col-lg-3 col-6 text-center">
                <span data-toggle="counter-up"><?= count($allUsers);?></span>
                <p>Participants</p>
              </div>
            </div>
          </div>
        </section>

        <section id="leaderboard">
          <div class="container wow fadeIn">
            <div class="section-header">
              <h3 class="section-title">Leaderboard</h3>
              <p class="section-description">Qui est au sommet ? Qui risque de plonger ? </p>
            </div>
            <div class="row justify-content-center">
              <table class="table text-center table-bordered table-sm col-lg-6 col-11">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Points</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $leaderboard = $uService->getLeaderboard();
                  for ($i=0; $i < count($leaderboard) ; $i++) { 
                    if ($i > 0) {
                      if ($leaderboard[$i]['score_total'] == $leaderboard[$i-1]['score_total']) {
                        $place = $lastPlace;
                      }else{
                        $place = $lastPlace+1;
                      }
                    }else{
                      $place = $i+1;
                    }
                    ?>
                    <tr>
                      <td>
                        <?php
                        switch ($place) {
                          case 1:
                            $imgPlc = "<img src='img/trophy/trophy-first.png' width='25px'>";
                            break;
                          case 2:
                            $imgPlc = "<img src='img/trophy/trophy-second.png' width='25px'>";
                            break;
                          case 3:
                            $imgPlc = "<img src='img/trophy/trophy-third.png' width='25px'>";
                            break;
                          default:
                            $imgPlc = $place;
                            break;
                        }
                        echo $imgPlc;
                        ?>
                      </td>
                      <td><?= $leaderboard[$i]['first_name'];?></td>
                      <td><span data-toggle="counter-up"><?= $leaderboard[$i]['score_total'];?></span></td>
                    </tr>
                    <?php
                    $lastPlace = $place;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section id="secret">
          <div class="container wow swing">
            <div class="section-header">
              <h3 class="section-title">Secret</h3>
              <p class="section-description">
                <?php
                $startDate = DateTime::createFromFormat('Y-m-d H:i:s','2019-07-06 00:00:00');
                $actualDate = DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
                if ($actualDate > $startDate){
                    if ($secretService->isSet($_SESSION['user']['id'])) {
                        echo "Tu penses avoir deviné ? Viens tenter ta chance...";
                    }else{
                        echo "Tu n'as pas encore soumis ton secret, fais le dès maintenant pour prendre part au jeu";
                    }
                }else{
                    echo "Début du jeu dans...";
                    ?>
                    <div class="row justify-content-center">
                        <div class='countdown' data-date="2019-07-06" data-time="00:00"></div>
                    </div>
                    <?php
                }
                ?>
              </p>
            </div>
            <div class="row justify-content-center">
              <form method="POST" class="text-center col-lg-6 col-11" action="script/secret.php">
                <?php 
                if ($secretService->isSet($_SESSION['user']['id'])) {
                  if ($secretService->canSubmit()) {
                          if ($actualDate > $startDate){
                          ?>
                          <div class="form-group mb-2">
                              <label for="user">Je pense que</label>
                              <select class="form-control" id="user" name="user">
                                  <?php
                                  foreach ($secretService->getAvailable()['users'] as $key => $value) {
                                      if($value['id'] != $_SESSION['user']['id']){
                                          ?>
                                          <option value="<?= $value['id'];?>"><?= $value['first_name'];?></option>
                                          <?php
                                      }
                                  }
                                  ?>
                              </select>
                          </div>
                          <div class="form-group mb-2">
                              <label for="secret">a le secret</label>
                              <select class="form-control" id="secret" name="secret">
                                  <?php
                                  foreach ($secretService->getAvailable()['secrets'] as $key => $value) {
                                      ?>
                                      <option value="<?= $value['id'];?>"><?= $value['secret'];?></option>
                                      <?php
                                  }
                                  ?>
                              </select>
                          </div>
                          <button type="submit" class="btn btn-vacation mb-2">Faire une proposition</button>
                          <?php
                      }
                  }else{
                    ?>
                    <p class="section-text">
                      <span style="color:#ffa500" class="h2"><i class="fa fa-exclamation-circle"></i></span>
                      <br>
                      Vous avez déjà soumis une proposition aujourd'hui.<br>Prochaine proposition dans : 
                      <div class="row justify-content-center">
                        <div class='countdown' data-date="<?php echo date('Y-m-d');?>" data-time="23:59:59"></div>
                      </div>
                    </p>
                    <?php
                  }
                }else{
                  ?>
                  <div class="form-group mb-2">
                    <input type="text" name="secretSet" placeholder="Mon secret" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-vacation mb-2">Soumettre mon secret</button>
                  <?php
                }
                ?>
              </form>
            </div>
          </div>
        </section>
       
        <section id="killer">
          <?php 
          $mService = MissionService::getInstance();
          $mission = $mService->getActive($_SESSION['user']['id']);
          ?>
          <div class="container wow fadeIn">
            <div class="section-header text-center">
              <h3 class="section-title">Killer</h3>
              <?php
              $actualDay = date('w');
              /*
               * Dimanche Lundi Mardi et Mercredi -> Prochaine mission Mercredi 12h
               * Jeudi Vendredi Samedi -> Prochaine mission Samedi 12h 
               * Attention, pour le samedi et le mercredi, les règles sont valables uniquement jusqu'à 12h
               */ 
              if (($actualDay >= 0 AND $actualDay <= 2) OR ($actualDay == 6))  {
                if ($actualDay == 6 AND date('H') < 12) {
                  $nextMissionDay = date('Y-m-d');
                }else{
                  $nextMissionDay = date('Y-m-d',strtotime('next Wednesday'));
                }
              }else{
                if ($actualDay == 3 AND date('H') < 12) {
                  $nextMissionDay = date('Y-m-d');
                }else{
                  $nextMissionDay = date('Y-m-d',strtotime('next Saturday'));
                }
              }
              
              switch ($mission->getState()) {
                case NULL:
                  ?>
                  <p class="section-description">
                    Il n'y a pas encore de missions distribuées<br>
                    <span class="h1"><i class="fas fa-cog fa-spin"></i></i></span>
                    <div class="row justify-content-center">
                        <div class='countdown' data-date="<?= date('Y-m-d',strtotime('next Saturday'));?>" data-time="12:00:00"></div>
                      </div>
                    <br>
                  </p>
                  <?php
                  break;
                // Si on est en lice
                case 0:
                  $day = date('w',strtotime($nextMissionDay)) == 3 ? "Mercredi":"Samedi";
                  ?>
                  <p class="section-description">Votre mission jusqu'à <?= $day ;?> 12h00, si vous l'acceptez.</p>
                  <?php
                  break;
                // Si on a été tué
                case 1:
                  ?>
                  <p class="section-description">
                    Vous avez été tué par <span class="pseudo"><?= $uService->getName($mission->getKiller());?></span>
                    <br>
                    Revenez à la prochaine distribution de missions
                    <br>
                    <span class="h1"><i class="fas fa-skull-crossbones"></i></span>
                    <div class='countdown' data-date="<?= $nextMissionDay;?>" data-time="12:00"></div>
                  </p>
                  <?php
                  break;
                // Si on a été découvert
                case 2: 
                  ?>
                  <p class="section-description">
                    Vous avez été découvert par <span class="pseudo"><?= $uService->getName($mission->getKiller());?></span>
                    <br>
                    Revenez à la prochaine distribution de missions
                    <br>
                    <span class="h1"><i class="fas fa-skull-crossbones"></i></span>
                    <div class='countdown' data-date="<?= $nextMissionDay;?>" data-time="12:00"></div>
                  </p>
                  <?php
                  break;
                // Si on a gagné
                case 3:
                  ?>
                  <p class="section-description">
                    Vous avez gagné cette partie
                    <br>
                    Revenez à la prochaine distribution de missions
                    <br>
                    <span class="h1 pseudo"><i class="fas fa-trophy"></i></span>
                    <div class='countdown' data-date="<?= $nextMissionDay;?>" data-time="12:00"></div>
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

        <section id="history">
          <div class="container wow fadeInUp">
            <div class="section-header">
              <h3 class="section-title">Historique des points</h3>
              <p class="section-description">Qui a gagné quoi et comment ? La réponse à toutes tes questions</p>
            </div>
            <div class="row justify-content-center">
              <form method="POST" class="text-center" action="#history">
                <div class="form-group mx-sm-3 mb-2">
                  <label for="history">Voir l'historique de</label>
                  <select class="form-control" id="history" name="history">
                    <option value="0">Tous</option>
                    <?php 
                      foreach ($allUsers as $key => $value) {
                        if (isset($_POST['history']) && $_POST['history'] == $value['id']) {
                          ?>
                          <option value="<?= $value['id'];?>" selected><?= $value['first_name'];?></option>
                          <?php
                        }else{
                          ?>
                          <option value="<?= $value['id'];?>"><?= $value['first_name'];?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-vacation mb-4">Voir <i class="fa fa-eye"></i></button>
              </form>
            </div>
            <div class="row justify-content-center">
              <table class="table table-bordered table-sm col-10">
                <thead>
                  <tr>
                    <th>Nombre de points</th>
                    <th>Action réalisée</th>
                    <th>Date & Heure</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $history = isset($_POST['history']) ? $sService->getHistory($_POST['history']):$sService->getAllHistory();
                  foreach ($history as $key => $value) {
                    ?>
                    <tr>
                      <td><?= $value['score'];?></td>
                      <td><span class="pseudo"><?= $value['first_name']."</span> ".$value['reason'];?></td>
                      <td><?= date('d/m à H:i',strtotime($value['datetime']));?></td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      <?php
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

  <!-- <script>
    var div = document.createElement('div');
    div.className = 'fb-customerchat';
    div.setAttribute('page_id', '623370331464687');
    div.setAttribute('ref', '');
    document.body.appendChild(div);
    window.fbMessengerPlugins = window.fbMessengerPlugins || {
      init: function () {
        FB.init({
          appId            : '1678638095724206',
          autoLogAppEvents : true,
          xfbml            : true,
          version          : 'v3.0'
        });
      }, callable: []
    };
    window.fbAsyncInit = window.fbAsyncInit || function () {
      window.fbMessengerPlugins.callable.forEach(function (item) { item(); });
      window.fbMessengerPlugins.init();
    };
    setTimeout(function () {
      (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    }, 0);
  </script>-->
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
