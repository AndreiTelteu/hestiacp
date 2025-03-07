<!-- Begin toolbar -->
<div class="toolbar">
	<div class="toolbar-inner">
		<div class="toolbar-buttons">
			<a class="button button-secondary button-back js-button-back" href="/list/user/">
				<i class="fas fa-arrow-left icon-blue"></i><?= _("Back") ?>
			</a>
			<a href="/add/package/" class="button button-secondary js-button-create">
				<i class="fas fa-circle-plus icon-green"></i><?= _("Add Package") ?>
			</a>
		</div>
		<div class="toolbar-right">
			<div class="toolbar-sorting">
				<button class="toolbar-sorting-toggle js-toggle-sorting-menu" type="button" title="<?= _("Sort items") ?>">
					<?= _("Sort by") ?>:
					<b>
						<?php if ($_SESSION['userSortOrder'] === 'name') { $label = _('Name'); } else { $label = _('Date'); } ?>
						<?=$label;?> <i class="fas fa-arrow-down-a-z"></i>
					</b>
				</button>
				<ul class="toolbar-sorting-menu animate__animated animate__fadeIn js-sorting-menu u-hidden">
					<li data-entity="sort-date" data-sort-as-int="1">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'date') { echo 'active'; } ?>"><?= _("Date") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-name">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'name') { echo 'active'; } ?>"><?= _("Name") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<form x-data x-bind="BulkEdit" action="/bulk/package/" method="post">
					<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
					<select class="form-select" name="action">
						<option value=""><?= _("Apply to selected") ?></option>
						<option value="delete"><?= _("Delete") ?></option>
					</select>
					<button type="submit" class="toolbar-input-submit" title="<?= _("Apply to selected") ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container">
	<div class="units js-units-container">
		<div class="units-header">
			<div class="l-unit__col l-unit__col--right">
				<div class="clearfix l-unit__stat-col--left super-compact">
					<input type="checkbox" class="js-toggle-all-checkbox" title="<?= _("Select all") ?>">
				</div>
				<div class="clearfix l-unit__stat-col--left wide"><b><?= _("Package") ?></b></div>
				<div class="clearfix l-unit__stat-col--left compact-3 u-text-right"><b>&nbsp;</b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center compact"><b><i class="fas fa-terminal" title="<?= _("Shell") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center compact-2"><b><i class="fas fa-hard-drive" title="<?= _("Quota") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center compact-2"><b><i class="fas fa-right-left" title="<?= _("Bandwidth") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-earth-americas" title="<?= _("Web Domains") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-link" title="<?= _("Web Aliases") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-book-atlas" title="<?= _("DNS Zones") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-globe" title="<?= _("DNS Records") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-envelopes-bulk" title="<?= _("Mail Domains") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-inbox" title="<?= _("Mail Accounts") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-database" title="<?= _("Databases") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-clock" title="<?= _("Cron Jobs") ?>"></i></b></div>
				<div class="clearfix l-unit__stat-col--left u-text-center super-compact"><b><i class="fas fa-file-zipper" title="<?= _("Backups") ?>"></i></b></div>
			</div>
		</div>

		<!-- Begin package list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
			?>
			<div class="l-unit animate__animated animate__fadeIn js-unit"
				data-sort-date="<?=strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])?>"
				data-sort-name="<?=$key?>"
				data-sort-bandwidth="<?=$data[$key]['BANDWIDTH']?>"
				data-sort-disk="<?=$data[$key]['DISK_QUOTA']?>">
				<div class="l-unit__col l-unit__col--right">
					<div class="clearfix l-unit__stat-col--left super-compact">
						<input id="check<?=$i?>" class="js-unit-checkbox" type="checkbox" title="<?= _("Select") ?>" name="package[]" value="<?=$key?>">
					</div>
					<?php if ($key == 'system'){ ?>
						<div class="clearfix l-unit__stat-col--left wide truncate"><b><?=$key?></b></div>
					<?php } else { ?>
						<div class="clearfix l-unit__stat-col--left wide truncate">
							<b><a href="/edit/package/?package=<?=$key?>&token=<?=$_SESSION['token']?>" title="<?= _("Edit Package") ?>: <?=$key?>"><?=$key?></a></b>
						</div>
					<?php } ?>
					<!-- START QUICK ACTION TOOLBAR AREA -->
					<div class="clearfix l-unit__stat-col--left u-text-right compact-3">
						<div class="l-unit-toolbar__col l-unit-toolbar__col--right u-noselect">
							<div class="actions-panel clearfix">
								<?php if (($key == 'system')) { ?>
									<!-- Restrict editing system package -->
								<?php } else {?>
									<div class="actions-panel__col actions-panel__edit shortcut-enter" data-key-action="href"><a href="/edit/package/?package=<?=$key?>&token=<?=$_SESSION['token']?>" title="<?= _("Edit Package") ?>"><i class="fas fa-pencil icon-orange icon-dim"></i></a></div>
								<?php } ?>
								<div class="actions-panel__col actions-panel__edit" data-key-action="href"><a href="/copy/package/?package=<?=$key?>&token=<?=$_SESSION['token']?>" title="<?= _("Duplicate") ?>"><i class="fas fa-clone icon-teal icon-dim"></i></a></div>
								<?php if ($key == 'system') { ?>
									<!-- Restrict deleting system package -->
								<?php } else {?>
									<div class="actions-panel__col actions-panel__delete shortcut-delete" data-key-action="js">
										<a
											class="data-controls js-confirm-action"
											href="/delete/package/?package=<?=$key?>&token=<?=$_SESSION['token']?>"
											data-confirm-title="<?= _("Delete") ?>"
											data-confirm-message="<?= sprintf(_('Are you sure you want to delete package %s?'), $key) ?>"
										>
											<i class="fas fa-trash icon-red icon-dim"></i>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<!-- END QUICK ACTION TOOLBAR AREA -->
					<div class="clearfix l-unit__stat-col--left u-text-center compact">
						<?php if ($data[$key]["SHELL"] == "nologin") { ?>
							<i class="fas fa-circle-minus icon-large" title="<?= _("SSH Access") ?>: <?= $data[$key]["SHELL"] ?>"> </i>
						<?php } else { ?>
							<i class="fas fa-circle-check icon-green icon-large"></i>
						<?php } ?>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center compact-2">
						<span title="<?= _("Quota") ?>: <?= humanize_usage_size($data[$key]["DISK_QUOTA"]) ?> <?= humanize_usage_measure($data[$key]["DISK_QUOTA"]) ?>">
							<?php if (preg_match("/[a-z]/i", $data[$key]["DISK_QUOTA"])): ?>
								<b>&infin;</b>
							<?php else: ?>
								<b><?= humanize_usage_size($data[$key]["DISK_QUOTA"]) ?></b> <span class="u-text-small"><?= humanize_usage_measure($data[$key]["DISK_QUOTA"]) ?></span>
							<?php endif; ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center compact-2">
						<span title="<?= _("Bandwidth") ?>: <?= humanize_usage_size($data[$key]["BANDWIDTH"]) ?> <?= humanize_usage_measure($data[$key]["BANDWIDTH"]) ?>">
							<?php if ($data[$key]["BANDWIDTH"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= humanize_usage_size($data[$key]["BANDWIDTH"]) ?></b> <span class="u-text-small"><?= humanize_usage_measure($data[$key]["BANDWIDTH"]) ?></span>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Web Domains") ?>: <?= $data[$key]["WEB_DOMAINS"] ?>">
							<?php if ($data[$key]["WEB_DOMAINS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["WEB_DOMAINS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Web Aliases") ?>: <?= $data[$key]["WEB_ALIASES"] ?>">
							<?php if ($data[$key]["WEB_ALIASES"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["WEB_ALIASES"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("DNS Zones") ?>: <?= $data[$key]["DNS_DOMAINS"] ?>">
							<?php if ($data[$key]["DNS_DOMAINS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["DNS_DOMAINS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("DNS Records") ?>: <?= $data[$key]["DNS_RECORDS"] ?>">
							<?php if ($data[$key]["DNS_RECORDS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["DNS_RECORDS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Mail Domains") ?>: <?= $data[$key]["MAIL_DOMAINS"] ?>">
							<?php if ($data[$key]["MAIL_DOMAINS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["MAIL_DOMAINS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Mail Accounts") ?>: <?= $data[$key]["MAIL_ACCOUNTS"] ?>">
							<?php if ($data[$key]["MAIL_ACCOUNTS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["MAIL_ACCOUNTS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Databases") ?>: <?= $data[$key]["DATABASES"] ?>">
							<?php if ($data[$key]["DATABASES"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["DATABASES"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Cron Jobs") ?>: <?= $data[$key]["CRON_JOBS"] ?>">
							<?php if ($data[$key]["CRON_JOBS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["CRON_JOBS"] ?></b>
							<?php } ?>
						</span>
					</div>
					<div class="clearfix l-unit__stat-col--left u-text-center super-compact">
						<span class="badge" title="<?= _("Backups") ?>: <?= $data[$key]["BACKUPS"] ?>">
							<?php if ($data[$key]["BACKUPS"] == "unlimited") { ?>
								<b>&infin;</b>
							<?php } else { ?>
								<b><?= $data[$key]["BACKUPS"] ?></b>
							<?php } ?>
						</span>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<footer class="app-footer">
	<div class="container app-footer-inner">
		<p>
			<?php printf(ngettext("%d package", "%d packages", $i), $i); ?>
		</p>
	</div>
</footer>
