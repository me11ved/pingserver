<div id="box">

<div>
	<h3>Статистика пинга</h3>
</div>
<table>
	<thead>
		<th>#</th>
		<th>Время запроса</th>
		<th>Статус</th>
		<th>Среднее время ответа (ms)</th>
		<th>Ip сервера</th>
		<th>Группа</th>
		<tbody>
			<?php if ($this->data["pingResults"]) : ?>
				<?php foreach ($this->data["pingResults"] as $k => $res): ?>
				<tr>
					<td><?=$res['id']?></td>
					<td><?=$res['check_date']?></td>
					<td>
						<?php if ($res["success"]) : ?>
							<b id="good_2">Доступен</b>
						<?php else : ?>
							<b id="bad_2">Недоступен</b>
						<?php endif; ?>
					</td>
					<td><?=$res["response_time"]?></td>
					<td><?=$res["ip"]?></td>
					<td><?=$res["group"]?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan='7'>Данных пока нет</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</thead>
</table>

</div>
<div id="box">
	<div>
		<h3>Структура серверов</h3>
		
		<div class="drevo">
			<?php if ($this->data["serverLists"]) : ?>
				<ul>
				<?php foreach ($this->data["serverLists"] as $k => $group) : ?>
					
						<li>
							<span><?=$group["title"]?></span>
							<?php if ($group["servers"]) : ?>
								<ul>
									<?php foreach ($group["servers"] as $k2 => $serv) : ?>
										<li><?=$serv["ip"]?>
										<?php if($serv["comments"]) : ?>
											<i>(<?=$serv["comments"]?>)</i>
										<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
				<?php endforeach; ?>
			<?php else : ?>
				<p>Данных пока нет</p>
			<?php endif; ?>
		</div>
		
	</div>
</div>

