<!-- Begin toolbar -->
<div class="toolbar">
	<div class="toolbar-inner">
		<div class="toolbar-buttons">
			<a class="button button-secondary button-back js-button-back" href="/list/dns/">
				<i class="fas fa-arrow-left icon-blue"></i><?= _("Back") ?>
			</a>
			<?php if ($read_only !== "true") { ?>
				<a href="/add/dns/?domain=<?= htmlentities($_GET["domain"]) ?>" class="button button-secondary js-button-create">
					<i class="fas fa-circle-plus icon-green"></i><?= _("Add Record") ?>
				</a>
				<a href="/edit/dns/?domain=<?= htmlentities($_GET["domain"]) ?>" class="button button-secondary js-button-create">
					<i class="fas fa-pencil icon-blue"></i><?= _("Edit DNS Domain") ?>
				</a>
			<?php } ?>
		</div>
		<div class="toolbar-right">
			<div class="toolbar-sorting">
				<button class="toolbar-sorting-toggle js-toggle-sorting-menu" type="button" title="<?= _("Sort items") ?>">
					<?= _("Sort by") ?>:
					<b>
						<?php if ($_SESSION['userSortOrder'] === 'name') { $label = _('Record'); } else { $label = _('Date'); } ?>
						<?=$label;?> <i class="fas fa-arrow-down-a-z"></i>
					</b>
				</button>
				<ul class="toolbar-sorting-menu animate__animated animate__fadeIn js-sorting-menu u-hidden">
					<li data-entity="sort-date" data-sort-as-int="1">
						<span class="name <?php if ($_SESSION['userSortOrder'] === 'date') { echo 'active'; } ?>"><?= _("Date") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-value">
						<span class="name"><?= _("IP or Value") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-record">
						<span class="name"><?= _("Record") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-ttl" data-sort-as-int="1">
						<span class="name"><?= _("TTL") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
					<li data-entity="sort-type">
						<span class="name"><?= _("Type") ?> <i class="fas fa-arrow-down-a-z"></i></span><span class="up"><i class="fas fa-arrow-up-a-z"></i></span>
					</li>
				</ul>
				<?php if ($read_only !== "true") { ?>
					<form x-data x-bind="BulkEdit" action="/bulk/dns/" method="post">
						<input type="hidden" name="domain" value="<?= htmlentities($_GET["domain"]) ?>">
						<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
						<select class="form-select" name="action">
							<option value=""><?= _("Apply to selected") ?></option>
							<option value="suspend"><?= _("Suspend") ?></option>
							<option value="unsuspend"><?= _("Unsuspend") ?></option>
							<option value="delete"><?= _("Delete") ?></option>
						</select>
						<button type="submit" class="toolbar-input-submit" title="<?= _("Apply to selected") ?>">
							<i class="fas fa-arrow-right"></i>
						</button>
					</form>
				<?php } ?>
			</div>
			<div class="toolbar-search">
				<form action="/search/" method="get">
					<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
					<input type="search" class="form-control js-search-input" name="q" value="<? echo isset($_POST['q']) ? htmlspecialchars($_POST['q']) : '' ?>" title="<?= _("Search") ?>">
					<button type="submit" class="toolbar-input-submit" title="<?= _("Search") ?>">
						<i class="fas fa-magnifying-glass"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container">
	<div class="units js-units-container">
		<div class="header units-header">
			<div class="l-unit__col l-unit__col--right">
				<div class="clearfix l-unit__stat-col--left super-compact">
					<input type="checkbox" class="js-toggle-all-checkbox" title="<?= _("Select all") ?>" <?= $display_mode ?>>
				</div>
				<div class="clearfix l-unit__stat-col--left"><b><?= _("Record") ?></b></div>
				<div class="clearfix l-unit__stat-col--left super-compact u-text-right"><b>&nbsp;</b></div>
				<div class="clearfix l-unit__stat-col--left compact u-text-center" style="padding-left: 32px;"><b><?= _("Type") ?></b></div>
				<div class="clearfix l-unit__stat-col--left compact u-text-center"><b><?= _("Priority") ?></b></div>
				<div class="clearfix l-unit__stat-col--left compact u-text-center"><b><?= _("TTL") ?></b></div>
				<div class="clearfix l-unit__stat-col--left super-compact"><b>&nbsp;</b></div>
				<div class="clearfix l-unit__stat-col--left wide-6"><b><?= _("IP or Value") ?></b></div>
			</div>
		</div>

		<!-- Begin DNS record list item loop -->
		<?php
			foreach ($data as $key => $value) {
				++$i;
				if ($data[$key]['SUSPENDED'] == 'yes') {
					$status = 'suspended';
				}else{
					$status = 'active';

				}
			?>
			<div class="l-unit <?php if ($status == 'suspended') echo 'l-unit--suspended';?> animate__animated animate__fadeIn js-unit"
				data-sort-date="<?=strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])?>"
				data-sort-record="<?=$data[$key]['RECORD']?>"
				data-sort-type="<?=$data[$key]['TYPE']?>"
				data-sort-ttl="<?=$data[$key]['TTL']?>"
				data-sort-value="<?=$data[$key]['VALUE']?>">
				<div class="l-unit__col l-unit__col--right">
					<div class="clearfix l-unit__stat-col--left super-compact">
						<input id="check<?= $data[$key]["ID"] ?>" class="js-unit-checkbox" type="checkbox" title="<?= _("Select") ?>" name="record[]" value="<?= $data[$key]["ID"] ?>" <?= $display_mode ?>>
					</div>
					<div class="clearfix l-unit__stat-col--left u-truncate">
						<b>
						<?php if (($read_only === 'true') || ($data[$key]['SUSPENDED'] == 'yes')) {?>
							<?=substr($data[$key]['RECORD'], 0, 12); if(strlen($data[$key]['RECORD']) > 12 ) echo '...'; ?>
						<?php } else { ?>
							<a href="/edit/dns/?domain=<?=htmlspecialchars($_GET['domain'])?>&record_id=<?=$data[$key]['ID']?>&token=<?=$_SESSION['token']?>" title="<?= _("Edit DNS Record") . ': '.htmlspecialchars($data[$key]['RECORD'])?>"><? echo substr($data[$key]['RECORD'], 0, 12); if(strlen($data[$key]['RECORD']) > 12 ) echo '...'; ?></a>
						<?php } ?>
						</b>
					</div>
				<!-- START QUICK ACTION TOOLBAR AREA -->
				<div class="clearfix l-unit__stat-col--left super-compact u-text-right">
					<div class="l-unit-toolbar__col l-unit-toolbar__col--right u-noselect">
						<div class="actions-panel clearfix">
							<?php if ($read_only === "true") { ?>
								<!-- Restrict editing of DNS records when impersonating 'admin' account -->
								&nbsp;
							<?php } else { ?>
								<?php if ($data[$key]['SUSPENDED'] == 'no') {?>
									<div class="actions-panel__col actions-panel__logs shortcut-enter" data-key-action="href"><a href="/edit/dns/?domain=<?=htmlspecialchars($_GET['domain'])?>&record_id=<?=$data[$key]['ID']?>&token=<?=$_SESSION['token']?>" title="<?= _("Edit DNS Record") ?>"><i class="fas fa-pencil icon-orange icon-dim"></i></a></div>
								<?php } ?>
								<div class="actions-panel__col actions-panel__delete shortcut-delete" data-key-action="js">
									<a
										class="data-controls js-confirm-action"
										href="/delete/dns/?domain=<?= htmlspecialchars($_GET["domain"]) ?>&record_id=<?= $data[$key]["ID"] ?>&token=<?= $_SESSION["token"] ?>"
										data-confirm-title="<?= _("Delete") ?>"
										data-confirm-message="<?= sprintf(_("Are you sure you want to delete record %s?"), $key) ?>"
									>
										<i class="fas fa-trash icon-red icon-dim"></i>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<!-- END QUICK ACTION TOOLBAR AREA -->
				<div class="clearfix l-unit__stat-col--left compact u-text-center" style="padding-left: 32px;"><b><?=$data[$key]['TYPE']?></b></div>
				<div class="clearfix l-unit__stat-col--left compact u-text-center"><?=$data[$key]['PRIORITY']?>&nbsp;</div>
				<div class="clearfix l-unit__stat-col--left compact u-text-center"><?php if($data[$key]['TTL'] == ''){ echo _('Default'); }else{ echo $data[$key]['TTL'];} ?></div>
				<div class="clearfix l-unit__stat-col--left super-compact"><b>&nbsp;</b></div>
				<div class="clearfix l-unit__stat-col--left wide-6 truncate" style="word-break: break-word;"><?= htmlspecialchars($data[$key]["VALUE"], ENT_QUOTES, "UTF-8") ?></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<footer class="app-footer">
	<div class="container app-footer-inner">
		<p>
			<?php printf(ngettext("%d DNS record", "%d DNS records", $i), $i); ?>
		</p>
	</div>
</footer>
