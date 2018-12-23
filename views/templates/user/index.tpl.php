</div>
<div class="jumbotron">
	<div class="container">
		<h1>Welcome to flashcards!</h1>
		<p>Welcome to the flashcard application of Matthias Lantsch.</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-green">
				<div class="panel-heading">
						<div class="row">
								<div class="col-xs-3">
										<i class="fa fa-tasks fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
										<div class="huge"><?=$myBoxCount?></div>
										<div>Your Boxes</div>
								</div>
						</div>
				</div>
				<div class="panel-footer">
						<h2>My Boxes</h2>
						<p>
							List the flashcard boxes created by you and administer them.
							Compare your progress across different study sets.
							Create a new flashcard box for a new study set.
						</p>
						<a href="<?=linkTo("my")?>">
							<span class="pull-left">List my Boxes</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
							<div class="row">
									<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
											<div class="huge"><?=$boxCount?></div>
											<div>Total Flashcard Boxes</div>
									</div>
							</div>
				</div>
				<div class="panel-footer">
						<h2>Start studying!</h2>
						<p>
							Browse through hundreds of boxes created by the community covering wide ranges of subjects.
							Widen your interests by checking out the study sets of other people.
						</p>
						<a href="<?=linkTo("boxes")?>">
							<span class="pull-left">List All</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-red">
				<div class="panel-heading">
							<div class="row">
									<div class="col-xs-3">
											<i class="fa fa-user fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
											<div class="huge"><?=$user->name?></div>
											<div>User Profile</div>
									</div>
							</div>
				</div>
				<div class="panel-footer">
						<h2>Edit your Profile</h2>
						<p>
							Check out how other people see you.
							Edit your settings in order to customize your flashcards experience.
							Reset your progress if you want to start over.
						</p>
						<a href="<?=linkTo("profile")?>">
							<span class="pull-left">User Profile</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</a>
				</div>
			</div>
		</div>
	</div>
</div>
