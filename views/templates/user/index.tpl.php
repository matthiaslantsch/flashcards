<div class="jumbotron jumbotron-fluid bg-dark">
  <div class="container">
    <h1 class="display-4">Welcome to flashcards!</h1>
    <p class="lead">Welcome to the flashcard application of Matthias Lantsch.</p>
  </div>
</div>
<main class="container">
  <div class="card-deck">
    <div class="card bg-dark xs-4">
      <div class="card-header border-success bg-success">
        <div class="row">
          <div class="col-md-2">
            <i class="fa fa-tasks fa-5x"></i>
          </div>
          <div class="col-md-9 text-right">
            <div>Your Boxes</div>
            <h1><?=$myBoxCount?></h1>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h3 class="card-title">My Boxes</h3>
        <p class="card-text">
          List the flashcard boxes created by you and administer them.
          Compare your progress across different study sets.
          Create a new flashcard box for a new study set.
        </p>
      </div>
      <div class="card-footer bg-dark">
        <a href="<?=linkTo("my")?>">
          <span class="pull-left">List my Boxes</span>
          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </a>
      </div>
    </div>
    <div class="card bg-dark xs-4">
      <div class="card-header border-primary bg-primary">
        <div class="row">
          <div class="col-md-2">
            <i class="fa fa-users fa-5x"></i>
          </div>
          <div class="col-md-9 text-right">
            <div>Total Flashcard Boxes</div>
            <h1><?=$boxCount?></h1>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h3 class="card-title">Start studying!</h3>
        <p class="card-text">
          Browse through hundreds of boxes created by the community covering wide ranges of subjects.
          Widen your interests by checking out the study sets of other people.
        </p>
      </div>
      <div class="card-footer bg-dark">
        <a href="<?=linkTo("boxes")?>">
          <span class="pull-left">List All</span>
          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </a>
      </div>
    </div>
    <div class="card bg-dark xs-4">
      <div class="card-header border-danger bg-danger">
        <div class="row">
          <div class="col-md-2">
            <i class="fa fa-user fa-5x"></i>
          </div>
          <div class="col-md-9 text-right">
            <div>User Profile</div>
            <h4><?=$user->name?></h4>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h3 class="card-title">Edit your Profile</h3>
        <p class="card-text">
          Check out how other people see you.
          Edit your settings in order to customize your flashcards experience.
          Reset your progress if you want to start over.
        </p>
      </div>
      <div class="card-footer bg-dark">
        <a href="<?=linkTo("profile")?>">
          <span class="pull-left">User Profile</span>
          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </a>
      </div>
    </div>
  </div>
</main>
