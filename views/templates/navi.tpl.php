<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?=linkTo()?>">Flashcards</a>
	</div>
	<ul class="nav navbar-top-links navbar-right">
		<?php if(isset($box)): ?>
		    <span class="text-muted"><?=$box->name?></span>
			<li>
				<a href="<?=linkTo("boxes/$box->id")?>"><i class="fa fa-eye" aria-hidden="true"></i> Overview</a>
			</li>
			<li>
				<a href="<?=linkTo("boxes/$box->id/view")?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Flashcards</a>
			</li>
			<li>
				<a href="<?=linkTo("boxes/$box->id/study")?>"><i class="fa fa-leanpub" aria-hidden="true"></i> Study</a>
			</li>
		<?php endif; ?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="<?=linkTo("profile")?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
				</li>
				<li class="divider"></li>
				<li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
<div class="flashcards-container">
