<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="<?=linkTo()?>">Flashcards</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?=linkTo("my")?>"><i class="fa fa-list-ul" aria-hidden="true"></i> Your own boxes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=linkTo("boxes")?>"><i class="fa fa-globe" aria-hidden="true"></i> Community boxes</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if(isset($box)): ?>
        <li class="nav-item">
          <span class="nav-link text-muted"><?=$box->name?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=linkTo("boxes/{$box->id}")?>"><i class="fa fa-eye" aria-hidden="true"></i> Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=linkTo("boxes/{$box->id}/view")?>"><i class="fa fa-th-large" aria-hidden="true"></i> Flashcards</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=linkTo("boxes/{$box->id}/study")?>"><i class="fa fa-leanpub" aria-hidden="true"></i> Study</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=linkTo("boxes/{$box->id}/choice")?>"><i class="fa fa-bars" aria-hidden="true"></i> Choices</a>
        </li>
      <?php endif; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="naviDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="naviDropdown">
          <a class="dropdown-item nav-link" href="<?=linkTo("profile")?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item nav-link">
            <i class="fa fa-sign-out fa-fw"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>
